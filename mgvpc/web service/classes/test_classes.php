<?php
    function __autoload($class_name){
        require($class_name . '.class.php'); 
    }
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php        
//            echo "TEST DE LA CLASSE PRODUIT<br>";
//            echo "------------------------------------------------";
//            $mira = new produit(
//                    "GUI-0099",
//                    "PRS S2 Mira",
//                    "Perfect match for blues and rock, but it pretty much handles anything you throw at it.",
//                    1249.50
//                    );
//            $mira->setId("GUI-0001");
//            var_dump($mira);
//            
//            $guild = new produit(
//                    "GUI-0098",
//                    "Guild Starfire IV",
//                    "A grand to spend? Put this straight at the top of your double-cut shopping list.",
//                    1049
//                    );
//            $guild->setId("GUI-0002");
//            var_dump($guild);
//            
//            $json = json_encode($mira);
//            var_dump($json);
//            $json = json_encode($guild);
//            var_dump($json);
//            
//            echo "TEST DE LA CLASSE CLIENT<br>";
//            echo "------------------------------------------------";
//            $unClient = new client(
//                    "DUSSART",
//                    "Jean",
//                    "5 rue Saint-Gilles",
//                    "80100",
//                    "ABBEVILLE"
//                    );
//            var_dump($unClient);
//            
//            echo "TEST DE LA CLASSE COMMANDE<br>";
//            echo "------------------------------------------------";
//            $unClient = new client(
//                    "DUSSART",
//                    "Jean",
//                    "5 rue Saint-Gilles",
//                    "80100",
//                    "ABBEVILLE"
//                    );
//            $cde = new commande($unClient);
//            $mira = new produit(
//                    "GUI-0001",
//                    "PRS S2 Mira",
//                    "Perfect match for blues and rock, but it pretty much handles anything you throw at it.",
//                    1249.50
//                    );
//            $guild = new produit(
//                    "GUI-0002",
//                    "Guild Starfire IV",
//                    "A grand to spend? Put this straight at the top of your double-cut shopping list.",
//                    1049
//                    );
//            $cde->addProduit($mira);
//            $cde->addProduit($mira);
//            $cde->addProduit($mira);
//            $cde->addProduit($guild);
//            $cde->addProduitQte($guild, 2);
//            $cde->addProduitQte($mira, 3);
//            $cde->addProduitQte($mira, 3);
//            
//            var_dump($cde);
//
//            $cde->removeProduit($mira);
//            $cde->removeProduit($guild);
//            var_dump($cde);
//            
//            echo "Prix total : ".$cde->getTotal()." €<br><br>";
//            
//            $json = json_encode($cde);
//            var_dump($json);
//            
//            echo "TEST DE LA CLASSE PRODUITMANAGER <br>";
//            echo "------------------------------------------------";
//            $manager = new produitManager(database::getDB());
//            
//            var_dump ($manager->getList());
//            var_dump ($manager->getList("WHERE prixProd>60"));
//            var_dump ($manager->get("CHA-0001"));
//            var_dump ($manager->get("CHA-0099"));
//            $prodTest = new produit(
//                    "TST-0001",
//                    "produit test",
//                    "Description du produit test ajouté",
//                    199.99
//                    );
//            //Ajout du nouveau produit
//            var_dump ($manager->save($prodTest));
//            var_dump ($manager->getList());
//            
//            //On veut modifier un produit déjà existant en base
//            $prodModif=$manager->get("TST-0001");
//            $prodModif->setDesc("modification du descriptif");
//            $prodModif->setLib("nom modifié");
//            $prodModif->setPrix(999.90);            
//            var_dump ($manager->save($prodModif));
//            var_dump ($manager->getList());
//            
//            //Suppression d'un produit existant
//            $prodModif=$manager->get("TST-0001");
//            var_dump($manager->delete($prodModif));
//            var_dump ($manager->getList());
//            
//            $prodTest = new produit(
//                    "TST-0001",
//                    "produit test",
//                    "Description du produit test ajouté",
//                    199.99
//                    );
//            //Ajout du produit TST-0001
//            $manager->save($prodTest);
//            $prodModif=$manager->get("TST-0001");            
//            $prodModif->setId("INCONNU");
//            var_dump($prodModif);
//            //Suppression du produit inexistant
//            var_dump ($manager->delete($prodModif));
//            
//            echo "TEST DE LA CLASSE CLIENTMANAGER <br>";
//            echo "------------------------------------------------";
//            $manager = new clientManager(database::getDB());
//            
//            $cliTest = new client(
//                    "nom test",
//                    "prénom test",
//                    "rue test",
//                    "cptes",
//                    "ville test"
//                    );
//            //Ajout du nouveau client
//            var_dump ($manager->save($cliTest));
//            
//            //Méthodes de sélection de client(s)
//            var_dump ($manager->getList());
//            var_dump ($manager->getList("WHERE prenomCli='Jean'"));
//            var_dump ($manager->get(2));
//
//            //On veut modifier le client 8 déjà existant en base
//            $cliTest=$manager->get(8);
//            $cliTest->setNom("nom modifié");
//            $cliTest->setPrenom("prénom modifié");           
//            $manager->save($cliTest);
//            var_dump ($manager->getList());
//            
//            
//            //Suppression du client existant 6 sans commande
//            $cliTest=$manager->get(12);
//            var_dump ($manager->delete($cliTest));
//            
//            //Suppression du client existant 2 avec sa commande 4
//            $cliTest=$manager->get(2);
//            var_dump ($manager->delete($cliTest));
//            
//            $cliTest=$manager->get(6);
//            $cliTest->setId(83);
//            //Suppression du client inexistant 83
//            var_dump ($manager->delete($cliTest));
//
//            echo "TEST DE LA CLASSE COMMANDEMANAGER <br>";
//            echo "----------------------------------------------------------------------";            
//            $manager = new commandeManager(database::getDB());
//            
//            //Test de getCdesClient
//            $cliManager = new clientManager(database::getDB());
//            $client = $cliManager->get(3);
//            $tabCdes = $manager->getCdesClient($client);
//            var_dump($tabCdes);
//            
//            // Test de getList
//            $cdes = $manager->getList();
//            var_dump($cdes);
//            var_dump($cdes[18]->getProduits());
//            
//            $cdes = $manager->getList("WHERE etatCde LIKE '%préparation%'");
//            var_dump($cdes);            
//            var_dump($cdes[1]->getProduits());
//            
//            // Test de get
//            var_dump ($manager->get(1));
//                     
//            //Suppression de la commande existante 4
//            $cde = $manager->get(1);
//            var_dump ($manager->delete($cde));
//            
//            //Suppression de la commande inexistante 83
//            $cde = $manager->get(12);
//            $cde->setNum(83);
//            var_dump($manager->delete($cde));
//
//            //Enregistrement d'une nouvelle commande du client 2
//            $managerCli = new clientManager(database::getDB());
//            $leClient = $managerCli->get(3);
//            
//            $managerProd = new produitManager(database::getDB());
//            $prodCH = $managerProd->get("CHA-0001");
//            $prodTAB = $managerProd->get("TAB-0002");
//            
//            $cde = new commande($leClient);
//            $cde->addProduit($prodCH);
//            $cde->addProduit($prodTAB);
//            
//            var_dump($cde);
//                        
//            var_dump ($manager->save($cde));
//                       
//            //On veut modifier la commande 14 déjà existante en base
//            $cde = $manager->get(14);
//            echo "<br>*** commande AVANT modif **********************************<br>";
//            var_dump($cde);
//            
//            //On ajoute des produits à la commande
//            $managerProd = new produitManager(database::getDB());
//            $prodch1 = $managerProd->get("CHA-0001");
//            $prodch2 = $managerProd->get("CHA-0002");
//            $prodtab = $managerProd->get("TAB-0001");
//            $cde->removeProduit($prodtab);
//            $cde->addProduit($prodch1);
//            $cde->addProduit($prodch1);
//            $cde->addProduit($prodch2);
//            $cde->addProduit($prodch2);
//            
//            echo "<br>*** commande APRES modif **********************************<br>";
//            var_dump($cde);
//            $cde->setEtat("Modifiée");
//            
//            //On enregistre la commande modifiée
//            var_dump($manager->save($cde));
//               
        ?>
    </body>
</html>