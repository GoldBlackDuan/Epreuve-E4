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
    private $id="";
    private $nom="";
    private $prenom="";
    private $rue="";
    private $cp="";
    private $ville="";
 
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
        $this->nom = $nom;
        $this->prenom = $pre;
        $this->rue = $rue;
        $this->cp = $cp;
        $this->ville = $vil;
    }
    
    // Mutateurs chargés de modifier les attributs
    public function setId($id){$this->id = $id;}    
    public function setNom($n){$this->nom = $n;}
    public function setPrenom($p){$this->prenom = $p;}
    public function setRue($r){$this->rue = $r;}
    public function setCP($c){$this->cp = $c;}
    public function setVille($v){$this->ville = $v;}
    
    // Accesseurs chargés d'exposer les attributs
    public function getId(){return $this->id;}
    public function getNom(){return $this->nom;}
    public function getPrenom(){return $this->prenom;}
    public function getRue(){return $this->rue;}
    public function getCP(){return $this->cp;}
    public function getVille(){return $this->ville;}
    
    /**
     * Spécifie les données qui doivent être linéarisées en JSON.
     * 
     * Linéarise l'objet en une valeur qui peut être linéarisé nativement par la fonction json_encode().
     * 
     * @return mixed Retourne les données qui peuvent être linéarisées par la fonction json_encode()
     */
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'rue' => $this->rue,
            'cp' => $this->cp,
            'ville' => $this->ville
        ];
    }
}