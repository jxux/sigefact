<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantServiceBinnaclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Service_Binnacles', function (Blueprint $table) {
            $table->Increments('id');
            $table->char('code',5)->unique();
            $table->string('name', 150);

            $table->unsignedInteger('category_id')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('Category_Binnacles');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Service_Binnacles');
    }
}
