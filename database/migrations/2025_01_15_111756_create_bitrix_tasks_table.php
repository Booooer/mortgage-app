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
        Schema::create('bitrix_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('bitrix_task_id');

            $table->foreignId('app_id')->references('id')
                ->on('b24_installs')
                ->cascadeOnDelete();
            $table->foreignId('task_id')->references('id')
                ->on('tasks')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitrix_tasks');
    }
};
