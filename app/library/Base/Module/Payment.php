<?php
namespace Base\Module;

use DateTime;
use DateInterval;
use Base\Exception;
use Base\Exception\RequestException;
use Base\Crypto;

class Payment{

    public static function payment(){

        // 1. Check token param
        $token = isset($_GET['token']) ? $_GET['token'] : null;
        if ($token === null)
            throw new RequestException(RequestException::ERROR_PARAM_NOT_FOUND);

        // 2. Check post data
        $data = isset($_POST['data']) ? $_POST['data'] : null;
        if ($data === null)
            throw new RequestException(RequestException::ERROR_DATA_NOT_FOUND);

        // 3. Get Token
        // $clientCode = "lotte";
        $apiToken = \ApiToken::findFirst(
                array(
                        "conditions" => "token = ?1",
                        "bind" => array(
                                1 => $token
                        )
                ));
        // var_dump($client);die;

        // 4. Check token
        if (! $apiToken) {
            throw new RequestException(RequestException::ERROR_PERMISSION_DENY);
        }

        // 5. Get Client
        // $clientCode = "lotte";
        $client = \PaymentClient::findFirst($apiToken->client_id);
        // var_dump($client);die;

        // 6. Check client
        if (! $client) {
            throw new RequestException(RequestException::ERROR_DATA_NOT_FOUND);
        }

        // 7. Check ips allowed
        if ($client->ips_allowed != '' && strpos($_SERVER['REMOTE_ADDR'], $client->ips_allowed) === false) {
            throw new RequestException(RequestException::ERROR_PERMISSION_DENY);
        }

        // 8. Check expired
        $now = new DateTime();
        $minValidDate = $now->sub(new DateInterval('PT' . intval($apiToken->lifetime) . 'S'));
        if($apiToken->date_updated > $minValidDate){
            throw new RequestException(RequestException::ERROR_PERMISSION_SESSION_EXPIRE);
        }

         // 9. Decrypt data
        $decryptedData = Crypto::decryptBase64AES($data,$token);

        $cardInfo = new \Base\Entity\CreditCard($decryptedData);
        // print_r($decryptedData);die;


        // 10. Get Transaction
        $clientSessionId = $decryptedData;
        $paymentTransaction = \PaymentTransaction::findFirst(
            array(
                "conditions" => "client_transaction_id = ?1 AND client_id = ?2",
                "bind" => array(
                    1 => $cardInfo->clientTransactionId,
                    2 => $client->id
                )
            ));

        // 11. Check transaction existed
        if(!$paymentTransaction){
            $paymentTransaction = new \PaymentTransaction();
            $paymentTransaction->setCreditCard($cardInfo);
            $paymentTransaction->client_id  = $client->id;
            $paymentTransaction->gateway_id  = 1;
            $paymentTransaction->ip_number  = $_SERVER['REMOTE_ADDR'];
            $paymentTransaction->status     = PAYMENT_STATUS_COMPLETED;

//             var_dump($paymentTransaction);die;
            if ($paymentTransaction->save() === false) {
                throw new RequestException(RequestException::ERROR_DB_PROBLEM, implode(',', $paymentTransaction->getMessages()));
//                 throw new RequestException(RequestException::ERROR_DB_PROBLEM);
            }
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_TRANSACTION_EXISTED);
        }

        //12. Send email
        if ($paymentTransaction) {
            $email = new Email();
            $email->newPayment($paymentTransaction->id);
        }


        // 9. Render json
        \Base\Response::renderJson(array(
            'transactionId' => $paymentTransaction->id
        ));


    }
}