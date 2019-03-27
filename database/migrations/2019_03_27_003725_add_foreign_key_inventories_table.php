<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('inventories', function(Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('movement_id')->references('id')->on('movements');
            $table->foreign('branch_office_id')->references('id')->on('branch_offices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function(Blueprint $table){
            $table->dropForeign([
                'product_id',
                'movement_id',
                'branch_office_id',
            ]);
        });
    }
}
