
<?php
use yii\widgets\DetailView;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        [
            'attribute' => 'status',
            'label' => 'Trạng thái',
            'format' => 'raw',
            'value' => ($model->status == \common\models\Category::STATUS_ACTIVE) ?
                '<span class="label label-success">' . $model->getStatusName() . '</span>' :
                '<span class="label label-danger">' . $model->getStatusName() . '</span>',
        ],
        [                      // the owner name of the model
            'attribute' => 'created_at',
            'label' => 'Ngày tham gia',
            'value' => date('d/m/Y H:i:s', $model->created_at),
        ],
        [                      // the owner name of the model
            'attribute' => 'updated_at',
            'label' => 'Ngày thay đổi thông tin',
            'value' => date('d/m/Y H:i:s', $model->updated_at),
        ],
    ],
]) ?>