<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('boxes', function(Blueprint $table){
            $table->foreign('box_state_id')->references('id')->on('box_states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('boxes', function(Blueprint $table){
            $table->dropForeign([
                'box_state_id',
            ]);
        });
    }
}
