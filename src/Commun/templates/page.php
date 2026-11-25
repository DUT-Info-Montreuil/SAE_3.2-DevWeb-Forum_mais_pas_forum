
<?php
require_once __DIR__ . '/../Xss.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titre) ?></title><?php // comme sa va etre appeler dans Template titre et contenue seront connus , donner via le constructeur de template ?>
</head>
<body>
<?php require __DIR__ . '/entete.php'; ?>
<main>
    <?= $contenu ?>
</main>
<?php require __DIR__ . '/pied.php'; ?>
</body>
</html>