<?php
/**
 * Classe représentant les clients.
 * 
 * Les clients sont définis par :
 *     <br>- un id unique
 *     <br>- un nom
 *     <br>- un prénom
 *     <br>- une adresse (comprenant la rue, le code postal et la ville).
 *
 * @author Ben
 */
class client implements JsonSerializable {
    private $idCli="";
    private $nomCli="";
    private $prenomCli="";
    private $rueCli="";
    private $cpCli="";
    private $villeCli="";
 
    /**
     * Instancie un objet client.
     *  
     * @param string Nom du client.
     * @param string Prénom du client.
     * @param string Rue du client.
     * @param string Code postal du client.
     * @param string Ville du client.
     * 
     */
    public function __construct($nom, $pre, $rue, $cp, $vil){
        $this->nomCli = $nom;
        $this->prenomCli = $pre;
        $this->rueCli = $rue;
        $this->cpCli = $cp;
        $this->villeCli = $vil;
    }
    
    // Mutateurs chargés de modifier les attributs
    public function setId($id){$this->idCli = $id;}    
    public function setNom($n){$this->nomCli = $n;}
    public function setPrenom($p){$this->prenomCli = $p;}
    public function setRue($r){$this->rueCli = $r;}
    public function setCP($c){$this->cpCli = $c;}
    public function setVille($v){$this->villeCli = $v;}
    
    // Accesseurs chargés d'exposer les attributs
    public function getId(){return $this->idCli;}
    public function getNom(){return $this->nomCli;}
    public function getPrenom(){return $this->prenomCli;}
    public function getRue(){return $this->rueCli;}
    public function getCP(){return $this->cpCli;}
    public function getVille(){return $this->villeCli;}
    
    /**
     * Spécifie les données qui doivent être linéarisées en JSON.
     * 
     * Linéarise l'objet en une valeur qui peut être linéarisé nativement par la fonction json_encode().
     * 
     * @return mixed Retourne les données qui peuvent être linéarisées par la fonction json_encode()
     */
    public function jsonSerialize() {
        return [
            'id' => $this->idCli,
            'nom' => $this->nomCli,
            'prenom' => $this->prenomCli,
            'rue' => $this->rueCli,
            'cp' => $this->cpCli,
            'ville' => $this->villeCli
        ];
    }
}
