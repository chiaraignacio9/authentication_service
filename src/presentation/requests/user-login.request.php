<?php

namespace App\presentation\requests;

use App\libs\Validation;

class UserLoginRequestOptions {

    function __construct(
        public string $username,
        public string $password
    )
    {}

}

class UserLoginRequest extends Validation{
    
    protected $fields = [
        'username' => 'required',
        'password' => 'required'
    ];

    public function __construct(
        public UserLoginRequestOptions $values
    )
    {
        $this->validate($values);
    }    

}