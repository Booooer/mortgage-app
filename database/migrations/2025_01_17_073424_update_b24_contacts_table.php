<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropColumns('b24_contacts', 'phone_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b24_contacts', function (Blueprint $table) {
            $table->foreignId('phone_id')->references('id')
                ->on('phones')
                ->cascadeOnDelete();
        });
    }
};
