<?php


namespace App\Http\Controllers\Tasks;


interface InterfaceTask
{
    public function generate();
    public function solution();
    public function answer();
    public function replaceText($text);
    public static function getData();
}
