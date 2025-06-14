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

        Schema::create('Evenement_jours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evenement_id')->constrained()->onDelete('cascade');
            $table->date('date')->nullable();
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('apporter')->nullable();
            $table->string('description')->nullable();
            $table->boolean('pause_cafe')->default(false);
            $table->boolean('pause_dejeuner')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
