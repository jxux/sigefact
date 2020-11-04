<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApirucToConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->text('url_apiruc')->nullable();
            $table->text('token_apiruc')->nullable();
        });

        DB::table('configurations')->update([
            'id' => '1',
            'url_apiruc' => 'https://apiperu.dev',
            'token_apiruc' => '70f85ec059f51333b17d839511922d36da2f7f081905499aa94cdcc01fec86ec'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn(['url_apiruc', 'token_apiruc']);
        });
    }
}
