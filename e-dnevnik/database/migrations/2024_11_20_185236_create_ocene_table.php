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
        Schema::create('ocene', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ucenik_id')->constrained('ucenici')->onDelete('cascade');
            $table->foreignId('predmet_id')->constrained('predmeti')->onDelete('cascade');
            $table->integer('ocena'); // 1-5
            $table->date('datum'); // Datum kada je ocena dodeljena
            $table->text('komentar')->nullable(); // Opciono
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocene');
    }
};
