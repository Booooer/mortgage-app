<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->default(DB::raw('(gen_random_uuid())'))->unique(); // postgres compatible
            $table->string('name')->nullable();
            $table->integer('bitrix_id')->nullable();

            $table->foreignId('app_id')->references('id')
                ->on('b24_installs')
                ->cascadeOnDelete();

            $table->timestampsTz();
            $table->softDeletesTz();
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
