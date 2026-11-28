<?php
require_once __DIR__ . '/../Model/Studio.php';
require_once __DIR__ . '/../../Commun/Xss.php';//méthode e()
require_once __DIR__ . '/../../Commun/Vue.php';

class StudioView extends Vue
{

    public function afficherListe(array $studio): void{//temporaire juste pour tester
        $this->debutContenu();
        foreach($studio as $s){
            ?>
            <ul>
            <li><a href="index.php?module=studio&amp;route=detail&amp;id=<?=  $s->getIdStudio() ?>"><?= e($s->getNomStudio()) ?></a></li>
            </ul>
            <?php
        }
        ?>
        <a href="index.php?module=studio&amp;route=creerStudio">CreerStudio</a>
        <?php
        $this->afficherPage('creation studio');
    }

    public function afficherFormulaireCreationStudio() : void{
        $this->debutContenu();
        ?>

        <h1>Création Studio</h1>
        <form action="index.php?module=studio&route=creerStudio" method="post" enctype="multipart/form-data">
            <input type="hidden" name="jeton" value="<?= e($_SESSION["jeton"]) ?>">
            <label for="nom_studio">Nom</label>
            <input type="text" id="nom_studio" name="nom_studio" required>
            <br>
            <label for="logo">logo</label>
            <input type ="file"  name="logo" accept="image/png,image/jpeg,image/svg+xml" required><br>
            <label for="description_studio">Description du studio</label><br>
            <textarea name="description_studio" id="description_studio" rows="5" cols="40" required placeholder="Decrire le studio"></textarea><br>
            <button type="submit">Envoyer</button>
        </form>

        <?php
        $this->afficherPage('creation studio');
    }

    public function afficherDetail(?Studio $studio , array $jeux): void{
        $this->debutContenu();
        if($studio == null){
            ?>
            <p>Erreur en affichant le detail du studio</p>
            <?php
        }else{
            $logo = $studio->getLogoStudio();
            $envoye = preg_match('~\Alogo_Studio/[a-f0-9]{32}\.(png|jpg|svg)\z~',$logo) === 1;
            $existe = $envoye && is_file(__DIR__ . '/../../../data/' . $logo);

            if ($existe) {
                $src = '../data/' . $logo;
                echo '<img src="' . e($src) . '" alt="logo de ' . e($studio->getNomStudio()) . '" width="180">';
            } else {
                echo '<p>Logo indisponible</p>';
            }
            ?>
            <h2>id Studio  : <?=$studio->getIdStudio()?></h2>
            <h1>nom Studio  : <?=e($studio->getNomStudio())?></h1>
            <h2>nb Abonnée  : <?=$studio->getNbAbonne()?></h2>
            <h2>Description du studio :<?=$studio->getDescriptionStudio()?></h2>

            <?php

            self::afficherRelationStudioJeux($jeux);
        }
        $this->afficherPage('detail studio');
    }

    public function afficherRelationStudioJeux(array $jeux){//comme c'est appeler dans la methode details bah pas de debutContenue
        ?>
        <h2>Jeux</h2>
        <ul>
        <?php

        foreach ($jeux as $jeu) {
            ?>
            <li><a href="index.php?module=jeux&route=detail&id_jeux=<?= $jeu->getId() ?>"><?=e($jeu->getNom_jeux())?></a></li>
            <p></p>

            <?php
        }
        ?>
        </ul>
        <?php
    }

}