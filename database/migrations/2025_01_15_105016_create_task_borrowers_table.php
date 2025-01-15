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
        Schema::create('task_borrowers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->default(DB::raw('(gen_random_uuid())'))->unique(); // postgres compatible
            $table->string('type');
            $table->string('employment_type');
            $table->string('bank_salary');
            $table->string('marital_status');
            $table->boolean('have_children');

            $table->foreignId('contact_id')->references('id')
                ->on('b24_contacts')
                ->cascadeOnDelete();
            $table->foreignId('phone_id')->references('id')
                ->on('phones')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_borrowers');
    }
};
