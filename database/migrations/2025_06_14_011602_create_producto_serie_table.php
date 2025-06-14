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
        Schema::create('producto_serie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('serie_id')->constrained()->onDelete('cascade')->onUpdate('cascade');   
            $table->text('descripcion');  
            $table->string('imagen');
            $table->timestamps();
            $table->unique(['producto_id', 'serie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_serie');
    }
};
