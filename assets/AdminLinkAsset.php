<?php

namespace app\assets;


use yii\web\AssetBundle;

class AdminLinkAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'media/css/link.css',
    ];
    public $js = [
        'media/js/link.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}