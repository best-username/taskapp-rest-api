<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_task', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('label_id')->nullable()->unsigned();
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');
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
        Schema::table('label_task', function (Blueprint $table) {
            $table->dropForeign(['label_id']);
            $table->dropForeign(['task_id']);
            $table->dropColumn(['label_id', 'task_id']);
        });
        Schema::dropIfExists('label_task');
    }
}
