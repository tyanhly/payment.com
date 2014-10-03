<?php

class TemplateLanguage extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $language_id;

    /**
     *
     * @var integer
     */
    public $template_id;

    /**
     *
     * @var string
     */
    public $subject;

    /**
     *
     * @var string
     */
    public $body;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('language_id', 'SystemLanguage', 'id', NULL);
        $this->belongsTo('template_id', 'Template', 'id', NULL);
    }

}
