<?php
/**
 * Classe représentant les catégories de produits.
 * 
 * Les catégorie sont définis par
 *      <br>- un id unique
 *      <br>- un numéro
 *      <br>- un libellé
 * 
 * @author Ben
 */
class categorie implements JsonSerializable {
    private $id;
    private $num;
    private $lib;

    /**
     * Instancie un objet categorie produit.
     * 
     * @param type Numéro de la catégorie
	 * @param type Libellé de la catégorie
     */    
    public function __construct($id, $num, $lib){
        $this->id = $id;
        $this->num = $num;
        $this->lib = $lib;
    }    

    // Mutateurs chargés de modifier les attributs
    public function setId($id){$this->id = $id;}    
    public function setNum($num){$this->num = $num;}
    public function setLib($lib){$this->lib = $lib;}
    
    // Accesseurs chargés d'exposer les attributs
    public function getId(){return $this->id;}
	public function getNum(){return $this->num;}
    public function getLib(){return $this->lib;}
    
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
            'num' => $this->num,
            'lib' => $this->lib
        ];
    }
    
}