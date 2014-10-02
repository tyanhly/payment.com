<?php
return new \Phalcon\Config(array(
    'database' => array(
        'adapter'          => 'Mysql',
        'host'             => 'localhost',
        'username'         => 'root',
        'password'         => 'password',
        'dbname'           => 'payment',
        'dbnameEmailQueue' => 'email_queue',
    ),
    'application' => array(
        'controllersDir'   => __DIR__ . '/../../app/controllers/',
        'modelsDir'        => __DIR__ . '/../../app/models/DbTable', //DbTable auto generated form Phalcon DevTools, do not touch it
        'modelsRealDir'    => __DIR__ . '/../../app/models/',
        'viewsDir'         => __DIR__ . '/../../app/views/',
        'formsDir'         => __DIR__ . '/../../app/forms/',
        'pluginsDir'       => __DIR__ . '/../../app/plugins/',
        'libraryDir'       => __DIR__ . '/../../app/library/',
        'cacheDir'         => __DIR__ . '/../../app/cache/',
        'baseUri'          => '/',
    ),
    'mongo' => array(
        'host'   => 'localhost',
        'dbname' => 'big-labs'
    ),
    'upload' => array(
        'dataDir'      => '/home/web/data/big-labs/',
        'uploadDir'    => '/home/web/data/big-labs/uploads',
        'uploadUri'    => '/uploads',
        'tmpDir'       => 'tmp',
    ),
    'url' => array(
        'frontend' => 'http://',
        'backend'  => 'http://payment.admin/',
        'cdn'      => 'http://',
        'api'      => 'http://payment.api/',
    ),
    'permission' => array(
        'superAdminId' => 1,
        'defaultAllow' => array(
            'permission' => array(
                'index'
            ),
            'index' => array(
                'index'
            ),
            'session' => array(
                'logout'
            ),
        )
    )
));
