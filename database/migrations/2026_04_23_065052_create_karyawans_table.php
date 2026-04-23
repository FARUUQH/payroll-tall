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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();

                $table->string('nik')->unique();
                $table->string('nama');
                $table->string('email')->unique();
                $table->string('telepon');
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
                $table->date('tanggal_masuk');

                //relasi
                $table->foreignId('departemen_id')->constrained('departemen')->restrictOnDelete();
                $table->foreignId('jabatan_id')->constrained('jabatan')->restrictOnDelete();

                $table->integer('gaji_pokok');
                $table->integer('tunjangan')->default(0);

                $table->string('status')->default('aktif');
                $table->string('bank');
                $table->string('nomor_rekening');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
