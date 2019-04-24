<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyBoxDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('box_details', function(Blueprint $table){
            $table->foreign('box_id')->references('id')->on('boxes');
            $table->foreign('inventory_id')->references('id')->on('inventories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('box_details', function(Blueprint $table){
            $table->dropForeign([
                'box_id',
                'product_id',
            ]);
        });
    }
}
