<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TagSeeder extends Seeder {
  public function run() {
    $data = [
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "BACKEND",
        "color" => "8D6E63",
      ],
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "FRONTEND",
        "color" => "6D4C41",
      ],
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "BD",
        "color" => "8E24AA",
      ],
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "SERVIDOR",
        "color" => "D81B60",
      ],
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "HARDWARE",
        "color" => "00897B",
      ],
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "DOCUMENTACIÓN",
        "color" => "C0CA33",
      ],
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "REVISIÓN",
        "color" => "43A047",
      ],
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "ADQUISICIÓN",
        "color" => "F4511E",
      ],
      [
        "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "updated_at" => Carbon::now()->format("Y-m-d H:i:s"),
        "created_by_id" => 1,
        "updated_by_id" => 1,
        "name" => "CAPACITACIÓN",
        "color" => "FFB300",
      ],
    ];

    Tag::insert($data);
  }
}
