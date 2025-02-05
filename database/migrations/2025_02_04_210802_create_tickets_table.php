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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('ticket_id')->primary();
            $table->uuid('user_id');
            $table->string('ticket_number')->nullable(false);
            $table->string('affiliation')->nullable(false);
            $table->string('priority')->nullable(false);
            $table->string('status')->nullable(false);
            $table->string('type')->nullable(false);
            $table->uuid('office_id');
            $table->timestamp('resolved_date')->nullable();
            $table->string('service')->nullable(false);
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
        Schema::dropIfExists('tickets');
    }
};
