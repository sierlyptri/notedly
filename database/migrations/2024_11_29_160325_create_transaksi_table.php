<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_transaksi', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['pengeluaran', 'pemasukan']);
            $table->string('kategori');
            $table->decimal('jumlah', 15, 2);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->string('created_by');
            $table->string('updated_by')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_transaksi');
    }
};
