<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }
    //update接收两个参数，第一个默认为当前用户登录的实例，第二个参数是要进行授权的用户
    public function update(User $currentUser,User $user)
    {
      return $currentUser->id===$user->id;
    }
    public function destroy(User $currentUser,User $user)
    {
      return $currentUser->is_admin && $currentUser->id!==$user->id;
    }
}
