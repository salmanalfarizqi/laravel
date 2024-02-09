<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\meja;
use Illuminate\Http\Request;

class mejaController extends Controller
{
    public function index(){
        $data = meja::all();
        return response() -> json([
            'message' => 'sukses menampilkan data meja',
            'status' => 200,
            'data' => $data,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
        ];

        $request -> validate($rules);

        $tetap = 212;
        $kode = $tetap.$this -> generateRandomString();

        $request['id'] = $kode;

        $data = meja::create($request -> all());

        return response() -> json([
            'message' => 'sukses menambahkan data meja',
            'status' => 200,
            'data' => $data
        ]);
    }

    public function cari($id){
        $data = meja::findOrFail($id);
        
        return response() -> json([
            'message' => 'berhasil mencari meja',
            'status' => 200,
            'data' => $data -> name,
        ],200);
    }

    function generateRandomString($length = 5) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
