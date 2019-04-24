<?php

use Illuminate\Database\Seeder;
use App\TransferState;

class TransferStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TransferState::class, 4)->create();
    }
}
