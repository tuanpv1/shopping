<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/21/2016
 * Time: 8:48 AM
 */
use frontend\widgets\viewUser;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

?>
<section>
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?= Url::to(['site/index']) ?>">Home</a></li>
                <li><a href="<?= Url::to(['user/info']) ?>">Thông tin cá nhân</a></li>
                <li>Đổi mật khẩu</li>
            </ol>
        </div>
        <div class="row">
            <?= viewUser::Widget() ?>
            <div class="col-sm-9 padding-right">
                <h2 class="title text-center">Thay đổi mật khẩu</h2>
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="shopper-info">
                        <form>
                            <input type="password"  name="user_old_pass" id="user_old_pass" placeholder="Mật khẩu cũ">
                            <label id="old_pass" style="color:red">Mật khẩu cũ không đúng</label>
                            <label id="old_pass_input" style="color:red">Mật khẩu cũ không được để trống</label>
                            <input type="password" name="user_new_pass" id="user_new_pass" placeholder="Mật khẩu mới" >
                            <label id="new_pass_input" style="color:red">Mật khẩu mới không được để trống</label>
                            <input type="password" name="user_confirm_pass" placeholder="Xác nhận mật khẩu" id="user_confirm_pass" value="" >
                            <label id="confirm_pass" style="color:red">Mật khẩu mới không trùng khớp</label>
                            <label id="confirm_pass_input" style="color:red">Xác nhận mật khẩu không được để trống</label>
                            <br>

                            <a class="btn btn-primary" id="btn_pass" href="javascript:void(0)">Đổi mật khẩu</a>
                            <a href="<?= Url::to(['user/info']) ?>" class="btn btn-primary" id="btn">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
