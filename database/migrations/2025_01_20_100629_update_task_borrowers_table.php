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
        Schema::dropColumns('task_borrowers', 'bank_salary');

        Schema::table('task_borrowers', function (Blueprint $table) {
            $table->foreignId('bank_id')->references('id')
                ->on('banks')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('task_borrowers', 'bank_id');

        Schema::table('task_borrowers', function (Blueprint $table) {
            $table->string('bank_salary');
        });
    }
};
