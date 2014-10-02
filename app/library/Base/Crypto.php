<?php

namespace Base;

use Base\Exception\RequestException;

class Crypto {

    public static function encryptBase64RSAByPubKey ($data, $pubKey) {
        openssl_public_encrypt($data, $encryptData,
                openssl_get_publickey($pubKey));
        return base64_encode($encryptData);
    }

    public static function decryptBase64RSAByPubKey ($data, $pubKey) {
        // var_dump($pubKey);die;
        openssl_get_publickey($pubKey);
        openssl_public_decrypt(base64_decode($data), $decryptData,
                openssl_get_publickey($pubKey));
        if ($decryptData == NULL) {
            throw new RequestException(
                    RequestException::ERROR_RSA_CANNOT_DECRYPT);
        }
        return $decryptData;
    }

    public static function encryptBase64RSAByPriKey ($data, $priKey, $passphrase) {
        openssl_private_encrypt($data, $encryptData,
                openssl_get_privatekey($priKey, $passphrase));
        return base64_encode($encryptData);
    }

    public static function decryptBase64RSAByPriKey ($data, $priKey, $passphrase) {
        openssl_private_decrypt(base64_decode($data), $decryptData,
                openssl_get_privatekey($priKey, $passphrase));
        if ($decryptData == NULL) {
            throw new RequestException(
                    RequestException::ERROR_RSA_CANNOT_DECRYPT);
        }
        return $decryptData;
    }

    public static function encryptBase64AES($data, $token) {
        /**
         * @todo Encrypt data
         */
        $encryptData = base64_encode($data);

        return $encryptData;
    }

    public static function decryptBase64AES($data, $token) {
        $decryptData = base64_decode($data);
        /**
         * @todo decrypt AES
         */
        return $decryptData;
    }


}