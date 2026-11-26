<?php
//http://localhost/SAE_3.2-DevWeb-Forum_mais_pas_forum/public/ test
class JeuxRepository extends BDD{

    public function __construct()
    {
        //$file = require_once __DIR__ . '/../../../data/bd.sql';
        //$this->pdo = new PDO($file);
        parent::__construct();
    }
    public function findAll(): array{
        $requete = BDD::$pdo->prepare("SELECT * FROM Jeux");
        $requete->execute();
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        $listedejeux = [];

        foreach($resultats as $r){
            $listedejeux[] = Jeux::fromArray($r);
        }
    return $listedejeux;}

    public function findById(int $id_jeux): ?Jeux{
        $requete = BDD::$pdo->prepare("SELECT * FROM Jeux");
        $requete->execute(["id_jeux" => $id_jeux]);
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        if (!$resultat){
            return null;
        }
        return Jeux::fromArray($resultat);
    }

    public function ajouter(Jeux $j): int{ //je meteais arreter la et je devais maide du TP4 pour le finir !
        $requete = BDD::$pdo->prepare("INSERT INTO Jeux (nom_jeux, configuration_minimal, configuration_requise, description_jeux) VALUES (:nom_jeux, :configuration_minimal, :configuration_requise, :description_jeux)");
        $requete->execute([
            "nom_jeux" => $j->getNom_jeux(),
            "minimal" => $j->getConfig_minimal(),
            "requise" => $j->getConfig_requise(),
            "description" => $j->getDescription()
        ]);
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        return BDD::$pdo->lastInsertId();
    }



    public function modifier(Jeux $jeux): void {
        $requete = BDD::$pdo->prepare("
        UPDATE Jeux
        SET nom_jeux = :nom_jeux,
            configuration_minimal = :configuration_minimal,
            configuration_requise = :configuration_requise,
            description_jeux = :description_jeux
        WHERE id_jeux = :id_jeux
    ");

        $requete->execute([
            "nom_jeux" => $jeux->getNom_jeux(),
            "minimal" => $jeux->getConfig_minimal(),
            "requise" => $jeux->getConfig_requise(),
            "description" => $jeux->getDescription(),
            "id_jeux" => $jeux->getId()
        ]);
    }



















}