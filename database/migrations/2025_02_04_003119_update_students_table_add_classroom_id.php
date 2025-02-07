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
        Schema::table('students', function (Blueprint $table) {
            // Tambahkan kolom classroom_id
            $table->foreignId('classroom_id')->nullable()->after('class')->constrained()->onDelete('cascade');
            
            // Hapus kolom class jika tidak diperlukan lagi
            $table->dropColumn('class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Kembalikan kolom class jika rollback dilakukan
            $table->string('class')->after('name');
            
            // Hapus kolom classroom_id
            $table->dropForeign(['classroom_id']);
            $table->dropColumn('classroom_id');
        });
    }
};
