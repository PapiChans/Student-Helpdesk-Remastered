<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('custom_user_tables', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('email')->unique()->nullable(false);
            $table->string('password')->nullable(false);
            $table->boolean('is_admin')->default(false)->nullable(false);
            $table->timestampTz('lockout_expiration')->nullable();
            $table->integer('login_attempts')->default(0)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_user_tables');
    }
};
