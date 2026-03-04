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
            $table->string('booking_code', 20)->unique();
            $table->foreignId('field_id')->constrained('fields');

            // Data customer
            $table->string('customer_name', 150);
            $table->string('customer_whatsapp', 20);
            $table->string('customer_email', 150);

            // Detail jadwal
            $table->date('play_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('duration_hours', 4, 2);

            // Harga (snapshot)
            $table->decimal('price_per_hour_snapshot', 12, 2);
            $table->decimal('total_price', 12, 2);

            // Metode pembayaran
            $table->string('payment_method', 30);
            $table->decimal('dp_percentage_snapshot', 5, 2)->nullable();
            $table->decimal('dp_amount', 12, 2)->nullable();
            $table->decimal('remaining_amount', 12, 2)->nullable();

            // Status & kebijakan
            $table->string('status', 30)->default('waiting_payment');
            $table->boolean('policy_agreed')->default(false);

            // Informasi tambahan
            $table->text('admin_note')->nullable();
            $table->string('rating_token', 64)->unique()->nullable();

            // Konfirmasi
            $table->timestamp('confirmed_at')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('admins');

            // Penyelesaian
            $table->timestamp('completed_at')->nullable();

            // Pembatalan
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancelled_by', 20)->nullable();
            $table->boolean('dp_refunded')->nullable();

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
