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
        Schema::create('error_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index();
            $table->foreignId('assignee_id')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('resolve_by')->nullable();
            $table->timestampTz('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_groups');
    }
};
