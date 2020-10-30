<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before($user, $ability)
	{
	    //如果用户拥有内容管理权限授权通过 true:通过，false:拒绝，null:通过其它的策略方法来决定授权通过与否
	    if($user->can('manage_contents')){//所有权限在Gate注册，可以用can方法
	        return true;
        }	}
}
