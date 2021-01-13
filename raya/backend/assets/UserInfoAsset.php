<?php

namespace backend\assets;

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
        '/../../core/assets/js/datepicker/persian-date.min.js',
        '/../../core/assets/js/datepicker/persian-datepicker.min.js',
        '/../../core/assets/js/user-info/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'airani\bootstrap\BootstrapRtlAsset',
    ];
}
