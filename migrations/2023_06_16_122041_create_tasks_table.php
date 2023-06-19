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
            $table->integer('id');
            $table->integer('line');
            $table->string('triggers')->nullable();
            $table->string('rewards')->nullable();
            $table->string('detail');
			$table->string('guide')->nullable();
            $table->string('progress_type');
            $table->string('progress_ids')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
