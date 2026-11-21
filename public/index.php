<?php
session_set_cookie_params([
    "lifetime" => 0,
    "path" => "/",
    "secure" => true,
    "httponly" => true,
    "samesite" => "Lax",
]);
session_start();

//les classes nécessaires
require_once __DIR__ . '/../src/Commun/Csrf.php';
require_once __DIR__ . '/../src/Utilisateur/RouteurUtilisateur.php';
require_once __DIR__ . '/../src/Utilisateur/Controller/UtilisateurController.php';
require_once __DIR__ . '/../src/Utilisateur/Model/UtilisateurRepository.php';


//lien test
//http://localhost/SAE-3.2-DevWeb-Forum_mais_pas_forum/


if (!isset($_SESSION["jeton"])){
    echo "c bon ";
    $_SESSION["jeton"] = Csrf::jeton();//attribue un jeton
    echo $_SESSION["jeton"];// afficher le jeton , pas obliger c juste pour test
}
else {
    echo $_SESSION["jeton"];// a un jeton
//	unset($_SESSION["jeton"]);//  pour vider une session du token
    echo "a un jeton";
}

$module = $_GET['module'] ?? 'utilisateur';

if ($module ==='utilisateur'){
$controleur = new UtilisateurController(new UtilisateurRepository ,new UtilisateurView );
$routeur = new UtilisateurRouteur($controleur);
$routeur->router();
}