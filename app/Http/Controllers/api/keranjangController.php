<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\keranjang;
use Illuminate\Http\Request;

class keranjangController extends Controller
{
    public function index(Request $request)
    {
        $data = keranjang::where('id_meja', $request -> meja) -> with('item') -> get();
        $kuitansi = keranjang::where('id_meja', $request -> meja) -> sum('totals');
        return response() -> json([
            'items' => $data,
            'totals' => $kuitansi,
        ]);
    }

    public function store(Request $request){
        $rule = [
            'id_meja' => 'required',
            'id_barang' => 'required',
            'qty' => 'required',
        ];

        $request -> validate($rule);
        
        $barang = barang::findOrFail($request -> id_barang);
        $harga = $barang -> price;
        $total = $harga * $request -> qty;
        $request['totals'] = $total;
        keranjang::create($request -> all());
        return response() -> json([
            'statust' => 200,
            'message' => 'success add product to cart',
        ], 200);
    }

    public function destroy(string $id){
        $data = keranjang::findOrFail($id);
        $data -> delete();

        return response() -> json([
            'statust' => 200,
            'message' => 'success delete items'
        ], 200);
    }

    public function tambahQty(string $id, Request $request){
        $rule = [
            'qty' => 'required',
        ];
        $request -> validate($rule);
        $data = keranjang::findOrFail($id);
        $id_barang = $data -> id_barang;
        $barang = barang::findOrFail($id_barang) -> price;
        $total = $barang * $request -> qty;
        $request['totals'] = $total;
        $data -> update($request -> all());

        return response() -> json([
            'statust' => 200,
            'message' => 'success Add  quantity'
        ], 200);
    }
}
