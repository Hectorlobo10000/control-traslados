<?php

use Illuminate\Database\Seeder;
use App\BoxState;

class BoxStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BoxState::class, 2)->create();
    }
}
