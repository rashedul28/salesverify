<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_file_matches', function (Blueprint $table) {
            $table->id();
            $table->string('source_id');
            $table->string('offer_source_name');
            $table->string('offer_name');
            $table->date('sale_date')->nullable();          
            $table->integer('sales_count');     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_file_matches');
    }
};
