<?php
/**
 * Classe de configuration de la base de données.
 * 
 * @author Ben
 */
class database
{   
    //Configuration de la Base de données
    private $serverName="localhost";
    private $serverPort="3306";
    private $databaseName="mgvpcdb";
    private $databaseUser="etudiant";
    private $databasePassword="etudiant";
    private $databaseCharset="UTF8";
    
    //Attribut de type instance de PDO
    private $db=null;
    
    private function __construct()
    {        
        $serverName = $this->serverName;
        $databasePort = $this->serverPort;
        $databaseName = $this->databaseName;
        $databaseUser = $this->databaseUser;
        $databasePassword = $this->databasePassword;
        $databaseCharset = $this->databaseCharset;
                
        if (!isset($this->db))
        {
            $this->db = new PDO('mysql:host='.$serverName.';port='.$databasePort.';dbname='.$databaseName.';charset='.$databaseCharset, $databaseUser, $databasePassword);
        }
    }
/**
 * 
 * Récupère une connexion à la base de données
 * 
 * @staticvar   database    Base de données
 * @return      PDO         Connexion PDO à la base de données
 */
    public static function getDB()
    {
        static $database = null;
        if (!isset($database))
        {
            $database = new database();
        }
        return $database->db;
    }
}
