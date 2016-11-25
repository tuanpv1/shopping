<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Product */
if($is_banner == 1){
    $this->title = 'Thêm Sản phẩm';
    $this->params['breadcrumbs'][] = ['label' => 'Danh sách sản phẩm', 'url' => ['index', 'is_banner'=>$is_banner]];
}else{
    $this->title = 'Thêm Banner';
    $this->params['breadcrumbs'][] = ['label' => 'Danh sách sản phẩm banner', 'url' => ['index','is_banner'=>$is_banner]];
}
$this->params['breadcrumbs'][] = $this->title;
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
                    'thumbnailInit' => $thumbnailInit,
                    'thumbnailPreview' => $thumbnailPreview,
                    'imageDesInit' => $imageDesInit,
                    'imageDesPreview' => $imageDesPreview,
                ]) ?>
            </div>
        </div>
    </div>
</div>

