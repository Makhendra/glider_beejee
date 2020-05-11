<?php

use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            'Системы исчисления',
            'Протяженность дороги',
            'Таблицы истинности и логические схемы',
            'Представление и считывание данных',
        ];
        foreach ($groups as $name){
            \App\Models\GroupTask::create(compact('name'));
        }
    }
}
