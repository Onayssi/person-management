<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\PersonForm;
use app\models\Person;
use app\models\Language;
use yii\helpers\ArrayHelper;
use yii\db\Query;
 
class PersonController extends Controller
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
                        'actions' => ['index','add','edit','save','delete'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['site/index']);
    }

    /**
     * Add action.
     *
     * @return form view
     */
    public function actionAdd()
    {
        $model = new PersonForm();
        $languages = ArrayHelper::map(Language::find()->where(['active'=>'yes'])->asArray()->all(), 'id',  function($model, $default) {
            return $model['code'].' ('.$model['language'].')';
        });
        return $this->render('add',[
            'model' => $model,
            'languages' => $languages
        ]);
    }

    /**
     * Edit action.
     *
     * @return form view
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = Person::findOne($id);
        if(!$id || !$model){
            $this->redirect(['site/index']);             
        }else{
            $languages = ArrayHelper::map(Language::find()->where(['active'=>'yes'])->asArray()->all(), 'id',  function($model, $default) {
                return $model['code'].' ('.$model['language'].')';
            });
            return $this->render('edit',[
                'model' => $model,
                'languages' => $languages
            ]);            
        }
    }
    
    /**
     * Save: Create/update action (submission of insertion or updating).
     *
     * @return action view
     */
    public function actionSave()
    {
        if (Yii::$app->request->post()) {
            $request = Yii::$app->request->post();
            if(key_exists("PersonForm",$request)){
                $request = $request['PersonForm'];
            }else if(key_exists("Person",$request)){
                $request = $request['Person'];
            }else{
                $this->redirect(['site/index', 'message' => 'Error occurred!']);
            }
            $personForm = new PersonForm();
            if(!$request["id"] || $request["id"]==0){
                $person = new Person();
            }else{
                $person = Person::findOne($request["id"]); 
            }
            $languages = ArrayHelper::map(Language::find()->where(['active'=>'yes'])->asArray()->all(), 'id',  function($model, $default) {
                return $model['code'].' ('.$model['language'].')';  
            });
            $personForm->id = (int)$request["id"];;
            $personForm->first_name = $request["first_name"];
            $personForm->last_name = $request["last_name"];
            $personForm->mobile = $request["mobile"];
            $personForm->email = $request["email"];
            $personForm->lang = (int)$request["lang"];
            $personForm->date_of_birth = $request['date_of_birth']; 
            // Email validity issue
            if(!$person->isUniqueEmail((int)$request['id'],$personForm->email,$personForm)){
               return $this->render(((int)$request["id"]===0)?'add':'edit', ['model'=> $personForm, 'languages'=>$languages, 'message' => $personForm->errors]);
            }
            // in that case, validate the data
            if ($personForm->validate()) {
                // save it to the database
                $data = array(
                    'first_name'=>$personForm->first_name,
                    'last_name'=>$personForm->last_name,
                    'mobile'=>$personForm->mobile,
                    'email'=>$personForm->email,
                    'lang'=>$personForm->lang,
                    'date_of_birth'=>date("Y-m-d",strtotime($personForm->date_of_birth))                  
                );
                $command = Yii::$app->db->createCommand();
                if($personForm){
                    if((int)$request["id"]===0){
                        $command->insert('persons', $data)->execute();
                        $notify_message = 'New Person has been created successfully.';
                    }else{ 
                        $command->update('persons', $data, 'id = '.(int)$request['id'])->execute();
                        $notify_message = 'Person has been updated successfully.';
                    }    
                    $this->redirect(['site/index', 'message' => $notify_message]);                    
                }else{
                    $notify_message = 'Error occurred! Model could not be handled.';
                    if((int)$request["id"]===0){
                        return $this->render('add', ['model'=> $personForm, 'languages'=>$languages, 'message' => $notify_message]);
                    }else{
                        return $this->render('edit', ['model'=> $personForm, 'languages'=>$languages, 'message' => $notify_message]);
                    }
                }
            }else{
                if((int)$request["id"]===0){
                    return $this->render('add', ['model'=> $personForm, 'languages'=>$languages, 'message' => $personForm->errors]);
                }else{
                    return $this->render('edit', ['model'=> $personForm, 'languages'=>$languages, 'message' => $personForm->errors]);
                }
            }
        }
    }
    /**
     * Delete a Person
     *
     * @return view redirection
     */ 
    public function actionDelete(){
        $id = Yii::$app->request->get('id');
        $model = Person::findOne($id);
        if(!$id || !$model){
            $this->redirect(['site/index']);             
        }else{
            $model->delete();
            return $this->redirect(['site/index',
                'model' => $model,
                'message' => "Record has been deleted successfully."
            ]);            
        }        
    }
}
