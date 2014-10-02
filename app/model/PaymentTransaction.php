<?php
use Phalcon\Mvc\Model, Phalcon\Mvc\Model\Message, Phalcon\Mvc\Model\Validator\InclusionIn, Phalcon\Mvc\Model\Validator\Uniqueness;
use Base\Entity\CreditCard;

class PaymentTransaction extends Model
{

    public $id;
    public $currency_id;
    public $client_id;
    public $client_buyer_id;
    public $client_transaction_id;
    public $gateway_id;
    public $card_type;
    public $card_name;
    public $card_number;
    public $amount;
    public $description;
    public $custom_description;
    public $ip_number;
    public $status;

    public function getSource ()
    {
        return 'payment_transaction';
    }


    public function validation ()
    {

    }

    public function setCreditCard(CreditCard $creditCard){
//         var_dump($creditCard);die;
        $this->client_buyer_id  = $creditCard->buyerId;
        $this->client_transaction_id   = $creditCard->clientTransactionId;
        $this->currency_id      = $creditCard->currency;
        $this->amount           = $creditCard->amount;
        $this->card_type        = $creditCard->cardType;
        $this->card_name        = $creditCard->cardName;
        $this->card_number      = $creditCard->cardNumber;
    }
}