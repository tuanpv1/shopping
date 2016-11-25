<?php

use common\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Cập nhật người dùng ' . $model->fullname?$model->fullname:$model->username;
$this->params['breadcrumbs'][] = ['label' => 'QL người dùng '.User::getTypeNameByID($model->type), 'url' => ['index','type'=>$model->type]];
$this->params['breadcrumbs'][] = ['label' => $model->fullname?$model->fullname:$model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-gift"></i><?=$this->title?></div>
            </div>
            <div class="portlet-body form">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
