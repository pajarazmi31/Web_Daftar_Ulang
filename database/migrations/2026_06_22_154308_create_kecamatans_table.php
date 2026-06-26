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
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->char('id', 7)->primary(); // Sesuai kode BPS 7 digit
            $table->char('kabupaten_id', 4);
            $table->string('nama');
            $table->timestamps();

            $table->foreign('kabupaten_id')->references('id')->on('kabupatens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
