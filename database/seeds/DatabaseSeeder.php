<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            DepartmentsTableSeeder::class,
            CitiesTableSeeder::class,
            AddressesTableSeeder::class,
            BranchOfficesTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            MovementsTableSeeder::class,
            BoxStatesTableSeeder::class,
            ProductsTableSeeder::class,
            BoxesTableSeeder::class,
            InventoriesTableSeeder::class,
            TransferStatesTableSeeder::class,
        ]);
    }
}
