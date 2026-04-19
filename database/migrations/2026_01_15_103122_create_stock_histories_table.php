<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedInteger('previous_stock');
            $table->unsignedInteger('new_stock');
            $table->integer('change_amount');
            $table->enum('change_type', ['in', 'out', 'adjust'])->default('adjust');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->index('medicine_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};
