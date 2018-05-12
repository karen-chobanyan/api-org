<?php

return [
    'id' => 'micro-app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'flushInterval' => 1,
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning', 'info'],
//                    'logFile' => '@app/runtime/logs/main.log',
                ],
            ],
        ],
    ],
//  'controllerNamespace' => 'micro\controllers',
//  'aliases' => [
//    '@micro' => __DIR__,
//  ],
];