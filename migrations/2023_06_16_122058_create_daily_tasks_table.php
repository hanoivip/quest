<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTasksTable extends Migration
{

    public function up()
    {
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->integer('line');
            $table->longText('triggers')->nullable();
            $table->longText('rewards')->nullable();
            $table->string('detail');
            $table->string('progress_type');
            $table->longText('progress_ids')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('daily_tasks');
    }
}
