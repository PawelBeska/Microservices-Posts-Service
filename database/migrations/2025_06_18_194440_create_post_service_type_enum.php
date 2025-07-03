<?php

use App\Enums\PostServiceTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $enumValues = collect(PostServiceTypeEnum::all())->map(fn($type) => "'".str_replace("'", "''", $type)."'")->implode(',');

        DB::statement(
            "
        DO $$ BEGIN
    CREATE TYPE post_service_type_enum AS ENUM ($enumValues);
EXCEPTION
    WHEN duplicate_object THEN null;
END $$;"
        );
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS post_service_type_enum;");
    }
};
