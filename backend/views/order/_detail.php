<?php
use common\models\Order;
use common\models\Product;
use common\models\User;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>
<div class="tabbable-custom ">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => User::findOne($model->user_id)->username,
            ],
            [
                'attribute' => 'total',
                'value' => Product::formatNumber($model->total).' VND',
            ],
            [
                'attribute' => 'total_number',
                'value' => $model->total_number.' Sản phẩm',
            ],
            [
                'attribute' => 'name_buyer',
                'value' => $model->name_buyer,
            ],
            [
                'attribute' => 'email_buyer',
                'value' => $model->email_buyer,
            ],
            [
                'attribute' => 'phone_buyer',
                'value' => $model->phone_buyer,
            ],
            [
                'attribute' => 'address_buyer',
                'value' => $model->address_buyer,
            ],
            [
                'attribute' => 'name_receiver',
                'value' => $model->name_receiver,
            ],
            [
                'attribute' => 'phone_receiver',
                'value' => $model->phone_receiver,
            ],
            [
                'attribute' => 'address_receiver',
                'value' => $model->address_receiver,
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => Order::getStatus($model->status),
            ],
            [
                'attribute' => 'note',
                'value' => $model->note,
            ],
            [                      // the owner name of the model
                'attribute' => 'created_at',
                'label' => 'Ngày tạo',
                'value' => date('d/m/Y H:i:s', $model->created_at),
            ],
            [                      // the owner name of the model
                'attribute' => 'updated_at',
                'label' => 'Ngày thay đổi thông tin',
                'value' => date('d/m/Y H:i:s', $model->updated_at),
            ],
        ],
    ]) ?>
</div>