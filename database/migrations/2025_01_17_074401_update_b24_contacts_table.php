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
        Schema::dropColumns('b24_contacts', [
            'name',
            'surname',
            'last_name',
        ]);

        Schema::table('b24_contacts', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('last_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('b24_contacts', [
            'name',
            'surname',
            'last_name',
        ]);

        Schema::table('b24_contacts', function (Blueprint $table) {
            $table->string('name');
            $table->string('surname');
            $table->string('last_name');
        });
    }
};
