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
        Schema::create('breakdown_statuses', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('breakdown')->unsigned();
            $table->foreign('breakdown')->references('id')->on('breakdowns');

            $table->bigInteger('user')->unsigned();
            $table->foreign('user')->references('id')->on('users');

            $table->bigInteger('status')->unsigned();
            $table->foreign('status')->references('id')->on('statuses');

            $table->string('remark')->nullable();

            $table->bigInteger('authorize')->unsigned()->nullable();
            $table->foreign('authorize')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdown_statuses');
    }
};
