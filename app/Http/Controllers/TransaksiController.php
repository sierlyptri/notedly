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
        $response = [
            'status' => true,
            'data' => $data
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
        // Log data yang diterima untuk debugging
        \Log::info('User ID:', ['user_id' => $request->user_id]);
        \Log::info('Request Data:', $request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'kategori' => 'required',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'created_by' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Membuat data transaksi
        $transaksi = new Transaksi();
        $transaksi->user_id = $request->user_id;
        $transaksi->jenis = $request->jenis;
        $transaksi->kategori = $request->kategori;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->deskripsi = $request->deskripsi;
        $transaksi->tanggal = $request->tanggal;
        $transaksi->created_by = $request->created_by;
        
        $status = $transaksi->save();

        if (!$status) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal disimpan'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Transaksi::where('user_id', $id)->first();
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
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'kategori' => 'required',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $transaksi = Transaksi::where('user_id', $id)->first();
        $transaksi->user_id = $request->user_id;
        $transaksi->jenis = $request->jenis;
        $transaksi->kategori = $request->kategori;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->deskripsi = $request->deskripsi;
        $transaksi->tanggal = $request->tanggal;
        $transaksi->updated_by = $request->updated_by;
        $status = $transaksi->save();
        if (!$status) {
            $respon = [
                'status' => false,
                'message' => 'Data gagal diupdate'
            ];
            return $respon;
        }else{
            $respon = [
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ];
            return $respon;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::where('user_id', $id)->first();
        $status = $transaksi->delete();
        if (!$status) {
            $respon = [
                'status' => false,
                'message' => 'Data gagal dihapus'
            ];
            return $respon;
        }else{
            $respon = [
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ];
            return $respon;
        }
    }
}