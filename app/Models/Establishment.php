<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    static public function getItems()
    {
        $items = Establishment::where('active', true)->get([
            'id',
            'name',
            'legal_name',
            'legal_code',
            'legal_zip',
            'created_at',
            'fiscal_type_id',
            'fiscal_regime_id'
        ]);

        foreach ($items as $item) {
            $item->fiscal_type = FiscalType::find($item->fiscal_type_id, ['name']);
            $item->fiscal_regime = FiscalRegime::find($item->fiscal_regime_id, ['name', 'code']);
        }

        return $items;
    }

    static public function getItem($id)
    {
        $item = Establishment::find($id);
        $item->fiscal_type = FiscalType::find($item->fiscal_type_id, ['name']);
        $item->fiscal_regime = FiscalRegime::find($item->fiscal_regime_id, ['name', 'code']);

        return $item;
    }
}