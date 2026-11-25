<?php

require_once __DIR__ . '/../../Commun/BDD.php';
require_once __DIR__ . '/Utilisateur.php';

class UtilisateurRepository extends BDD
{
    public function findById(int $id): ?Utilisateur
    {
        $requete = self::$pdo->prepare('SELECT * FROM Utilisateur WHERE id = :id');
        $requete->execute(['id' => $id]);
        $ligne = $requete->fetch(PDO::FETCH_ASSOC);
        return $ligne === false ? null : self::versUtilisateur($ligne);
    }

    public function findByEMail(string $email): ?Utilisateur
    {
        $requete = self::$pdo->prepare('SELECT * FROM Utilisateur WHERE email = :email');
        $requete->execute(['email' => $email]);
        $ligne = $requete->fetch(PDO::FETCH_ASSOC);
        return $ligne === false ? null : self::versUtilisateur($ligne);
    }

    private static function versUtilisateur(array $ligne): Utilisateur
    {
        return new Utilisateur((int)$ligne['id_utilisateur'], $ligne['nom_utilisateur'], $ligne['email'], $ligne['mot_de_passe'], (int)$ligne['id_role']);
    }

    public function inscrire(Utilisateur $utilisateur): void
    {

        $motdepassedevenuhash = password_hash($utilisateur->getMDP(), PASSWORD_DEFAULT);
        $requete = self::$pdo->prepare('INSERT INTO Utilisateur(nom_utilisateur, email, mot_de_passe ,id_role) VALUES (:nom_utilisateur, :email, :mot_de_passe_hash, :role)');
        $requete->execute(['nom_utilisateur' => $utilisateur->getNom(), 'email' => $utilisateur->getEMail(), 'mot_de_passe_hash' => $motdepassedevenuhash, 'role' => $utilisateur->getRole()]);

    }

    public function findAll(): array
    {
        $requete = self::$pdo->query('SELECT id_utilisateur, nom_utilisateur, email,mot_de_passe, id_role FROM Utilisateur ORDER BY nom_utilisateur');
        $utilisateurs = [];
        while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
            $utilisateurs[] = $this->versUtilisateur($ligne);
        }
        return $utilisateurs;
    }

}