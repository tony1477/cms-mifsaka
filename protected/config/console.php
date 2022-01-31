<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Agemlive Console Application',

	// preloading 'log' component
	'preload'=>array(),

	// application components
	'components'=>array(

		// database settings are configured in database.php
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;port=5000;dbname=agemlive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'cr4nkc4s3',
			'charset' => 'utf8',
			'initSQLs'=>array('set names utf8'),
			'schemaCachingDuration' => 3600,
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),

	),
);
