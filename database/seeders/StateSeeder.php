<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder {
  public function run() {
    $data = [
      [
        "name" => "PLANIFICACIÓN",
        "color" => "1565C0",
      ],
      [
        "name" => "EN CURSO",
        "color" => "FF8F00",
      ],
      [
        "name" => "PAUSADO",
        "color" => "6A1B9A",
      ],
      [
        "name" => "LISTO",
        "color" => "2E7D32",
      ],
      [
        "name" => "PENDIENTE",
        "color" => "424242",
      ],
      [
        "name" => "CANCELADO",
        "color" => "C62828",
      ],
    ];

    State::insert($data);
  }
}
