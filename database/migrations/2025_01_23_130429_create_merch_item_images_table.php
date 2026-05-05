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
        Schema::create('merch_item_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merch_item_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('merch_item_id')->references('id')->on('merch_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merch_item_images');
    }
};
