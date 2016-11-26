<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/21/2016
 * Time: 8:48 AM
 */
use frontend\widgets\viewUser;
use kartik\helpers\Html;
use yii\helpers\Url;

?>
<section>
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?= Url::to(['site/index']) ?>">Home</a></li>
                <li class="active">Thông tin cá nhân</li>
            </ol>
        </div>
        <div class="row">
            <?= viewUser::Widget() ?>
            <div class="col-sm-9 padding-right">
                <h2 class="title text-center">Thông tin chi tiết người dùng</h2>
                <p>
                    <?= Html::a('Cập nhật', ['update'], ['class' => 'btn btn-primary']) ?>
                </p>
                <div class="tabbable-custom nav-justified">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="<?php echo $active==1? 'active':'';?>">
                            <a href="#tab_info" data-toggle="tab">
                                Thông tin</a>
                        </li>

                        <li class="<?php echo $active==2? 'active':'';?>">
                            <a href="#tab_images" data-toggle="tab">
                                Lịch sử đơn hàng</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane <?php echo $active==1? 'active':'';?>" id="tab_info">
                            <?= $this->render('_detail', [
                                'model' => $model
                            ]) ?>
                        </div>

                        <div class="tab-pane <?php echo $active==2? 'active':'';?>" id="tab_images">
                            <?= $this->render('_order', [
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,

                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
