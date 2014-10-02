<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'password',
        'dbname'      => 'payment',
    ),
    'url' => array(
        'frontend' => 'http://',
        'backend'  => 'http://',
        'api'      => 'http://',
    )
));
