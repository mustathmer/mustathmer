<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    //'language'	 => 'ar',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
		// ./yii message/config common/config/i18n.php   => To generate the i18n.php in common config
		// ./yii message/extract @common/config/i18n.php => To extract all needed text in code to translate it.
	    'i18n' => [
	        'translations' => [
	            /*'frontend*' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	            ],
	            'backend*' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	            ],
	            'api*' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	            ],*/
	            'site' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	            ],
	            'yii' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	            ],
	        ],
	    ],
		
    ],
];
