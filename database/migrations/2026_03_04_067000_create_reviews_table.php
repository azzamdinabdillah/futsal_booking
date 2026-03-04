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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained('bookings')->onDelete('cascade');
            $table->foreignId('field_id')->constrained('fields')->onDelete('cascade');

            // Rating lapangan (opsional)
            $table->unsignedTinyInteger('field_rating_score')->nullable()->comment('1-5, boleh kosong jika tidak diisi');
            $table->text('field_rating_comment')->nullable();

            // Rating pelayanan umum (opsional)
            $table->unsignedTinyInteger('service_rating_score')->nullable()->comment('1-5, boleh kosong jika tidak diisi');
            $table->text('service_rating_comment')->nullable();

            // Soft delete oleh admin
            $table->boolean('is_deleted')->default(false);
            $table->foreignId('deleted_by')->nullable()->constrained('admins');
            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
