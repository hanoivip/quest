<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Main tasks 
 * @author GameOH
 *
 */
class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('line');
            $table->text('triggers')->nullable();
            $table->text('rewards')->nullable();
            $table->integer('target');
            $table->string('detail');
			$table->string('guide')->nullable();
            $table->string('progress_type');
            $table->text('progress_ids')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
