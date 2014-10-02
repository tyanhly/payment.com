<?php

namespace Base\Module;

use Base\Exception\RequestException;
class Api {

    public static function token () {

        // 1. Check client param
        $clientCode = isset($_GET['client']) ? $_GET['client'] : null;
        if ($clientCode === null)
            throw new RequestException(RequestException::ERROR_PARAM_NOT_FOUND);

            // 2. Check post data
        $data = isset($_POST['data']) ? $_POST['data'] : null;
        if ($data === null)
            throw new RequestException(RequestException::ERROR_DATA_NOT_FOUND);

            // 3. Get Client
            // $clientCode = "lotte";
        $client = \PaymentClient::findFirst(
                array(
                        "conditions" => "client_code = ?1",
                        "bind" => array(
                                1 => $clientCode
                        )
                ));
        // print_r($client->toArray());die;

        // 4. Check client
        if (! $client) {
            throw new RequestException(RequestException::ERROR_DATA_NOT_FOUND);
        }

        // 5. Check ips allowed
        if ($client->ips_allowed != '' && strpos($_SERVER['REMOTE_ADDR'], $client->ips_allowed) === false) {
            throw new RequestException(RequestException::ERROR_PERMISSION_DENY);
        }

        // 6. Decrypt data
        $decryptedData = \Base\Crypto::decryptBase64RSAByPubKey($data,
                $client->public_key);

        // 7. Get SessionId
        $clientSessionId = $decryptedData;
        $token = \ApiToken::findFirst(
                array(
                        "conditions" => "client_session_id = ?1 AND client_id = ?2",
                        "bind" => array(
                                1 => $clientSessionId,
                                2 => $client->id
                        )
                ));

        // 8. Check token existed
        if (! $token) {
            $token = new \ApiToken();

            $token->client_id = $client->id;
            $token->client_session_id = $clientSessionId;
            $token->token = sha1(uniqid(rand(), 1)) . '_' . md5(
                    $clientSessionId);
            $token->lifetime = APP_TOKEN_LIFETIME;
            
            if ($token->save() === false) {
                print_r($token->getMessages());exit;
                throw new RequestException(RequestException::ERROR_DB_PROBLEM);
            }
        }

        // 9. Render json
        \Base\Response::renderJson(array(
                'token' => $token->token
        ));
    }
}