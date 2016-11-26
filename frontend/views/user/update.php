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
                <li><a href="<?= Url::to(['user/info']) ?>">Thông tin cá nhân</a></li>
                <li class="active">cập nhật thông tin cá nhân</li>
            </ol>
        </div>
        <div class="row">
            <?= viewUser::Widget() ?>
            <div class="col-sm-9 padding-right text-center">
                <h2 class="title text-center">Nhập thông tin cập nhật</h2>
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="shopper-info">
                        <form action="<?= Url::to(['user/update']) ?>" method="post" enctype="multipart/form-data">
                            <input type="text" readonly="readonly" name="user_name" id="user_name" placeholder="Tên đăng nhập" value="<?= $model->username?$model->username:'' ?>">
                            <input type="text" name="full_name" id="full_name" placeholder="Họ và tên" value="<?= $model->fullname?$model->fullname:'' ?>">
                            <input type="email" name="user_email" required placeholder="Địa chỉ email" id="user_email" value="<?= $model->email?$model->email:'' ?>">
                            <input type="tel" name="user_phone" required placeholder="Số điện thoại người mua hàng" id="user_phone" value="<?= $model->phone?'0'.$model->phone:'' ?>">
                            <input type="text" required name="user_adress" placeholder="Địa chỉ người mua hàng" id="user_adress" value="<?= $model->address?$model->address:'' ?>">
                            <input type="hidden" id="check_post" name="check_post" value="1">
                            <select name="user_gender">
                                <option value="1">Nam</option>
                                <option value="2">Nữ</option>
                            </select>
                            <button class="btn btn-primary" id="btn">Cập nhật</button>
                            <a href="<?= Url::to(['user/info']) ?>" class="btn btn-primary" id="btn">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
