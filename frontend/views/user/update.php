<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/21/2016
 * Time: 8:48 AM
 */
use common\models\User;
use frontend\widgets\viewUser;
use kartik\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
$avatarPreview = !$model->isNewRecord && !empty($model->image);
?>
<section>
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?= Url::to(['site/index']) ?>">Home</a></li>
                <li><a href="<?= Url::to(['site/index']) ?>">Thông tin cá nhân</a></li>
                <li class="active">cập nhật thông tin cá nhân</li>
            </ol>
        </div>
        <div class="row">
            <?= viewUser::Widget() ?>
            <div class="col-sm-9 padding-right">
                <h2 class="title text-center">Nhập thông tin cập nhật</h2>

                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data'],
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'fullSpan' => 8,
                ]); ?>

                <?= $form->field($model, 'username')->textInput(['maxlength' => true,'readonly'=>true]) ?>

                <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'image')->fileInput()?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'gender')->dropDownList([
                        'data' => User::getListGender(),
                    ]
                )?>

                <div class="row text-center">
                    <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    <?= Html::a('Hủy', ['user/info'], ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</section>
