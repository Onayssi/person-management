<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = 'Person Management';
?>
<div class="site-index">
   
    <div class="jumbotron">
        <h2>Person Management!</h2>
        <p class="lead">A web based person management application that managing persons.</p>       
        <p>
            <a class="btn btn-lg btn-info" href="<?=Url::to(['person/add']);?>">Create New Person</a>
        </p>
    </div>

    <div class="body-content">
        <?php if (Yii::$app->getRequest()->getQueryParam('message')): ?>
            <div class="alert alert-success">
                <?php echo Yii::$app->getRequest()->getQueryParam('message'); ?>
            </div>
        <?php endif;?>
        <h3>List of all Persons:</h3>
        <hr />
        <div class="pull-right">
            <a class="btn btn-lg btn-info" href="<?=Url::to(['person/add']);?>">Add New</a>
        </div>
        <div class="table-responsive clearCollision">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Mobile Number</th>
                    <th>Email Address</th>
                    <th>Language</th>
                    <th>Date of Birth</th>
                    <th>Created on</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <?php
                        if(count($models)===0){
                            ?>
                            <td colspan="8">
                                <div class="alert alert-warning">No data available at this moment.</div>
                            </td>                           
                        <?php
                        }else{
                            foreach($models as $record){
                                ?>
                                <tr>
                                    <td><?=ucfirst($record["first_name"])?></td>
                                    <td><?=ucfirst($record["last_name"])?></td>
                                    <td><?=$record["mobile"]?></td>
                                    <td><?= Html::a($record["email"], null, ['href' => 'mailto:'.$record["email"]]);?></td>
                                    <td><?= $record->language->language?></td>
                                    <td><?=date("d-F-Y",strtotime($record["date_of_birth"]))?></td>
                                    <td><?=date("d-m-Y \a\\t H:iA",strtotime($record["created_at"]))?></td>
                                    <td>
                                        <?= Html::a('Edit', null, ['href' => Url::to(['person/edit', 'id' => $record['id']])]);?> | 
                                        <?= Html::a('Delete', null, ['class' => 'handLink', 'onclick' => '', 'data-toggle' => 'modal', 'data-target' => '#DisplayCDPModal', 'data-href' => Url::to(['person/delete', 'id' => $record['id']])]);?>
                                    </td>
                                </tr>
                                <?php 
                            }
                        }
                    ?>
                </tr>
            </table>
        </div>
        <!-- Modal PopUp (delete Person) -->
        <div id="DisplayCDPModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure you want to delete this record?</h4>
              </div>
              <div class="modal-body">
                  <p align="center">
                      <center>
                          <button type="button" class="btn btn-info" data-dismiss="modal">Dismiss</button>&nbsp;
                          <a class="btn btn-danger confAndProccDelPRAct">Proceed</a>
                      </center>
                  </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
