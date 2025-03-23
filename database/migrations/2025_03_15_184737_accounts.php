<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('services_id')->constrained('services')->onDelete('cascade');
            $table->string('name_account');
            $table->string('email_account');
            $table->string('pass_account'); 
            $table->string('type_account', 20);
            $table->decimal('price', 10, 2);
            $table->integer('available_profiles')->default(0);
            $table->integer('used_profiles')->default(0);
            $table->date('date_pay')->nullable();
            $table->date('renewal_date_account');
            $table->string('status', 20);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
