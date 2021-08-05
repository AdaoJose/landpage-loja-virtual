<?php
namespace App\Controller;

/**
 * retorna o json recebido que vem no corpo da requisição
 * @param bool $returnAsArray = true retorna array, false retorna objeto
 * @return json
 */
class RequestController{
    public static function getRequest(bool $returAsArray = true){
        return json_decode(file_get_contents("php://input"), $returAsArray);
    }
    public static function paramRequestExists(array $param): bool
    {
        foreach ($param as $value) {
            if(!array_key_exists($value, self::getRequest())){
                return false;
            }
        }
        return true;
    }

}