<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/20/2016
 * Time: 1:29 PM
 */
use common\models\Category;
use common\models\Product;
use frontend\widgets\viewedProduct;
use frontend\widgets\viewModal;
use yii\helpers\Url;

?>
<style>
    .fb_iframe_widget,.fb_iframe_widget span, .fb_iframe_widget span iframe[style] { min-width: 100% !important; width: 100% !important;
    }
</style>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Hãng sản xuất</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        <?php
                        if($cat){
                            foreach($cat as $item){
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a href="<?= Url::to(['product/category','id_cat'=>$item->id]) ?>"><?= $item->name ?></a></h4>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div><!--/category-products-->

                    <div class="price-range"><!--price-range-->
                        <h2>Giá</h2>
                        <div class="well text-center">
                            <input type="text" class="span2" value="" data-slider-min="4000000" data-slider-max="50000000" data-slider-step="5" data-slider-value="[4000000,10000000]" id="sl2" ><br />
                            <b class="pull-left">4,000,000 VND</b> <b class="pull-right">50,000,000 VND</b>
                        </div>
                    </div><!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/shipping.jpg" alt="" />
                    </div><!--/shipping-->

                </div>
            </div>
            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div id="amazingslider-wrapper-1" style="display:block;position:relative;max-width:330px;margin:0px auto 86px;">
                            <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
                                <ul class="amazingslider-slides" style="display:none;">
                                    <?php
                                    $img = $model->getImages();
                                        if($img){
                                            foreach($img as $item){
                                                ?>
                                                    <li><img src="<?= Product::getImageFe($item->name) ?>"/></li>
                                                <?php
                                            }
                                        }
                                    ?>
                                </ul>
                                <ul class="amazingslider-thumbnails" style="display:none;">
                                    <?php
                                    $img = $model->getImages();
                                    if($img){
                                        foreach($img as $item){
                                            ?>
                                            <li><img id="product_image" src="<?= Product::getImageFe($item->name) ?>" /></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="product-information"><!--/product-information-->
                            <?php
//                            echo "<pre>";print_r($model-/>sale);die();
                            if($model->sale != 0){
                                ?>
                                <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/sale.png" class="new" alt="" />
                                <?php
                            }else if($model->created_at >= $from && $model->created_at <= $now ){
                                ?>
                                <img  src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/product-details/new.jpg" class="newarrival" alt="" />
                                <?php
                            }
                            ?>
                            <h2 id="product_name"><?= $model->name ?></h2>
                            <p>Nhà sản xuất: <?= Category::findOne(['id'=>$model->id_category])->name ?></p>
                            <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/product-details/rating.png" alt="" />
                                                <span>
                                                    <span id="product_price">
                                                        <?php
//                                                            $va = $model->getImages();
//                                                            echo"<pre>";print_r($va);die();
                                                            if($model->sale == null){
                                                                echo Product::formatNumber($model->price).' VND';
                                                            }else{
                                                                $val = ($model->price*(100-$model->sale))/100;
                                                                echo Product::formatNumber($val).' VND';
                                                            }
                                                        ?>
                                                    </span>
                                                    <p>
                                                        <a type="button" class="btn btn-fefault cart" href="javascript:void(0)" onclick="addCart(<?= $model->id ?>)"><i class="fa fa-shopping-cart"></i> Mua ngay</a>
                                                    </p>
                                                </span>
                            <p><b>Trạng thái:</b> <?= $model->status==Product::STATUS_ACTIVE?'Còn hàng':''?></p>
                            <p><b>Cung cấp bởi:</b> E-SHOPPING</p>
                            <a href=""><img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/product-details/share.png" class="share img-responsive"  alt="" /></a>
                        </div><!--/product-information-->
                    </div>
                </div><!--/product-details-->

                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
                            <li><a href="#companyprofile" data-toggle="tab">Thông số kĩ thuật</a></li>
                            <li><a href="#tag" data-toggle="tab">Nhật xét</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade  active in" id="details" >
                            <?= $model->des?$model->des:'Đang cập nhật' ?>
                        </div>

                        <div class="tab-pane fade" id="companyprofile" >
                            <?= $this->render('_detail', [
                                'model' => $model
                            ]) ?>
                        </div>

                        <div class="tab-pane fade text-center" id="tag" >
                            <div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>
                            <div class="fb-comments" xid="<?php echo $model->id; ?> data-numposts="20" data-colorscheme="light" data-version="v2.3"></div>
                        </div>

                    </div>
                </div><!--/category-tab-->

                <?= viewedProduct::Widget()?>
                <?= viewModal::Widget() ?>
            </div>
        </div>
    </div>
</section>
