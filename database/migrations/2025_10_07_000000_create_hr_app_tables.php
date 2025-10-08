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
        Schema::enableForeignKeyConstraints();

        // USERS
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('full_name');
            $table->string('company_name')->nullable(); // Added company_name field
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->enum('role', ['admin', 'hr']);
            $table->string('profile_picture')->nullable();
            $table->boolean('email_verified')->default(false);
            $table->boolean('accepted_terms_and_privacy')->default(false);
            $table->timestamps();
        });

        // SMTP CREDENTIALS
        Schema::create('smtp_credentials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('smtp_host');
            $table->integer('smtp_port');
            $table->boolean('smtp_secure')->default(false);
            $table->string('smtp_email');
            $table->text('smtp_app_password_encrypted')->nullable(); // Add ->nullable() here
            $table->timestamps();
        });

        // JOB POSITIONS
        Schema::create('positions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->timestamps();
        });

        // APPLICANTS
        Schema::create('applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->foreignUuid('applied_position_id')->nullable()->constrained('positions')->onDelete('set null');
            $table->enum('status', ['pending', 'reviewed', 'rejected', 'approved', 'interviewed'])->default('pending');
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // APPLICANT FILES
        Schema::create('applicant_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->nullable(); // cv, portfolio, etc.
            $table->foreignUuid('uploaded_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('uploaded_at')->useCurrent();
        });

        // MESSAGE TEMPLATES
        Schema::create('message_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('template_type', ['reject', 'approve', 'invite']);
            $table->string('subject');
            $table->longText('body');
            $table->foreignUuid('created_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // MESSAGE HISTORY
        Schema::create('message_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sender_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignUuid('applicant_id')->nullable()->constrained('applicants')->onDelete('set null');
            $table->foreignUuid('template_id')->nullable()->constrained('message_templates')->onDelete('set null');
            $table->string('recipient_email');
            $table->string('subject');
            $table->longText('body');
            $table->enum('send_status', ['sent', 'failed', 'queued'])->default('sent');
            $table->text('smtp_response')->nullable();
            $table->json('attachments_json')->nullable();
            $table->timestamp('sent_at')->useCurrent();
        });

        // PASSWORD RESETS
        Schema::create('password_resets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });

        // APP SETTINGS
        Schema::create('app_settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('value');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('message_history');
        Schema::dropIfExists('message_templates');
        Schema::dropIfExists('applicant_files');
        Schema::dropIfExists('applicants');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('smtp_credentials');
        Schema::dropIfExists('users');
    }
};