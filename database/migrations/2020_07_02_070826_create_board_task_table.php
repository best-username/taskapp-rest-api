<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_task', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id')->nullable()->unsigned();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->integer('task_id')->nullable()->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('board_task', function (Blueprint $table) {
            $table->dropForeign(['board_id']);
            $table->dropForeign(['task_id']);
            $table->dropColumn(['board_id', 'task_id']);
        });
        Schema::dropIfExists('board_task');
    }
}
