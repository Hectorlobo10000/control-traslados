<?php

use Illuminate\Database\Seeder;
use App\Box;

class BoxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Box::class, 3)->create();
    }
}
