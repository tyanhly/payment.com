<?php
use Base\Exception\RequestException;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/constants.php';
require_once __DIR__ . '/../app/init.php';

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