<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarEventsTable extends Migration
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
            $table->text('responsible');
            $table->date('date');
            $table->integer('change');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('change_id');
            $table->timestamps();
            $table->foreign('user_id', 'ix_calendar_events_user_id')->references('id')->on('users');
            $table->foreign('company_id', 'ix_calendar_events_company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('change_id', 'ix_calendar_events_change_id')->references('id')->on('changes_dictionary');
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
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropForeign(['ix_calendar_events_company_id']);
        });
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropForeign(['ix_calendar_events_change_id']);
        });
        Schema::dropIfExists('calendar_events');
    }
}
