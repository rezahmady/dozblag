<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the export_jobs table used by the custom Export Operation.
     * Each row represents a single export job for a (crud_key, user_id) pair.
     */
    public function up(): void
    {
        Schema::create('export_jobs', function (Blueprint $table) {
            $table->id();

            // CRUD identifier (e.g., 'trafic-permit-report')
            $table->string('crud_key', 100)->index();

            // Owner of the export job
            $table->unsignedBigInteger('user_id')->index();

            // queued | processing | completed | cancelled | failed
            $table->string('status', 20)->default('queued');

            // Progress tracking
            $table->unsignedBigInteger('total_rows')->default(0);
            $table->unsignedBigInteger('processed_rows')->default(0);
            $table->unsignedTinyInteger('progress_percent')->default(0);

            // Snapshot of request filters/query string when the job was started
            $table->json('filters')->nullable();

            // Cancel request flag - polled by the worker every chunk
            $table->boolean('cancel_requested')->default(false);

            // Final file information
            $table->string('file_path', 500)->nullable();
            $table->string('file_name', 255)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            // Error message (if status = failed)
            $table->text('error_message')->nullable();

            // Timestamps for lifecycle tracking
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            // Composite index for the most common lookup:
            // "is there an active job for this crud + user?"
            $table->index(['crud_key', 'user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('export_jobs');
    }
};
