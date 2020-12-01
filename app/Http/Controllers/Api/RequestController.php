<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Peminjaman;
use App\ReqPeminjaman;
use Illuminate\Http\Request;
use App\Reqreq;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function index()
    {
        $req = ReqPeminjaman::all();
        if (count($req)  > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $req
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    public function show($id)
    {
        $req = ReqPeminjaman::find($id);
        if (!is_null($req)  > 0) {
            return response([
                'message' => 'Retrieve Success',
                'data' => $req
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
            'Judul' => 'required',
            'ISBN' => 'required',
            'peminjam' => 'required',
            'tgl_pinjam' => 'required|date',
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

        $req = Peminjaman::create($storeData);
        $this->destroy($request->id);
        return response([
            'message' => 'Add Request Success',
            'data' => $req,
        ], 200);
    }

    public function destroy($id)
    {
        $req = ReqPeminjaman::find($id);

        if (is_null($req)) {
            return response([
                'message' => 'Request Not Found',
                'data' => null
            ], 404);
        }

        if ($req->delete()) {
            return response([
                'message' => 'Delete Success',
                'data' => $req,
            ], 200);
        }

        return response([
            'message' => 'Delete Request Failed',
            'data' => null,
        ], 400);
    }
}
