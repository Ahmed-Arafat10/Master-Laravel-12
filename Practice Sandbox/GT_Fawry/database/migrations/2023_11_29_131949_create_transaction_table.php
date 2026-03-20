<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('transactions'))
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')
                    ->constrained('users')
                    ->restrictOnDelete();
                $table->unsignedBigInteger('ref_num');
                $table->string('merchant_ref_num');
                $table->float('order_amount');
                $table->float('payment_amount');
                $table->float('fawry_fees');
                $table->string('status');
                $table->string('payment_method');
                $table->string('signature');
                    $table->float('taxes');
                $table->string('type');
                $table->longText('qr_code')->nullable();
                $table->unique(['ref_num', 'merchant_ref_num', 'signature']);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
