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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->uuid('evaluation_id')->primary();
            $table->uuid('user_id');
            $table->string('reference')->nullable(false);
            $table->string('status')->nullable(false)->default('New');
            $table->integer('QA')->nullable();
            $table->integer('QB')->nullable();
            $table->integer('QC')->nullable();
            $table->integer('QD')->nullable();
            $table->integer('QE')->nullable();
            $table->integer('QF')->nullable();
            $table->integer('QG')->nullable();
            $table->integer('QH')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();

            // Foreign Key Assignment
            $table->foreign('user_id')->references('user_id')->on('custom_user_tables')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
