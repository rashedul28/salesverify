<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function ($table) {
            $table->id();
            $table->timestamp('date_time');
            $table->string('offer_source');
            $table->string('offer_name');
            $table->string('country');
            $table->string('source_id');
            $table->string('referrer');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}