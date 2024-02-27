<?php

namespace App\domain\datasources;

use App\domain\entities\UserEntity;

abstract class UserDatasource {

    abstract function save(UserEntity $user): bool;
    abstract function findByUsername(string $username): UserEntity|bool;

}