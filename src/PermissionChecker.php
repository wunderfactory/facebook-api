<?php namespace Wunderfactory\Facebook;

class PermissionChecker {

	private $permissions = [];
	private $failed = [];

	public function __construct($permissions)
	{
		$this->permissions = $permissions;
	}

	public function has($permissions)
	{
		if(is_array($permissions))
		{
			return $this->hasPermissions($permissions);
		}
		else
		{
			return $this->hasPermission($permissions);
		}
	}

	public function hasPermission($permission)
	{
		return (in_array($permission, array_keys($this->permissions)) && $this->permissions[$permission] == 'granted');
	}

	public function hasPermissions($permissions)
	{
		$fail = false;
		foreach($permissions as $permission)
		{
			if(!$this->hasPermission($permission))
			{
				$this->failed[] = $permission;
				$fail = true;
			}
		}
		return !$fail;
	}

	public function getFailed()
	{
		return $this->failed;
	}
}