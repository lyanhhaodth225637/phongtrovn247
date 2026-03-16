<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wards', function (Blueprint $table) {

            $table->id();

            $table->foreignId('province_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('code', 20)->unique();
            $table->string('name', 150);
            $table->string('slug', 160)->index();

            $table->enum('type', ['ward', 'commune', 'special_zone'])
                ->default('ward');

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            $table->tinyInteger('zoom')->default(13);

            $table->timestamps();
            $table->unique(['province_id', 'name']); // duy nhất trong tỉnh
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
