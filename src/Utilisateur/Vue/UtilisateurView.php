<?php
require_once __DIR__ . '/../Model/Utilisateur.php';
require_once __DIR__ . '/../../Commun/Xss.php';//méthode e()
require_once __DIR__ . '/../../Commun/Vue.php';

class UtilisateurView extends Vue
{


    public function afficherFormulaireInscription(): void {
        $this->debutContenu();
        ?>
        <h1>Inscription</h1>
        <form action="index.php?module=utilisateur&route=inscrire" method="post" enctype="multipart/form-data">
            <input type="hidden" name="jeton" value="<?= e($_SESSION["jeton"]) ?>">
            <label for="nom_utilisateur">Nom</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>
            <label for="mot_de_passe_hash">Mot de passe</label>
            <input type="password" id="mot_de_passe_hash" name="mot_de_passe_hash" required>
            <button type="submit">Envoyer</button>
        </form>

        <a href="index.php?module=utilisateur&amp;route=connecter">Se connecter</a>
        <?php


        $this->afficherPage('Les Inscription utilisateur');
    }

    public function afficherListeDesInscrit(array $utilisateurs)
    {
        $this->debutContenu();
        ?>

        <h1>utilisateurs</h1>
        <?php
        foreach ($utilisateurs as $utilisateur) {
            ?>
            <section>
                <h2>Nom : <?= e($utilisateur->getNom()) ?></h2>
                <p>id : <?= $utilisateur->getID() ?></p>
                <p>Email : <?= e($utilisateur->getEMail()) ?></p>
                <p>mdp : <?= $utilisateur->getMDP() ?></p>
                <p>id Rôle : <?= $utilisateur->getRole() ?></p>
            </section>
            <?php
        }
        echo '<p><a href="index.php?module=utilisateur&amp;route=inscrire">Retour inscription</a></p>';
        ?>
        <?php
        $this->afficherPage('Les utilisateurs inscrit');
    }

    public function afficherFormulaireConnexion(): void {
        $this->debutContenu();
        ?>
        <h1>Connexion</h1>
        <form action="index.php?module=utilisateur&route=connecter" method="post" enctype="multipart/form-data">
            <input type="hidden" name="jeton" value="<?= e($_SESSION["jeton"]) ?>">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom"required>
            <label for="email">Email</label>
            <input type="text" id="email" name="email"required>
            <label for="mot_de_passe_hash">Mot de passe</label>
            <input type="password" id="mot_de_passe_hash" name="mot_de_passe_hash"required>
            </label>
            <button type="submit">Envoyer</button>
        </form>
        <a href="index.php?module=utilisateur&amp;route=inscrire">Créer un compte</a>


        <?php
        $this->afficherPage('Les Connexion utilisateur');
    }

}