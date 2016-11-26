<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Category;
use common\models\User;
use frontend\widgets\cartWidget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/ico/apple-touch-icon-57-precomposed.png">
</head>
<body>
<?php $this->beginBody() ?>
<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> +84 01 88 821</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> shopping@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="<?= Url::to(['site/index']) ?>"><img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/logo.png" alt="" /></a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <?php
                            if (Yii::$app->user->isGuest) {
                                ?>
                                <li><a href="<?= Url::to(['user/info'])?>"><i class="fa fa-user"></i> Tài Khoản</a></li>
                                <?php
                            } else {
                                ?>
                                <li><a href="<?= Url::to(['user/info'])?>"><i class="fa fa-user"></i><?= Yii::$app->user->identity->username ?></a></li>
                                <?php
                            }
                            ?>
                            <?= cartWidget::Widget() ?>
                            <?php
                                if (Yii::$app->user->isGuest) {
                            ?>
                            <li><a href="<?= Url::to(['site/login'])?>"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a href="<?= Url::to(['site/logout'])?>" data-method="post"><i class="fa fa-unlock"></i> Đăng xuất</a></li>
                                    <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="<?= Url::to(['site/index'])?>" class="active">Trang chủ</a></li>
                            <li class="dropdown"><a href="#">Hãng sản xuất<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <?php
                                        $cat = Category::find()->andWhere(['status'=>Category::STATUS_ACTIVE])->all();
                                        foreach($cat as $item) {
                                            ?>
                                            <li><a href="<?=Url::to(['product/category','id_cat'=>$item->id])?>"><?= $item->name ?></a></li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                            <li><a href="<?= Url::to(['product/index']) ?>">Sản phẩm</a></li>
                            <li><a href="<?= Url::to(['product/sale']) ?>">Sale</a></li>
                            <li><a href="<?= Url::to(['site/contact'])?>">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
                        <input id="key_search" onchange="getSearch()" type="text" placeholder="Tìm kiếm"/>
                    </div>
                </div>
            </div>
            <?= Alert::widget() ?>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->
<?= $content ?>
<footer id="footer"><!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span>e</span>-shopping</h2>
                        <p>Giá cả hợp lý, hãy đặt hàng ngay để hưởng chương trình ưu đãi</p>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/iframe1.png" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/iframe2.png" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/iframe3.png" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/iframe4.png" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="address">
                        <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/home/map.png" alt="" />
                        <p>Địa chỉ E-SHOPPING: 124 Hoàng Quốc Việt</p>
                    </div>
                </div>
            </div>
        </div>
    </div

    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Service</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="">Trợ giúp</a></li>
                            <li><a href="">Liên hệ</a></li>
                            <li><a href="">Order Status</a></li>
                            <li><a href="">Change Location</a></li>
                            <li><a href="">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Quock Shop</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="">Dell</a></li>
                            <li><a href="">Apple</a></li>
                            <li><a href="">Xaomi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Policies</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="">Terms of Use</a></li>
                            <li><a href="">Privecy Policy</a></li>
                            <li><a href="">Refund Policy</a></li>
                            <li><a href="">Billing System</a></li>
                            <li><a href="">Ticket System</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="">Thông tin E_SHOPPING</a></li>
                            <li><a href="">Careers</a></li>
                            <li><a href="">Store Location</a></li>
                            <li><a href="">Affillate Program</a></li>
                            <li><a href="">Copyright</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <form action="#" class="searchform">
                            <input type="text" placeholder="Your email address" />
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <p>Get the most recent updates from <br />our site and be updated your self...</p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2016 E-SHOPPING Inc. All rights reserved.</p>
                <p class="pull-right">Designed by <span>Romeo</span></p>
            </div>
        </div>
    </div>

</footer><!--/Footer-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
