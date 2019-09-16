<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'test@test.ru';
        $pwd = md5($email);
        User::create(['email' => $email, 'password' => $pwd, 'name' => $email]);
    }
}
