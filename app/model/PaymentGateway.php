<?php

class PaymentGateway extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $gateway_key;

    /**
     *
     * @var string
     */
    public $gateway_name;

    /**
     *
     * @var string
     */
    public $login_account;

    /**
     *
     * @var integer
     */
    public $is_disabled;

    /**
     *
     * @var string
     */
    public $last_used;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'PaymentTransaction', 'gateway_id', NULL);
        $this->hasMany('id', 'SummaryTransaction', 'gateway_id', NULL);
    }

}
