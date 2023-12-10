<?php
use \yii\web\Request;
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl()); // you set override the frontend/web with blank space and it will return the baseUrl.
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'en-US', //'ru-RU',
    'sourceLanguage' => 'en-US',

    'as beforeRequest' => [

        'class' => 'app\components\LanguageHandler',

    ],
    'components' => [

        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '662591340845-rbtdueltf5qq13fvim9q25adrd4go4pn.apps.googleusercontent.com',//'247155691525-n8tk5l6lg4ks5r5bb9a5393hk5kdlnff.apps.googleusercontent.com',
                    'clientSecret' => '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',//'cHqJUwCGEMLC7pb8-84JcpW1',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '835859237885935',//'1152745178429650',
                    'clientSecret' => 'a2dcc65e046983250cf115a0cf90870b'//'45832829760ed9da9f735b38724c4dec',
                ],
            ],
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
      
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => $baseUrl,
            
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
    'params' => $params,
];
