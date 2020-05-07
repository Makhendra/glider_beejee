<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        $pwd = Hash::make($email);
        User::create(['email' => $email, 'password' => $pwd, 'name' => $email]);
    }
}
