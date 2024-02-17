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
        Schema::create('attendes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('attende_code_id')->references('uuid')->on('attende_codes');
            $table->foreignId('approval_status_id')->references('id')->on('approval_statuses');
            $table->datetime('attende_time')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->text('photo')->nullable()->default(null);
            $table->unsignedFloat('latitude')->nullable()->default(null);
            $table->unsignedFloat('longitude')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendes');
    }
};
