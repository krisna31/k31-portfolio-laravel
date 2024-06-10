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
        Schema::create('attende_codes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('description')->nullable()->default(null);
            $table->foreignId('attende_type_id')->constrained('attende_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->default(0)->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger('radius')->nullable();
            $table->foreignId('default_approval_status_id')->constrained('approval_statuses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('start_date')->nullable()->default(null);
            $table->dateTime('end_date')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attende_codes');
    }
};
