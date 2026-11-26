<?php

require_once __DIR__ . '/../data/bd.sql';
require_once __DIR__ . '/../src/Jeux/Controller/JeuxController.php';
require_once __DIR__ . '/../src/Jeux/Model/BDD.php';
require_once __DIR__ . '/../src/Jeux/Model/Jeux.php';
require_once __DIR__ . '/../src/Jeux/Model/JeuxRepository.php';
require_once __DIR__ . '/../src/Jeux/View/JeuxView.php';
require_once __DIR__ . '/../src/Jeux/JeuxRouter.php';

$jeuxview = new JeuxView();
$jeuxrepository = new JeuxRepository();
$controlleurjeux = new JeuxController($jeuxrepository , $jeuxview);

$module = $_GET['module'] ?? 'jeux';

if($module == "jeux"){
    $router = new JeuxRouteur($controlleurjeux);
    $router->router();
}else{
    echo "Router invalide";
}

