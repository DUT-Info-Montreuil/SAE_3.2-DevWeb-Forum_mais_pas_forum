<?php
//http://localhost/SAE_3.2-DevWeb-Forum_mais_pas_forum/public/ test
class JeuxRepository extends BDD{

    public function __construct()
    {
        parent::__construct();

    }
    public function findAll(): array{
        $requete = self::$pdo->prepare("SELECT * FROM Jeux");
        $requete->execute();
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        $listedejeux = [];

        foreach($resultats as $r){
            $listedejeux[] = Jeux::fromArray($r);
        }
    return $listedejeux;}

    public function findById(int $id_jeux): ?Jeux{
        $requete = self::$pdo->prepare("SELECT * FROM Jeux WHERE id_jeux = :id_jeux");
        $requete->execute(["id_jeux" => $id_jeux]);
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        if (!$resultat){
            return null;
        }
        return Jeux::fromArray($resultat);
    }

    public function ajouter(Jeux $j): int{ //je meteais arreter la et je devais maide du TP4 pour le finir !
        $requete = self::$pdo->prepare("INSERT INTO Jeux (nom_jeux, configuration_minimal, configuration_requise, description_jeux , logo) VALUES (:nom_jeux, :configuration_minimal, :configuration_requise, :description_jeux , :logo)");
        $requete->execute([
            "nom_jeux" => $j->getNom_jeux(),
            "configuration_minimal" => $j->getConfig_minimal(),
            "configuration_requise" => $j->getConfig_requise(),
            "description_jeux" => $j->getDescription(),
            "logo" => $j->getLogo()
        ]);
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        return self::$pdo->lastInsertId();
    }



    public function modifier(Jeux $jeux): void {
        $requete = BDD::$pdo->prepare("
        UPDATE Jeux
        SET nom_jeux = :nom_jeux,
            configuration_minimal = :configuration_minimal,
            configuration_requise = :configuration_requise,
            description_jeux = :description_jeux,
            logo = :logo
        WHERE id_jeux = :id_jeux
    ");

        $requete->execute([
            "nom_jeux" => $jeux->getNom_jeux(),
            "configuration_minimal" => $jeux->getConfig_minimal(),
            "configuration_requise" => $jeux->getConfig_requise(),
            "description_jeux" => $jeux->getDescription(),
            "logo" => $jeux->getLogo(),
            "id_jeux" => $jeux->getId()
        ]);
    }

    public function supprimer(int $id_jeux): void{
        $requete = BDD::$pdo->prepare("DELETE FROM Jeux WHERE id_jeux = :id_jeux");

        $requete->execute(["id_jeux" => $id_jeux]);
    }

    public function relationDevelopper(int $id_jeux, int $id_studio): void//le studio qui à créer le jeu
    {
        $requete = self::$pdo->prepare('INSERT INTO Developper (id_jeux, id_studio)VALUES (:id_jeux, :id_studio)');
        $requete->execute(['id_jeux' => $id_jeux, 'id_studio' => $id_studio]);
    }

    public function findStudioByJeux(int $id_jeux): array // pour recup le studio de la relation faire la meme dans Studio mais pour une liste de jeu
    {
        $requete = self::$pdo->prepare('SELECT id_studio FROM Developper WHERE id_jeux = :id_jeux');
        $requete->execute(['id_jeux' => $id_jeux]);
        $lignes = $requete->fetchAll(PDO::FETCH_ASSOC);
        $studios = [];

        foreach ($lignes as $ligne) {
            $requete = self::$pdo->prepare('SELECT * FROM Studio WHERE id_studio = :id_studio');
            $requete->execute(['id_studio' => $ligne['id_studio']]);// ligne est le tableau qui a un id qui est stockés dans la liste d'id de lignes
            $studio = $requete->fetch(PDO::FETCH_ASSOC);//on recupère 1 studio en array , il contient id ,nom et nbAbonne
            if ($studio !== false) {//si sa a marché
                $studios[] = StudioRepository::versStudio($studio);
            }
        }

        return $studios;// retourne les studios correspondant
    }
    public static function versJeux(array $ligne): Jeux
    {
        return new Jeux((int)$ligne['id_jeux'], $ligne['nom_jeux'],$ligne['configuration_minimal'],$ligne['configuration_requise'],$ligne['description_jeux'] ,$ligne['logo']);
    }










}