<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('merch_items', function (Blueprint $table) {
            // Step 1: Drop foreign key and column for artist_id
            $table->dropForeign(['artist_id']);
            $table->dropColumn('artist_id');

            // Step 2: Add user_id column as nullable initially
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        // Step 3: Backfill existing merch_items with a valid user_id.
        // Ensure that user_id value '1' exists or replace with an appropriate ID.
        DB::table('merch_items')->update(['user_id' => 1]);

        Schema::table('merch_items', function (Blueprint $table) {
            // Step 4: Alter the column to be non-nullable and then add the foreign key constraint
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('merch_items', function (Blueprint $table) {
            // Rollback: remove user_id and add artist_id again
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->unsignedBigInteger('artist_id')->after('id');
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
        });
    }

};
