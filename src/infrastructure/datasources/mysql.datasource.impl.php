<?php 

namespace App\infrastructure\datasources;

use App\database\Mysql;
use App\domain\datasources\UserDatasource;
use App\domain\entities\UserEntity;
use Exception;

class MysqlDatasourceImpl extends UserDatasource {
    
    function save(UserEntity $user): bool {
        
        try{
            $database = new Mysql();
            $connection = $database->connect();

            $statement = $connection->prepare('INSERT INTO users (
                username, password
            ) VALUES (
                :username, :password
            )');
            
            $statement->bindParam(':username', $user->username);
            $statement->bindParam(':password', $user->password);
            $statement->execute();

            return true;
        }catch(Exception $e) {
            return false;
        }

    }

    
    function findByUsername(string $username): UserEntity|bool {        

        try{
            $database = new Mysql();
            $connection = $database->connect();

            $statement = $connection->prepare('SELECT * FROM users WHERE username = :username');
            $statement->bindParam(':username', $username);
            $statement->execute();

            $user = $statement->fetch();            

            if($user){

                $userEntity = new UserEntity($user['id'], $user['username'], $user['password']);

                return $userEntity;
            }

            return false;
        }catch(Exception $e) {
            echo $e;
            return false;
        }

    }

}