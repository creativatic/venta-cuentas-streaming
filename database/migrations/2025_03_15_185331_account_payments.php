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
        Schema::create('account_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounts_id')->constrained('accounts')->onDelete('cascade');
            $table->decimal('igv', 18, 2);
            $table->decimal('pay', 18, 2);
            $table->decimal('total_pay', 18, 2);
            $table->decimal('next_pay', 18, 2);
            $table->date('date_pay');
            $table->date('next_date_pay');
            $table->string('status', 20);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_payments');
    }
};
