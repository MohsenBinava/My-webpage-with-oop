<?php

namespace App\Modles;

use App\Entities\UserEntity;
use App\Modles\Modle;

class User extends Modle{
    protected $fileName = "users";
    protected $entityClass = UserEntity::class;

    public function authenticatUser($email,$password)
    {
        $data = $this->database->getData();
        $user = array_filter($data,function($item) use ($email,$password) {
            if($item->getEmail() ==$email and $item->getPassword() == $password)
                return true;
            return false;
        });

        $user = array_values($user);
        if(count($user))
            return $user[0];
        return false;
    }
}