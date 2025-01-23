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
        Schema::dropColumns('task_borrowers', [
            'employment_type',
            'marital_status',
        ]);

        Schema::table('task_borrowers', function (Blueprint $table) {
            $table->foreignId('employment_type_id')->references('id')
                ->on('employment_types')
                ->cascadeOnDelete();

            $table->foreignId('marital_status_id')->references('id')
                ->on('marital_statuses')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('task_borrowers', [
            'employment_type_id',
            'marital_status_id',
        ]);

        Schema::table('task_borrowers', function (Blueprint $table) {
            $table->string('employment_type')->nullable();
            $table->string('marital_status')->nullable();
        });
    }
};
