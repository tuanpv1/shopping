<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="login-form"><!--login form-->
                        <h2 class="text-center">Đăng kí tài khoản</h2>
                        <?php $form = ActiveForm::begin([
                            'id' => 'form-signup',
                        ]); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'Tên đăng nhập'])->label('Tên đăng nhập (*)') ?>

                        <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder'=>'Email'])->label('Email (*)') ?>

                        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Mật khẩu'])->label('Mật khẩu (*)') ?>

                        <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder'=> 'Xác nhận mật khẩu'])->label('Nhập lại mật khẩu (*)') ?>

                        <?= $form->field($model, 'phone')->textInput(['placeholder'=>'Số điện thoại']) ?>

                        <?= $form->field($model, 'address')->textInput(['placeholder'=>'Địa chỉ'])->label('Địa chỉ (*)') ?>

                        <div class="form-group">
                            <?= $form->field($model,'accept')->checkbox()->label('Tôi đồng ý với quy định và điều khoản của trang (*)')?>
                        </div>

                        <div style="color:#999;margin:1em 0">
                            Đã có tài khoản <?= Html::a('Đăng nhập', ['site/login']) ?> ngay
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('ĐĂNG KÝ', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div><!--/login form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
</div>

