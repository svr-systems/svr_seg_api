<?php

namespace Database\Seeders;

use App\Models\fiscalRegime;
use Illuminate\Database\Seeder;

class FiscalRegimeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "name" => "GENERAL DE LEY PERSONAS MORALES",
                "code" => "601",
                "fiscal_type_id" => 2
            ],
            [
                "name" => "PERSONAS MORALES CON FINES NO LUCRATIVOS",
                "code" => "603",
                "fiscal_type_id" => 2
            ],
            [
                "name" => "SUELDOS Y SALARIOS E INGRESOS ASIMILADOS A SALARIOS",
                "code" => "605",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "ARRENDAMIENTO",
                "code" => "606",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "DEMÁS INGRESOS",
                "code" => "608",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "RESIDENTES EN EL EXTRANJERO SIN ESTABLECIMIENTO PERMANENTE EN MÉXICO",
                "code" => "610",
                "fiscal_type_id" => null
            ],
            [
                "name" => "INGRESOS POR DIVIDENDOS (SOCIOS Y ACCIONISTAS)",
                "code" => "611",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "PERSONAS FÍSICAS CON ACTIVIDADES EMPRESARIALES Y PROFESIONALES",
                "code" => "612",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "INGRESOS POR INTERESES",
                "code" => "614",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "SIN OBLIGACIONES FISCALES",
                "code" => "616",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "SOCIEDADES COOPERATIVAS DE PRODUCCIÓN QUE OPTAN POR DIFERIR SUS INGRESOS",
                "code" => "620",
                "fiscal_type_id" => 2
            ],
            [
                "name" => "INCORPORACIÓN FISCAL",
                "code" => "621",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "ACTIVIDADES AGRÍCOLAS, GANADERAS, SILVÍCOLAS Y PESQUERAS",
                "code" => "622",
                "fiscal_type_id" => 2
            ],
            [
                "name" => "OPCIONAL PARA GRUPOS DE SOCIEDADES",
                "code" => "623",
                "fiscal_type_id" => 2
            ],
            [
                "name" => "COORDINADOS",
                "code" => "624",
                "fiscal_type_id" => 2
            ],
            [
                "name" => "RÉGIMEN DE ENAJENACIÓN O ADQUISICIÓN DE BIENES",
                "code" => "607",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "RÉGIMEN DE LOS INGRESOS POR OBTENCIÓN DE PREMIOS",
                "code" => "615",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "RÉGIMEN DE LAS ACTIVIDADES EMPRESARIALES CON INGRESOS A TRAVÉS DE PLATAFORMAS TECNOLÓGICAS",
                "code" => "625",
                "fiscal_type_id" => 1
            ],
            [
                "name" => "RÉGIMEN SIMPLIFICADO DE CONFIANZA",
                "code" => "626",
                "fiscal_type_id" => null
            ]
        ];

        fiscalRegime::insert($data);
    }
}