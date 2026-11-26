<?php
class JeuxView{
    public function __construct(){

    }
    public function afficherListe(array $jeux): void{
        foreach($jeux as $j){
            echo "</p>";
            echo "<a href=\"index.php?route=detail&id={$j->getId()}\"> {$j->getNom()} </a><br>";
            echo "<a href=\"index.php?route=detail&id={$j->getId()}</a><br>";
            echo "<a href=\"index.php?module=jeux&route=formulaire_ajout> Ajouter </a>";
            echo "<a href=\"index.php?module=jeux&route=formulaire_modification&id={$j->getId()}\"> Modifier </a>";

        }
    }

    public function afficherDetail(?Jeux $jeux , array$extension): void{
        if($jeux == null){
            echo"Erreur en affichant le detail du jeux";
        }else{
            echo "<h1>Intitulé du jeux:{$jeux->getNom_jeux()}</h1>";
            echo "<h1>Configuration Minimal : {$jeux->getConfig_minimal()}</h1>";
            echo "<h1>Configuration Requise :{$jeux->getConfig_requise()}</h1>";
            echo "<h1>Description du jeux :{$jeux->getDescription()}</h1>";

            //echo "<img src=\"../data/{$jeux->getLogo()}\" width=\"300\">";
            /*
            foreach ($dept as $departement) {
                echo "<h1> Specialite : {$departement->getspecialite()}</h1>";
                echo "<a href=\"index.php?module=departement&route=detail&id={$departement->getid()}\"> {$departement->getspecialite()} </a><br>";
            }
            echo "<a href=\"index.php?module=departement&route=formulaire_ajout&id_iut={$iut->getId()}\"> Ajouter </a>";
            echo "<a href=\"index.php\">Retour</a>";
            */
        }
    }

    public function afficherFormulaireAjout(): void{
        echo '<form method="post" action="index.php?module=jeux&route=ajouter">
            <input type ="text"  name="nom_jeux">
            <input type ="text"  name="minimal">
            <input type ="number"  name="requise">
            <input type ="number"  name="description_jeux">
            
            <button type="Submit"> Ajouter </button>
        </form>';
    }


    public function afficherFormulaireModification(Jeux $j): void{
        echo '<form method="post" action="index.php?module=jeux&route=modifier" >    
    <input type="hidden" name="id_jeux" value="' . $j->getId() . '">

        <input type="text" name="nom_jeux" required value="' .
            htmlspecialchars($j->getNom_jeux(), ENT_QUOTES, 'UTF-8') . '">

        <input type="text" name="minimal" required value="' . htmlspecialchars($j->getConfig_minimal() , ENT_QUOTES, 'UTF-8') . '">
        <input type="text" name="requise" required value="' . htmlspecialchars($j->getConfig_requise() , ENT_QUOTES, 'UTF-8') . '">
        <input type="text" name="description" required value="' . htmlspecialchars($j->getDescription() , ENT_QUOTES, 'UTF-8') . '">

            <button type="Submit"> Modifier </button>
        </form>';


    }








}
?>


}