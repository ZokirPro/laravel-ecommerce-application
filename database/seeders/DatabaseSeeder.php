<?php

namespace Database\Seeders;

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
        $this->call(AdminsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        //$this->call(CategoriesTableSeeder::class);
        $this->call(AttributesTableSeeder::class);
        $this->call(AttributeValuesTableSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
