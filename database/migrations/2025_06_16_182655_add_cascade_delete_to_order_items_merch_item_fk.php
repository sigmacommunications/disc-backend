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
        // 1) Delete any order_items pointing at a non-existent merch_item
        DB::table('order_items')
            ->whereNotIn('merch_item_id', function ($query) {
                $query->select('id')->from('merch_items');
            })
            ->delete();

        Schema::table('order_items', function (Blueprint $table) {
            // 2) Drop the old foreign key
            $table->dropForeign(['merch_item_id']);

            // 3) Re-create it with ON DELETE CASCADE
            $table->foreign('merch_item_id')
                ->references('id')
                ->on('merch_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the cascade FK
            $table->dropForeign(['merch_item_id']);

            // Re-create the original constraint without cascade
            $table->foreign('merch_item_id')
                ->references('id')
                ->on('merch_items');
        });
    }
};
