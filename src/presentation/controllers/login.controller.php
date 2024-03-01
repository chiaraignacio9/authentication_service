<?php

namespace App\presentation\controllers;

use App\domain\use_cases\LoginUseCase;
use App\infrastructure\datasources\MysqlDatasourceImpl;
use App\infrastructure\repositories\UserRepositoryImpl;
use App\libs\Request;
use App\presentation\requests\UserLoginRequest;
use App\presentation\requests\UserLoginRequestOptions;
use Exception;

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

        $loginUseCase = new LoginUseCase(new UserRepositoryImpl(new MysqlDatasourceImpl()));
        
        
        try{

            $token = $loginUseCase->login(
                    username:$requestData->username, 
                    password:$requestData->password
            );                        

            if(!$token){
                $this->response([
                    'oldValues' => $requestData,
                    'message' => 'The credentials do not match any user '
                ]);
            }            

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