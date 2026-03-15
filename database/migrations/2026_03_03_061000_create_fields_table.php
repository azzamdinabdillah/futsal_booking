<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->decimal('price_per_hour', 12, 2);
            $table->decimal('length_m', 5, 2);
            $table->decimal('width_m', 5, 2);
            // $table->string('surface_type', 100);
            // $table->string('roof_type', 50);
            // $table->string('player_capacity', 20);
            $table->text('description')->nullable();
            $table->string('status', 20)->default('active');
            $table->text('inactive_reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
