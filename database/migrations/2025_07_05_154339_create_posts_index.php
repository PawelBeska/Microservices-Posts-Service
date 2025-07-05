<?php

use Illuminate\Database\Migrations\Migration;
use PDPhilip\Elasticsearch\Schema\Blueprint;
use PDPhilip\Elasticsearch\Schema\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::delete('posts');
        Schema::create('posts', static function (Blueprint $table) {
            $table->uuid('user_id');
            $table->unsignedBigInteger('category_id');
            $table->keyword('pickup_country');
            $table->text('pickup_city');
            $table->keyword('pickup_postal_code')->nullValue('NULL');
            $table->text('pickup_address');
            $table->geoPoint('pickup_location');
            $table->keyword('delivery_country');
            $table->text('delivery_city');
            $table->keyword('delivery_postal_code')->nullValue('NULL');
            $table->text('delivery_address');
            $table->geoPoint('delivery_location');
            $table->date('pickup_date_from');
            $table->date('pickup_date_to');
            $table->date('delivery_date_from');
            $table->date('delivery_date_to');
            $table->nested('cargo')->properties(function (Blueprint $nested) {
                $nested->keyword('name');
                $nested->unsignedInteger('weight');
                $nested->unsignedInteger('quantity');
                $nested->unsignedInteger('length');
                $nested->unsignedInteger('width');
                $nested->unsignedInteger('height');
            });
            $table->keyword('service_type');
            $table->smallInteger('pickup_floor')->nullValue(-1);
            $table->boolean('pickup_elevator');
            $table->smallInteger('delivery_floor')->nullValue(-1);
            $table->boolean('delivery_elevator');
            $table->boolean('as_company')->default(false);
            $table->keyword('company_country')->nullValue('NULL');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
