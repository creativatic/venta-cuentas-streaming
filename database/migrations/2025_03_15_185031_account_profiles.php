<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('account_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('profile_number');
            $table->string('profile_name', 255)->nullable();
            $table->string('profile_pin', 10)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('status_profile', 20)->nullable();
            $table->unsignedBigInteger('accounts_id');
            $table->timestamps();
            
            $table->foreign('accounts_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_profiles');
    }
};