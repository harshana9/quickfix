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
        Schema::create('email_carbon_copy_people', function (Blueprint $table) {
            $table->id();
            $table->string('person')->unique()->required();
            $table->string('email')->unique()->required();
            $table->enum('cc_level', [1,2,3])->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_carbon_copy_people');
    }
};
