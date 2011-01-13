<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
    return array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'My Web Application',
        // preloading 'log' component
        'preload' => array('log'),
        // autoloading model and component classes
        'import' => array(
            'application.models.*',
            'application.components.*',
        ),
        'modules' => array(
            'dashboard','paypal'
        ),
        // application components
        'components' => array(
            'user' => array(
                // enable cookie-based authentication
                'class'=>'application.components.CTradeUser',
                'allowAutoLogin' => true,
            ),
            // uncomment the following to enable URLs in path-format

           'urlManager'=>array(
                        'class'=>'ext.DbUrlManager.EDbUrlManager',
                        'urlFormat'=>'path',
                        'connectionID'=>'db',
                        'rules'=>array(
                                'site/search/<keyword:[a-zA-z0-9-]+>/<page:\d+>'=>'site/search/keyword/<keyword>/page/<page>',
                                'user/order/<page:\d+>'=>'user/order/page/<page>',
                                'buy-ps3-jailbreak'=>array('site/page/view/buy-ps3-jailbreak','caseSensitive'=>false),
                                'site/promotion/<page:\d+>'=>'site/promotion/page/<page>',
                             'feed'=>array('site/feed','urlSuffix'=>'.xml','caseSensitive'=>false),
                                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                                'categories'=>'category/index',
                                 '<category:[a-zA-z0-9-]+>/<page:\d+>'=>array(
                                        'category/view',
                                        'type'=>'db',
                                        'fields'=>array(
                                                'category'=>array(
                                                        'table'=>'tm_category_entity',
                                                        'field'=>'category_SEF'
                                                ),
                                        ),
                                ),
                                '<category:[a-zA-z0-9-]+>'=>array(
                                        'category/view',
                                        'type'=>'db',
                                        'fields'=>array(
                                                'category'=>array(
                                                        'table'=>'tm_category_entity',
                                                        'field'=>'category_SEF'
                                                ),
                                        ),
                                ),

                                '<product:[a-zA-z0-9-]+>'=>array(
                                        'product/view',
                                        'type'=>'db',
                                        'fields'=>array(
                                                'product'=>array(
                                                        'table'=>'tm_product_entity',
                                                        'field'=>'product_SEF'
                                                ),
                                        ),
                                       'urlSuffix'=>'.html',
                                ),

                        ),
                        'showScriptName'=>false,
                ),
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=milestone',
                'emulatePrepare' => true,
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'tablePrefix' => 'tm_',
            ),
            'thumb' => array(
                'class' => 'ext.phpthumb.EasyPhpThumb',
            ),
            'errorHandler' => array(
                // use 'site/error' action to display errors
                'errorAction' => 'site/error',
            ),
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'error, warning',
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
        'params' => array(
            // this is used in contact page
            'adminEmail' => 'webmaster@example.com',
        ),
    );