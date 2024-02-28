<?php

namespace App\presentation\controllers;

use App\domain\use_cases\LogoutUseCase;

class LogoutController {

    public function index(){
        $logoutUseCase = new LogoutUseCase();

        $logoutUseCase->logout();
    }

}