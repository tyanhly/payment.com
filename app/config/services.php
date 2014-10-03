<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Use Loader() to autoload our model
$loader = new \Phalcon\Loader();

$loader->registerDirs(
        array(
                __DIR__ . '/../library/',
                __DIR__ . '/../model/'
        ))->register();

// Create and bind the DI to the application
$di = new \Phalcon\DI\FactoryDefault();

$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});
$di->set('dbEmailQueue', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbnameEmailQueue
    ));
});

$di->set('systemConfig', function() {
    $configs = array();
    foreach (SystemConfig::find() as $config) {
        $configs[$config->key] = $config->value;
    }

    return $configs;
});

$app = new \Phalcon\Mvc\Micro($di);