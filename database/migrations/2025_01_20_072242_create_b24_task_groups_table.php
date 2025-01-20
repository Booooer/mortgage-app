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
        Schema::create('b24_task_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');

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
        Schema::dropIfExists('b24_task_groups');
    }
};
