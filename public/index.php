<?php

error_reporting(E_ALL);

header("X-Powered-By: " . $_SERVER['HTTP_HOST']);
header('Server: ' . $_SERVER['HTTP_HOST']);
header("Access-Control-Allow-Origin: *");

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

if (in_array(APPLICATION_ENV, array('production', 'stagging'))) {
    ini_set('display_errors', 0);
} else {
    ini_set('display_errors', 1);
}

try {

    /**
     * Read the configuration
     */
    $config    = include __DIR__ . "/../app/config/config.php";
    $configEnv = include __DIR__ . "/../app/config/config-" . APPLICATION_ENV . ".php";
    $config->merge($configEnv);

    /**
     * Read services
     */
    include __DIR__ . "/../app/config/services.php";

    /**
     * Read constants
     */
    include __DIR__ . "/../app/config/constants.php";

} catch (\Exception $e) {
   echo $e->getMessage();
   echo $e->getTraceAsString();
}



use Base\Exception\RequestException;
require_once __DIR__ . '/../vendor/autoload.php';

$app->before(
        function  () use( $app) {
        /**
         *
         * @todo Log Access and Request
         */
        });

try {
    $app->post('/api/token',function  () {
//         var_dump($_POST);die;die;
        Base\Module\Api::token();
    });

    $app->post('/api/payment', function  () {
        Base\Module\Payment::payment();
    });

    $app->notFound(function () use ($app) {
        throw new RequestException(RequestException::ERROR_NOT_SERVICE_YET);
    });

    $app->handle();
}
catch (RequestException $re) {
    if(APP_IS_DEBUGING){
        throw $re;
        die;
    }
    Base\Response::renderJson(
            array(
                    'ErrorCode' => $re->getCode(),
                    'ErrorMsg' => $re->getMessage()
            ));
}
catch (Exception $e) {
    if(APP_IS_DEBUGING){
        throw $e;
        die;
    }
    /**
     *
     * @todo Log Error can not handle
     */
    Base\Response::renderJson(
            array(
                    'ErrorCode' => RequestException::ERROR_NOT_CATCH_YET,
                    'ErrorMsg' => 'System has a problem, please contact us!'
            ));
}