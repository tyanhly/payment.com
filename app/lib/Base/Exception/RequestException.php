<?php

namespace Base\Exception;

class RequestException extends \Exception {

    const ERROR_PARAM_NOT_FOUND                 = 0x1001;

    const ERROR_DATA_NOT_FOUND                  = 0x1002;

    const ERROR_CLIENT_NOT_FOUND                = 0x1003;

    const ERROR_RSA_CANNOT_DECRYPT              = 0x2001;

    const ERROR_DB_PROBLEM                      = 0x3001;

    const ERROR_PERMISSION_DENY                 = 0x4001;

    const ERROR_PERMISSION_SESSION_EXPIRE       = 0x4002;

    const ERROR_PAYMENT_CARDINFO                = 0xE001;

    const ERROR_PAYMENT_TRANSACTION_EXISTED     = 0xE002;
    const ERROR_PAYMENT_CURRENCY_NOT_EXISTED    = 0xE003;

    const ERROR_NOT_CATCH_YET                   = 0xFFFF;

    // public function RequestException ($message, $code, $previous){
    // parent::__construct($message,$code,$previous);
    // }
    public function __construct ($code, $msg = null) {
        if ($msg === null) {
            $msg = $this->__getMsg($code);
        }
        parent::__construct($msg, $code);
    }

    private function __getMsg ($code) {
        return 'DEC: ' . $code . ' - HEX: ' . dechex($code);
    }
}