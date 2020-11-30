<?php

namespace App\Http\Controllers\Api;

use App\Buku;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        if (count($buku)  > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $buku
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    public function show($id)
    {
        $buku = Buku::find($id);
        if (!is_null($buku)  > 0) {
            return response([
                'message' => 'Retrieve Success',
                'data' => $buku
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->except('image');
        $validate = Validator::make($storeData, [
            'ISBN' => 'required|max:60|unique:bukus',
            'Judul' => 'required|regex:/^[\pL\s\-]+$/u',
            'pengarang' => 'required|alpha',
            'kategori' => 'required|alpha',
            'tahun' => 'required|numeric',
            'bahasa' => 'required',
            'image' => 'alpha'
        ]);

        if (isset($request->image)) {
            $explodeed = explode(',', $request->image);
            $decoded = base64_decode($explodeed[1]);

            (str_contains($explodeed[0], 'jpeg')) ?  $extension = 'jpg' : $extension = 'png';
            $filename = rand() . '.' . $extension;
            $path = public_path() . '/' . $filename;
            file_put_contents($path, $decoded);
        }

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $buku = Buku::create($request->except('image') + [
            'image' => $filename
        ]);

        return response([
            'message' => 'Add Buku Success',
            'data' => $buku,
        ], 200);
    }

    public function destroy($id)
    {
        // Cari buku dari database berdasarkan id
        $buku = Buku::find($id);
        // Delete File image in public
        File::delete('/' . $buku->image);


        if (is_null($buku)) {
            return response([
                'message' => 'Buku Not Found',
                'data' => null
            ], 404);
        }

        // Delete Buku
        if ($buku->delete()) {
            return response([
                'message' => 'Delete Buku Success',
                'data' => $buku,
            ], 200);
        }

        return response([
            'message' => 'Delete Buku Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        if (is_null($buku)) {
            return response([
                'message' => 'Buku Not Found',
                'data' => null
            ], 404);
        }
        $updateData = $request->except('image');

        if (isset($request->image)) {
            $explodeed = explode(',', $request->image);
            $decoded = base64_decode($explodeed[1]);

            (str_contains($explodeed[0], 'jpeg')) ?  $extension = 'jpg' : $extension = 'png';
            $filename = rand() . '.' . $extension;
            $path = public_path() . '/' . $filename;
            file_put_contents($path, $decoded);
            $buku->image = $filename;
        }

        if (isset($updateData['ISBN'])) {
            $buku->ISBN = $updateData['ISBN'];
        }

        if (isset($updateData['Judul'])) {
            $buku->Judul = $updateData['Judul'];
        }
        if (isset($updateData['pengarang'])) {
            $buku->pengarang = $updateData['pengarang'];
        }
        if (isset($updateData['penerbit'])) {
            $buku->penerbit = $updateData['penerbit'];
        }
        if (isset($updateData['kategori'])) {
            $buku->kategori = $updateData['kategori'];
        }
        if (isset($updateData['tahun'])) {
            $buku->tahun = $updateData['tahun'];
        }
        if (isset($updateData['bahasa'])) {
            $buku->bahasa = $updateData['bahasa'];
        }

        $buku->updated_at = Carbon::now();

        if ($buku->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => $buku,
            ], 200);
        }
        return response([
            'message' => 'Update User Failed',
            'data' => null,
        ], 400);
    }
}
