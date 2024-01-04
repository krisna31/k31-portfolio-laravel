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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider')->default('Basic Email & Password');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->unique()->nullable();
            $table->string('nomor_induk_kependudukan')->unique()->nullable();
            $table->string('nomor_induk_pegawai')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('gender_id')->references('id')->on('genders')->default(1);
            $table->foreignId('position_id')->references('id')->on('positions')->default(1);
            $table->date('birth_date')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
