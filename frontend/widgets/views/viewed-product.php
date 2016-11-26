<?php
use common\models\Product;
if(isset($viewedInfo)) {
?>
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Các sản phẩm đã xem</h2>
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
//                if(isset($viewedInfo)) {
                    $i = 0;
//                    for ($j = 0; $j < count($viewedInfo); $j++) {
                        ?>
                        <div class="item <?= $i < 3 ? 'active' : '' ?>">
                            <?php
                            foreach ($viewedInfo as $item) {
                                if($i < 3) {
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products tp_003">
                                                <div class="productinfo text-center">
                                                    <a href="<?= \yii\helpers\Url::to(['product/detail', 'id' => $item['id']]) ?>">
                                                        <img style="height: 170px"
                                                             src="<?= Product::getFirstImageLinkTP($item['image']) ?>"
                                                             alt="<?= $item['name'] ?>"/>
                                                    </a>
                                                    <br><br>
                                                    <p><?= $item['name'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                $i++;
                            }
                            ?>
                        </div>
                        <?php
//                    }
//                }
                ?>
        </div>
<!--        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">-->
<!--            <i class="fa fa-angle-left"></i>-->
<!--        </a>-->
<!--        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">-->
<!--            <i class="fa fa-angle-right"></i>-->
<!--        </a>-->
    </div>
</div><!--/recommended_items-->
<?php
}
?>