<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \DB;

class EstablishmentController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'ok' => true,
                'msg' => 'Registros retornados correctamente',
                'items' => Establishment::getItems()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'ok' => false,
                'msg' => 'ERR. ' . $th
            ], 200);
        }
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {
            $valid_item = $this->validItem($req);
            if ($valid_item->fails()) {
                return response()->json([
                    'ok' => false,
                    'msg' => $valid_item->errors()->first()
                ], 200);
            }

            $item = new Establishment;
            $item->created_by_id = $req->user()->id;
            $this->saveItem($item, $req);

            DB::commit();
            return response()->json([
                'ok' => true,
                'msg' => 'Registro creado correctamente'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'ok' => false,
                'msg' => 'ERR. ' . $th
            ], 200);
        }
    }

    public function show($id)
    {
        try {
            return response()->json([
                'ok' => true,
                'msg' => 'Registro retornado correctamente',
                'item' => Establishment::getItem($id)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'ok' => false,
                'msg' => 'ERR. ' . $th
            ], 200);
        }
    }

    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $valid_item = $this->validItem($req);
            if ($valid_item->fails()) {
                return response()->json([
                    'ok' => false,
                    'msg' => $valid_item->errors()->first()
                ], 200);
            }

            $this->saveItem(Establishment::find($id), $req);

            DB::commit();
            return response()->json([
                "ok" => true,
                "msg" => "Registro actualizado correctamente"
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                "ok" => false,
                "msg" => "ERR. " . $th
            ], 200);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = Establishment::find($id);
            $item->active = false;
            $item->save();

            DB::commit();
            return response()->json([
                "ok" => true,
                "msg" => "Registro eliminado correctamente"
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                "ok" => false,
                "msg" => "ERR. " . $th
            ], 200);
        }
    }

    public function validItem($req)
    {
        return Validator::make(
            $req->all(),
            [
                // 'field' => 'string|required|min:2|max:100',
            ]
        );
    }

    public function saveItem($item, $req)
    {
        $item->name = GenController::filter($req->name, 'U');
        $item->legal_name = GenController::filter($req->legal_name, 'U');
        $item->legal_code = GenController::filter($req->legal_code, 'U');
        $item->legal_zip = GenController::filter($req->legal_zip, 'U');
        $item->updated_by_id = $req->user()->id;
        $item->fiscal_type_id = GenController::filter($req->fiscal_type_id, 'id');
        $item->fiscal_regime_id = GenController::filter($req->fiscal_regime_id, 'id');
        $item->save();

        return $item;
    }
}