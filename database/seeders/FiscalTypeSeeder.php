<?php

namespace Database\Seeders;

use App\Models\FiscalType;
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

        FiscalType::insert($data);
    }
}