<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/24/2016
 * Time: 6:20 PM
 */
use common\models\Product;
use kartik\grid\GridView;
use yii\helpers\Html;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        [
            'class' => '\kartik\grid\DataColumn',
            'label' => 'Ảnh SP',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $widget) {
                $link = Product::getFirstImageLinkTP(Product::findOne($model->product_id)->image);
                return $link ? Html::img($link, ['alt' => 'Thumbnail', 'width' => '50', 'height' => '50']) : '';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'product_id',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a(Product::findOne($model->product_id)->name, ['view', 'id' => $model->product_id], ['class' => 'label label-primary']);
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'price',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Product::formatNumber($model->price).' VND';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'sale',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return $model->sale?$model->sale.' %':' 0%';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'price_sale',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Product::formatNumber($model->price_sale).' VND';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'number',
            'value' => function ($model, $key, $index, $widget) {
                return $model->number.' Sản phẩm';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'total',
            'value' => function ($model, $key, $index, $widget) {
                return Product::formatNumber($model->total).' VND';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'created_at',
            'value' => function ($model, $key, $index, $widget) {
                return date('d/m/Y H:i:s', $model->created_at);
            },
        ],
    ],
]); ?>
