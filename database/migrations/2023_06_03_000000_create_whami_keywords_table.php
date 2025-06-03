<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhamiKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyword_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->string('attribute_code');
            $table->timestamps();

            $table->index('keyword');
            $table->index('attribute_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('keyword_attributes');
    }
}
