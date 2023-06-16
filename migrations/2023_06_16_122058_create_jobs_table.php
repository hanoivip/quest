<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{

    public function up()
    {
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->integer('id');
            //$table->integer('line');
            $table->string('triggers')->nullable();
            $table->string('rewards')->nullable();
            $table->string('detail');
            $table->string('progress_type');
            $table->string('progress_ids')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('daily_tasks');
    }
}
