<?php

use common\models\Category;
use common\models\Produce;
use common\models\Product;
use common\widgets\CKEditor;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
$avatarPreview = !$model->isNewRecord && !empty($model->image);

$id_category = Html::getInputId($model, 'id_category');

$js = <<<JS
    $("#$id_category").change(function () {
        var id_cat = $('#$id_category').val();
    });
JS;

?>

<div class="form-body">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'fullSpan' => 8,
//        'enableAjaxValidation' => true,
//        'enableClientValidation' => false,
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'thumbnail[]')->widget(\kartik\widgets\FileInput::classname(), [
        'options' => [
            'multiple' => true,
            'accept' => 'image/*',
            'style'=>'width: 100%;'

        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::to(['/product/upload-file']),
            'uploadExtraData' => [
                'type' => \common\models\Product::IMAGE_TYPE_THUMBNAIL,
                'thumbnail_old' => $model->thumbnail
            ],
            'allowedFileExtensions'=>['jpg','gif','jpeg','png'],
            'showUpload' => false,
            'showRemove' => true,
            'maxFileSize'=> Product::MAX_SIZE_UPLOAD,
            'maxFileCount' => 10,
            'minFileCount' => 1,
            'initialPreview' => $thumbnailPreview,
            'initialPreviewConfig' => $thumbnailInit,

        ],
        'pluginEvents' => [
            "fileuploaded" => "function(event, data, previewId, index) {
                var response=data.response;
                console.log(response.success);
                console.log(response);
                if(response.success){
                    console.log(response.output);
                    var current_screenshots=response.output;
                    var old_value_text=$('#images_tmp').val();
                    console.log('xxx'+old_value_text);
                    if(old_value_text !=null && old_value_text !='' && old_value_text !=undefined)
                    {
                        var old_value=jQuery.parseJSON(old_value_text);

                        if(jQuery.isArray(old_value)){
                            console.log(old_value);
                            old_value.push(current_screenshots);

                        }
                    }
                    else{
                        var old_value= [current_screenshots];
                    }
                    $('#images_tmp').val(JSON.stringify(old_value));
                 }
            }",
            "fileclear" => "function() {  console.log('delete'); }",
            "filedeleted" => "function(event, key) {
                    var image_deleted=key;
                    var old_value_text=$('#images_tmp').val();
                        var old_value=jQuery.parseJSON(old_value_text);

                        if(jQuery.isArray(old_value)){
                            var arrLength=old_value.length;

                            for (i = 0; i < old_value.length; i++) {
                                var row=old_value[i];
                                if(image_deleted == row['name']){

                                    old_value.splice(i,1);
                                    console.log(old_value);
                                }
                            }
                        }
                    else{
                        var old_value= [current_screenshots];
                    }
                    $('#images_tmp').val(JSON.stringify(old_value));
                }"
        ],

    ]) ?>

    <?=
    $form->field($model, 'image_des[]')->widget(\kartik\widgets\FileInput::classname(), [
        'options' => [
            'multiple' => true,
            'accept' => 'image/*',
            'style'=>'width: 100%;'

        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::to(['/product/upload-file']),
            'uploadExtraData' => [
                'type' => \common\models\Product::IMAGE_TYPE_DES,
                'image_des_old' => $model->image_des
            ],
            'allowedFileExtensions'=>['jpg','gif','jpeg','png'],
            'showUpload' => false,
            'showRemove' => true,
            'maxFileSize'=> Product::MAX_SIZE_UPLOAD,
            'maxFileCount' => 10,
            'minFileCount' => 1,
            'initialPreview' => $imageDesPreview,
            'initialPreviewConfig' => $imageDesInit,
        ],
        'pluginEvents' => [
            "fileuploaded" => "function(event, data, previewId, index) {
                var response=data.response;
                console.log(response.success);
                console.log(response);
                if(response.success){
                    console.log(response.output);
                    var current_screenshots=response.output;
                    var old_value_text=$('#images_tmp').val();
                    console.log('xxx'+old_value_text);
                    if(old_value_text !=null && old_value_text !='' && old_value_text !=undefined)
                    {
                        var old_value=jQuery.parseJSON(old_value_text);

                        if(jQuery.isArray(old_value)){
                            console.log(old_value);
                            old_value.push(current_screenshots);

                        }
                    }
                    else{
                        var old_value= [current_screenshots];
                    }
                    $('#images_tmp').val(JSON.stringify(old_value));
                 }
            }",
            "fileclear" => "function() {  console.log('delete'); }",
            "filedeleted" => "function(event, key) {
                    var image_deleted=key;
                    var old_value_text=$('#images_tmp').val();
                        var old_value=jQuery.parseJSON(old_value_text);

                        if(jQuery.isArray(old_value)){
                            var arrLength=old_value.length;

                            for (i = 0; i < old_value.length; i++) {
                                var row=old_value[i];
                                if(image_deleted == row['name']){

                                    old_value.splice(i,1);
                                    console.log(old_value);
                                }
                            }
                        }
                    else{
                        var old_value= [current_screenshots];
                    }
                    $('#images_tmp').val(JSON.stringify(old_value));
                }"
        ],

    ]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?php if($model->is_banner == 2){ ?>

        <?= $form->field($model, 'is_banner')->dropDownList([1=>'Không',2=>'Có']) ?>

    <?php } ?>

    <?= $form->field($model, 'id_category')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Category::find()->andWhere(['status'=>Category::STATUS_ACTIVE])->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Chọn doanh hãng sản xuất'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'id_produce')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Produce::find()->andWhere(['status'=>Produce::STATUS_ACTIVE])->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Chọn doanh nhà phân phối'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
//    ->andWhere(['id_cat'=>$id_cat])
    ?>

    <?= $form->field($model, 'sale')->textInput() ?>

    <?= $form->field($model, 'chip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_ram')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_hdd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'des')->widget(CKEditor::className(), [
        'options' => [
            'rows' => 6,
        ],
    ]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'touch')->dropDownList([ 1=>'Không', 2=>'Có' ]) ?>

    <?= $form->field($model, 'graphics')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os')->dropDownList([ 1=>'Windows', 2=>'Mac', 3=>'Free OS' ]) ?>

    <?= $form->field($model, 'Processor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_cpu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_cpu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'speed_cpu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cache')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'speed_max')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'motherboard')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Chipset')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'technology_cpu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wifi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hdmi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'webcam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lan')->textInput() ?>

    <?= $form->field($model, 'dvd')->dropDownList([ 1=>'Có', 2=>'Không' ]) ?>

    <?= $form->field($model, 'speed_bus')->textInput() ?>

    <?= $form->field($model, 'max_ram')->textInput() ?>

    <?= $form->field($model, 'ram')->textInput() ?>

    <?= $form->field($model, 'hdd')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(Product::getListStatus()) ?>

    <div class="row text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Hủy', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
