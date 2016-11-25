<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/21/2016
 * Time: 8:48 AM
 */
use frontend\widgets\viewUser;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

?>
<section>
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?= Url::to(['site/index']) ?>">Home</a></li>
                <li><a href="<?= Url::to(['user/info']) ?>">Thông tin cá nhân</a></li>
                <li>Đổi mật khẩu</li>
            </ol>
        </div>
        <div class="row">
            <?= viewUser::Widget() ?>
            <div class="col-sm-9 padding-right">
                <h2 class="title text-center">Thay đổi mật khẩu</h2>
                <div class="tabbable-custom nav-justified">
                    <?php $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                    ]); ?>

                    <div>
                        <?= $form->field($model, 'old_password')->passwordInput(['placeholder'=>'Nhập mật khẩu cũ'])->label('Mật khẩu cũ (*)') ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'setting_new_password')->passwordInput(['placeholder'=>'Nhập mật khẩu mới'])->label('Mật khẩu mới (*)')  ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder'=>'Xác nhận mật khẩu mới'])->label('Xác nhận mật khẩu mới (*)')  ?>
                    </div>
                    <div class="text-center">
                        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Đổi mật khẩu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        <?= Html::a('Hủy', ['user/info'], ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
