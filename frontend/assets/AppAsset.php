<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/prettyPhoto.css',
        'css/price-range.css',
        'css/animate.css',
        'css/main.css',
        'css/responsive.css',
        'sliderengine/amazingslider-1.css',
        'css/site.css',
    ];
    public $js = [
        'js/jquery.js',
        'js/price-range.js',
        'js/jquery.scrollUp.min.js',
        'js/bootstrap.min.js',
        'js/jquery.prettyPhoto.js',
        'js/main.js',
        'js/bootstrap.js',
        'js/tp.js',
        'sliderengine/jquery.js',
        'sliderengine/amazingslider.js',
        'sliderengine/initslider-1.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}