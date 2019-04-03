<?php
require_once ("database.class.php");

/**
 * Classe d'accès aux données concernant les clients.
 *
 * @author Ben
 */
class clientManager {
    
    private $db;
    
    /**
     * Instancie un objet clientManager.
     * 
     * Permet d'instanicer un objet clientManager qui nous permettra ensuite d'accéder aux données de la base spécifiée en paramètre.
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
     * Enregistre ou Modifie le client dans la base.
     * 
     * Pour enregistrer le client passé en paramètre en base de données :
     *      UPDATE si le client est déjà existant;
     *      INSERT sinon (si id non trouvé ou non spécifié).
     * 
     * @param produit Client à enregister ou mettre à jour.
     * 
     * @return int Retourne l'id du client ajouté ou mis à jour.
     */
    public function save(client $cli)
    {        
        $nbRows = 0;

        // le secteur que nous essayons de sauvegarder existe-t-il dans la  base de données ?
        if ($cli->getId()!=''){
            $query = "select count(*) as nb from `client` where `idCli`=?";
            $traitement = $this->db->prepare($query);
            $param1=$cli->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();
            $ligne = $traitement->fetch();
            $nbRows=$ligne[0];
        }
        
        // Si le secteur que nous essayons de sauvegarder existe dans la base de données : UPDATE
        if ($nbRows > 0)
        {
            $query = "update `client` set `nomCli`=?, `prenomCli`=?, `rueCli`=?, `cpCli`=?, `villeCli`=? where `idCli`=?;";
            $traitement = $this->db->prepare($query);
            $param1=$cli->getNom();
            $traitement->bindparam(1,$param1);
            $param2=$cli->getPrenom();
            $traitement->bindparam(2,$param2);
            $param3=$cli->getRue();
            $traitement->bindparam(3,$param3);
            $param4=$cli->getCP();
            $traitement->bindparam(4,$param4);
            $param5=$cli->getVille();
            $traitement->bindparam(5,$param5);
            $param6=$cli->getId();
            $traitement->bindparam(6,$param6);
            $traitement->execute();
        }
        // sinon : INSERT
        else
        {
            $query = "insert into `client` (`nomCli`, `prenomCli`,`rueCli`,`cpCli`,`villeCli`) values (?,?,?,?,?);";
            $traitement = $this->db->prepare($query);
            $param1=$cli->getNom();
            $traitement->bindparam(1,$param1);
            $param2=$cli->getPrenom();
            $traitement->bindparam(2,$param2);
            $param3=$cli->getRue();
            $traitement->bindparam(3,$param3);
            $param4=$cli->getCP();
            $traitement->bindparam(4,$param4);
            $param5=$cli->getVille();
            $traitement->bindparam(5,$param5);            
            $traitement->execute();
        }
        
        if ($cli->getId() == "")
        {
            $cli->setId($this->db->lastInsertId());
        }
        return $cli->getId();
    }

    /**
     * Supprime le client de la base.
     * 
     * Supprime de la base le client (table "client"), les commandes (table "commande") passées par celui-ci et les lignes de commandes associées (table "comporter").
     * 
     * @param produit Objet client devant être supprimé.
     * @return boolean Retourne TRUE si la suppression est un succès, FALSE sinon.
     */    
    public function delete(client $cli)
    {
        $nbRows = 0;

        // le client que nous essayons de supprimer existe-t-il dans la  base de données ?
        if ($cli->getId()!=''){                    
            $query = "select count(*) as nb from `client` where `idCli`=?";
            $traitement = $this->db->prepare($query);
            $param1 = $cli->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();
            $ligne = $traitement->fetch();
            $nbRows=$ligne[0];
        }

        // SI le client que nous essayons de supprimer existe dans bd
        // ALORS
        //      DELETE FROM comporter, commande, client
        //          et retourne TRUE
        if ($nbRows > 0)
        {            
            // DELETE FROM comporter
            $query = "DELETE FROM comporter WHERE numCde IN "
                    . "(Select numCde FROM commande WHERE idCliCde=?);";
            $traitement = $this->db->prepare($query);
            $param1 = $cli->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();
            
            // DELETE FROM commande
            $query = "DELETE FROM commande WHERE idCliCde=?;";
            $traitement = $this->db->prepare($query);
            $param1 = $cli->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();
            
            // DELETE FROM client
            $query = "DELETE FROM client WHERE idCli=?;";
            $traitement = $this->db->prepare($query);
            $param1 = $cli->getId();
            $traitement->bindparam(1,$param1);
            $traitement->execute();
            
            return true;
        }
        // SINON
        //      retourne FALSE
        else {
            return false;
        }
    }

    /**
     * Sélectionne un(des) client(s) dans la base.
     * 
     * Méthode générique de SELECT qui renvoie un tableau de client correspondant aux critères de sélection spécifiés.
     * Si aucun paramètre n'est précisé, la valeur par défaut du paramètre 'WHERE 1' permet d'obtenir tous les clients.
     * 
     * @param string Chaîne de caractère devant être une restriction SQL valide.
     * @return array Renvoie un tableau d'objet(s) client.
     */
    public function getList($restriction='WHERE 1')
    {
        $query = "select * from `client` ".$restriction.";";
        $cliList = Array();

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
            $cli = new client($row['nomCli'],$row['prenomCli'],$row['rueCli'],$row['cpCli'],$row['villeCli']);
            //positionnement de l'id
            $cli->setId($row['idCli']);
            //ajout de l'objet à la fin du tableau
            $cliList[] = $cli;
        }
        //retourne le tableau d'objets 'client'
        return $cliList;   
    }
    
    /**
     * Sélectionne un client dans la base.
     * 
     * Méthode de SELECT qui renvoie le client dont l'id est spécifié en paramètre.
     * 
     * @param int ID du client recherché
     * @return produit|boolean Renvoie l'objet client recherché ou FALSE s'il n'a pas été trouvé
     */
    public function get($id)
    {
        $query = "select * from `client` WHERE `idCli`=?;";

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
        if($row = $traitement->fetch()) {
            //On instancie un objet 'client' avec les valeurs récupérées
            //appel du constructeur paramétré
            $cli = new client($row['nomCli'],$row['prenomCli'],$row['rueCli'],$row['cpCli'],$row['villeCli']);
            //positionnement de l'id
            $cli->setId($row['idCli']);

            //retourne l'objet 'client' correpsondant
            return $cli;
        }
        else {
            return false;
        }
    }
    
}