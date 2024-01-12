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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
	        $table->string('main_email')->nullable()->unique();
            $table->string('cc_email_1')->nullable()->unique();
            $table->string('cc_email_2')->nullable()->unique();
            $table->string('cc_email_3')->nullable()->unique();
	        $table->string('contact_1')->nullable();
            $table->string('contact_2')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
