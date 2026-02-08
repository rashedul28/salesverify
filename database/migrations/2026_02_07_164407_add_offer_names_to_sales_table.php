<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->string('offer_source_name')->after('offer_source_id');
        $table->string('offer_name')->after('offer_id');
    });
}

public function down()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->dropColumn(['offer_source_name', 'offer_name']);
    });
}
};
