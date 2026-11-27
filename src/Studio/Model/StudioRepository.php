<?php

require_once __DIR__ . '/../../Commun/BDD.php';

Class StudioRepository extends BDD {

    public function findById(int $id): ?Studio
    {
        $requete = self::$pdo->prepare('SELECT * FROM Studio WHERE id_studio = :id');
        $requete->execute(['id' => $id]);
        $ligne = $requete->fetch(PDO::FETCH_ASSOC);
        return $ligne === false ? null : self::versStudio($ligne);
    }
    public function findAll() : array
    {
        $lignes = self::$pdo->query('SELECT * FROM Studio ')->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'versStudio'], $lignes);
    }
    private static function versStudio(array $ligne): Studio
    {
        return new Studio((int)$ligne['id_studio'], $ligne['nom_studio']);
    }

    public function creerStudio(Studio $studio): int
    {
        $requete = self::$pdo->prepare('INSERT INTO Studio(nom_studio) VALUES (:nom_studio)');
        $requete->execute(['nom_studio' => $studio->getNomStudio()]);
        return self::$pdo->lastInsertId();
    }
}
