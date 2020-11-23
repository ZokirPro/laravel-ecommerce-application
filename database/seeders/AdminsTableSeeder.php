<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//changed part
use App\Models\Admin;
use Faker\Factory as Faker;
//end
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker::create();
        
        Admin::create([
            'name'=>$faker->name,
            'email'=>'admin@admin.com',
            'password'=>bcrypt('password'),
        ]); 
    }
}
