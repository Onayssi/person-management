<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\PersonForm */
use yii\app;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Manage Person - Edit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-person-edit">
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
            Please edit the following form to update the current info.
        </p>

        <div class="row">
            <div class="col-lg-8">

                <?php $form = ActiveForm::begin(['id' => 'person-form', 'action' => 'index.php?r=person/save']); ?>

                    <?= $form->field($model, 'first_name', ['inputOptions' => ['autocomplete' => 'off']])->textInput(['autofocus' => true])->label('First Name') ?>
                
                    <?= $form->field($model, 'last_name', ['inputOptions' => ['autocomplete' => 'off']])->textInput()->label('Last Name')  ?>
                
                    <?= $form->field($model, 'mobile', ['inputOptions' => ['autocomplete' => 'off']])->label('Mobile Number (at least 10 digits)') ?>

                    <?= $form->field($model, 'email', ['inputOptions' => ['autocomplete' => 'off']])->label('Email address') ?>
                    
                    <?= $form->field($model, 'lang')->dropDownList($languages, [], ['label'=>'languages'])->label('Language') ?>
                
                    <?= $form->field($model, 'date_of_birth', ['inputOptions' => ['autocomplete' => 'off']])->label('Date of birth (format: d-m-Y)') ?>
                
                    <?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false);?>
                
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right', 'name' => 'person-button']) ?>
                    </div>

                <?php ActiveForm::end();?>
                
                <center>
                    <p class="clearCollision">
                        <a class="btn btn-info" href="<?=Url::to(['site/index']);?>">&Lt;&nbsp;Back</a>
                    </p>
                </center>
                
            </div>
        </div>
</div>
