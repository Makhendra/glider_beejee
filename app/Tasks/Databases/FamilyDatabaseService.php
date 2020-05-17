<?php

namespace App\Tasks\Databases;

use Faker\Factory;

class FamilyDatabaseService
{
    public $counter = 0;
    const WOMEN_GENDER = 'Ж';
    const MEN_GENDER = 'М';

    public function getFamily()
    {
        $family = [];
        $isFullFamily = rand(0, 1);
        if ($isFullFamily > 0.2) {
            $family['mother'] = $this->getPerson(self::WOMEN_GENDER, 0);
            $family['father'] = $this->getPerson(
                self::MEN_GENDER,
                $family['mother']['last_name_num'],
                $family['mother']['year'] - 5,
                $family['mother']['year'] + 5
            );
        } else {
            $isWoman = random_int(0, 1);
            if ($isWoman) {
                $family['mother'] = $this->getPerson(self::WOMEN_GENDER);
            } else {
                $family['father'] = $this->getPerson(self::MEN_GENDER);
            }
        }
        $cntChildren = random_int(0, 3);
        $parent = $family['mother'] ?? $family['father'];
        for ($i = 0; $i < $cntChildren; $i++) {
            $gender = random_int(0, 1) == 0 ? self::MEN_GENDER : self::WOMEN_GENDER;
            $family['childrens'][] = $this->getPerson(
                $gender,
                $parent['last_name_num'],
                $parent['year'] + 18,
                2020,
                isset($family['father']) ? $family['father']['name'] : null
            );
        }
        return $family;
    }

    public function getPerson($gender = null, $lastNameNum = null, $yearMin = 1950, $yearMax = 1999, $parent = null)
    {
        $gender = $gender ? $gender : self::MEN_GENDER;
        $year = random_int($yearMin, $yearMax);
        list($lastNum, $lastName) = $this->getLastName($gender, $lastNameNum);
        return [
            'is_parent' => empty($parent),
            'family_id' => $this->counter,
            'last_name_num' => $lastNum,
            'last_name' => $lastName,
            'name' => $this->getName($gender),
            'middlename' => $this->getMiddleName($gender, $parent),
            'year' => $year,
            'gender' => $gender
        ];
    }


    public function getFamilies()
    {
        $cntFamilies = random_int(3, 7);
        $result = [];
        for ($i = 0; $i < $cntFamilies; $i++) {
            $result[] = $this->getFamily();
            $this->counter += 1;
        }
        return $result;
    }

    public function getLastName($gender, $lastNameNum = null)
    {
        $lastNames = [
            [self::MEN_GENDER => 'Иванов', self::WOMEN_GENDER => 'Иванова'],
            [self::MEN_GENDER => 'Сидоренко', self::WOMEN_GENDER => 'Сидоренко'],
            [self::MEN_GENDER => 'Попов', self::WOMEN_GENDER => 'Попова'],
            [self::MEN_GENDER => 'Иванов', self::WOMEN_GENDER => 'Иванова'],
            [self::MEN_GENDER => 'Капица', self::WOMEN_GENDER => 'Капица'],
            [self::MEN_GENDER => 'Гаджиев', self::WOMEN_GENDER => 'Гаджиева'],
            [self::MEN_GENDER => 'Кан', self::WOMEN_GENDER => 'Кан'],
            [self::MEN_GENDER => 'Смирнов', self::WOMEN_GENDER => 'Смирнова'],
            [self::MEN_GENDER => 'Кузнецов', self::WOMEN_GENDER => 'Кузнецова'],
            [self::MEN_GENDER => 'Соколов', self::WOMEN_GENDER => 'Соколова'],
        ];
        $rand = empty($lastNameNum) ? random_int(0, count($lastNames) - 1) : $lastNameNum;
        return [$rand, $lastNames[$rand][$gender]];
    }

    public function getMiddleName($gender, $parent = null)
    {
        $MiddleNames = [
            [self::MEN_GENDER => 'Антонович', self::WOMEN_GENDER => 'Антоновна', 'name' => 'Антон'],
            [self::MEN_GENDER => 'Борисович', self::WOMEN_GENDER => 'Борисовна', 'name' => 'Борис'],
            [self::MEN_GENDER => 'Евгеньевич', self::WOMEN_GENDER => 'Евгеньевна', 'name' => 'Евгений'],
            [self::MEN_GENDER => 'Викторович', self::WOMEN_GENDER => 'Викторовна', 'name' => 'Виктор'],
            [self::MEN_GENDER => 'Григорьевич', self::WOMEN_GENDER => 'Григорьевна', 'name' => 'Григорий'],
            [self::MEN_GENDER => 'Максимович', self::WOMEN_GENDER => 'Максимовна', 'name' => 'Максим'],
            [self::MEN_GENDER => 'Янович', self::WOMEN_GENDER => 'Яновна', 'name' => 'Ян'],
            [self::MEN_GENDER => 'Романович', self::WOMEN_GENDER => 'Романовна', 'name' => 'Роман'],
            [self::MEN_GENDER => 'Владимирович', self::WOMEN_GENDER => 'Владимировна', 'name' => 'Владимир'],
            [self::MEN_GENDER => 'Олегович', self::WOMEN_GENDER => 'Олеговна', 'name' => 'Олег'],
            [self::MEN_GENDER => 'Михайлович', self::WOMEN_GENDER => 'Михайловна', 'name' => 'Михаил'],
            [self::MEN_GENDER => 'Алексеевич', self::WOMEN_GENDER => 'Алексеевна', 'name' => 'Алексей'],
            [self::MEN_GENDER => 'Генадьевич', self::WOMEN_GENDER => 'Генадьевна', 'name' => 'Геннадий'],
            [self::MEN_GENDER => 'Юрьевич', self::WOMEN_GENDER => 'Юрьевна', 'name' => 'Юрий'],
            [self::MEN_GENDER => 'Павлович', self::WOMEN_GENDER => 'Павловна', 'name' => 'Павел'],
            [self::MEN_GENDER => 'Кириллович', self::WOMEN_GENDER => 'Кирилловна', 'name' => 'Кирилл'],
        ];
        if ($parent) {
            $num =array_filter($MiddleNames, function ($item) use ($parent) {
                return $item['name'] == $parent;
            });
            if($num) {
                $first = array_shift($num);
                return $first[$gender];
            }
        }
        $num = random_int(0, count($MiddleNames) - 1);
        return $MiddleNames[$num][$gender];
    }

    public function getName($gender)
    {
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
        $namesMale = [
            'Антон',
            'Борис',
            'Евгений',
            'Павел',
            'Виктор',
            'Роман',
            'Алексей',
            'Григорий',
            'Ян',
            'Максим',
        ];
        $rand = random_int(0, count($namesMale) - 1);
        return $gender == self::WOMEN_GENDER ? $namesFemale[$rand] : $namesMale[$rand];
    }


}