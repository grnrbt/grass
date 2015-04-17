<?php

namespace app\assets;


use yii\web\AssetBundle;

class AdminLinkAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'media/styles/link.css',
    ];
    public $js = [
        'media/scripts/vendor/jquery.cookie.js',
        'media/scripts/vendor/require.js',
        'media/scripts/link.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}