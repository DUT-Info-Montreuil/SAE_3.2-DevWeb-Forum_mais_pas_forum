<?php
//lien testage : http://localhost/SAE_3.2-DevWeb-Forum_mais_pas_forum/public/index.php?module=jeux
session_set_cookie_params([
    "lifetime" => 0,
    "path" => "/",
    "secure" => true,
    "httponly" => true,
    "samesite" => "Lax",
]);
session_start();
//require_once __DIR__ . '/../data/bd.sql';
//Globale
require_once __DIR__ . '/../src/Commun/Xss.php';
require_once __DIR__ . '/../src/Commun/Csrf.php';
require_once __DIR__ . '/../src/Jeux/Model/BDD.php';
//Module Jeux
require_once __DIR__ . '/../src/Jeux/Controller/JeuxController.php';
require_once __DIR__ . '/../src/Jeux/Model/Jeux.php';
require_once __DIR__ . '/../src/Jeux/Model/JeuxRepository.php';
require_once __DIR__ . '/../src/Jeux/View/JeuxView.php';
require_once __DIR__ . '/../src/Jeux/JeuxRouter.php';

if(!isset($_SESSION["jeton"])){
    $_SESSION["jeton"] = Csrf::jeton();
}else{

}



$module = $_GET['module'] ?? 'jeux';

if($module == "jeux"){

    $jeuxview = new JeuxView();
    $jeuxrepository = new JeuxRepository();
    $controlleurjeux = new JeuxController($jeuxrepository , $jeuxview);
    $router = new JeuxRouteur($controlleurjeux);
    $router->router();
}else{
    echo "Router invalide";
}

