<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class UserInfoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/datepicker/persian-datepicker.min.css',
    ];
    public $js = [
        'js/datepicker/persian-date.min.js',
        'js/datepicker/persian-datepicker.min.js',
        'js/user-info/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'airani\bootstrap\BootstrapRtlAsset',
    ];
}
