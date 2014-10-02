<?php
use Phalcon\Mvc\Model, Phalcon\Mvc\Model\Message, Phalcon\Mvc\Model\Validator\InclusionIn, Phalcon\Mvc\Model\Validator\Uniqueness;

class PaymentClient extends Model {

    public $id;

    public $client_code;

    public $client_name;

    public $pri_key;

    public $pub_key;

    public $passphrase;

    public $ips_allowed;

    public $is_disabled;

    public function getSource () {
        return 'payment_client';
    }

    public function validation () {}
}