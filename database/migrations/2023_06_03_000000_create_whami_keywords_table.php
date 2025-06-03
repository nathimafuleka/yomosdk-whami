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
        Schema::create('whami_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable()->comment('User phone number');
            $table->string('keyword')->comment('The keyword used');
            $table->string('attribution_code')->nullable()->comment('Attribution code for tracking');
            $table->timestamps();
            
            // Index for faster lookups
            $table->index(['number', 'keyword']);
            $table->index(['keyword', 'attribution_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whami_keywords');
    }
}
