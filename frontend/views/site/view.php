<?php

use common\models\Product;
use frontend\widgets\viewUser;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
?>
<section>
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?= Url::to(['site/index']) ?>">Home</a></li>
                <li><a href="<?= Url::to(['user/info']) ?>">Thông tin cá nhân</a></li>
                <li class="active">Chi tiết đơn hàng</li>
            </ol>
        </div>
        <div class="row">
            <?= viewUser::Widget() ?>
            <div class="col-sm-9 padding-right">
                <h2 class="title text-center">Thông tin chi tiết đơn hàng</h2>
                <ul class="nav nav-tabs nav-justified">
                    <li class="<?php echo $active==1? 'active':'';?>">
                        <a href="#tab_info" data-toggle="tab">
                            Thông tin đơn hàng </a>
                    </li>

                    <li class="<?php echo $active==2? 'active':'';?>">
                        <a href="#tab_images" data-toggle="tab">
                            Sản phẩm trong đơn hàng</a>
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
                            'model' => $model,
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
