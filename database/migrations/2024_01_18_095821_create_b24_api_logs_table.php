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
        Schema::create('b24_api_logs', static function (Blueprint $table) {
            $table->id();

            $table->string('scope')->nullable();
            $table->string('level');
            $table->text('message');
            $table->jsonb('context');

            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b24_api_logs');
    }
};
