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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->nullable();
            
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            $table->foreignId('facility_id')
                ->constrained('facilities')
                ->cascadeOnDelete();

            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->integer('total_price');
            $table->string('status')->default('pending_payment'); // pending_payment, confirmed, cancelled

            $table->string('snap_token')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_status')->nullable();
            $table->timestamp('payment_verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
