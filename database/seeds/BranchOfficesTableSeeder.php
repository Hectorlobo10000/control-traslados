<?php

use Illuminate\Database\Seeder;

class BranchOfficesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\BranchOffice::class, 18)->create();
    }
}
