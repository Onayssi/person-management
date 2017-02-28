<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = 'Members - Person Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">
        <?php if (Yii::$app->getRequest()->getQueryParam('message')): ?>
            <div class="alert alert-success">
                <?php echo Yii::$app->getRequest()->getQueryParam('message'); ?>
            </div>
        <?php endif;?>
        <h3>List of all Members:</h3>
        <hr />
        <div class="pull-right">
            <a class="btn btn-lg btn-info" href="<?=Url::to(['member/add']);?>">Add New</a>
        </div>
        <div class="table-responsive clearCollision">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered">
                <tr>
                    <th>Username</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Created on</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <?php
                        if(count($models)===0){
                            ?>
                            <td colspan="6">
                                <div class="alert alert-warning">No data available at this moment.</div>
                            </td>      
                        <?php
                        }else{
                            foreach($models as $record){
                                ?>
                                <tr>
                                    <td><?=$record["username"]?></td>
                                    <td><?= Html::a($record["email"], null, ['href' => 'mailto:'.$record["email"]]);?></td>
                                    <td><?= ucwords($record->role)?></td>
                                    <td><?=date("d-m-Y \a\\t H:iA",strtotime($record["created_at"]))?></td>
                                    <td>
                                        <div class="form-group">
                                            <select name="activity" onchange="javascript:location.href = this.value;" class="form-control">
                                                <option value="<?=Url::to(['member/activity', 'id'=>$record['id'], 'act' => 'yes']);?>" <?php if($record['active']==='yes'){?> selected="selected"<?php }?>>Active</option>
                                                <option value="<?=Url::to(['member/activity', 'id'=>$record['id'], 'act' => 'no']);?>" <?php if($record['active']==='no'){?> selected="selected"<?php }?>>Inactive</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <?= Html::a('Edit', null, ['href' => Url::to(['member/edit', 'id' => $record['id']])]);?>
                                    </td>
                                </tr>
                                <?php 
                            }
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
</div>
