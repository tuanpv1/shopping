<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title text-center">Liên hệ<strong>Us</strong></h2>
                <div id="gmap" class="contact-map">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="contact-form">
                    <h2 class="title text-center">Gửi ý kiến</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                        </div>
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'email') ?>
                        </div>
                        <div class="form-group col-md-12">
                            <?= $form->field($model, 'subject') ?>
                        </div>
                        <div class="form-group col-md-12">
                            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
                        </div>
                        <div class="form-group col-md-12">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-info">
                    <h2 class="title text-center">Thông tin liên hệ</h2>
                    <address>
                        <p>E-Shopping.</p>
                        <p>124 Hoàng Quốc Việt, Hà Nội</p>
                        <p>Việt Nam</p>
                        <p>Mobile: +84 17 38 93</p>
                        <p>Fax: 1-714-252-0026</p>
                        <p>Email: shopping@gmail.com</p>
                    </address>
                    <div class="social-networks">
                        <h2 class="title text-center">Kết nối với chúng tôi</h2>
                        <ul>
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--/#contact-page-->
