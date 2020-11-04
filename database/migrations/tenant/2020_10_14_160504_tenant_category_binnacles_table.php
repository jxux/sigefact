<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCategoryBinnaclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Category_Binnacles', function (Blueprint $table) {
            $table->Increments('id');
            $table->char('code',5)->unique();
            $table->string('name', 150);
            $table->timestamps();
        });

        DB::table('Category_Binnacles')->insert([
            ['code' => '-', 'name' => 'Sin Categoría', 'created_at' => now()],
 
          ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Category_Binnacles');
    }
}
