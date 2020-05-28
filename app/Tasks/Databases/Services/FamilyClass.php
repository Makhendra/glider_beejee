<?php


namespace App\Tasks\Databases\Services;


use App\Models\Family;

class FamilyClass
{
    private $familyId;
    private $cntChildren;

    private $mother;
    private $father;
    private $childrens = [];

    private $maxYear;
    private $minYear;
    private $parentsDiff = 5;
    private $childrenParentDiff = 18;

    private $lastNameId;

    /**
     * FamilyClass constructor.
     * @param $familyId
     * @param int $maxChildren
     * @param int $minChildren
     * @param int $parent
     */
    public function __construct($familyId, $parent = null, $maxChildren = 5, $minChildren = 0)
    {
        $this->familyId = $familyId;

        $this->minYear = 1900;
        $this->maxYear = date('Y');

        $this->cntChildren = rand($minChildren, $maxChildren);

        if($parent) {
            if($parent['gender'] == Family::MEN_GENDER) {
                $lastName = Family::where('for_men', '=', $parent['last_name'])->first();
                $this->father = $parent;
            } else {
                $lastName = Family::where('key', '=', 'last_name')->get()->random(1)->first();
                $parent['last_name'] = $lastName->for_women;
                $this->mother = $parent;
            }
        } else {
            $lastName = Family::where('key', '=', 'last_name')->get()->random(1)->first();
        }

        $this->lastNameId = $lastName->id;
    }

    public function setMother()
    {
        if(empty($this->mother)) {
            $gender = Family::WOMEN_GENDER;
            if (isset($this->father['year'])) {
                $year = rand($this->father['year'] - $this->parentsDiff, $this->father['year'] + $this->parentsDiff);
            } else {
                $year = rand($this->minYear, $this->maxYear - $this->childrenParentDiff);
            }

            $this->mother = [
                'is_child' => false,
                'is_parent' => true,
                'last_name' => $this->getLastName($gender),
                'name' => $this->getName($gender),
                'middle_name' => $this->getMiddleName($gender),
                'year' => $year,
                'gender' => $gender,
                'family_id' => $this->familyId
            ];
        }
    }

    public function setFather()
    {
        if(empty($this->father)) {
            $gender = Family::MEN_GENDER;
            if (isset($this->mother['year'])) {
                $year = rand($this->mother['year'] - $this->parentsDiff, $this->mother['year'] + $this->parentsDiff);
            } else {
                $year = rand($this->minYear, $this->maxYear - $this->childrenParentDiff);
            }

            $this->father = [
                'is_child' => false,
                'is_parent' => true,
                'last_name' => $this->getLastName($gender),
                'name' => $this->getName($gender),
                'middle_name' => $this->getMiddleName($gender),
                'year' => $year,
                'gender' => $gender,
                'family_id' => $this->familyId
            ];
        }
    }

    public function generateChildrens()
    {
        for ($i = 0; $i < $this->cntChildren; $i ++) {
            $this->generateChild();
        }
    }

    public function generateChild()
    {
        $parent = $this->mother['year'] ?? $this->father['year'];
        $gender = rand(0, 1) == 0 ? Family::MEN_GENDER : Family::WOMEN_GENDER;
        $year = rand($parent + $this->childrenParentDiff, $parent + 50);

        $this->childrens[] = [
            'is_child' => true,
            'is_parent' => false,
            'last_name' => $this->getLastName($gender),
            'name' => $this->getName($gender),
            'middle_name' => $this->getMiddleName($gender),
            'year' => $year,
            'gender' => $gender,
            'family_id' => $this->familyId
        ];
    }

    public function generateFamily()
    {
        $isFullFamily = rand(0, 1);

        if ($isFullFamily) {
            $this->setMother();
            $this->setFather();
        } else {
            $isWoman = rand(0, 1);
            if ($isWoman) {
                $this->setMother();
            } else {
                $this->setFather();
            }
        }

        $this->generateChildrens();
    }

    public function getFamily()
    {
        return [
            'mother' => $this->mother,
            'father' => $this->father,
            'childrens' => $this->childrens
        ];
    }

    public function getLastName($gender)
    {
        $lastName = Family::find($this->lastNameId);
        return $gender == Family::MEN_GENDER ? $lastName->for_men : $lastName->for_women;
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

}