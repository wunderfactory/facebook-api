<?php

namespace Wunderfactory\Facebook;

use Illuminate\Support\Facades\Config;
use Wunderfactory\Facebook\Exceptions\InvalidFacebookAccessTokenException;

class Facebook {

	const PERMISSION_USER_ABOUT_ME = 'user_about_me';
	const PERMISSION_PUBLIC_PROFILE = 'public_profile';
	const PERMISSION_EMAIL = 'email';
	const PERMISSION_USER_BIRTHDAY = 'user_birthday';
	const PERMISSION_USER_LOCATION = 'user_location';

	protected $api;
	protected $accessToken = null;
	protected $permissions = [];

	public function __construct()
	{
		$this->api = new \Facebook\Facebook(Config::get('credentials.facebook'));
	}

	public function setAccessToken($accessToken)
	{
		$this->accessToken = $accessToken;
		$this->api->setDefaultAccessToken($accessToken);
		$this->updatePermissions();
	}

	public function updatePermissions()
	{
		$permissionsRaw = $this->api()->get('/me/permissions', $this->accessToken)->getDecodedBody()['data'];
		$permissions = [];

		foreach($permissionsRaw as $permission)
		{
			$permissions[$permission['permission']] = $permission['status'];
		}
		$this->permissions = $permissions;
	}

	public function api()
	{
		return $this->api;
	}

	public function me()
	{
		$graphUser = $this->api()->get('/me', $this->accessToken)->getGraphUser();
		return $graphUser;
	}

	public function getPermissionChecker()
	{
		return new PermissionChecker($this->permissions);
	}

	public  function getPermissionManager() {
		return new PermissionManager();
	}

	public function getPermissions()
	{
		return $this->permissions;
	}

	public function __call($method, $args)
	{
		if(method_exists($this->api, $method))
		{
			try{
				call_user_func_array([$this->api(), $method], $args);
			} catch (\Exception $e) {
				throw new InvalidFacebookAccessTokenException(400, 'Unable to access user with facebook_token '.$this->accessToken);
			}
		}
	}
}