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
        // 1. Settings Table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('school_logo')->nullable();
            $table->string('principal_name')->nullable();
            $table->text('principal_speech')->nullable();
            $table->string('principal_photo')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('maps_iframe')->nullable();
            $table->string('external_ppdb_link')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->timestamps();
        });

        // 2. Teachers Table
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('name');
            $table->string('position');
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Extracurriculars Table
        Schema::create('extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->string('coach')->nullable();
            $table->timestamps();
        });

        // 4. Facilities Table
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        // 5. Categories Table (for Blog)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 6. Posts Table (Blog)
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->integer('views')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 7. Announcements Table
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->date('date');
            $table->timestamps();
        });

        // 8. Agendas Table
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->string('location')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();
        });

        // 9. Achievements Table
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('student_name')->nullable();
            $table->date('date')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        // 10. Alumni Table (Tracer)
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('graduation_year');
            $table->string('job')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('testimonial')->nullable();
            $table->timestamps();
        });

        // 11. Messages Table (Hubungi Kami)
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('alumni');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('agendas');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('extracurriculars');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('settings');
    }
};
