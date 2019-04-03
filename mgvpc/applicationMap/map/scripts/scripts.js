
function ajouteLigne(){
    // création d'une nouvelle ligne dans la table
    var table=document.getElementById("boncom");
    var maLigne = table.insertRow(table.rows.length-6); //insérer avant les  dernières lignes
    
    // définition du contenu de cette ligne
    cellules="<td><img src=\"../images/suppLigne.png\" onclick=\"supprimeLigne(this.parentNode.parentNode);\"</td>";
    cellules+="<td><input class=\"ref\" type=\"text\" name=\"ref[]\" value=\"\" onchange=\"valideLigne(this);\" required/></td>";
    cellules+="<td><input class=\"des\" type=\"text\" name=\"des[]\" readonly/></td>";
    cellules+="<td><input class=\"qte\" type=\"text\" value=\"1\" name=\"qte[]\" readonly/></td>";
    cellules+="<td><input class=\"bpqte\" type=\"button\" value=\"-\" onclick=\"decQte(this.parentNode.parentNode);\"/></td>";
    cellules+="<td><input class=\"bpqte\" type=\"button\" value=\"+\" onclick=\"incQte(this.parentNode.parentNode);\"/></td>";            
    cellules+="<td><input class=\"prx\" type=\"text\" name=\"puht[]\" readonly onchange=\"calculLigneHT(this.parentNode.parentNode);\"/> €</td>";
    cellules+="<td><input class=\"ttl\" type=\"text\" name=\"ligneht[]\" readonly/> €</td>";        
    maLigne.innerHTML=cellules;
}

function incQte(tr) {
    oldQte = Number(tr.cells[3].childNodes[0].value);
    newQte = oldQte+1;
    tr.cells[3].childNodes[0].value = newQte;
    
    //Calcul du total ligne  
    calculLigneHT(tr);
}

function decQte(tr) {
    oldQte = Number(tr.cells[3].childNodes[0].value);
    newQte = oldQte-1;
    if (newQte<1) {
        newQte=1;        
    }
    tr.cells[3].childNodes[0].value = newQte;
    
    //Calcul du total ligne
    calculLigneHT(tr);
}

function supprimeLigne(tr) {
    //On supprime l'élément elt du DOM
    tr.remove();

    // Re-Calcul des totaux généraux
    calculTotaux();
}

function calculLigneHT(elt) {
    qte = parseFloat(elt.cells[3].childNodes[0].value);
    puht = parseFloat(elt.cells[6].childNodes[0].value);
    if (isNaN(puht)) {
        // pour éviter l'affichage de NaN si le prix n'est pas saisi
        elt.cells[7].childNodes[0].value=null;
    } else {
        //on arrondi à 2 chiffres après la virgule
        elt.cells[7].childNodes[0].value = Math.round(qte*puht*100)/100;
    }
    
    // Re-Calcul des totaux généraux
    calculTotaux();
}

function calculTotaux() {
    // On récupère dans un tableau les elt de class "ttl"
    var tabLignes = document.getElementsByClassName("ttl");

    // On parcours le tableau en cumulant la valeur
    var totht=0;
    for(var i= 0; i < tabLignes.length; i++) {
        var totligne = tabLignes[i].value;
        // si le total ligne contient une valeur on l'ajoute au cumul en cours
        if (totligne!=""){
            totht+=parseFloat(totligne);
        }
    }
    document.getElementById("totalht").value=Math.round(totht*100)/100+ " €";
    document.getElementById("totaltva").value=Math.round((totht*0.2)*100)/100+ " €";
    document.getElementById("totalttc").value=Math.round((totht*1.2*100))/100+ " €";
}

function valideLigne(input) {
    // On définit le modèle (pattern) à utiliser
    var modele = /[a-zA-Z]{3}-[0-9]{4}/;
    var saisie = input.value;
    var msg = document.getElementById("msgErreur");
    
    // Si la chaine saisie ne correspond pas au modèle
    if (modele.test(saisie)===false) {
        // On écrit un message d'erreur dans la zone de message
        msg.innerHTML = "<b> Erreur de saisie : </b>la référence produit doit être de la forme ABC-1234 ";
        msg.style.color = "#D80600";
        
        // On vide la zone de saisie et lui redonne le focus pour refaire la saisie
        input.value="";
        input.style.fontWeight = "normal";
        setTimeout(function () { input.focus(); },10);
    }
    else {
        // On efface le message d'erreur dans la zone de message
        msg.innerHTML = "";
        msg.style.color = "#000000";
        msg.style.backgroundColor = "white"; 
        
        // On met en majuscule et en gras la référence saisie
        var saisie = input.value;
        input.value = saisie.toUpperCase();
        input.style.fontWeight = "bold";
        
        //On appelle la fonction AJAX
        remplirLigneAuto(input);        
    }
}

function remplirLigneAuto(input)  {
    // Recuperation de la reference saisi dans une variable
    var ref = encodeURIComponent(input.parentNode.parentNode.getElementsByClassName("ref")[0].value);
    
    xhrLib = new XMLHttpRequest;
    xhrLib.open('POST', '../scripts/getInfoLibelle.php', true);
    xhrLib.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhrLib.onreadystatechange = function() {
        if((xhrLib.readyState === 4 && xhrLib.status === 200)) {
            var lib = xhrLib.responseText;
            input.parentNode.parentNode.getElementsByClassName("des")[0].value = lib;
            if (lib == ""){
                // On écrit un message d'erreur dans la zone de message
                var msg = document.getElementById("msgErreur");
                msg.innerHTML = "<b> Erreur de saisie : </b>la référence produit n'existe pas";
                msg.style.color = "#D80600";

                // On redonne le focus pour refaire la saisie
                input.style.fontWeight = "normal";
                setTimeout(function () { input.focus(); },10);
            }
        }
    };
    xhrLib.send('reference=' + ref);    
    
    xhrPx = new XMLHttpRequest;
    xhrPx.open('POST', '../scripts/getInfoPrix.php', true);
    xhrPx.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhrPx.onreadystatechange = function() {
        if((xhrPx.readyState === 4 && xhrPx.status === 200)) {
            var prx = xhrPx.responseText;
            input.parentNode.parentNode.getElementsByClassName("prx")[0].value = prx;            
            calculLigneHT(input.parentNode.parentNode);            
            calculTotaux();
        }
    };
    xhrPx.send('reference=' + ref);   
}

function trouveNomClient(input) {
    // Recuperation de la reference saisi dans une variable
    var numCli = encodeURIComponent(input.value);    
    msg = document.getElementById("msgClient");
    
    if (!isNaN(parseInt(numCli))) {
        xhr = new XMLHttpRequest;
        xhr.open('POST', '../scripts/getInfoClient.php', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if((xhr.readyState === 4 && xhr.status === 200)) {            
                var nom = xhr.responseText;
                if (nom != "") {
                    msg.innerHTML = "<b>" + nom + "</b>";
                    msg.style.color = "#04B431";
                }
                else {
                    msg.innerHTML = "Numéro client inconnu";
                    msg.style.color = "#D80600";
                    input.value = "";
                    setTimeout(function () { input.focus(); },10);
                }
            }
        };
        xhr.send('num=' + numCli);
    }
}