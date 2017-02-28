<?php
use yii\app;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\ActiveForm;

$this->title = 'Profile - Person Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-profile-entry">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php if (!empty($message)): ?>       
            <div class="alert <?=(is_array($message)?'alert-danger':'alert-success')?>">
                <?php 
                    if(is_array($message)){
                        echo "<ul>";
                        foreach($message as $item){
                            foreach($item as $error){
                                echo "<li>".($error)."</li>";
                            }
                        }
                        echo "</ul>";
                    }else{
                        echo $message;
                    }
                ?>
            </div> 
    <?php endif;?> 
    
        <div class="panel panel-default">  
            <div class="panel-heading"><strong>Message:</strong></div>
            <div class="panel-body">
                <div class="alert alert-warning">
                    Username and email address are in read mode only.
                    To change your username or email address,
                        <?=(Yii::$app->user->identity->role!='administrator')?'please contact your administrator to handle the update.':'please navigate to the member view and check your account.';?>
                </div> 
            </div>
        </div>
    
        <p>
            Please fill out the filed below if you want to change your current password.<br />
        </p>    

        <div class="row">
            <div class="col-lg-8">

                <?php $form = ActiveForm::begin(['id' => 'member-form', 'action' => 'index.php?r=member/password']); ?>

                    <?= $form->field($model, 'username', ['inputOptions' => ['autocomplete' => 'off', 'readonly'=>'readonly', 'disabled'=>'disabled', 'value'=>Yii::$app->user->identity->username]])->textInput(['autofocus' => true])->label('User Name') ?>

                    <?= $form->field($model, 'email', ['inputOptions' => ['autocomplete' => 'off', 'readonly'=>'readonly', 'disabled'=>'disabled', 'value'=>Yii::$app->user->identity->email]])->label('Email address') ?>
                
                    <?= $form->field($model, 'password_hash', ['inputOptions' => ['autocomplete' => 'off']])->passwordInput()->label('Update Password') ?>
                
                    <?= $form->field($model, 'id')->hiddenInput(['value'=> Yii::$app->user->identity->id])->label(false);?>
                
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right', 'name' => 'profile-button']) ?>
                    </div>

                <?php ActiveForm::end();?>
                
                <center>
                    <p class="clearCollision">
                        <a class="btn btn-info" href="<?=Url::to(['site/index']);?>">Go to Main View</a>
                    </p>
                </center>
                
            </div>
        </div>
            <?php
        $this->registerJs("
            window.setTimeout(function(){
                    $('#profileForm-password_hash').removeAttr('value');
                    $('input[type=\"password\"]').val('');
                    },50);",
            View::POS_LOAD,
            'autocomplete-off-profile-form'
        );
?>
</div>