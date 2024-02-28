<?php

namespace App\domain\use_cases;

use App\domain\entities\UserEntity;
use App\infrastructure\repositories\UserRepositoryImpl;
use Exception;

class RegisterUseCase {
    
    public function __construct(
        private UserRepositoryImpl $userRepository
    )
    {}


    public function register(string $username, string $password): ?bool {        
        
        if( $user = $this->userRepository->findByUsername( $username ) ){            
            throw new Exception('The username is already registered');
        }

        if( $this->userRepository->save(new UserEntity(
            id: null,
            username: $username,
            password: password_hash($password, PASSWORD_BCRYPT)
        )) ){
            return true;
        }

        throw new Exception('Error while user is registering');
                
    }
}