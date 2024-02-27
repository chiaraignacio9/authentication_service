<?php


namespace App\libs;

use Error;

class Request {

    private $request;

    function getRequest(){
        $this->request = file_get_contents('php://input');        
        return $this;
    }    

    function asJson(){        

    }

    function asObject(): ?object{

        if( is_string($this->request) ){
            return (json_decode($this->request));
        }

        throw new Error('The request data must be an string ');
        
    }

    function asArray(): ?array{
        
        if( is_string($this->request) ){
            return (json_decode($this->request, true));
        }

        throw new Error('The request data must be an string ');
        
    }
}
