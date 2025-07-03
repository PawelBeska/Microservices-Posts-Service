<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('externals')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->comment('Title of the post');
            $table->text('content')->nullable()->comment('Content of the post');

            $table->string('pickup_country', 2);
            $table->string('pickup_city');
            $table->string('pickup_postal_code')->nullable();
            $table->text('pickup_address')->nullable();
            $table->magellanPoint('pickup_location', 4326);

            $table->string('delivery_country', 2);
            $table->string('delivery_city');
            $table->string('delivery_postal_code')->nullable();
            $table->text('delivery_address')->nullable();
            $table->magellanPoint('delivery_location', 4326);

            $table->dateTime('pickup_date_from')->nullable();
            $table->dateTime('pickup_date_to')->nullable();
            $table->dateTime('delivery_date_from')->nullable();
            $table->dateTime('delivery_date_to')->nullable();

            $table->jsonb('cargo');
            $table->addColumn('postServiceTypeEnum', 'service_type');
            $table->unsignedSmallInteger('pickup_floor')->nullable();
            $table->boolean('pickup_elevator')->nullable();
            $table->unsignedSmallInteger('delivery_floor')->nullable();
            $table->boolean('delivery_elevator')->nullable();
            $table->boolean('as_company')->default(false);
            $table->string('company_country', 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
