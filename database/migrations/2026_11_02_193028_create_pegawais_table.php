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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 30)->unique()->nullable();
            $table->string('nama', 150);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('pendidikan_terakhir', ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3']);
            $table->date('tanggal_lahir');
            $table->string('jabatan', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telepon', 25)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
