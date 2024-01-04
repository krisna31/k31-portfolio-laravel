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
            $table->id();
            $table->string('code');
            $table->string('description')->nullable()->default(null);
            $table->foreignId('attende_type_id')->constrained('attende_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('start_date')->nullable()->default(null);
            $table->dateTime('end_date')->nullable()->default(null);
            $table->timestamps();
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
