<?php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\InclusionIn;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class PaymentCurrency extends Model {

    public $id;
    public $currency_name;
    public $currency_code;
    public $is_disabled;

    public function getSource () {
        return 'payment_currency';
    }

    public function validation () {}
}