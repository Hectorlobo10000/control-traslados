<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('transfers', function(Blueprint $table){
            $table->foreign('transfer_state_id')->references('id')->on('transfer_states');
            $table->foreign('branch_office_send_id')->references('id')->on('branch_offices');
            $table->foreign('branch_office_receive_id')->references('id')->on('branch_offices');
            $table->foreign('user_send_id')->references('id')->on('users');
            $table->foreign('user_receive_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('transfers', function(Blueprint $table){
            $table->dropForeign([
                'transfer_state_id', 
                'branch_office_send_id',
                'branch_office_receive_id',
                'user_send_id',
                'user_receive_id',
            ]);
        });
    }
}
