<?php

namespace App\Tasks;

abstract class TaskFabric
{
    abstract public function getTask(): TaskInterface;
}