<?php

namespace App\config;

require_once dirname(__DIR__) . '\config\envs.plugin.php';

use Exception;

class JwtManager {

    public function createToken(array $payload):string|bool{

        $secretKey = $_ENV['SECRET_KEY'];        
        
        try{

            $headerBase64 = $this->base64Encode([
                'alg' => 'HS256',
                'typ' => 'JWT'
            ]);
    
            $payloadBase64 = $this->base64Encode([
                $payload
            ]);            
    
            $signature = hash_hmac(
                'sha256',
                $headerBase64 . '.' . $payloadBase64,
                $secretKey,
                true
            );

            $signatureBase64 = $this->base64Encode($signature);
            
            return ($headerBase64 .'.' . $payloadBase64 . '.'. $signatureBase64);

        }catch(Exception $e){
            echo $e;
            return false;
        }

    }

    public function validateToken(string $token):bool{

        $secretKey = $_ENV['SECRET_KEY'];
        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = explode('.', $token);

        $signature = $this->base64Decode($base64UrlSignature);
        $expectedSignature = hash_hmac(
            'sha256', 
            $base64UrlHeader . '.' . $base64UrlPayload,
            $secretKey, true);
    
        return hash_equals($signature, $expectedSignature);
        
    }

    public function decodeToken(string $token){

        list(, $base64UrlPayload , ) = explode('.', $token);
        $payload = $this->base64Decode($base64UrlPayload);
        return json_decode($payload, true);
    }

    private function base64Encode($data){

        if(!is_string($data)){
            $data = json_encode($data);
        }
        $base64 = base64_encode($data);
        $base64 = strtr($base64, '+/', '-_');
        return rtrim($base64, '=');
    }

    private function base64Decode($data) {

        $base64 = strtr($data, '-_', '+/');
        $base64Padded = str_pad($base64, strlen($base64) % 4, '=', STR_PAD_RIGHT);

        return base64_decode($base64Padded);
    }

}