<?php

use Illuminate\Database\Seeder;

class ErrorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('errors')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Неизвестная ошибка'
                ]
            ]
        );
    }
}
