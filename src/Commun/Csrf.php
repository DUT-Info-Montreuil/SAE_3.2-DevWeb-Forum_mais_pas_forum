<?php

class Csrf {

    public static function jeton(): string {
        if(!isset($_SESSION["jeton"])){
            $_SESSION["jeton"] = bin2hex(random_bytes(32));
        }
        return $_SESSION["jeton"];
    }


    public static function verifier($valeur): bool {
        if(!isset($_SESSION["jeton"])){
            return false;
        }
        if(!is_string($valeur)){
            return false;
        }
        if(!hash_equals($_SESSION["jeton"] ?? "" , $valeur)){

            return false;

        }
        return true;}

}
?>
