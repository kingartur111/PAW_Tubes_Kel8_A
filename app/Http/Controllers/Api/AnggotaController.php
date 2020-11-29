<?php

namespace App\Http\Controllers\Api;

use App\Anggota;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();
        if (count($anggota)  > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $anggota
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    public function show($id)
    {
        $anggota = Anggota::find($id);
        if (!is_null($anggota)  > 0) {
            return response([
                'message' => 'Retrieve Success',
                'data' => $anggota
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_anggota' => 'required|max:60|unique:anggotas',
            'nama' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email',
            'status' => 'required|alpha'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $anggota = Anggota::create($storeData);
        return response([
            'message' => 'Add Anggota Success',
            'data' => $anggota,
        ], 200);
    }

    public function destroy($id)
    {
        $anggota = Anggota::find($id);

        if (is_null($anggota)) {
            return response([
                'message' => 'Anggota Not Found',
                'data' => null
            ], 404);
        }

        if ($anggota->delete()) {
            return response([
                'message' => 'Delete Anggota Success',
                'data' => $anggota,
            ], 200);
        }

        return response([
            'message' => 'Delete Anggota Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        if (is_null($anggota)) {
            return response([
                'message' => 'Anggota Not Found',
                'data' => null
            ], 404);
        }
        $updateData = $request->all();

        if (isset($updateData['idpegawagi'])) {
            $anggota->idpegawai = $updateData['idpegawai'];
        }

        if (isset($updateData['nama'])) {
            $anggota->nama = $updateData['nama'];
        }
        if (isset($updateData['no_telp'])) {
            $anggota->no_telp = $updateData['no_telp'];
        }
        if (isset($updateData['jabatan'])) {
            $anggota->jabatan = $updateData['jabatan'];
        }

        $anggota->updated_at = Carbon::now();

        if ($anggota->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => $anggota,
            ], 200);
        }
        return response([
            'message' => 'Update User Failed',
            'data' => null,
        ], 400);
    }
}
