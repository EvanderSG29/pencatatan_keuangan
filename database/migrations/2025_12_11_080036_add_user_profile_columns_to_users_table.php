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
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_telp')->nullable()->after('email');
            $table->string('alamat')->nullable()->after('no_telp');
            $table->date('tanggal_lahir')->nullable()->after('alamat');
            $table->string('jenis_kelamin')->nullable()->after('tanggal_lahir');
            $table->string('lokasi')->nullable()->after('jenis_kelamin');
            $table->string('path_foto')->nullable()->after('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['no_telp', 'alamat', 'tanggal_lahir', 'jenis_kelamin', 'lokasi', 'path_foto']);
        });
    }
};
