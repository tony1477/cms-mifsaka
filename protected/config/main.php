<?php
return array(
	'theme'=>'cerulean',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Mifsaka',
	'preload'=>array(),

	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.admin.models.*',
		'ext.fpdf.*',
		'ext.yii-easyui.web.*',
		'ext.yii-easyui.widgets.*'
	),

	'modules'=>array(
		'admin'=>array(),
		'common'=>array(),
		'accounting'=>array(),
		'inventory'=>array(),
		'purchasing'=>array(),
		'production'=>array(),
		'project'=>array(),
		'hr'=>array(),
		'order'=>array(),
		'api'=>array()
	),

	'components'=>array(
		'authManager' => array(
			'class' => 'CDbAuthManager',
			'connectionID' => 'db',
    ),
		
		'format'=>array(
		'class'=>'application.components.Formatter',
		),
		'widgetFactory' => array(
			'widgets' => array(
				'CLinkPager' => array(
					'header' => '<div class="pagination pagination-centered">',
					'footer' => '</div>',
					'nextPageLabel' => 'Next',
					'prevPageLabel' => 'Prev',
					'cssFile'=>false,
					'selectedPageCssClass' => 'active',
					'hiddenPageCssClass' => 'disabled',
					'htmlOptions' => array(
							'class' => 'pagination',
					)
				),
				'CGridView' => array(
					'htmlOptions' => array(
							'class' => 'table-responsive',
							'style'=>'cursor: pointer;',
					),
					'ajaxUpdate'=>true,
					'filter'=>null,
					'selectableRows' => 2,
					'enableSorting'=>true,
					'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
					'itemsCssClass' => 'table table-striped table-hover',
					'cssFile' => false,
					'summaryCssClass' => 'dataTables_info',
					'summaryText' => 'Showing {start} to {end} of {count} entries',
					'template' => '{pager}{items}{summary}{pager}',
				),
				'RefreshGridView' => array(
					'htmlOptions' => array(
							'class' => 'table-responsive',
							'style'=>'cursor: pointer;',
					),
					'ajaxUpdate'=>true,
					'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
					'itemsCssClass' => 'table table-striped table-hover',
					'cssFile' => false,
					'summaryCssClass' => 'dataTables_info',
					'summaryText' => 'Showing {start} to {end} of {count} entries',
					'template' => '{pager}{items}{summary}{pager}',
				),
			)
		),  
		
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false,  
			'rules'=>array(
				''=>'site/index',
				'<module:[\w-]+>/<controller:[\w-]+>/index/url'=>'<module>/<controller>/index',
				'<module:[\w-]+>/<controller:[\w-]+>'=>'<module>/<controller>',
				'<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>/<name:[\w-]+>'=>'<module>/<controller>/<action>'
			),
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;port=3306;dbname=agemlive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'martoni14', 
			'charset' => 'utf8',
			'initSQLs'=>array('set names utf8'),
			'schemaCachingDuration' => 3600,
			//'enableParamLogging' => true,
    ),
    
    'session'=>array(
      'class' => 'CDbHttpSession',
      'connectionID' => 'db',
      'sessionTableName' => 'yiisession',
    ),
		
		'mail' => array(
				'class' => 'ext.yii-mail.YiiMail',
				'transportType'=>'smtp',
				'transportOptions'=>array(
				'host'=>'kangaroospringbed.com',
				'username'=>'it.notification@kangaroospringbed.com',
				'password'=>'1tn0t1f',
				'port'=>'25',                       
			),
			'viewPath' => 'application.views.mail',             
		),
		
		'cache'=>array(
      //'class'=>'system.caching.CFileCache',
      //'class'=>'CRedisCache',
		),
	),

	'params'=>array(
		'themes'=>'cerulean',
		'adminEmail'=>'romy@prismagrup.com',
		'defaultPageSize'=>10,
		'defaultYearFrom'=>date('Y')-1,
		'defaultYearTo'=>date('Y'),
		'sizeLimit'=>10*1024*1024,
		'allowedext'=>array("xls","csv","xlsx","vsd","pdf","gdb","doc","docx","jpg","gif","png","rar","zip","jpeg"),
		'language'=>1,
		'defaultnumberqty'=>'#,##0.00',
		'defaultnumberprice'=>'#,##0.00',
		'dateviewfromdb'=>'d-m-Y',
		'longdateviewfromdb'=>'d M Y',
		'dateviewcjui'=>'dd-mm-yy',
		'dateviewgrid'=>'dd-MM-yyyy',
		'datetodb'=>'Y-m-d',
		'timeviewfromdb'=>'h:m',
		'datetimeviewfromdb'=>'d-M-Y H:i:s',
		'timeviewcjui'=>'h:m',
		'datetimeviewgrid'=>'dd-MM-yyyy H:m',
		'datetimetodb'=>'Y-m-d H:i:s',
		'googleApiKey'=>'AIzaSyCiH2X-10OQmmRbJkviFxMqAivrujTu8N4',
		'key'=>'ea4378929664b8695e575d36cebdedc5f1b7b3d4ee394540',
		'ip' => 'http://116.203.92.59/api/',
		'tele' => 'https://api.telegram.org/bot842590160:AAFhr5iTwa4NYRBfhDNfZcWEBs2qIDTmJ2A',
	),
);
