<?php

use Illuminate\Database\Migrations\Migration;
use PDPhilip\Elasticsearch\Schema\Blueprint;
use PDPhilip\Elasticsearch\Schema\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->indexField(true);
            $table->nested('name')->properties(function (Blueprint $nested) {
                $nested->keyword('language');
                $nested->text('value');
            });
            $table->nested('description')->properties(function (Blueprint $nested) {
                $nested->keyword('language');
                $nested->text('value');
            });
            $table->nested('slug')->properties(function (Blueprint $nested) {
                $nested->keyword('language');
                $nested->text('value');
            });
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
