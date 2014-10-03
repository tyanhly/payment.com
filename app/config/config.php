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
        'modelsDir'        => __DIR__ . '/../../app/models/DbTable', //DbTable auto generated form Phalcon DevTools, do not touch it
        'modelsRealDir'    => __DIR__ . '/../../app/models/',
        'formsDir'         => __DIR__ . '/../../app/forms/',
        'pluginsDir'       => __DIR__ . '/../../app/plugins/',
        'libraryDir'       => __DIR__ . '/../../app/library/',
        'baseUri'          => '/',
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
    'debugMode'    => 1
));
