<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('team_id')->unsigned()->index();
            $table->string('unsubscribed_status')->default('none');
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->string('phone')->index();
            $table->string('email')->nullable()->index();
            $table->integer('sticky_phone_number_id')->nullable();
            $table->string('twitter_id')->nullable()->index();
            $table->string('fb_messenger_id')->nullable()->index();
            $table->string('time_zone')->nullable();
            $table->timestamps();

            $table->index(['team_id', 'phone'], 'idx_phone_search');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
