<?php

namespace App\Tasks\Databases\Services;

class FamilyDatabaseService
{

    public function getFamilies($min = 3, $max = 7, $maxChildren = 3)
    {
        $families = [];
        $counter = 1;
        $cntFamilies = rand($min, $max);
        while ($counter < $cntFamilies) {
            $class = new FamilyClass($counter, $maxChildren);
            $class->generateFamily();
            $family = $class->getFamily();
            $families[] = $family;
            $counter += 1;
        }
        return $families;
    }

    public function fullName($people)
    {
        if ($people) {
            return "{$people['last_name']} {$people['name']} {$people['middle_name']}";
        }
    }

    public function getFamiliesWithGrandchildren($min = 3, $max = 7, $level = 4)
    {
        $families = [];
        $cntFamilies = rand($min, $max);
        while ($cntFamilies > 0) {
            if ($level > 1) {
                // Level 1 - parent
                $class = new FamilyClass($cntFamilies);
                $class->minYear = 1900;
                $class->maxYear = 1920;
                $class->generateFamily();
                $family = $class->getFamily();
                $cntFamilies -= 1;

                // Level 2 - child
                if ($level > 2) {
                    $cntChildren = count($family['childrens']);
                    if ($cntChildren) {
                        $parentId = rand(0, ($cntChildren - 1 >= 0) ? $cntChildren - 1 : 0);
                        $parent = $family['childrens'][$parentId];
                        if (date('Y') - $parent['year'] >= 18) {
                            $family['childrens'][$parentId]['is_parent'] = true;
                            $parent = $family['childrens'][$parentId];
                            $class = new FamilyClass($cntFamilies, $parent);
                            $class->generateFamily();
                            $family2 = $class->getFamily();
                            $cntFamilies -= 1;
                            // Level 3 - grandchild
                            if ($level > 3) {
                                $cntChildren = count($family2['childrens']);
                                if ($cntChildren) {
                                    $parentId = rand(0, ($cntChildren - 1 >= 0) ? $cntChildren - 1 : 0);
                                    $parent = $family2['childrens'][$parentId];
                                    if (date('Y') - $parent['year'] >= 18) {
                                        $family2['childrens'][$parentId]['is_parent'] = true;
                                        $parent = $family2['childrens'][$parentId];
                                        $class = new FamilyClass($cntFamilies, $parent);
                                        $class->generateFamily();
                                        $family3 = $class->getFamily();
                                        $cntFamilies -= 1;
                                        // Level 4 - great grandchild
                                        if ($level >= 4) {
                                            $cntChildren = count($family3['childrens']);
                                            if ($cntChildren) {
                                                $parentId = rand(0, ($cntChildren - 1 >= 0) ? $cntChildren - 1 : 0);
                                                $parent = $family3['childrens'][$parentId];
                                                if (date('Y') - $parent['year'] >= 18) {
                                                    $family3['childrens'][$parentId]['is_parent'] = true;
                                                    $parent = $family3['childrens'][$parentId];
                                                    $class = new FamilyClass($cntFamilies, $parent);
                                                    $class->generateFamily();
                                                    $family4 = $class->getFamily();
                                                    $cntFamilies -= 1;
                                                    $family3['family'] = $family4;
                                                }
                                            }
                                        }
                                        $family2['family'] = $family3;
                                    }
                                }
                            }
                            $family['family'] = $family2;
                        }
                    }
                }
                $families[] = $family;
            }
        }
        return $families;
    }

}