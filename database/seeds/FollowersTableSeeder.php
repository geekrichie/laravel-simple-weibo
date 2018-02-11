<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users=User::all();
        $user=$users->first();
        $user_id=$user->id;
        //获取除了ID为1的所有用户
        $followers=$users->slice(1);
        $follower_ids=$followers->pluck('id')->toArray();
          //获取除了ID为1的所有用户
        $user->follow($follower_ids);
        foreach ($followers as $follower) {
          //除了一号以外的所有用户都来关注一号用户
          $follower->follow($user_id);
        }
    }
}
