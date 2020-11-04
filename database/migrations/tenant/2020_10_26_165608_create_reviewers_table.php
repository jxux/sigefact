<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewersTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('reviewers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->json('user');
            $table->uuid('external_id');
            $table->date('date');
            $table->string('description', 2000)->nullable();
            $table->integer('status')->nullable();
            $table->unsignedInteger('binnacle_id');
            $table->json('binnacle');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('binnacle_id')->references('id')->on('binnacles');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviewers');
    }
}
