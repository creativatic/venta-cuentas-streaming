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
            Schema::create('payment_notification', function (Blueprint $table) {
                $table->id();
                $table->string('type_notification', 20); // Tipo de notificación
                $table->string('notification_first', 255)->nullable(); // Primera notificación
                $table->string('notification_second', 255)->nullable(); // Segunda notificación
                $table->string('notification_third', 255)->nullable(); // Tercera notificación
                $table->string('notification_fourth', 255)->nullable(); // Cuarta notificación
                $table->decimal('notification_pay', 18, 2)->nullable(); // Monto de la notificación
                $table->string('notification_email', 255)->nullable(); // Correo de notificación
                $table->string('notification_phone', 20)->nullable(); // Teléfono de notificación
                $table->string('notification_status', 20)->nullable(); // Estado de la notificación
                $table->text('notification_description')->nullable(); // Descripción de la notificación
                $table->unsignedBigInteger('account_payment_id'); // Clave foránea a account_payments
                $table->unsignedBigInteger('pays_profile_id'); // Clave foránea a pays_profile
                $table->timestamps();
    
                // Relación con account_payments
                $table->foreign('account_payment_id')
                      ->references('id')
                      ->on('account_payments')
                      ->onDelete('cascade');
    
                // Relación con pays_profile
                $table->foreign('pays_profile_id')
                      ->references('id')
                      ->on('pays_profile')
                      ->onDelete('cascade');
            });
        }

    
        public function down(): void
        {
            Schema::dropIfExists('payment_notification');
        }
    };
    