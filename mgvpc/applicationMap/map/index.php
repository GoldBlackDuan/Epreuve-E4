<!-- AFFICHAGE DU HAUT DE LA PAGE -->
<?php
    include ('inc/header.inc.php');
    include ('inc/menu.inc.php');
?>

<!-- AFFICHAGE DU CONTENU DE LA PAGE -->
<div id="content">

    <!-- Affichage du contenu "utile" de la page -->
    <div class="left">

        <img id="banner" src="images/warehouse.jpg" alt="Entrepot">
        <br>

        <h2>M-A-P / MG Apps Portal</h2>
        MG Portail applicatif v1.1

    </div>
    
    <!-- Affichage du menu de droite -->
    <?php
        include ("inc/right.inc.php");
    ?>
    
    <!-- rétablissement du flux normal -->
    <div style="clear:both;"></div>

</div>

<!-- AFFICHAGE DU BAS DE PAGE -->
<?php
    include ("inc/footer.inc.php");
?>
