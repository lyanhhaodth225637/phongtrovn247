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
        Schema::create('provinces', function (Blueprint $table) {

            $table->id();
            $table->string('name', 150)->unique();
            $table->string('slug', 160)->unique();
            $table->string('code', 20)->unique();
            $table->enum('type', ['province', 'city'])->default('province');

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->tinyInteger('zoom')->default(10);

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
