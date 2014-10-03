<?php

class EmailQueue extends \Phalcon\Mvc\Model
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
    public $from_name;

    /**
     *
     * @var string
     */
    public $from;

    /**
     *
     * @var string
     */
    public $to;

    /**
     *
     * @var string
     */
    public $cc;

    /**
     *
     * @var string
     */
    public $bcc;

    /**
     *
     * @var string
     */
    public $reply_to;

    /**
     *
     * @var string
     */
    public $subject;

    /**
     *
     * @var string
     */
    public $reference;

    /**
     *
     * @var string
     */
    public $body;

    /**
     *
     * @var string
     */
    public $sent_result;

    /**
     *
     * @var string
     */
    public $has_daily_send_limit;

    /**
     *
     * @var integer
     */
    public $priority;

    /**
     *
     * @var string
     */
    public $status;

    /**
     *
     * @var string
     */
    public $date_sent;

    /**
     *
     * @var string
     */
    public $date_created;



    public function beforeValidationOnCreate()
    {
        $this->status       = STATUS_PENDING;
        $this->date_created = new \Phalcon\Db\RawValue('NOW()');
    }
    
    public function beforeValidationOnUpdate()
    {
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'EmailQueueAttachment', 'queue_id', NULL);
        $this->setConnectionService('dbEmailQueue');
    }

}
