<?php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\InclusionIn;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class ApiToken extends Model {

    public $id;
    public $client_id;
    public $client_session_id;
    public $token;
    public $lifetime;
    public $date_updated;
    public function getSource () {
        return 'api_token';
    }


    public function beforeValidationOnCreate()
    {
        $this->date_created = new \Phalcon\Db\RawValue('NOW()');
    }
    
    public function beforeValidationOnUpdate()
    {
    }

    public function validation () {}
}