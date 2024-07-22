<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder {
  public function run() {
    $data = [
      [
        "name" => "BAJA",
        "color" => "#FFF9C4",
      ],
      [
        "name" => "MEDIA",
        "color" => "#FFD54F",
      ],
      [
        "name" => "ALTA",
        "color" => "#FF6D00",
      ],
    ];

    Priority::insert($data);
  }
}
