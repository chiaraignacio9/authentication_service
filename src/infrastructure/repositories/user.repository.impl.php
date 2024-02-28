<?php

namespace App\infrastructure\repositories;

use App\domain\datasources\UserDatasource;
use App\domain\entities\UserEntity;
use App\domain\repositories\UserRepository;
use Exception;

class UserRepositoryImpl extends UserRepository {

    public function __construct(
        private readonly UserDatasource $datasource
    )
    {}

    function save(UserEntity $user): bool {
        
        try{            
            $this->datasource->save( $user );
            return true;
        }catch(Exception $e) {
            return false;
        }

    }

    
    function findByUsername(string $username): UserEntity|bool {

        try{
            
            if( $user = $this->datasource->findByUsername( $username ) ){
                return $user;
            }
            
            return false;
        }catch(Exception $e) {

            return false;

        }

    }

}