<?php

class Template extends \Phalcon\Mvc\Model
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
    public $category_id;

    /**
     *
     * @var integer
     */
    public $group_id;

    /**
     *
     * @var string
     */
    public $key;

    /**
     *
     * @var string
     */
    public $variable;

    /**
     *
     * @var integer
     */
    public $is_disabled;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'TemplateLanguage', 'template_id', NULL);
        $this->belongsTo('category_id', 'TemplateCategory', 'id', NULL);
        $this->belongsTo('group_id', 'TemplateGroup', 'id', NULL);
    }


    static function getEmailTemplate($key, $languageId) {
        $templateCategory = TemplateCategory::findFirst("template_category = 'Email'");

        if ($templateCategory) {
            $template = Template::findFirst("key = '$key' AND category_id = '$templateCategory->id'");

            if ($template) {
                $templateLanguage = TemplateLanguage::findFirst("template_id = '$template->id'");

                return $templateLanguage->toArray();
            }
        }

        return array();
    }
}
