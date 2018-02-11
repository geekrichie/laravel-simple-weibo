<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Status extends Model
{
  //制定可以修改的字段，防止出现MassAssignmentException批量赋值异常
   protected $fillable=['content'];
    /**
     *一条微博属于一个用户
     *
     *
     */
    public function user()
    {
      return $this->belongsTo(User::class);
    }


}
