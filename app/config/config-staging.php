<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'biglabsm',
        'dbname'      => 'payment',
    ),
    'url' => array(
        'frontend' => 'http://staging',
        'backend'  => 'http://payment.bl.kiss-concept.com',
        'cdn'      => 'http://staging',
        'api'      => 'http://api.bl.kiss-concept.com/',
    ),
    'debugMode'    => 0
));
