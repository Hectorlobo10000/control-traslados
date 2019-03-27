<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('transfer_details', function(Blueprint $table){
            $table->foreign('transfer_id')->references('id')->on('transfers');
            $table->foreign('box_id')->references('id')->on('boxes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('transfer_details', function(Blueprint $table){
            $table->dropForeign([
                'transfer_id',
                'box_id',
            ]);
        });
    }
}
