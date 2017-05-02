<?php

use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
