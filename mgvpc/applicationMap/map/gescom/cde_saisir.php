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
        <h2>Saisie Bon de Commande</h2>
        <form action="cde_enregistrer.php" method="post">
            <table id="numCli">
                <tr>            
                    <td class="supp"></td>
                    <td width="100"><b>Numéro client </b></td><td><input onchange="trouveNomClient(this);" type="number" min="1" step="1" name="numCli" max="999999" style="text-align: center;width:80px;" required/></td>
                    <td id="msgClient"></td>
                </tr>
            </table>
            <table id="tabErreur">
                <tr>            
                    <td class="supp"></td>
                    <td height="20px" id="msgErreur"></td>
                </tr>
            </table>
            <table id="boncom">
                <tr>
                    <th></th><th>Référence</th><th>Désignation</th><th colspan='3'>Quantité</th><th>Prix UHT</th><th>Ligne HT</th>
                </tr>
                <tr>
                    <td class="supp"></td>
                    <td><input class="ref" type="text" name="ref[]" onchange="valideLigne(this);" required/></td> <!-- en HTML : pattern="[A-Za-z]{3}-[0-9]{5}" title="ABC-1234" -->
                    <td><input class="des" type="text" name="des[]" readonly/></td>
                    <td><input class="qte" type="text" name="qte[]" value="1" readonly/></td>
                    <td><input class="bpqte" type="button" value="-" onclick="decQte(this.parentNode.parentNode);"/></td>
                    <td><input class="bpqte" type="button" value="+" onclick="incQte(this.parentNode.parentNode);"/></td>            
                    <td><input class="prx" type="text" name="puht[]" readonly onchange="calculLigneHT(this.parentNode.parentNode);"/> €</td>
                    <td><input class="ttl" type="text" name="ligneht[]" readonly/> €</td>
                </tr>
                <tr>
                    <td class="supp"></td>
                    <td colspan="7"><input id="btaddline" type="button" value="Ajouter une ligne" onclick="ajouteLigne();" /></td>
                </tr>
                <!-- TOTAUX de fin de formulaire-->
                <tr>
                    <td class="supp"></td>
                    <td class="ref"></td>
                    <td class="des"></td>
                    <td class="qte"></td>
                    <td></td>
                    <td></td>             
                    <td class="libtotal">Total HT</td>
                    <td><input id="totalht" class="total" type="text" name="totalht" readonly  value="0 €"/></td>
                </tr>
                <tr>
                    <td class="supp"></td>
                    <td class="ref"></td>
                    <td class="des"></td>
                    <td class="qte"></td>
                    <td></td>
                    <td></td>            
                    <td class="libtotal">Taux TVA</td>
                    <td><input id="tauxtva" class="total" type="text" name="tauxtva" readonly  value="20%"/></td>
                </tr>
                <tr>
                    <td class="supp"></td>
                    <td class="ref"></td>
                    <td class="des"></td>
                    <td class="qte"></td>
                    <td></td>
                    <td></td>             
                    <td class="libtotal">Total TVA</td>
                    <td><input id="totaltva" class="total" type="text" name="totaltva" readonly value="0 €"/></td>
                </tr>
                <tr>
                    <td class="supp"></td>
                    <td class="ref"></td>
                    <td class="des"></td>
                    <td class="qte"></td>
                    <td></td>
                    <td></td>             
                    <td class="libtotalttc">Total TTC</td>
                    <td class="libtotalttc"><input id="totalttc" type="text" name="totalttc" readonly value="0 €"/></td>
                </tr>
                <tr>
                    <td class="supp"></td>
                    <td class="ref"></td>
                    <td class="des"></td>
                    <td class="qte"></td>
                    <td></td>
                    <td></td>             
                    <td colspan="2"><br><input class="btsub" type="submit" value="Valider la commande"/></td>
                </tr>
            </table>
        </form>

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