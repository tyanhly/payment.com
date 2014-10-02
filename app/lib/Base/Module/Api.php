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
        // var_dump($client);die;

        // 4. Check client
        if (! $client) {
            throw new RequestException(RequestException::ERROR_DATA_NOT_FOUND);
        }

        // 5. Check ips allowed
        if (strpos($_SERVER['REMOTE_ADDR'], $client->ips_allowed) === false) {
            throw new RequestException(RequestException::ERROR_PERMISSION_DENY);
        }

        // 6. Decrypt data
        $decryptedData = \Base\Crypto::decryptBase64RSAByPubKey($data,
                $client->pub_key);

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
            $now = new \DateTime();
            $token = new \ApiToken();

            $token->client_id = $client->id;
            $token->client_session_id = $clientSessionId;
            $token->token = sha1(uniqid(rand(), 1)) . '_' . md5(
                    $clientSessionId);
            $token->lifetime = APP_TOKEN_LIFETIME;
            $token->date_updated = $now->format('Y-m-d H:i:s');
            if ($token->save() === false) {
                throw new RequestException(RequestException::ERROR_DB_PROBLEM);
            }
        }

        // 9. Render json
        \Base\Response::renderJson(array(
                'token' => $token->token
        ));
    }
}