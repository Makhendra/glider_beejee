<?php

namespace App\Tasks\Databases\Services;

class FamilyDatabaseService
{

    public function getFamilies($max = 7, $maxChildren = 3, $nested = false)
    {
        $families = [];
        $counter = 1;
        $cntFamilies = rand(3, $max);
        $nestedCnt = $nested ? rand(1, $maxChildren) : 0;
        while ($counter < $cntFamilies) {
            $class = new FamilyClass($counter, null, $maxChildren);
            $class->generateFamily();
            $family = $class->getFamily();
            $families[] = $family;
            $counter += 1;
            $cntChildren = count($family['childrens']);
            if ($nestedCnt && $cntChildren) {
                $parentId = rand(0, ($cntChildren - 1 >= 0) ? $cntChildren - 1 : 0);
                $parent = $family['childrens'][$parentId];
                if (date('Y') - $parent['year'] >= 18) {
                    $family['childrens'][$parentId]['is_parent'] = true;
                    $parent = $family['childrens'][$parentId];
                    $class = new FamilyClass($counter, $parent, $maxChildren, 1);
                    $class->generateFamily();
                    $families[] = $class->getFamily();
                    $counter += 1;
                    $nestedCnt -= 1;
                }
            }
        }
        return $families;
    }

    public function fullName($people)
    {
        if ($people) {
            return "{$people['last_name']} {$people['name']} {$people['middle_name']}";
        }
    }


}