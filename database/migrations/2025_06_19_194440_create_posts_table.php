<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('externals')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('title')->comment('Title of the post');
            $table->text('content')->comment('Content of the post');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
