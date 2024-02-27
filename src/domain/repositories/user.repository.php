<?php

namespace App\domain\repositories;

use App\domain\entities\UserEntity;

abstract class UserRepository {

    abstract function save(UserEntity $user): bool;
    abstract function findByUsername(string $username): UserEntity|bool;

}