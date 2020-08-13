<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->integer('cost');
            $table->text('type');
            $table->text('company');
            $table->text('responsible');
            $table->date('date');
            $table->integer('change')->unique();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id', 'ix_calendar_events_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropForeign(['ix_calendar_events_user_id']);
        });
        Schema::dropIfExists('calendar_events');
    }
}
