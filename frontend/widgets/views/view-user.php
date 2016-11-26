<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/25/2016
 * Time: 8:30 PM
 */
use yii\helpers\Url;

?>
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Trang cá nhân</h2>
        <div class="panel-group category-products" id="accordian">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <img style="width: 80px" src="<?= $model->getAvatar() ?>" alt="">
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4 class="panel-title "><a href="<?= Url::to(['user/change-avatar']) ?>">đổi avatar</a></h4>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4 class="panel-title "><a href="<?= Url::to(['user/change-password']) ?>">đổi mật khẩu</a></h4>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4 class="panel-title "><a href="<?= Url::to(['user/info']) ?>"><?= $model->username ?></a></h4>
                </div>
            </div>
        </div>

        <div class="shipping text-center"><!--shipping-->
            <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/shipping.jpg" alt="" />
        </div><!--/shipping-->

    </div>
</div>
