<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserQuestsTable extends Migration
{
    public function up()
    {
        Schema::create('user_quests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('line_id');
            $table->integer('task_id')->comment('Task Id or Job Id');
            $table->integer('target');
            $table->tinyInteger('status')->nullable();
            $table->timestamp('rewarded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_quests');
    }
}
