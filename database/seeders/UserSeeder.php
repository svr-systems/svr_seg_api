<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
  public function run()
  {
    $data = [
      [
        "name" => "ADMIN",
        "email" => "admin@svrmexico.com",
        "password" => bcrypt("Hondo_1029*"),
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
      ]
    ];

    DB::table("users")->insert($data);
  }
}