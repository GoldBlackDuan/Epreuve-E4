<!-- AFFICHAGE DU HAUT DE LA PAGE -->
<?php
    include ("../inc/header.inc.php");
    include ("../inc/menu.inc.php");
    
    function __autoload($class_name){
        require('../../classes/' . $class_name . '.class.php'); 
    }    
?>
<script>

function filtrePrix(){
    //modifier la valeur du span pour visualiser le prix choisi
	var prixMax = document.getElementById("prixMax").value;
	document.getElementById("selRange").innerHTML = prixMax+"€";
    
	 // Récupère les éléments qui ont un prix
	var prix = document.getElementsByName("prix");
	
	
	for (var i=0; i < prix.length ; i++){ // Pour chaque prix
		// On masque la ligne
		prix.item(i).parentNode.parentNode.style.display="none";
		
		// Si un prix est inférieur à la valeur demandée
		// 'parseFloat' permet de transformer une chaîne de caractères en un nombre flottant
		if(parseFloat(prix.item(i).value) < prixMax){ 
			// Alors on affiche la ligne dont le prix est inférieur à la valeur demandée
			prix.item(i).parentNode.parentNode.style.display=""; 
		}
	}
}
</script>
<!-- AFFICHAGE DU CENTRE DE PAGE -->
<div id="content">
    <!-- Affichage du contenu "utile" de la page -->
	<div class="left">        

    <!-- Recherche de la commande en base de données -->
    Filtrer par prix max 
    <input id="prixMax" type="range" min="0" max="500" step="10" value="500" onchange='filtrePrix()' /> 
    <span id="selRange">500€</span> 
    <?php
    //récupération des produits
    $prodManager = new produitManager(database::getDB());
    $tabProd = $prodManager->getList();
	
    echo "<p><table class=\"tab_cde\"><tr><th>Référence</th><th><a href='catalogue.php?tri=desig'>Désignation</a><th>Prix U. HT</th></tr>";
    
	if(isset($_GET['tri'])&&($_GET['tri']!=""))
	{
		if($_GET['tri']=="desig")
		{
			// Affiche la liste par ordre croissant
			$tabProd=$prodManager->getList("order by libProd");
			//echo "salut";
		}
	}
	
	else
	{
		$tabProd=$prodManager->getList();
	}
	
	//parcours des résultats
    foreach ($tabProd as $prod){
        echo "<tr align='center'>";
        echo "<td>".$prod->getId()."</td>";
        echo "<td>".$prod->getLib()."</td>";
        echo "<td>".$prod->getPrix()."</td>";
        echo "</tr>";
    }
    echo "</table></p>"; 
   
    ?>
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
