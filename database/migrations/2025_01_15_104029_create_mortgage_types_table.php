<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mortgage_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->default(DB::raw('(gen_random_uuid())'))->unique(); // postgres compatible
            $table->string('title');

            $table->foreignId('app_id')->references('id')
                ->on('b24_installs')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortgage_types');
    }
};
