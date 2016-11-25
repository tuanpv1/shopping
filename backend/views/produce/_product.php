<?php
use common\models\Produce;
use common\models\Product;
use kartik\grid\GridView;
use yii\helpers\Html;

?>
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
                return Html::a($model->name, ['product/view', 'id' => $model->id], ['class' => 'label label-primary']);
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
    ],
]); ?>