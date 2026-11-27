<nav>
        <?php
        if (isset($_SESSION["id_utilisateur"])) {
            ?>
            <form action="index.php?module=utilisateur&route=deconnecter" method="post">
            <input type="hidden" name="jeton" value="<?= e($_SESSION['jeton']) ?>">
            <button type="submit">Deconnexion</button>
            </form>

            <a href="index.php?module=jeux&amp;route=liste">liste jeux</a>
            <a href="index.php?module=studio&amp;route=liste">liste studio</a>

            <a href="index.php?module=utilisateur&amp;route=test">
                test
            </a>
            <?php
        }
        ?>

</nav>