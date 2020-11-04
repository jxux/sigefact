<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantBinnaclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('binnacles', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('user_id');
            $table->json('user');
            $table->uuid('external_id');
            $table->date('date');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->time('hour')->nullable();
            $table->unsignedInteger('client_id');
            $table->json('client');
            $table->unsignedInteger('category_id');
            $table->json('category');
            $table->date('period');
            $table->unsignedInteger('service_id');
            $table->json('service');
            $table->string('description', 2000)->nullable();
            $table->integer('status')->nullable();

            $table->unsignedInteger('reviewer_id')->nullable();
            $table->json('reviewer')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('persons');
            $table->foreign('category_id')->references('id')->on('Category_Binnacles');
            $table->foreign('service_id')->references('id')->on('Service_Binnacles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('binnacles');
    }
}
