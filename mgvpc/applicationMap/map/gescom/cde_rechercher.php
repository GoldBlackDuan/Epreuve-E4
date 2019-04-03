<!-- AFFICHAGE DU HAUT DE LA PAGE -->
<?php
    include ("../inc/header.inc.php");
    include ("../inc/menu.inc.php");
?>
    
<!-- AFFICHAGE DU CONTENU DE LA PAGE -->
<div id="content">
    
    <!-- Affichage du contenu "utile" de la page -->
    <div class="left">

        <img id="banner" src="../images/warehouse.jpg" alt="Entrepot">
        <br>
        <h2>Rechercher par NUMERO</h2>
        <div id="formRechNum">
            <form method="post" action="cde_rechercher_resultat.php">
                <input type="hidden" name="typeRech" value="num">
                <fieldset>
                    <p><input type="text" name="numCde" size="33" placeholder="Numéro de la commande" required>&nbsp;&nbsp;
                        <input type="submit" value="Rechercher"></p>
                </fieldset>
            </form>
        </div>
        <h2>Rechercher par CLIENT</h2>
        <div id="formRechCli">
            <form method="post" action="cde_rechercher_resultat.php">
                <input type="hidden" name="typeRech" value="cli">
                <fieldset>
                    <p><input type="text" name="nomCli" size="50" placeholder="Nom du Client" required></p>
                    <p><input type="text" name="prenomCli" size="50" placeholder="Prénom du Client" required>&nbsp;&nbsp;
                        <input type="submit" value="Rechercher"></p>
                </fieldset>
            </form>
        </div>
    </div>

    <!-- Affichage du menu de droite -->
    <?php
        include ("../inc/right.inc.php");
    ?>
    
    <!-- rétablissement du flux normal -->
    <div style="clear:both;"></div>

</div>

<!-- AFFICHAGE DU BAS DE PAGE -->
<?php
    include ("../inc/footer.inc.php");
?>
