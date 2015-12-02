<?php namespace Wunderfactory\Facebook;

class FacebookPermission
{
    public $field;

    public $attribute;

    protected $sanitizer;

    /**
     * FacebookPermission constructor.
     * @param $field
     * @param $attribute
     * @param $sanitizer
     */
    public function __construct($field, $attribute, $sanitizer)
    {
        $this->field = $field;
        $this->attribute = $attribute;
        $this->sanitizer = $sanitizer;
    }

    public function sanitize($value)
    {
        if (!$this->isSanitationNeeded())
        {
            return $value;
        } else
        {
            return call_user_func($this->sanitizer, $value);
        }
    }

    private function isSanitationNeeded()
    {
        return !is_null($this->sanitizer) && is_callable($this->sanitizer);
    }


}