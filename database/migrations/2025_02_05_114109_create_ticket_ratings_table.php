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
        Schema::create('ticket_ratings', function (Blueprint $table) {
            $table->uuid('rating_id')->primary();
            $table->uuid('ticket_id');
            $table->uuid('user_id');
            $table->integer('rating')->nullable(false);
            $table->string('remarks')->nullable(false);
            $table->timestamps();

            // Foreign Key Assignment
            $table->foreign('user_id')->references('user_id')->on('custom_user_tables')->onDelete('restrict');
            $table->foreign('ticket_id')->references('ticket_id')->on('tickets')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_ratings');
    }
};
