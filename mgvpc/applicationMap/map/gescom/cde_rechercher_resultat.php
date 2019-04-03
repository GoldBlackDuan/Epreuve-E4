<!-- AFFICHAGE DU HAUT DE LA PAGE -->
<?php
    include ("../inc/header.inc.php");
    include ("../inc/menu.inc.php");
    
    function __autoload($class_name){
        require('../../classes/' . $class_name . '.class.php'); 
    }    
?>

<!-- AFFICHAGE DU CENTRE DE PAGE -->
<div id="content">
    
    <!-- Affichage du contenu "utile" de la page -->
    <div class="left">        

    <!-- Recherche de la commande en base de données -->
    <?php
    
    switch ($_POST['typeRech']) {
                
        case "num" :
            //On cherche une unique commande avec son numéro
            $num = $_POST['numCde'];
            $cdeManager = new commandeManager(database::getDB());
            $cde = $cdeManager->get($num);            
            if (is_object($cde)) {
                echo "<h2> Information sur la commande n° ".$cde->getNum()."</h2>";
                echo "<p>Date : ".$cde->getDate()."<br>";
                echo "Etat actuel : ".$cde->getEtat()."</p>";

                echo "<p><b>Client #".$cde->getClient()->getId()."</b> ".$cde->getClient()->getPrenom().
                        " ".$cde->getClient()->getNom()." ".$cde->getClient()->getRue().
                        " ".$cde->getClient()->getCP()." ".$cde->getClient()->getVille()."</p>";


                echo "<p><table class=\"tab_cde\"><tr><th>Référence</th><th>Désignation</th><th>Prix U. HT</th><th>Quantité</th><th>Total HT</th></tr>";
                $totalGeneral = 0;
                foreach ($cde->getProduits() as $prod){
                    $id = $prod->getId();
                    $qte = $cde->getQuantites()[$id];
                    $totalLigne = $prod->getPrix() * $qte;                    
                    $totalGeneral += $totalLigne;
                    echo "<tr>";
                    echo "<td>".$id."</td>";
                    echo "<td>".$prod->getLib()."</td>";
                    echo "<td align='right'>".$prod->getPrix()." € </td>";
                    echo "<td align='center'>".$qte."</td>";                        
                    echo "<td align='right'>".$totalLigne." € </td>";                        
                    echo "</tr>";                        
                }
                echo "<tr><td colspan='4' align='right'>Total HT</td><td align='right'>".$totalGeneral." €</td>";
                echo "<tr><td colspan='4' align='right'>Taux TVA</td><td align='right'>20%</td>";
                echo "<tr><td colspan='4' align='right'>Total TVA</td><td align='right'>".$totalGeneral*0.2." €</td>";
                echo "<tr><td colspan='4' align='right'><b>TOTAL TTC</b></td><td align='right'><b>".$totalGeneral*1.2." €</b></td>";
                echo "</table></p>";
                echo "<p><a href=\"javascript:history.go(-1)\">Retour</a>";

            }
            else {
                echo "<h2> Erreur de recherche </h2>";
                echo "<p>La commande <b>n° ".$num."</b> est introuvable</p>";
                echo "<p><a href=\"javascript:history.go(-1)\">Retour</a>";
            }

        break;

        case "cli" :
            //On cherche plusieurs commande avec le nom/prenom du client
            $nom = $_POST['nomCli'];
            $prenom = $_POST['prenomCli'];                    

            $cliManager = new clientManager(database::getDB());
            $cdeManager = new commandeManager(database::getDB());

            $tabClis = $cliManager->getList("WHERE nomCli=\"".$nom."\" AND prenomCli=\"".$prenom."\";");
           
            if (!empty($tabClis) && is_object($tabClis[0])) {                                                
                 $client = $tabClis[0];
                 echo "<p><b>Client #".$client->getId()."</b> ".$client->getPrenom().
                                " ".$client->getNom()." ".$client->getRue().
                                " ".$client->getCP()." ".$client->getVille()."</p><hr>";

                $tabCdes = $cdeManager->getCdesClient($client);                        
                if (!empty($tabCdes)) {
                    foreach($tabCdes as $cde) {
                        echo "<h2> Information sur la commande n° ".$cde->getNum()."</h2>";
                        echo "<p>Date : ".$cde->getDate()."<br>";
                        echo "Etat actuel : ".$cde->getEtat()."</p>";

                        echo "<p><table class=\"tab_cde\"><tr><th>Référence</th><th>Désignation</th><th>Prix U. HT</th><th>Quantité</th><th>Total HT</th></tr>";
                        $totalGeneral = 0;
                        foreach ($cde->getProduits() as $prod){
                            $id = $prod->getId();
                            $qte = $cde->getQuantites()[$id];
                            $totalLigne = $prod->getPrix() * $qte;                    
                            $totalGeneral += $totalLigne;
                            echo "<tr>";
                            echo "<td>".$id."</td>";
                            echo "<td>".$prod->getLib()."</td>";
                            echo "<td align='right'>".$prod->getPrix()." € </td>";
                            echo "<td align='center'>".$qte."</td>";                        
                            echo "<td align='right'>".$totalLigne." € </td>";                        
                            echo "</tr>";
                        }
                        echo "<tr><td colspan='4' align='right'>Total HT</td><td align='right'>".$totalGeneral." €</td>";
                        echo "<tr><td colspan='4' align='right'>Taux TVA</td><td align='right'>20%</td>";
                        echo "<tr><td colspan='4' align='right'>Total TVA</td><td align='right'>".$totalGeneral*0.2." €</td>";
                        echo "<tr><td colspan='4' align='right'><b>TOTAL TTC</b></td><td align='right'><b>".$totalGeneral*1.2." €</b></td>";
                        echo "</table></p>";
                    }
                    echo "<p><a href=\"javascript:history.go(-1)\">Retour</a>";

                }
            }
            else {
                echo "<h2> Erreur de recherche </h2>";
                echo "<p>Le client \" <b>".$prenom." ".$nom." \"</b> n'existe pas ou n'a pas passé de commande</p>";
                echo "<p><a href=\"javascript:history.go(-1)\">Retour</a>";
            }

        break;
    }  
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