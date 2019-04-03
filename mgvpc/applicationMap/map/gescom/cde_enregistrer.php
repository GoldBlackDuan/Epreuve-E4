<!-- AFFICHAGE DU HAUT DE LA PAGE -->
<?php
include ("../inc/header.inc.php");
include ("../inc/menu.inc.php");

function __autoload($class_name){
    require('../../classes/' . $class_name . '.class.php'); 
}

?>

<!-- Enregistrement de la commande en base de données -->
<?php
$idCli = $_POST['numCli'];
$tabRef = $_POST['ref'];
$tabQte = $_POST['qte'];

if(isset($_POST['numCli']) && !empty($_POST['numCli'])
    && isset($_POST['ref']) && !empty($_POST['ref'])
    && isset($_POST['qte']) && !empty($_POST['qte']))   {

    $cliManager = new clientManager(database::getDB());
    $cdeManager = new commandeManager(database::getDB());
    $prodManager = new produitManager(database::getDB());
    
    $client = $cliManager->get($idCli);    
    $cde = new commande($client);
    
    for($i=0;$i<count($tabRef);$i++){
        $prod = $prodManager->get($tabRef[$i]);
        $cde->addProduitQte($prod,$tabQte[$i]);
    }
    $cdeManager->save($cde);
}
?>

<!-- AFFICHAGE DU CENTRE DE PAGE -->
<div id="content">
    
    <!-- Affichage du contenu "utile" de la page -->
    <div class="left">

        <img id="banner" src="../images/warehouse.jpg" alt="Entrepot">
        <br>

        <h2> La commande a bien été enregistrée. </h2>
        <br><a href="cde_saisir.php">Saisir une autre commande</a>
        <br> <a href="../index.php">Revenir à l'accueil</a>

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