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
        Schema::create('communaute_membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('communaute_id')->constrained('communautes')->onDelete('cascade');
            $table->foreignId('apprenant_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['apprenant_id', 'communaute_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communaute_membres');
    }
};
