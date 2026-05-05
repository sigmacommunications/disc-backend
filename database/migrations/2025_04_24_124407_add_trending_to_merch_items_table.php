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
            $table->boolean('trending')
                ->default(false)
                ->after('approved');
        });
    }

    public function down()
    {
        Schema::table('merch_items', function (Blueprint $table) {
            $table->dropColumn('trending');
        });
    }
};
