<?php

namespace App\presentation\controllers;

class LogoutController {

    public function index(){
        setcookie('token', '', time()-3600, '/');
        unset($_COOKIE['token']);
    }

}