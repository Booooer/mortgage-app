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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->default(DB::raw('(gen_random_uuid())'))->unique(); // postgres compatible
            $table->integer('deal_id');
            $table->string('type');
            $table->integer('wished_sum');
            $table->boolean('have_init_payment');
            $table->integer('init_payment')->nullable();
            $table->string('comment')->nullable();
            $table->integer('maternity_capital')->nullable();

            $table->foreignId('init_payment_source_id')->nullable()
                ->references('id')
                ->on('init_payment_sources')
                ->cascadeOnDelete();
            $table->foreignId('mortgage_type_id')->references('id')
                ->on('mortgage_types')
                ->cascadeOnDelete();
            $table->foreignId('live_complex_id')->references('id')
                ->on('live_complexes')
                ->cascadeOnDelete();
            $table->foreignId('borrower_id')->references('id')
                ->on('task_borrowers')
                ->cascadeOnDelete();
            $table->foreignId('author_id')->references('id')
                ->on('users')
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
        Schema::dropIfExists('tasks');
    }
};
