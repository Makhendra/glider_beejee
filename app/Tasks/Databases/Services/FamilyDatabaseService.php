<?php

namespace App\Tasks\Databases\Services;

use App\Models\Family;

class FamilyDatabaseService
{
    public $counter = 0;

    public function getFamily()
    {
        $family = [];
        $isFullFamily = rand(0, 1);
        if ($isFullFamily > 0.2) {
            $family['mother'] = $this->getPerson(Family::WOMEN_GENDER);
            $family['father'] = $this->getPerson(
                Family::MEN_GENDER,
                $family['mother']['year'] - 5,
                $family['mother']['year'] + 5,
                null,
                $family['mother']
            );
        } else {
            $isWoman = rand(0, 1);
            if ($isWoman) {
                $family['mother'] = $this->getPerson(Family::WOMEN_GENDER);
            } else {
                $family['father'] = $this->getPerson(Family::MEN_GENDER);
            }
        }
        $cntChildren = rand(0, 3);
        $parent = $family['mother'] ?? $family['father'];
        for ($i = 0; $i < $cntChildren; $i++) {
            $gender = rand(0, 1) == 0 ? Family::MEN_GENDER : Family::WOMEN_GENDER;
            $family['childrens'][] = $this->getPerson(
                $gender,
                $parent['year'] + 18,
                2020,
                $parent,
                $family['mother'] ?? null,
                $family['father'] ?? null
            );
        }
        return $family;
    }

    public function getPerson($gender = null, $yearMin = 1950, $yearMax = 1999, $parent = null, $mother = null, $father = null)
    {
        $gender = $gender ? $gender : Family::MEN_GENDER;
        $year = rand($yearMin, $yearMax);
        $middleName = $father ? $father['name'] : null;
        $lastNameId = $father ? $father['last_name_num'] : ($mother['last_name_num'] ?? null);
        list($lastNum, $lastName) = $this->getLastName($gender, $lastNameId);
        return [
            'is_parent' => empty($parent) ,
            'family_id' => $this->counter,
            'last_name_num' => $lastNum,
            'last_name' => $lastName,
            'name' => $this->getName($gender),
            'middlename' => $this->getMiddleName($gender, $middleName),
            'year' => $year,
            'gender' => $gender
        ];
    }


    public function getFamilies()
    {
        $cntFamilies = rand(3, 7);
        $result = [];
        for ($i = 0; $i < $cntFamilies; $i++) {
            $result[] = $this->getFamily();
            $this->counter += 1;
        }
        return $result;
    }

    public function getLastName($gender, $parentLastNameNum = null)
    {
        if (empty($parentLastNameNum)) {
            $lastName = Family::where('key', '=', 'last_name')->get()->random(1)->first();
        } else {
            $lastName = Family::find($parentLastNameNum);
        }
        $value = $gender == Family::MEN_GENDER ? $lastName->for_men : $lastName->for_women;
        return [$lastName->id, $value];
    }

    public function getMiddleName($gender, $parent = null)
    {
        if ($parent) {
            $middleName = Family::where('key', '=', 'name')
                ->whereGender(Family::MEN_GENDER)
                ->where('value', '=', $parent)
                ->get()->random(1)->first();
        } else {
            $middleName = Family::where('key', '=', 'name')->whereGender(Family::MEN_GENDER)
                ->get()
                ->random(1)
                ->first();
        }
        return $gender == Family::MEN_GENDER ? $middleName->for_men : $middleName->for_women;
    }

    public function getName($gender)
    {
        $name = Family::where('key', '=', 'name')->whereGender($gender)->get()->random(1)->first();
        return $name->value;
    }

    public function fullName($people)
    {
        return "{$people['last_name']} {$people['name']} {$people['middlename']}";
    }


}