<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/20/2016
 * Time: 6:03 PM
 */
use frontend\widgets\viewedProduct;
use yii\helpers\Url;
use common\models\Product;
?>
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
                            <b class="pull-left">4000000 VND</b> <b class="pull-right">50000000 VND</b>
                        </div>
                    </div><!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/shipping.jpg" alt="" />
                    </div><!--/shipping-->

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Danh sách sản phẩm</h2>
                    <?php
                    if($product){
                        foreach($product as $item){
//                            echo "<pre>";print($item->image);die();

                            ?>
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="tp_001 single-products">
                                        <div class="productinfo text-center">
                                            <img style="height: 170px" src="<?= Product::getFirstImageLinkTP($item->image) ?>" alt="<?= $item->name ?>" />
                                            <?php
                                            if($item->sale != 0){
                                                ?>
                                                <h2 style="font-size: medium">Giá còn: <?= Product::formatNumber(($item->price*(100-$item->sale))/100).' VND'?></h2>
                                                <p>Giá cũ: <span class="tp_002"><?= Product::formatNumber($item->price) ?></span> VND</p>
                                                <?php
                                            }else{
                                                ?>
                                                <h2 style="font-size: medium"   >Giá: <?= Product::formatNumber($item->price).' VND'?></h2>
                                                <?php
                                            }
                                            ?>
                                            <p><?= $item->name ?></p>
                                        </div>
                                        <div class="product-overlay">
                                            <div class="overlay-content">
                                                <?php
                                                if($item->sale != null || $item->sale != 0){
                                                    ?>
                                                    <h2 style="font-size: medium"   >Giá còn: <?= Product::formatNumber(($item->price*(100-$item->sale))/100).' VND'?></h2>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <h2 style="font-size: medium"   >Giá: <?= Product::formatNumber($item->price).' VND'?></h2>
                                                    <?php
                                                }
                                                ?>
                                                <p><?= $item->name ?></p>
                                                <p>Dung lượng Ram <?= $item->ram ?> GB</p>
                                                <p>Chipset: <?= $item->technology_cpu ?> GB</p>
                                                <p>Ổ cứng <?= $item->type_hdd==1?'HDD':'SSD' ?> Dung lượng <?= $item->hdd ?></p>
                                                <a href="<?= Url::to(['product/detail','id'=>$item->id])?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem cấu hình chi tiết</a>
                                            </div>
                                        </div>
                                        <?php
                                            if($item->sale !=0){
                                                ?>
                                                <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/sale.png" class="new" alt="" />
                                                <?php
                                            }else if($item->created_at >= $from && $item->created_at <= $now ){
                                            ?>
                                            <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/new.png" class="new" alt="" />
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href="javascript:void(0)" onclick="addCart(<?= $item->id ?>)"><i class="fa fa-plus-square"></i>Mua ngay</a></li>
                                            <li><a href="<?= Url::to(['product/detail','id'=>$item->id])?>"><i class="fa fa-plus-square"></i>Xem chi tiết</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }else{
                        ?>
                        Đang cập nhật
                        <?php
                    }
                    ?>
                </div><!--features_items-->
                <div>
                    <ul class="pagination">
                        <?php
                        if(isset($totalCountIndex)){
                            $pagination = new \yii\data\Pagination(['totalCount' => $totalCountIndex->totalCount,'pageSize' =>10]);
                            echo \yii\widgets\LinkPager::widget([
                                'pagination' => $pagination,
                            ]);
                        }
                        if(isset($totalCount)){
                            $pagination = new \yii\data\Pagination(['totalCount' => $totalCount,'pageSize' =>2]);
                            echo \yii\widgets\LinkPager::widget([
                                'pagination' => $pagination,
                            ]);
                        }
                        ?>
                    </ul>
                </div>
                <?= viewedProduct::Widget()?>
            </div>
        </div>
    </div>
</section>
