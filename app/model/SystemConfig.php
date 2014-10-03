<?php

class SystemConfig extends \Phalcon\Mvc\Model
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
    public $key;

    /**
     *
     * @var string
     */
    public $value;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
    }

}
