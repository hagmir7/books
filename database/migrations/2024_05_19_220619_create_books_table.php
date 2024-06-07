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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('title', 150)->nullable();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Author::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\BookCategory::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Language::class)->nullable()->constrained()->cascadeOnDelete();
            $table->integer('pages')->nullable();
            $table->string('size', 100)->nullable();
            $table->string('type', 10)->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('body')->nullable();
            $table->string('tags', 500)->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_public')->default(true);
            $table->string('slug')->unique()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
