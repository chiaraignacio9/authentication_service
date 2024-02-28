<?php

namespace App\domain\use_cases;

class LogoutUseCase {

    public function logout() {

        if( !isset( $_COOKIE['token'] ) ){
            http_response_code(403);
            exit;
        }

        setcookie('token', '', time()-3600, '/');
        unset($_COOKIE['token']);
    }

}