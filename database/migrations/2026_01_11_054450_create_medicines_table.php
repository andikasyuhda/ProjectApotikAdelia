<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->unsignedInteger('stok')->default(0);
            $table->string('lokasi')->default('-');
            $table->timestamps();

            $table->index('nama_obat');
            $table->index('stok');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
