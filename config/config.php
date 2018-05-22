<?php

$db = require __DIR__.'/database.php';
$keys = require __DIR__.'/keys.php';

return [
    'id'         => 'micro-app',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'modules'    => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
    ],
    'components' => [
        'request'    => [
            'enableCsrfCookie' => false,
        ],
        'log'        => [
            'traceLevel'    => YII_DEBUG ? 3 : 0,
            'flushInterval' => 1,
            'targets'       => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    //                    'levels' => ['error', 'warning', 'info'],
                    //                    'logFile' => '@app/runtime/logs/main.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules'               => [
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'v1/user',
                    'extraPatterns' => [
                        'GET test'     => 'test',
                        'OPTIONS test' => 'options',
                    ],
                ],
            ],
        ],
        'user'       => [
            'identityClass' => 'app\common\models\UserModel',
            'enableSession' => false,
        ],
        'db'         => $db,
        'jwt'        => [
            'class'          => 'app\common\components\Jwt',
            'privateKeyFile' => $keys['privateKeyFile'],
            'publicKeyFile'  => $keys['publicKeyFile'],
        ],
    ],
];