<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
        	'class' 				=> 'codemix\localeurls\UrlManager',
            'languages' 			=> ['en', 'ar'],

            'enablePrettyUrl' 		=> true,
            'enableStrictParsing' 	=> true,
            'showScriptName' 		=> true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/country'],
                    //'extraPatterns' => ['POST login' => 'login']
                    
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/city'],
                    //'extraPatterns' => ['POST search' => 'search']
                    
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/user'],
                    'extraPatterns' => ['POST login' => 'login']
                    
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/node'],
                    //'extraPatterns' => ['POST login' => 'login']
                    
                ],
            ],        
        ]
    ],
    'params' => $params,
];



