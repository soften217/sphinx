// app/database/seeds/UserTableSeeder.php
<?php

class UserTableSeeder extends Seeder
{
  public function run()
  {
    DB::table('users')->delete();
    
    User::create(array(
    	'name'     => 'JOEM',
        'username' => 'jmccasusi',
        'email'    => 'jmccasusi@gmail.com',
        'password' => Hash::make('password'),
    ));
  }
}