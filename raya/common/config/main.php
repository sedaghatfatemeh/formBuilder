<?php
return [
    'aliases' => [
        '@bower' => dirname(dirname(__DIR__)) .'/../'.'vendor/bower-asset',
        '@npm'   => dirname(dirname(__DIR__)) .'/../'.'vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
//            'debug/<controller>/<action>' => 'debug/<controller>/<action>',
        ],
    ],
];
