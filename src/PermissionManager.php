<?php namespace Wunderfactory\Facebook;

class PermissionManager
{

    public $permissionAttributes;

    /**
     * PermissionManager constructor.
     */
    public function __construct()
    {
        $this->permissionAttributes = $this->permissionAttributes();
    }

    private function permissionAttributes ()
    {
        return [
            Facebook::PERMISSION_PUBLIC_PROFILE => [
                new FacebookPermission('first_name', 'first_name', null),
                new FacebookPermission('last_name', 'last_name', null),
                new FacebookPermission('id', 'facebook_id', null)
            ],
            Facebook::PERMISSION_EMAIL => [
                new FacebookPermission('email', 'email', null),
            ],
            Facebook::PERMISSION_USER_BIRTHDAY => [
                new FacebookPermission('birthday', 'birthday', array($this, "sanitizeBirthday")),
            ],
            Facebook::PERMISSION_USER_LOCATION => [
                new FacebookPermission('location', 'city', null),
            ],
            Facebook::PERMISSION_USER_ABOUT_ME => [
                new FacebookPermission('about', 'about', null),
            ]
        ];
    }

    public function fields($fieldsWanted = null)
    {
        if (!$fieldsWanted)
            $fieldsWanted = array_keys($this->permissionAttributes);
        $fields = "";

        foreach($this->permissionAttributes as $attributes)
        {
            foreach($attributes as $attribute)
            {
                 if( array_has($fieldsWanted, array_search($attributes, $this->permissionAttributes))) {
                     $fields .= $attribute->field . ',';
                 }
            }
        }
        return (strlen($fields) == 0 ? "" : substr($fields, 0, strlen($fields) - 1));
    }

    public function sanitizeBirthday($value)
    {
        return $value;
    }
}
