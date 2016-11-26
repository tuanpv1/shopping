<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/25/2016
 * Time: 7:11 PM
 */
use common\models\User;
use kartik\detail\DetailView;
use kartik\helpers\Html;

?>

<?= DetailView::widget([
    'model' => $model,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'attributes' => [
        [
            'label' => 'Ảnh đại diện',
            'format' => 'html',
            'value' => $model->image?Html::img('@web/avatar/' .$model->image, ['width' => '200px']):Html::img('@web/img/avt_df.png' , ['width' => '200px']),
        ],
        ['attribute' => 'username', 'format' => 'raw', 'value' => '<kbd>' . $model->username . '</kbd>', 'displayOnly' => true],
        [
            'label' => 'Họ tên',
            'format' => 'html',
            'value' => $model->fullname,
        ],
        'email:email',
        'phone',
        'address',
        [
            'label' => 'Giới tính',
            'value' => $model->gender?User::getGenderName($model->gender):'',
        ]
    ],
]) ?>
