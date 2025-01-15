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
        Schema::create('b24_installs', function (Blueprint $table) {
            $table->id();

            $table->string('auth_id');
            $table->string('refresh_id');
            $table->string('member_id');
            $table->string('domain');
            $table->string('app_sid');
            $table->dateTimeTz('expires_in');
            $table->dateTimeTz('refresh_expires_in');

            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();

            $table->softDeletesTz();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b24_installs');
    }
};
