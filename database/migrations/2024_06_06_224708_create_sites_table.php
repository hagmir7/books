<?php

use App\Models\Language;
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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->string('name');
            $table->text('footer')->nullable();
            $table->text('header')->nullable();
            $table->text('keywords')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->foreignIdFor(Language::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
