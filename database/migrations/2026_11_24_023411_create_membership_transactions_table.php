<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('membership_application_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('reference_no')->unique();

            $table->enum('transaction_type', [
                'application',
                'renewal',
            ])->default('application');

            $table->decimal('amount', 10, 2);

            $table->enum('status', [
                'pending',
                'paid',
                'approved',
                'expired',
                'cancelled',
            ])->default('pending');

            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_transactions');
    }
};