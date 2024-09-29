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
        Schema::create('error_log_frames', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('error_log_id')
                ->references('id')
                ->on('error_logs')
                ->cascadeOnDelete();
            $table->jsonb('snippet');
            $table->integer('line_number');
            $table->string('file');
            $table->string('method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_log_frames');
    }
};
