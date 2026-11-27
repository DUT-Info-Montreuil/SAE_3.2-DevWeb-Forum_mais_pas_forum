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
            <button type="submit">Envoyer</button>
        </form>

        <?php
        $this->afficherPage('creation studio');
    }

    public function afficherDetail(?Studio $studio): void{
        $this->debutContenu();
        if($studio == null){
            ?>
            <p>Erreur en affichant le detail du studio</p>
            <?php
        }else{

            ?>
            <h2>id Studio  : <?=$studio->getIdStudio()?></h2>
            <h1>nom Studio  : <?=e($studio->getNomStudio())?></h1>
            <h2>nb Abonnée  : <?=$studio->getNbAbonne()?></h2>


            <?php
        }
        $this->afficherPage('detail studio');
    }

}