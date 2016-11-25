<?php

use common\models\Category;
use common\models\Produce;
use common\models\Product;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if($is_banner == 1){
    $this->title = 'Danh sách sản phẩm';
}else{
    $this->title = 'Danh sách sản phẩm banner';
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span
                        class="caption-subject font-green-sharp bold uppercase"><?= $this->title ?> </span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <p>
                <?= Html::a('Thêm mới', ['create','is_banner'=>$is_banner], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="portlet-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],

//                    'id',
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'image',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $widget) {
                            $link = $model->getFirstImageLink();
                            return $link ? Html::img($link, ['alt' => 'Thumbnail', 'width' => '50', 'height' => '50']) : '';
                        },
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'name',
                        'format' => 'html',
                        'value' => function ($model, $key, $index, $widget) {
                            return Html::a($model->name, ['view', 'id' => $model->id], ['class' => 'label label-primary']);
                        },
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'status',
                        'width' => '120px',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $widget) {
                            /**
                             * @var $model common\models\Product
                             */
                            if ($model->status == Product::STATUS_ACTIVE) {
                                return '<span class="label label-success">' . $model->getStatusName() . '</span>';
                            } else {
                                return '<span class="label label-danger">' . $model->getStatusName() . '</span>';
                            }

                        },
                        'filter' => Product::getListStatus(),
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => "Tất cả"],
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'format'=>'raw',
                        'attribute' => 'id_produce',
                        'value' => function ($model, $key, $index, $widget) {
                            return Html::a(Produce::findOne($model->id_produce)->name, ['produce/view', 'id' => $model->id_produce]);
                        },
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'format'=>'raw',
                        'attribute' => 'id_category',
                        'value' => function ($model, $key, $index, $widget) {
                            return Html::a(Category::findOne($model->id_category)->name, ['category/view', 'id' => $model->id_category]);
                        },
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'format'=>'raw',
                        'attribute' => 'price',
                        'value' => function ($model, $key, $index, $widget) {
                            return Product::formatNumber($model->price).' VND';
                        },
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'format'=>'raw',
                        'attribute' => 'sale',
                        'value' => function ($model, $key, $index, $widget) {
                            return $model->sale?$model->sale.' %':'0'.' %';
                        },
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}',
                    ],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
