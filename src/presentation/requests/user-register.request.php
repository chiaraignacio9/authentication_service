<?php

namespace App\presentation\requests;

use App\libs\Validation;

class UserRegisterRequestOptions {

    function __construct(
        public string $username,
        public string $password,
        public string $repassword,
    )
    {}

}

class UserRegisterRequest extends Validation {

    protected $fields = [
        'username' => 'required',
        'password' => 'required|min:8',
        'repassword' => 'required|repassword'
    ];

    public function __construct(
        public UserRegisterRequestOptions $values
    )
    {
        $this->validate($values);
    }    

}