<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Hãng sản xuất', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"><?= $this->title ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-custom ">
                    <p>
                        <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Xóa', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Bạn chắc chắn muốn xóa hãng sản xuất '.$model->name.'?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <div class="tabbable-custom nav-justified">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="<?php echo $active==1? 'active':'';?>">
                                <a href="#tab_info" data-toggle="tab">
                                    Thông tin</a>
                            </li>

                            <li class="<?php echo $active==2? 'active':'';?>">
                                <a href="#tab_images" data-toggle="tab">
                                    Sản phẩm</a>
                            </li>

                            <li class="<?php echo $active==3? 'active':'';?>">
                                <a href="#tab_produce" data-toggle="tab">
                                    Danh sách nhà phân phối</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?php echo $active==1? 'active':'';?>" id="tab_info">
                                <?= $this->render('_detail', [
                                    'model' => $model
                                ]) ?>
                            </div>

                            <div class="tab-pane <?php echo $active==2? 'active':'';?>" id="tab_images">
                                <?= $this->render('_product', [
                                    'searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                ]) ?>
                            </div>

                            <div class="tab-pane <?php echo $active==3? 'active':'';?>" id="tab_produce">
                                <?= $this->render('_produce', [
                                    'searchModel' => $searchModelProduce,
                                    'dataProvider' => $dataProviderProduce,
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
