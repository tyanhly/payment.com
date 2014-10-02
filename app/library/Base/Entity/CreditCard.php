<?php
namespace Base\Entity;

use Base\Exception\RequestException;
class CreditCard{

    public $buyerId;
    public $clientTransactionId;
    public $currency;
    public $amount;
    public $cardType;
    public $cardName;
    public $cardNumber;
    public $cvv;
    public $validThrough;

    public function __construct($json){
        $jsonDecode = json_decode($json);
//         var_dump($jsonDecode);die;
        if(isset($jsonDecode->buyerId)){
            $this->buyerId = $jsonDecode->buyerId;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'buyerId Error');
        }

        if(isset($jsonDecode->clientTransactionId)){
            $this->clientTransactionId = $jsonDecode->clientTransactionId;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'clientTransactionId Error');
        }

        if(isset($jsonDecode->currency)){

            $currency = \PaymentCurrency::findFirst(
                    array(
                            "conditions" => "currency_code = ?1 AND is_disabled = 0",
                            "bind" => array(
                                    1 => $jsonDecode->currency,
                            )
                    ));
            if(!$currency){
                throw new RequestException(RequestException::ERROR_PAYMENT_CURRENCY_NOT_EXISTED);
            }
            $this->currency = $currency->id;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'currency Error');
        }

        if(isset($jsonDecode->amount)){
            $this->amount = $jsonDecode->amount ;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'amount Error');
        }

        if(isset($jsonDecode->cardType)){
            $this->cardType = $jsonDecode->cardType;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'cardType Error');
        }

        if(isset($jsonDecode->cardName)){
            $this->cardName = $jsonDecode->cardName ;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'cardName Error');
        }

        if(isset($jsonDecode->cardNumber)){
            $this->cardNumber = $jsonDecode->cardNumber;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'cardNumber Error');
        }

        if(isset($jsonDecode->cvv)){
            $this->cvv = $jsonDecode->cvv;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'CVV Error');
        }

        if(isset($jsonDecode->validThrough)){
            $this->validThrough = $jsonDecode->validThrough;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'validThrough Error');
        }

        if(isset($jsonDecode->gateway)){
            $gateway = \PaymentGateway::findFirst(
                array(
                    "conditions" => "gateway_key = ?1",
                    "bind" => array(
                        1 => $jsonDecode->gateway,
                    )
                ));

            if (! $gateway) {
                throw new RequestException(RequestException::ERROR_DATA_NOT_FOUND);
            }
            $this->gateway_id = $gateway->id;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'gateway Error');
        }

        if(isset($jsonDecode->description)){
            $this->description = $jsonDecode->description;
        }else{
            throw new RequestException(RequestException::ERROR_PAYMENT_CARDINFO, 'description Error');
        }
//         var_dump($jsonDecode);die;
    }
}