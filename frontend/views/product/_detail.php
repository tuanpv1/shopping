<?php
use common\models\Product;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>
<div class="tabbable-custom ">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_category',
                'value' => \common\models\Category::findOne($model->id_category)->name,
            ],
            [
                'attribute' => 'chip',
                'value' => $model->chip,
            ],
            [
                'attribute' => 'type_ram',
                'value' => $model->type_ram,
            ],
            [
                'attribute' => 'type_hdd',
                'value' => $model->type_hdd,
            ],
            [
                'attribute' => 'webcam',
                'value' => $model->webcam,
            ],
            [
                'attribute' => 'max_ram',
                'value' => $model->max_ram?$model->max_ram.' GB':'Chưa cập nhật',
            ],
            [
                'attribute' => 'ram',
                'value' => $model->ram?$model->ram.' GB':'Chưa cập nhật',
            ],
            [
                'attribute' => 'hdd',
                'value' => $model->hdd?$model->hdd.' GB':'Chưa cập nhật',
            ],
            [
                'attribute' => 'lan',
                'value' => $model->lan==1?'Có':'Không',
            ],
            [
                'attribute' => 'dvd',
                'value' => $model->dvd==1?'có':'Không',
            ],
            [
                'attribute' => 'speed_bus',
                'value' => $model->speed_bus?$model->speed_bus.' Mhz':'Chưa cập nhật',
            ],
            [
                'attribute' => 'size',
                'value' => $model->size?$model->size.' inch':'Chưa cập nhật',
            ],
            [
                'attribute' => 'touch',
                'value' => $model->touch==1?'Không':'Có',
            ],
            [
                'attribute' => 'graphics',
                'value' => $model->graphics,
            ],
            [
                'attribute' => 'pin',
                'value' => $model->pin,
            ],
            [
                'attribute' => 'weight',
                'value' => $model->weight,
            ],
            [
                'attribute' => 'os',
                'value' => Product::getOS($model->os),
            ],
            [
                'attribute' => 'Processor',
                'value' => $model->Processor,
            ],
            [
                'attribute' => 'type_cpu',
                'value' => $model->type_cpu,
            ],
            [
                'attribute' => 'product_cpu',
                'value' => $model->product_cpu,
            ],
            [
                'attribute' => 'speed_cpu',
                'value' => $model->speed_cpu,
            ],
            [
                'attribute' => 'cache',
                'value' => $model->cache?$model->cache.' MB':'Chưa cập nhật',
            ],
            [
                'attribute' => 'speed_max',
                'value' => $model->speed_max,
            ],
            [
                'attribute' => 'motherboard',
                'value' => $model->motherboard,
            ],
            [
                'attribute' => 'Chipset',
                'value' => $model->Chipset,
            ],
            [
                'attribute' => 'technology_cpu',
                'value' => $model->technology_cpu,
            ],
            [
                'attribute' => 'wifi',
                'value' => $model->wifi,
            ],
            [
                'attribute' => 'hdmi',
                'value' => $model->hdmi,
            ],
            [
                'attribute' => 'color',
                'value' => $model->color,
            ],
        ],
    ]) ?>
</div>