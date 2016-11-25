<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/25/2016
 * Time: 7:15 PM
 */
use common\models\Order;
use common\models\Product;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'id',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a($model->id, ['site/view', 'id' => $model->id], ['class' => 'label label-primary']);
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'created_at',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return date('d/m/Y H:i:s', $model->created_at);
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'total',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Product::formatNumber($model->total).' VND';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'total_number',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return $model->total_number.' Sản phẩm';
            },
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'status',
            'width' => '200px',
            'value' => function ($model, $key, $index, $widget) {
                /** @var $model \common\models\ContentFeedback */

                return $model->getStatusName();
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => Order::getListStatus(),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Tất cả'],
        ],

        ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['site/view', 'id' => $model->id]), [
                        'title' => 'Thông tin chi tiết đơn hàng',
                    ]);

                },
            ]
        ],
    ],
]); ?>
