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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('printify_order_id')->nullable()->after('paypal_order_id');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->json('printify_data')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('printify_order_id');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('printify_data');
        });
    }
};
