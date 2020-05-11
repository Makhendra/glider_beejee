<?php

use Illuminate\Database\Seeder;
use \Encore\Admin\Auth\Database\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::truncate();
        $menu = [
            ['parent_id' => 0, 'title' => 'Группы', 'icon' => 'fa-object-ungroup', 'uri' => 'groups'],
            ['parent_id' => 0, 'title' => 'Задания', 'icon' => 'fa-list-alt', 'uri' => 'tasks'],
            ['parent_id' => 0, 'title' => 'Пользователи', 'icon' => 'fa-users', 'uri' => 'users']
        ];
        foreach ($menu as $m) {
            Menu::create($m);
        }
    }
}
