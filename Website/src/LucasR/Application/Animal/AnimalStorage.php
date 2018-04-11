<?php

namespace LucasR\Application\Animal;

use LucasR\Application\Animal\Animal;

interface AnimalStorage{
    public function getFiveMRA();
    public function getAll();
    public function willAppear(Animal $animal);
    public function getOne($id);
}

?> 