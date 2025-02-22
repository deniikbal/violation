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
        Schema::table('violation_types', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(); // Kolom category_id
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null'); // Relasi foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('violation_types', function (Blueprint $table) {
            $table->dropForeign(['category_id']); // Hapus foreign key
            $table->dropColumn('category_id'); // Hapus kolom category_id
        });
    }
};
