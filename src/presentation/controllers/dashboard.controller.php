<?php

namespace App\presentation\controllers;

use App\config\JwtManager;

class DashboardController {

    public function index(){

        if( !isset( $_COOKIE['token'] ) ){
            http_response_code(403);
            exit;
        }

        $token = $_COOKIE['token'];
        $jwtManager = new JwtManager();

        if( !$jwtManager->validateToken($token) ) {

            http_response_code(403);
            exit;

        }

        

    }

}