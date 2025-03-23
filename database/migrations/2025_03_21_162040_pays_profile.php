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
            Schema::create('pays_profile', function (Blueprint $table) {
                $table->id();
                $table->decimal('pay', 18, 2)->nullable();
                $table->decimal('total_pay', 18, 2)->nullable();
                $table->decimal('next_pay', 18, 2)->nullable();
                $table->date('date_pay')->nullable();
                $table->date('next_date_pay')->nullable();
                $table->date('renewal_date_profile')->nullable();
                $table->string('status', 20)->nullable();
                $table->string('description', 255)->nullable();
                $table->unsignedBigInteger('account_profile_id'); // Clave foránea
                $table->timestamps();

                // Definir la relación con account_profiles
                $table->foreign('account_profile_id')
                    ->references('id')
                    ->on('account_profiles')
                    ->onDelete('cascade');
            });
        }

    
        public function down(): void
        {
            Schema::dropIfExists('pays_profile');
        }
    };
    