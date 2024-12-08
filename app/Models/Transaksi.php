<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 't_transaksi';
    protected $primaryKey = 'id';
    protected $fillable = [ 'user_id', 'jenis', 'kategori', 'jumlah', 'deskripsi', 'tanggal', 'created_by', 'updated_by'];
}
