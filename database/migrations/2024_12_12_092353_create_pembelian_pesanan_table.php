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
        Schema::create('pembelian_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelians')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('pesanan_id')->constrained('pesanans')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_pesanan');
    }
};
