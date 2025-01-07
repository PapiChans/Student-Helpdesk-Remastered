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
        Schema::create('admin_profiles', function (Blueprint $table) {
            $table->uuid('profile_id')->primary();
            $table->uuid('user_id');
            $table->string('last_name')->nullable(false);
            $table->string('first_name')->nullable(false);
            $table->string('middle_name')->nullable();
            $table->string('gender')->nullable(false);
            $table->uuid('office_id');
            $table->boolean('is_master_admin')->default(false)->nullable(false);
            $table->boolean('is_technician')->default(false)->nullable(false);
            $table->timestamps();
            
            // Foreign Key Assignment
            $table->foreign('user_id')->references('user_id')->on('custom_user_tables')->onDelete('restrict');
            $table->foreign('office_id')->references('office_id')->on('offices')->onDelete('restrict');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_profiles');
    }
};
