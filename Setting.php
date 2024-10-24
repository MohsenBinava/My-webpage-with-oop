<?php

namespace App\Modles;

use App\Entities\SettingEntity;
use App\Modles\Modle;

class Setting extends Modle{
    protected $fileName = "setting";
    protected $entityClass = SettingEntity::class;
}