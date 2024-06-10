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
            $table->foreignUuid('attende_code_id')->references('id')->on('attende_codes');
            $table->foreignId('approval_status_id')->references('id')->on('approval_statuses');
            $table->foreignId('attende_status_id')->references('id')->on('attende_statuses');
            $table->datetime('attende_time')->nullable();
            $table->text('address')->nullable();
            $table->text('photo');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
