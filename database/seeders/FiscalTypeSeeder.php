<?php

namespace Database\Seeders;

use App\Models\fiscalType;
use Illuminate\Database\Seeder;

class FiscalTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "name" => "FÍSICA"
            ],
            [
                "name" => "MORAL"
            ],
        ];

        fiscalType::insert($data);
    }
}