<?php
require_once ("database.class.php");

/**
 * Classe d'accès aux données concernant les produits.
 * 
 * <br>TESTS :  OK
 * <br>DOC :    OK
 *
 * @author Ben
 */
class produitManager {
    
    private $db;
    
    /**
     * Instancie un objet produitManager.
     * 
     * Permet d'instanicer un objet produitManager qui nous permettra ensuite d'accéder aux données de la base spécifiée en paramètre.
     *  
     * @param database Instance de la classe database.
     */
    public function __construct($database)
    {
        //Dès le constructeur du manager on récupère la connection
        // à la base de données défini dans la classe database
        $this->db=$database;
    }    
    
    /**
     * Enregistre ou Modifie le produit dans la base.
     * 
     * Pour enregistrer le produit passé en paramètre en base de données :
     *      <br>UPDATE si le produit est déjà existant;
     *      <br>INSERT sinon (si id non trouvé ou non spécifié).
     * 
     * @param produit Produit à enregister ou mettre à jour.
     * 
     * @return int Retourne l'id du produit ajouté ou mis à jour.
     */
    public function save(produit $prod)
    {        
        $nbRows = 0;

        // le secteur que nous essayons de sauvegarder existe-t-il dans la  base de données ?
        if ($prod->getId()!=''){
            $query = "select count(*) as nb from `produit` where `idProd`=?";
            $traitement = $this->db->prepare($query);
            $param1=$prod->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();
            $ligne = $traitement->fetch();
            $nbRows=$ligne[0];
        }
        
        // Si le secteur que nous essayons de sauvegarder existe dans la base de données : UPDATE
        if ($nbRows > 0)
        {
            $query = "update `produit` set `libProd`=?, `descProd`=?, `prixProd`=? where `idProd`=?;";
            $traitement = $this->db->prepare($query);
            $param1=$prod->getLib();
            $traitement->bindparam(1,$param1);
            $param2=$prod->getDesc();
            $traitement->bindparam(2,$param2);
            $param3=$prod->getPrix();
            $traitement->bindparam(3,$param3);
            $param4=$prod->getId();
            $traitement->bindparam(4,$param4);
            $traitement->execute();
        }
        // sinon : INSERT
        else
        {
            $query = "insert into `produit` (`idProd`, `libProd`, `descProd`,`prixProd`) values (?,?,?,?);";
            $traitement = $this->db->prepare($query);
            $param1=$prod->getId();
            $traitement->bindparam(1,$param1);
            $param2=$prod->getLib();
            $traitement->bindparam(2,$param2);
            $param3=$prod->getDesc();
            $traitement->bindparam(3,$param3);
            $param4=$prod->getPrix();
            $traitement->bindparam(4,$param4);
            $traitement->execute();               
        }
        
        return $prod->getId();
    }

    /**
     * Supprime le produit de la base.
     * 
     * Supprime le produit de la base et les lignes de commandes associées de la table "comporter".
     * 
     * @param produit Produit devant être supprimé.
     * @return boolean Retourne true si la suppression est un succès, false sinon.
     */
    public function delete(produit $prod)
    {
        $nbRows = 0;

        // le produit que nous essayons de supprimer existe-t-il dans la  base de données ?
        if ($prod->getId()!=''){                    
            $query = "select count(*) as nb from `produit` where `idProd`=?";
            $traitement = $this->db->prepare($query);
            $param1 = $prod->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();
            $ligne = $traitement->fetch();
            $nbRows=$ligne[0];
        }

        // SI le produit que nous essayons de supprimer existe dans bd
        // ALORS
        //      DELETE FROM comporter, produit
        //          et retourne TRUE
        if ($nbRows > 0)
        {
            // DELETE FROM comporter
            $query = "DELETE FROM comporter WHERE `idProd`=?;";
            $traitement = $this->db->prepare($query);
            $param1 = $prod->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();
            
            // DELETE FROM produit
            $query = "delete from `produit` where `idProd`=?";
            $traitement = $this->db->prepare($query);
            $param1 = $prod->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();            
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Sélectionne un(des) produit(s) dans la base.
     * 
     * Méthode générique de SELECT qui renvoie un tableau de produit correspondant aux critères de sélection spécifiés.
     * Si aucun paramètre n'est précisé, la valeur par défaut du paramètre 'WHERE 1' permet d'obtenir tous les produits.
     * 
     * @param string Chaîne de caractère devant être une restriction SQL valide.
     * @return array Renvoie un tableau d'objet(s) produit.
     */
    public function getList($restriction='WHERE 1')
    {
        $query = "select * from `produit` ".$restriction.";";
        $prodList = Array();

        //execution de la requete
        try
        {
            $result = $this->db->Query($query);
        }
        catch(PDOException $e)
        {
            die ("Erreur : ".$e->getMessage());
        }

        //Parcours du jeu d'enregistrement
        while ($row = $result->fetch())
        {
            //appel du constructeur paramétré
            $produit = new produit($row['idProd'],$row['libProd'],$row['descProd'],$row['prixProd']);            
            //ajout de l'objet à la fin du tableau
            $prodList[] = $produit;
        }
        //retourne le tableau d'objets 'produit'
        return $prodList;   
    }
    
    /**
     * Sélectionne un produit dans la base.
     * 
     * Méthode de SELECT qui renvoie le produit dont l'id est spécifié en paramètre.
     * 
     * @param int ID du produit recherché
     * @return produit|boolean Renvoie l'objet produit recherché ou FALSE s'il n'a pas été trouvé
     */
    public function get($id)
    {
        $query = "select * from `produit` WHERE `idProd`=?;";

        //Connection et execution de la requete
        try
        {
            $traitement = $this->db->prepare($query);
            $traitement->bindparam(1,$id);
            $traitement->execute();
        }
        catch(PDOException $e)
        {
            die ("Erreur : ".$e->getMessage());
        }

        //On récupère la première et seule ligne du jeu d'enregistrement	
        if ($row = $traitement->fetch()) {
            //On instancie un objet 'produit' avec les valeurs récupérées
            $produit = new produit($row['idProd'],$row['libProd'],$row['descProd'],$row['prixProd']);
            //retourne l'objet 'produit' correpsondant
            return $produit;
        }
        else {
            return false;
        }
    }
    
}