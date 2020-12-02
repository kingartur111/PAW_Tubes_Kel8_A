<?php

namespace App\Http\Controllers\Api;


use App\Pegawai;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        if (count($pegawai)  > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    public function show($id)
    {
        $pegawai = Pegawai::find($id);
        if (!is_null($pegawai)  > 0) {
            return response([
                'message' => 'Retrieve Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        \Log::info($request->all());
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_pegawai' => 'required|max:60|unique:pegawais',
            'nama' => 'required|regex:/^[\pL\s\-]+$/u',
            'no_telp' => 'required|numeric',
            'jabatan' => 'required|alpha'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pegawai = Pegawai::create($storeData);
        return response([
            'message' => 'Add Pegawai Success',
            'data' => $pegawai,
        ], 200);
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);

        if (is_null($pegawai)) {
            return response([
                'message' => 'Pegawai Not Found',
                'data' => null
            ], 404);
        }

        if ($pegawai->delete()) {
            return response([
                'message' => 'Delete Pegawai Success',
                'data' => $pegawai,
            ], 200);
        }

        return response([
            'message' => 'Delete Pegawai Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        \Log::info($request->all());
        $pegawai = Pegawai::findOrFail($id);
        if (is_null($pegawai)) {
            return response([
                'message' => 'pegawai Not Found',
                'data' => null
            ], 404);
        }
        $updateData = $request->all();

        if (isset($updateData['id_pegawai'])) {
            $pegawai->idpegawai = $updateData['id_pegawai'];
        }

        if (isset($updateData['nama'])) {
            $pegawai->nama = $updateData['nama'];
        }
        if (isset($updateData['no_telp'])) {
            $pegawai->no_telp = $updateData['no_telp'];
        }
        if (isset($updateData['jabatan'])) {
            $pegawai->jabatan = $updateData['jabatan'];
        }

        $pegawai->updated_at = Carbon::now();

        if ($pegawai->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => $pegawai,
            ], 200);
        }
        return response([
            'message' => 'Update User Failed',
            'data' => null,
        ], 400);
    }
}
