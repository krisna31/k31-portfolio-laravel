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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_use');
            $table->string('title');
            $table->text('subtitle');
            $table->string('scroll_text');
            $table->string('bio_title');
            $table->text('bio_subtitle');
            $table->string('skill_title');
            $table->text('quote');
            $table->text('quote_author');
            $table->string('contact_links_title');
            $table->boolean('is_using_default_contact_links');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
