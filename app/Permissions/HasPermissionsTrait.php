<?php

namespace App\Permissions;

use App\Permission;
use App\Role;

trait HasPermissionsTrait
{
	public function givePermissionTo(...$permissions)
	{
		$permissions = $this->getAllPermissions(array_flatten($permissions));

		if($permissions !== null) {
			$this->permissions()->saveMany($permissions);		
		}

		return $this;
	}

	public function withdrawPermissionTo(...$permissions)
	{
		$permissions = $this->getAllPermissions(array_flatten($permissions));

		$this->permissions()->detach($permissions);		

		return $this;
	}

	public function updatePermissions(...$permissions)
	{
		$this->permissions()->detach();

		return $this->givePermissionTo($permissions);
	}

	protected function getAllPermissions(array $permissions)
	{
		return Permission::whereIn('name', $permissions)->get();
	}

	public function hasRole(...$roles) // ...$roles - puts parameters in an array called $roles
	{
		foreach ($roles as $role) {
			if($this->roles->contains('name', $role)) {
				return true;
			}
		}
		return false;
	}

	public function hasPermissionTo($permission)
	{
		return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
	}

	protected function hasPermission($permission)
	{
		return (bool) $this->permissions->where('name', $permission->name)->count();
	}

	protected function hasPermissionThroughRole($permission)
	{
		foreach ($permission->roles as $role) {
			if($this->roles->contains($role)) {
				return true;
			}
		}
		return false;
	}

	public function roles()
	{
	   	return $this->belongsToMany(Role::class, 'users_roles');
	}

	public function permissions()
	{
	   	return $this->belongsToMany(Permission::class, 'users_permissions');
	}
}

