<?php

use Illuminate\Database\Seeder;
use App\Models\Family;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Family::truncate();
        $lastNames = [
            [Family::MEN_GENDER => 'Иванов', Family::WOMEN_GENDER => 'Иванова'],
            [Family::MEN_GENDER => 'Сидоренко', Family::WOMEN_GENDER => 'Сидоренко'],
            [Family::MEN_GENDER => 'Попов', Family::WOMEN_GENDER => 'Попова'],
            [Family::MEN_GENDER => 'Иванов', Family::WOMEN_GENDER => 'Иванова'],
            [Family::MEN_GENDER => 'Капица', Family::WOMEN_GENDER => 'Капица'],
            [Family::MEN_GENDER => 'Гаджиев', Family::WOMEN_GENDER => 'Гаджиева'],
            [Family::MEN_GENDER => 'Кан', Family::WOMEN_GENDER => 'Кан'],
            [Family::MEN_GENDER => 'Смирнов', Family::WOMEN_GENDER => 'Смирнова'],
            [Family::MEN_GENDER => 'Кузнецов', Family::WOMEN_GENDER => 'Кузнецова'],
            [Family::MEN_GENDER => 'Соколов', Family::WOMEN_GENDER => 'Соколова'],
        ];
        $key = 'last_name';
        $value = 'last_name';
        foreach ($lastNames as $lastName) {
            $gender = 3;
            $for_women = $lastName[Family::WOMEN_GENDER];
            $for_men = $lastName[Family::MEN_GENDER];
            Family::create(compact('key', 'value', 'gender', 'for_men', 'for_women'));
        }

        $MiddleNames = [
            [Family::MEN_GENDER => 'Антонович', Family::WOMEN_GENDER => 'Антоновна', 'name' => 'Антон'],
            [Family::MEN_GENDER => 'Борисович', Family::WOMEN_GENDER => 'Борисовна', 'name' => 'Борис'],
            [Family::MEN_GENDER => 'Евгеньевич', Family::WOMEN_GENDER => 'Евгеньевна', 'name' => 'Евгений'],
            [Family::MEN_GENDER => 'Викторович', Family::WOMEN_GENDER => 'Викторовна', 'name' => 'Виктор'],
            [Family::MEN_GENDER => 'Григорьевич', Family::WOMEN_GENDER => 'Григорьевна', 'name' => 'Григорий'],
            [Family::MEN_GENDER => 'Максимович', Family::WOMEN_GENDER => 'Максимовна', 'name' => 'Максим'],
            [Family::MEN_GENDER => 'Янович', Family::WOMEN_GENDER => 'Яновна', 'name' => 'Ян'],
            [Family::MEN_GENDER => 'Романович', Family::WOMEN_GENDER => 'Романовна', 'name' => 'Роман'],
            [Family::MEN_GENDER => 'Владимирович', Family::WOMEN_GENDER => 'Владимировна', 'name' => 'Владимир'],
            [Family::MEN_GENDER => 'Олегович', Family::WOMEN_GENDER => 'Олеговна', 'name' => 'Олег'],
            [Family::MEN_GENDER => 'Михайлович', Family::WOMEN_GENDER => 'Михайловна', 'name' => 'Михаил'],
            [Family::MEN_GENDER => 'Алексеевич', Family::WOMEN_GENDER => 'Алексеевна', 'name' => 'Алексей'],
            [Family::MEN_GENDER => 'Генадьевич', Family::WOMEN_GENDER => 'Генадьевна', 'name' => 'Геннадий'],
            [Family::MEN_GENDER => 'Юрьевич', Family::WOMEN_GENDER => 'Юрьевна', 'name' => 'Юрий'],
            [Family::MEN_GENDER => 'Павлович', Family::WOMEN_GENDER => 'Павловна', 'name' => 'Павел'],
            [Family::MEN_GENDER => 'Кириллович', Family::WOMEN_GENDER => 'Кирилловна', 'name' => 'Кирилл'],
        ];
        $key = 'name';
        $gender = Family::MEN_GENDER;
        foreach ($MiddleNames as $name) {
            $value = $name['name'];
            $for_women = $name[Family::WOMEN_GENDER];
            $for_men = $name[Family::MEN_GENDER];
            Family::create(compact('key', 'value', 'gender', 'for_men', 'for_women'));
        }

        $namesFemale = [
            'Анна',
            'Виктория',
            'Дарья',
            'Елизавета',
            'Евгения',
            'Камилла',
            'Мария',
            'Нина',
            'София',
            'Ольга',
        ];
        $key = 'name';
        $gender = Family::WOMEN_GENDER;
        foreach ($namesFemale as $value) {
            Family::create(compact('key', 'value', 'gender'));
        }
    }
}
