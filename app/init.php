<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', APP_SHOW_ERROR);

// Use Loader() to autoload our model
$loader = new \Phalcon\Loader();

$loader->registerDirs(
        array(
                __DIR__ . '/lib/',
                __DIR__ . '/model/'
        ))->register();

// Create and bind the DI to the application
$di = new \Phalcon\DI\FactoryDefault();

// Set up the database service
$di->set('db',function  () {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(
        array(
            "host"          => DB_HOST,
            "username"      => DB_USERNAME,
            "password"      => DB_PASS,
            "dbname"        => DB_NAME
        ));
});

$app = new \Phalcon\Mvc\Micro($di);