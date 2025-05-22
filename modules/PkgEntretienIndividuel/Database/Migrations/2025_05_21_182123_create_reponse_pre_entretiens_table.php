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
        Schema::create('reponse_pre_entretiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pre_entretien_id')->constrained()->onDelete('cascade');
                $table->foreignId('apprenant_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('date_soumission');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reponse_pre_entretiens');
    }
};
