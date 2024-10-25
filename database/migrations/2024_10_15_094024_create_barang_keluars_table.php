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
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained('karyawans')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('status_penjualan');
            $table->integer('harga_jual');
            $table->integer('jumlah');
            $table->integer('pendapatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
