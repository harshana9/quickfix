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
        Schema::create('breakdowns', function (Blueprint $table) {
            $table->id();
            $table->string('mid');
            $table->string('merchant');
            $table->string('tid');
            $table->string('contact1');
            $table->string('contact2')->nullable();
            $table->string('email')->nullable();
            $table->string('error');
            $table->bigInteger('product')->unsigned();
            $table->foreign('product')->references('id')->on('products');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdowns');
    }
};
