<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\MemberForm;
use app\models\Member;
use app\models\ProfileForm;
use app\models\Profile;
use yii\helpers\ArrayHelper;
use yii\db\Query;
 
class MemberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','add','edit','save','activity','profile','password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ], 
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays members page.
     * For admin roles only
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity->role!='administrator'){
            $this->redirect(['site/index']);
        }
        $models = Member::find()->all();
        return $this->render('members', ['models' => $models]);        
    }

    /**
     * Add action.
     * For admin roles only
     * @return form view
     */
    public function actionAdd()
    {
        if(Yii::$app->user->identity->role!='administrator'){
            $this->redirect(['site/index']);
        }        
        $model = new MemberForm();
        return $this->render('entry',[
            'model' => $model
        ]);
    }

    /**
     * Edit action.
     * For admin roles only
     * @return form view
     */
    public function actionEdit()
    {
        if(Yii::$app->user->identity->role!='administrator'){
            $this->redirect(['site/index']);
        }        
        $id = Yii::$app->request->get('id');
        $model = Member::findOne($id);       
        if(!$id || !$model){
            $this->redirect(['member/index']);             
        }else{
            $model->password_hash = '';
            return $this->render('entry',[
                'model' => $model
            ]);            
        }
    }
    
    /**
     * Save: Create/update action (submission of insertion or updating).
     * For admin roles only
     * @return action view
     */
    public function actionSave()
    {
        if(Yii::$app->user->identity->role!='administrator'){
            $this->redirect(['site/index']);
        }        
        if (Yii::$app->request->post()) {
            $request = Yii::$app->request->post();
            if(key_exists("MemberForm",$request)){
                $request = $request['MemberForm'];
            }else if(key_exists("Member",$request)){
                $request = $request['Member'];                
            }else{
                $this->redirect(['member/index', 'message' => 'Error occurred!']);
            }
            $memberForm = new MemberForm();
            if(!$request["id"] || $request["id"]==0){
                $memberForm->scenario = MemberForm::SCENARIO_AJOUT;
                $member = new Member();
            }else{
                $memberForm->scenario = MemberForm::SCENARIO_MODIFY;
                $member = Member::findOne($request["id"]); 
            }
            $memberForm->id = (int)$request["id"];;
            $memberForm->username = $request["username"];
            $memberForm->email = $request["email"];
            $memberForm->password_hash = $request["password_hash"];
            $memberForm->role = $request["role"];
            $memberForm->active = $request["active"]; 
            // Username validity issue
            if(!$member->isUniqueUsername((int)$request['id'],$memberForm->username,$memberForm)){
               return $this->render('entry', ['model'=> $memberForm, 'message' => $memberForm->errors]);
            }
            // Email validity issue
            if(!$member->isUniqueEmail((int)$request['id'],$memberForm->email,$memberForm)){
               return $this->render('entry', ['model'=> $memberForm, 'message' => $memberForm->errors]);
            }            
            // in that case, validate the data
            if ($memberForm->validate()) {
                // save it to the database
                $data = array(
                    'username'=>$memberForm->username,
                    'email'=>$memberForm->email,
                    'role'=>$memberForm->role,
                    'active'=>$memberForm->active                 
                );
                if(!empty($memberForm->password_hash) && strlen($memberForm->password_hash)>=6){
                    $data['password_hash'] = Yii::$app->security->generatePasswordHash($memberForm->password_hash);
                    $data['auth_key'] = Yii::$app->security->generateRandomString();
                }
                $command = Yii::$app->db->createCommand();
                if($memberForm){
                    if((int)$request["id"]===0){
                        $command->insert('members', $data)->execute();
                        $notify_message = 'New Member has been created successfully. '.Yii::$app->params['mailNotification'];
                        /*** send an email to the created member to  notify him that he can access the app by his role ***/
                        $mail_body = 'Hi there,<br />A new account has been created for you from <strong>'.Yii::$app->name.'</strong> application.'
                                . '<br />You became member and you can login and navigate through the application using the credentials below:'
                                . '<br /><br /><strong>Username:</strong> '.$memberForm->username.''
                                . '<br /><strong>Email address:</strong> '.$memberForm->email.''
                                . '<br /><strong>Password:</strong> '.$memberForm->password_hash.''
                                . '<br /><br />&copy; '.date('Y').'. Person Management Support.';
                        $array_mail = ['subject'=>'New member created for ','to'=>$memberForm->email,'body'=>$mail_body];                        
                        if($memberForm->sendEmail($array_mail)){
                        /*
                         * Mail has been sent
                         */                           
                        }
                    }else{ 
                        $command->update('members', $data, 'id = '.(int)$request['id'])->execute();
                        $notify_message = 'Member has been updated successfully. '.Yii::$app->params['mailNotification'];
                        /*** send an email to the updated member to  notify him that their creds. have been updated ***/
                        $mail_body = 'Hi there,<br />Your credentials for <strong>'.Yii::$app->name.'</strong> application, have been updated by an administrator.'
                                . '<br />The updated fields are listed below:'
                                . '<br /><br /><strong>Username:</strong> '.$memberForm->username.''
                                . '<br /><strong>Email address:</strong> '.$memberForm->email.'';
                        if(!empty($memberForm->password_hash)){
                            $mail_body .= '<br /><strong>Password:</strong> '.$memberForm->password_hash.'';
                        }       
                        $mail_body .= '<br /><br />&copy; '.date('Y').'. Person Management Support.';
                        $array_mail = ['subject'=>'Member credentials updated for ','to'=>$memberForm->email,'body'=>$mail_body];                        
                        if($memberForm->sendEmail($array_mail)){
                            /*
                             * Mail has been sent
                             */
                        }                        
                    }    
                    $this->redirect(['member/index', 'message' => $notify_message]);                    
                }else{
                    $notify_message = 'Error occurred! Model could not be handled.';
                    return $this->render('entry', ['model'=> $memberForm, 'message' => $notify_message]);
                }
            }else{
                return $this->render('entry', ['model'=> $memberForm, 'message' => $memberForm->errors]);
            }
        }
    }
    /**
     * Enable/Disable a Member (rather than delete it)
     * For admin roles only
     * @return view redirection
     */ 
    public function actionActivity(){
        if(Yii::$app->user->identity->role!='administrator'){
            $this->redirect(['site/index']);
        }        
        $id = Yii::$app->request->get('id');
        $act = Yii::$app->request->get('act');
        $model = Member::findOne($id);  
        if(!$id || !$model){
            $this->redirect(['member/index']);             
        }else{
            $model->active = $act;
            $model->save();
            return $this->redirect(['member/index',
                'model' => $model,
                'message' => "Status has been updated successfully."
            ]);            
        }        
    }
    /**
     * Displays profile page.
     *
     * @return view
     */
    public function actionProfile()
    {
        $model = new ProfileForm();
        return $this->render('profile', ['model'=>$model]);        
    } 
    /**
     * Updating password 
     * from profile view
     */
    public function actionPassword()
    {
        if (Yii::$app->request->post()) {
            $request = Yii::$app->request->post();
            if(key_exists("ProfileForm",$request)){
                $request = $request['ProfileForm'];                
            }else{
                $this->redirect(['site/index', 'message' => 'Error occurred!']);
            }
            $profileForm = new ProfileForm();
            $profile = Profile::findOne($request["id"]);
            $profileForm->id = $profile->id;
            $profileForm->password_hash = $request["password_hash"]; 
            // in that case, validate the data
            if ($profileForm->validate()) {
                // save it to the database
                $data = array();
                if(!empty($profileForm->password_hash) && strlen($profileForm->password_hash)>=6){
                    $data['password_hash'] = Yii::$app->security->generatePasswordHash($profileForm->password_hash);
                    $data['auth_key'] = Yii::$app->security->generateRandomString();
                }
                $command = Yii::$app->db->createCommand();
                if($profileForm){
                    $command->update('members', $data, 'id = '.(int)$request['id'])->execute();
                    $notify_message = 'Your password has been updated successfully.';   
                    //$this->redirect(['member/profile', 'message' => $notify_message]); 
                    return $this->render('profile', ['model'=> $profileForm, 'message' => $notify_message]);
                }else{
                    $notify_message = 'Error occurred! Model could not be handled.';
                    return $this->render('entry', ['model'=> $profileForm, 'message' => $notify_message]);
                }
            }else{
                return $this->render('entry', ['model'=> $profileForm, 'message' => $profileForm->errors]);
            }
        }
    }    
    
}
