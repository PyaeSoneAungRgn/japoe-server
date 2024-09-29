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
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
            $table->string('exception');
            $table->text('message');
            $table->string('group')->index();
            $table->string('host')->nullable();
            $table->string('method')->nullable();
            $table->string('path')->nullable();
            $table->jsonb('headers')->nullable();
            $table->jsonb('query')->nullable();
            $table->jsonb('body')->nullable();
            $table->string('controller')->nullable();
            $table->jsonb('command')->nullable();
            $table->string('timezone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
