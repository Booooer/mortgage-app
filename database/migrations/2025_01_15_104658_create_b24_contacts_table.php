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
        Schema::create('b24_contacts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->default(DB::raw('(gen_random_uuid())'))->unique(); // postgres compatible
            $table->integer('bitrix_id');
            $table->string('name');
            $table->string('surname');
            $table->string('last_name');

            $table->foreignId('phone_id')->references('id')
                ->on('phones')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('b24_contacts');
    }
};
