<?php

class Csrf {

    public static function jeton(): string {
        return bin2hex(random_bytes(32));
    }


    public static function verifier($valeur): bool {
        if (!is_string($valeur)){
            return false;
        }

        if (!hash_equals($_SESSION["jeton"] ?? "", $valeur)) {
            http_response_code(403);
            echo 'mauvais jeton';
            return false;
        }
        echo 'bon jeton';
        return true;
    }
}
?>
