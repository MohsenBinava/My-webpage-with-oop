<?php

namespace App\Modles;

use App\Entities\PostEntity;
use App\Modles\Modle;

class Post extends Modle{
    protected $fileName = "posts";
    protected $entityClass = PostEntity::class;
}