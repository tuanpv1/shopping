<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/25/2016
 * Time: 10:45 PM
 */
use yii\helpers\Url;

?>
<div class="modal fade" tabindex="-1" id="modal_show" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thông Tin Mua Hàng</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 clearfix">
                        <img data-src="#" alt="" class="thumbnail" id="image_product" width="250px">
                    </div>
                    <div class="col-md-5 col-xs-12 col-sm-12">
                        <h4 class="alert alert-success" id="name_product">Tên SP</h4>
                        <p class="red"><span id = "price_product"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tiếp tục mua hàng</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
