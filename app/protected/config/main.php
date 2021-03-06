<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.



return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Vagrant Yii 1 ',
	 'language' => 'it',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.giix-components.*',
		//'ext.giix-components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'davide',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('*','::1'),
			'generatorPaths' => array(
		        'ext.giix-core', // giix generator
		    ),
		),


	),

	// application components
	'components'=>array(

		'user'=>array(
						// enable cookie-based authentication
						'allowAutoLogin'=>true,
						'class'=>'application.components.EWebUser',
				),
		'GxHtml'=>array('class'=>'application.components.GxHtml'),
		'mail' => array(
					'class' => 'application.extensions.yii-mail.YiiMail',
					'transportType' => 'smtp',
					'transportOptions' => array(
							'host' => '{host.com}',
							'username' => '{username}',
							'password' => '{password}',
							'port' => '465',
							'encryption' => 'ssl',
					),
					'viewPath' => 'application.views.user',
					'logging' => true,
					'dryRun' => false
			),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => false,
		),
		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=vagrantyii1',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
																																					),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'adminEmail@adminemail.com',
	),
);
