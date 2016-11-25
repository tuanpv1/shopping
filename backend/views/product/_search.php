<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'des') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'chip') ?>

    <?php // echo $form->field($model, 'type_ram') ?>

    <?php // echo $form->field($model, 'type_hdd') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'touch') ?>

    <?php // echo $form->field($model, 'graphics') ?>

    <?php // echo $form->field($model, 'pin') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'os') ?>

    <?php // echo $form->field($model, 'Processor') ?>

    <?php // echo $form->field($model, 'type_cpu') ?>

    <?php // echo $form->field($model, 'product_cpu') ?>

    <?php // echo $form->field($model, 'speed_cpu') ?>

    <?php // echo $form->field($model, 'cache') ?>

    <?php // echo $form->field($model, 'speed_max') ?>

    <?php // echo $form->field($model, 'motherboard') ?>

    <?php // echo $form->field($model, 'Chipset') ?>

    <?php // echo $form->field($model, 'technology_cpu') ?>

    <?php // echo $form->field($model, 'wifi') ?>

    <?php // echo $form->field($model, 'hdmi') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'webcam') ?>

    <?php // echo $form->field($model, 'lan') ?>

    <?php // echo $form->field($model, 'dvd') ?>

    <?php // echo $form->field($model, 'sale') ?>

    <?php // echo $form->field($model, 'speed_bus') ?>

    <?php // echo $form->field($model, 'max_ram') ?>

    <?php // echo $form->field($model, 'ram') ?>

    <?php // echo $form->field($model, 'hdd') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
