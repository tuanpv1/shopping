<?php
use common\models\Produce;
use yii\helpers\Html;
use kartik\grid\GridView;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'name',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a($model->name, ['produce/view', 'id' => $model->id], ['class' => 'label label-primary']);
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
                if ($model->status == Produce::STATUS_ACTIVE) {
                    return '<span class="label label-success">' . $model->getStatusName() . '</span>';
                } else {
                    return '<span class="label label-danger">' . $model->getStatusName() . '</span>';
                }

            },
            'filter' => Produce::getListStatus(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => "Tất cả"],
        ],
        'address',
        'phone',
    ],
]); ?>