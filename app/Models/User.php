<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Illuminate\Database\Query\Builder;
use Auth;
use App\Models\Status;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function sendPasswordResetNotification($token)
    {
      $this->notify(new ResetPassword($token));
    }

    /**
     * 创建函数，creating函数在用户模型创建之前生成
     *created函数在用户模型创建之后执行
     * 生成的用户激活令牌在用户模型创建之前完成，因此需要监听的是creating方法
     */
     public static function boot()
     {
        parent::boot();
        static::creating(function ($user){
            $user->activation_tokon=str_random(30);
       });
     }

     /**
      *取出所有微博，并按照创建时间倒序排列
      *
      *
      */
    public function feed()
    {
      $user_ids=Auth::user()->followings->pluck('id')->toArray();
       array_push($user_ids,Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)
                           ->with('user')
                           ->orderBy('created_at','desc');
    }
     /**
      *规定一个用户拥有多条微博
      *
      *
      */
    public function statuses()
    {
      return $this->hasMany(Status::class);
    }
    public function gravatar($size='100')
    {
      $hash=md5(strtolower(trim($this->attributes['email'])));
      return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

  /**
   * 创建多对多的粉丝用户关系
   *参数说明：第一个为模型名称，第二个是中间表名称，第三个主键，第四个从键
   */
   public function followers()
   {
     return $this->belongsToMany(User::class,'follows','user_id','follower_id');
   }

   public function followings()
   {
      return $this->belongsToMany(User::class,'follows','follower_id','user_id');
   }
   /**
    * 关注与取消关注的逻辑
    *参数说明：sync实现添加关联关系，followings实现取消关联关系
    */
  public function follow($user_ids)
  {
        if(!is_array($user_ids)){
        $user_ids=compact('user_ids');
      }
      $this->followings()->sync($user_ids,false);
  }
  public function unfollow($user_ids)
  {
        if(!is_array($user_ids)){
        $user_ids=compact('user_ids');
      }
      $this->followings()->detach($user_ids);
  }
  /**
   * 判断一个人是否关注了另一个人
   *
   */
    public function isFollowing($user_id)
    {

         return $this->followings->contains($user_id);
    }

}
