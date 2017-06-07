<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
      DB::table('users')->insert([
            'name' => str_random(10),
            'email' => rand(201600001, 201603999).'@iacademy.edu.ph',
            'password' => bcrypt('password'),
            'isFaculty' => 0,
        ]);
    }
}
