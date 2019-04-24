<?php

use Illuminate\Database\Seeder;
use App\Inventory;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Inventory::class, 50)->create();
    }
}
