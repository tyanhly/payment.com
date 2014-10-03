<?php
use Phalcon\Mvc\Model, Phalcon\Mvc\Model\Message, Phalcon\Mvc\Model\Validator\InclusionIn, Phalcon\Mvc\Model\Validator\Uniqueness;

class PaymentBuyer extends Model {

    public $id;

    public $client_id;

    public $client_buyer_id;

    public $full_name;

    public $last_transaction;

    public function getSource () {
        return 'payment_buyer';
    }

    public function validation () {}

    public function beforeValidationOnCreate()
    {
        $this->date_created = new \Phalcon\Db\RawValue('NOW()');
    }

}