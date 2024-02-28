<?php

namespace App\domain\use_cases;

use App\config\JwtManager;
use App\infrastructure\repositories\UserRepositoryImpl;
use Exception;

class LoginUseCase {

    public function __construct(
        private UserRepositoryImpl $userRepository
    )
    {}


    public function login(string $username, string $password): bool {        
        
        if( !$user = $this->userRepository->findByUsername( $username ) ){
            return false;
        }                    

        if ( !password_verify($password, $user->password) ){
            return false;
        }

        try{        
            $jwtManager = new JwtManager();

            $token = $jwtManager->createToken([
                "id" => $user->id,
                "username" => $username
            ]);                    

            setcookie(
                name:'token', 
                value:$token,
                path: '/',
                expires_or_options:time()+3600,
                httponly:true
            );
            return true;
        }catch( Exception $e ){
            return false;
        }
    }

}