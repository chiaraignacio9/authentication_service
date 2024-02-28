<?php

namespace App\presentation\controllers;

use App\domain\use_cases\RegisterUseCase;
use App\infrastructure\datasources\MysqlDatasourceImpl;
use App\infrastructure\repositories\UserRepositoryImpl;
use App\libs\Request;
use App\presentation\requests\UserRegisterRequest;
use App\presentation\requests\UserRegisterRequestOptions;
use Error;
use Exception;

class RegisterController extends Request {

    public function index() {
        
        $requestData = $this->getRequest()->asObject();        
        
        $registerRequest = new UserRegisterRequest( new UserRegisterRequestOptions(
            username:$requestData->username,
            password:$requestData->password,
            repassword:$requestData->confirmPassword
        ));

        if ( $registerRequest->hasErrors() ) {
            $this->response([
                'oldValues' => $requestData,
                'errors' => $registerRequest->errors
            ]);
        }
        
        try{            
            $registerUseCase = new RegisterUseCase(new UserRepositoryImpl(new MysqlDatasourceImpl()));
            $registerUseCase->register(
                username: $requestData->username,
                password: $requestData->password
            );
        }catch(Exception $e){
            $this->response([
                'message' => $e->getMessage()
            ]);
        }
            
    }

    private function response( ...$args ){
        
        http_response_code(400);
        echo json_encode( $args );
        exit;
    }

}