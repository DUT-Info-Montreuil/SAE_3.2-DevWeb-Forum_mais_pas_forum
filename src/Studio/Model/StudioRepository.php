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
    public static function versStudio(array $ligne): Studio
    {
        return new Studio((int)$ligne['id_studio'], $ligne['nom_studio']);
    }

    public function creerStudio(Studio $studio): int
    {
        $requete = self::$pdo->prepare('INSERT INTO Studio(nom_studio) VALUES (:nom_studio)');
        $requete->execute(['nom_studio' => $studio->getNomStudio()]);
        return self::$pdo->lastInsertId();
    }

    public function findJeuxByStudio(int $id_studio): array // pour recup le studio de la relation faire la meme dans Studio mais pour une liste de jeu
    {
        $requete = self::$pdo->prepare('SELECT id_jeux FROM Developper WHERE id_studio = :id_studio');
        $requete->execute(['id_studio' => $id_studio]);
        $lignes = $requete->fetchAll(PDO::FETCH_ASSOC);
        $jeux = [];

        foreach ($lignes as $ligne) {
            $requete = self::$pdo->prepare('SELECT * FROM Jeux WHERE id_jeux = :id_jeux');
            $requete->execute(['id_jeux' => $ligne['id_jeux']]);
            $jeu = $requete->fetch(PDO::FETCH_ASSOC);
            if ($jeu !== false) {
                $jeux[] = JeuxRepository::versJeux($jeu);
            }
        }
        return $jeux;
    }
}
