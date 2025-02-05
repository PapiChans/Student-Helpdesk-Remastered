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
        Schema::create('k_b_topics', function (Blueprint $table) {
            $table->uuid('topic_id')->primary();
            $table->uuid('folder_id');
            $table->string('title')->nullable(false);
            $table->text('content')->nullable(false);
            $table->integer('likes')->nullable();
            $table->integer('dislikes')->nullable();
            $table->string('status')->nullable(false)->default('Unpublished');
            $table->timestamps();

            $table->foreign('folder_id')->references('folder_id')->on('k_b_folders')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_b_topics');
    }
};
