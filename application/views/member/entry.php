<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\PersonForm */
use yii\app;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\ActiveForm;

$this->title = 'Manage Members - '.((!$model->id)?'Add':'Update');
$this->params['breadcrumbs'][] = $this->title;
$password_label = (!$model->id)?'Password':'Password (you can keep this field empty if you don\'t want to change it)';
?>
<div class="site-member-entry">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php if (!empty($message)): ?>       
            <div class="alert alert-danger">
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
    
        <p>
            Please fill out the following form to <?=(!$model->id)?'create a new':'update the current';?> member.
        </p>

        <div class="row">
            <div class="col-lg-8">

                <?php $form = ActiveForm::begin(['id' => 'member-form', 'action' => 'index.php?r=member/save']); ?>

                    <?= $form->field($model, 'username', ['inputOptions' => ['autocomplete' => 'off']])->textInput(['autofocus' => true])->label('User Name') ?>

                    <?= $form->field($model, 'email', ['inputOptions' => ['autocomplete' => 'off']])->label('Email address') ?>
                
                    <?= $form->field($model, 'password_hash', ['inputOptions' => ['autocomplete' => 'off']])->passwordInput()->label($password_label) ?>
                    
                    <?= $form->field($model, 'role')->dropDownList(["moderator"=>"Moderator","administrator"=>"Administrator"], [], ['label'=>'Role'])->label('Role') ?>
                
                    <?= $form->field($model, 'active')->dropDownList(["yes"=>"Yes","no"=>"no"], [], ['label'=>'Active'])->label('Active') ?>
                
                    <?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false);?>
                
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right', 'name' => 'member-button']) ?>
                    </div>

                <?php ActiveForm::end();?>
                
                <center>
                    <p class="clearCollision">
                        <a class="btn btn-info" href="<?=Url::to(['member/index']);?>">&Lt;&nbsp;Back</a>
                    </p>
                </center>
                
            </div>
        </div>
            <?php
        $this->registerJs("
            window.setTimeout(function(){                   
                    $('input[type=\"password\"]').val('');
                    $('#member-password_hash').removeAttr('value');
                    },100);",
            View::POS_LOAD,
            'autocomplete-off-member-form'
        );
?>
</div>
