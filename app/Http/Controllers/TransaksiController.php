<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use Validator;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transaksi::all();
        $data_query = DB::table('t_transaksi')->get();
        $response = [
            'status' => true,
            'data' => $data,
        ];
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:pengeluaran,pemasukan',
            'kategori' => 'required',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'nullable',
            'tanggal' => 'required|date'
        ]);

        $transaksi = new Transaksi();
        $transaksi->user_id = $request->user_id;
        $transaksi->jenis = $request->jenis;
        $transaksi->kategori = $request->kategori;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->deskripsi = $request->deskripsi;
        $transaksi->tanggal = $request->tanggal;
        $transaksi->created_by = 'user'; 
        $status = $transaksi->save();
        if (!$status) {
            $response = [
                'status' => false,
                'message' => 'Data gagal disimpan'
            ];
            return $response;
        }else{
            $response = [
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ];
            return $response;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Transaksi::where('user_id', $id)->get();
        $response = [
            'status' => true,
            'data' => $data
        ];
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:pengeluaran,pemasukan',
            'kategori' => 'required',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'nullable',
            'tanggal' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $transaksi = Transaksi::where('user_id',$id)->first();
        $transaksi->user_id = $request->user_id;
        $transaksi->jenis = $request->jenis;
        $transaksi->kategori = $request->kategori;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->deskripsi = $request->deskripsi;
        $transaksi->tanggal = $request->tanggal;
        $transaksi->created_by = 'user'; 
        $status = $transaksi->save();
        if (!$status) {
            $response = [
                'status' => false,
                'message' => 'Data gagal disimpan'
            ];
            return $response;
        }else{
            $response = [
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ];
            return $response;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::where('user_id',$id);
        $status = $transaksi->delete();
        if (!$status) {
            $response = [
                'status' => false,
                'message' => 'Data gagal dihapus'
            ];
            return $response;
        }else{
            $response = [
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ];
            return $response;
        }
    }
}
