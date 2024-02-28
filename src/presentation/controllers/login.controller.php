<?php

namespace App\presentation\controllers;

use App\domain\use_cases\LoginUseCase;
use App\infrastructure\datasources\MysqlDatasourceImpl;
use App\infrastructure\repositories\UserRepositoryImpl;
use App\libs\Request;
use App\presentation\requests\UserLoginRequest;
use App\presentation\requests\UserLoginRequestOptions;

class LoginController extends Request {

    public function index() {
        
        $requestData = $this->getRequest()->asObject();        
        
        $loginRequest = new UserLoginRequest( new UserLoginRequestOptions(
            username:$requestData->username,
            password:$requestData->password
        ));

        if ( $loginRequest->hasErrors() ) {
            $this->response([
                'oldValues' => $requestData,
                'errors' => $loginRequest->errors
            ]);
        }
        
        $loginService = new LoginUseCase(new UserRepositoryImpl(new MysqlDatasourceImpl()));
        
        if( !$token = $loginService->login(
                username:$requestData->username, 
                password:$requestData->password
            ) ){
            $this->response([                
                'oldValues' => $requestData,
                'message' => 'The credentials do not match any user '
            ]);
        }            

    }

    private function response( ...$args ){
        
        http_response_code(400);
        echo json_encode( $args );
        exit;
    }

}