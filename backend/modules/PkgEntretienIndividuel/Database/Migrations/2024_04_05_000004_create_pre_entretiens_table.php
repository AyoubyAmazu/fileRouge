<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pre_entretiens', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->boolean('active')->default(false);
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pre_entretiens');
    }
}; 