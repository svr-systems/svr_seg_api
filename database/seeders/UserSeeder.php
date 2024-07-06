<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder {
  public function run() {
    $data = [
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "SVR",
        "first_surname" => "ADMIN",
        "nickname" => "ADM-001",
        "email" => "admin@svrmexico.com",
        "password" => bcrypt("Hondo_1029*"),
        "role_id" => 1,
      ]
    ];

    User::insert($data);
  }
}