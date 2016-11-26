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
                <h2 class="title text-center">Thay đổi ảnh đại diện</h2>
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="shopper-info">
                        <div class="panel-heading text-center">
                            <img style="width: 180px" src="<?= $model->getAvatar() ?>" alt="">
                        </div>
                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'image')->fileInput()?>

                        <button class="btn btn-primary" id="btn">Cập nhật</button>
                        <a href="<?= Url::to(['user/info']) ?>" class="btn btn-primary" id="btn">Hủy</a>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
