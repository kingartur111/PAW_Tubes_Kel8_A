<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::all();
        if (count($peminjaman)  > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $peminjaman
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::find($id);
        if (!is_null($peminjaman)  > 0) {
            return response([
                'message' => 'Retrieve Success',
                'data' => $peminjaman
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
            'id_peminjaman' => 'required|max:60|unique:peminjamen',
            'ISBN' => 'required',
            'peminjam' => 'required',
            'tgl_pinjam' => 'required|date',
            'status' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $ISBN = DB::table('bukus')->where('ISBN', $request->ISBN)->value('ISBN');
        if ($request->ISBN != $ISBN) {
            return response([
                'message' => 'ISBN Not Found',
                'data' => null
            ], 404);
        }

        $peminjaman = Peminjaman::create($storeData);
        return response([
            'message' => 'Add peminjaman Success',
            'data' => $peminjaman,
        ], 200);
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (is_null($peminjaman)) {
            return response([
                'message' => 'peminjaman Not Found',
                'data' => null
            ], 404);
        }

        if ($peminjaman->delete()) {
            return response([
                'message' => 'Delete peminjaman Success',
                'data' => $peminjaman,
            ], 200);
        }

        return response([
            'message' => 'Delete peminjaman Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        \Log::info($request->all());
        $peminjaman = Peminjaman::findOrFail($id);
        if (is_null($peminjaman)) {
            return response([
                'message' => 'peminjaman Not Found',
                'data' => null
            ], 404);
        }
        $updateData = $request->all();

        if (isset($updateData['id_peminjaman'])) {
            $peminjaman->id_peminjaman = $updateData['id_peminjaman'];
        }
        if (isset($updateData['ISBN'])) {
            $peminjaman->ISBN = $updateData['ISBN'];
        }

        if (isset($updateData['peminjam'])) {
            $peminjaman->peminjam = $updateData['peminjam'];
        }
        if (isset($updateData['tgl_pinjam'])) {
            $peminjaman->tgl_pinjam = $updateData['tgl_pinjam'];
        }
        if (isset($updateData['status'])) {
            $peminjaman->status = $updateData['status'];
        }

        $peminjaman->updated_at = Carbon::now();

        if ($peminjaman->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => $peminjaman,
            ], 200);
        }
        return response([
            'message' => 'Update User Failed',
            'data' => null,
        ], 400);
    }
}
