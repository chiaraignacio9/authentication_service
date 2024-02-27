<?php

namespace App\domain\entities;

class UserEntity {    

    public function __construct(
        public string $id,
        public string $username,
        public string $password
    )
    {}

}