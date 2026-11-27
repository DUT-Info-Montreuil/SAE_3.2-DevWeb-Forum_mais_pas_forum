<?php

require_once __DIR__ . '/../../Studio/Model/Studio.php';
require_once __DIR__ . '/../Model/Jeux.php';
require_once __DIR__ . '/../../Commun/Xss.php';//méthode e()
require_once __DIR__ . '/../../Commun/Vue.php';

class JeuxView extends Vue {
    public function __construct(){

    }
    public function afficherListe(array $jeux): void{
        foreach($jeux as $j){
            echo "<p>";
            echo "<a href=\"index.php?module=jeux&route=detail&id_jeux={$j->getId()}\"> {$j->getNom_jeux()} </a><br>";


            echo "<a href=\"index.php?module=jeux&route=formulaire_modification&id_jeux={$j->getId()}\"> Modifier </a>";

            echo "</p>";
        }

        echo "<a href=\"index.php?module=jeux&route=formulaire_ajout\">Ajouter</a>";
    }

    public function afficherDetail(?Jeux $jeux ,array $studios, array$extension): void{
        if($jeux == null){
            echo"Erreur en affichant le detail du jeux";
        }else{

            $logo = $jeux->getLogo();
            //$logosAutorises = ['logos/iut-montreuil.svg','logos/iut-villetaneuse.svg','logos/iut-paris.svg'];
            //$fourni = in_array($logo , $logosAutorises , true);
            $envoye = preg_match('~\Aimages/[a-f0-9]{32}\.(png|jpg|svg)\z~',$logo) === 1;

            $existe = $envoye && is_file(__DIR__ . '/../../../data/' . $logo);



            echo "<h1>Intitulé du jeux:{$jeux->getNom_jeux()}</h1>";

            if($existe){
                $src = '../data/' . $logo;
                echo '<img src="' . e($src) . '" alt="logo de ' . e($jeux->getNom_jeux()) . '" width="180">';
            }else{
                echo '<p>Logo indisponible</p>';
            }

            echo "<h1>Configuration Minimal : {$jeux->getConfig_minimal()}</h1>";
            echo "<h1>Configuration Requise :{$jeux->getConfig_requise()}</h1>";
            echo "<h1>Description du jeux :{$jeux->getDescription()}</h1>";


            self::afficherRelationStudioJeux($studios);


            //echo "<img src=\"../data/{$jeux->getLogo()}\" width=\"300\">";
            /*
            foreach ($dept as $departement) {
                echo "<h1> Specialite : {$departement->getspecialite()}</h1>";
                echo "<a href=\"index.php?module=departement&route=detail&id={$departement->getid()}\"> {$departement->getspecialite()} </a><br>";
            }
            echo "<a href=\"index.php?module=departement&route=formulaire_ajout&id_iut={$iut->getId()}\"> Ajouter </a>";
            */
            echo "<a href=\"index.php?module=jeux&route=formulaire_modification&id_jeux={$jeux->getId()}\"> Modifier </a><br>";


            echo '<form method="post" action="index.php?module=jeux&route=supprimer"><br>
            <input type="hidden" name="id_jeux" value="' . $jeux->getId() . '">
            <input type="hidden" name="jeton" value="'. e($_SESSION["jeton"]) .'">
            <button type="submit">Supprimer</button>
            </form>';


            echo '<a href="index.php?module=jeux">Retour</a>';

        }
    }

    public function afficherFormulaireAjout(array $studios): void{
        $this->debutContenu();
        ?>
        <form method="post" action="index.php?module=jeux&route=ajouter" enctype="multipart/form-data">
            <input type="hidden" name="jeton" value="<?= e($_SESSION["jeton"]) ?>">
            <label for="nom_jeux">Nom</label>
            <input type ="text" required name="nom_jeux"><br>
            <label for="id_studio"> Studio développeur du jeu</label>
            <?php
            foreach ($studios as $studio){ ?>
                    <div>
                <input type="checkbox" name="id_studio[]" id="studio<?= $studio->getIdStudio() ?>" value="<?= $studio->getIdStudio() ?>">
                <label for="studio<?= $studio->getIdStudio() ?>">
                    <?= e($studio->getNomStudio()) ?>
                </label>
                    </div>
            <?php }//voir en javascript pour trouver un moyen de verifier qu'au moins une case est coché car le require force de cochez tt les cases
            ?>
            <br>
            <label for="logo">logo</label>
            <input type ="file"  name="logo" accept="image/png,image/jpeg,image/svg+xml" required><br>
            <label for="configuration_minimal">configuration minimal</label>
            <input type ="number" required  name="configuration_minimal"><br>
            <label for="configuration_requise">configuration requise</label>
            <input type ="number" required name="configuration_requise"><br>
            <textarea name="description_jeux" rows="5" cols="40" required placeholder="Description du jeu"></textarea><br>
            <button type="Submit"> Ajouter </button>
        </form>
        <?php
        $this->afficherPage('creation jeux');

    }


    public function afficherFormulaireModification(Jeux $j): void{
        echo '<form method="post" action="index.php?module=jeux&route=modifier" enctype="multipart/form-data">
         <input type="hidden" name="jeton" value="'. e($_SESSION["jeton"]) .'">
         
          
    <input type="hidden" name="id_jeux" value="' . $j->getId() . '">

        <input type="text" name="nom_jeux" required value="' .
            htmlspecialchars($j->getNom_jeux(), ENT_QUOTES, 'UTF-8') . '">

        <input type="number" name="configuration_minimal" required value="' . e($j->getConfig_minimal() , ENT_QUOTES, 'UTF-8') . '">
        <input type="number" name="configuration_requise" required value="' . e($j->getConfig_requise() , ENT_QUOTES, 'UTF-8') . '">
        <textarea name="description_jeux" rows="5" cols="40" required>' . e($j->getDescription()) . '</textarea>
        <img src="../data/' . e($j->getLogo(), ENT_QUOTES, 'UTF-8') . '" width="150">

        <input type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml">

        <p>Ne choisissez aucun fichier pour conserver le logo actuel</p>
            <button type="Submit"> Modifier </button>
            
            <a href="index.php?module=jeux&route=detail&id_jeux=' . $j->getId() . '">Retour</a>
        </form>';


    }
    public function afficherRelationStudioJeux(array $studios){//comme c'est appeler dans la methode details bah pas de debutContenue
        //mettre que le nom du studio affichés sois un lien vers le detail du studio

        ?>
        <h2>Studio(s)</h2>
        <ul>
        <?php

        foreach ($studios as $studio) {
            ?>
            <li><a href="index.php?module=studio&route=detail&id=<?= $studio->getIdStudio() ?>"><?=e($studio->getNomStudio())?></a></li>


            <?php
        }
        ?>
        </ul>
        <?php
    }








}
?>
