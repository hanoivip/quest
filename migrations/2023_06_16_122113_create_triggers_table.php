<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriggersTable extends Migration
{
    public function up()
    {
        Schema::create('triggers', function (Blueprint $table) {
            $table->integer('id');
            $table->string('type');
            $table->string('condition');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('triggers');
    }
}
