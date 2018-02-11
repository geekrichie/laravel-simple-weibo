<?php

use Illuminate\Database\Seeder;
use Faker\Generator;
use App\Models\User;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses=factory(Status::class)->times(100)->make()->each(function($status)
        {
              $faker=app(Faker\Generator::class);
              $user_ids=['1','2','3'];
              $status->user_id=$faker->randomElement($user_ids);
        });
        Status::insert($statuses->toArray());
    }
}
