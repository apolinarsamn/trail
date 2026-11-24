<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('membership_transaction_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('payment_no')->unique();

            $table->decimal('amount', 10, 2);

            $table->string('payment_method');
            $table->string('payment_reference')->nullable();

            $table->date('paid_at');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};