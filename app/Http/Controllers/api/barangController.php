<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class barangController extends Controller
{
    public function index(){
        $data = barang::all();
        return response() -> json([
            'message' => 'success get all data',
            'statust' => 200,
            'data' => $data,
        ],200);
    }

    public function store(Request $request){
        $rule = [
            'name_item' => 'required',
            'description' => 'required',
            'foto' => 'file|max:5000|mimes:png,jpg,jpeg|required',
            'price' => 'required',
            'stock' => 'required'
        ];

        $request -> validate($rule);

        $FileName = $this -> generateRandomString();
        $extension = $request -> foto -> extension();
        $file = $FileName.'.'.$extension;
        Storage::putFileAs('public', $request -> foto, $file);

        $request['image'] = $FileName.'.'.$extension;
        $data = barang::create($request -> all());
        return response() -> json([
            'message' => 'sukses menambahkan barang',
            'status' => 200,
            'data' => $data,
        ],200);
    }

    public function destroy($id){
        $data = barang::findOrFail($id);

        $data -> delete();

        return response() -> json([
            'message' => 'sukses menghapus barang',
            'status' => 200,
        ],200);
    }
    
    public function show($id){
        $data = barang::findOrFail($id);
        return response() -> json([
            'message' => 'suskes menampilkan barang',
            'status' => 200,
            'data' => $data,
        ]);
    }

    public function find(Request $request){
        $keyword = $request -> keyword;
        $data = barang::where('name_item','like',"%".$keyword."%") ->
         orWhere('price','like',"%".$keyword."%") -> 
         get();

         return response() -> json([
            'message' => 'sukses melakukan pencarian data',
            'status' => 200,
            'data' => $data,
         ]);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
