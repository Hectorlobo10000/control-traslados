<?php

use Illuminate\Database\Seeder;

class MovementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Movement::class, 2)->create();
    }
}
