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
        Schema::create("posts", function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY
            $table->string('title'); // VARCHAR(255) NOT NULL
            $table->string('slug')->unique(); // VARCHAR(255) UNIQUE NOT NULL
            $table->text('excerpt')->nullable(); // TEXT
            $table->longText('content'); // LONGTEXT NOT NULL
            //$table->foreignIdFor(\App\Models\User::class);
            $table->integer('author_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('featured_image')->nullable(); // VARCHAR(255), optional
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // ENUM
            $table->timestamp('published_at')->nullable(); // nullable timestamp

            // created_at and updated_at with default CURRENT_TIMESTAMP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
