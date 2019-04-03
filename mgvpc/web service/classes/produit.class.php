<?php
/**
 * Classe représentant les produits.
 * 
 * Les produits sont définis par
 *      <br>- un id unique
 *      <br>- un libellé
 *      <br>- une description
 *      <br>- un prix
 * 
 * @author Ben
 */
class produit implements JsonSerializable {
    private $id;
    private $lib;
    private $desc;
    private $prix;

    /**
     * Instancie un objet produit.
     * 
     * @param type Libellé du produit
     * @param type Description longue du produit
     * @param type Prix du produit
     */    
    public function __construct($id, $lib, $desc, $pri){
        $this->id = $id;
        $this->lib = $lib;
        $this->desc = $desc;
        $this->prix = $pri;
    }    

    // Mutateurs chargés de modifier les attributs
    public function setId($id){$this->id = $id;}    
    public function setLib($lib){$this->lib = $lib;}
    public function setDesc($desc){$this->desc = $desc;}
    public function setPrix($pri){$this->prix = $pri;}
    
    // Accesseurs chargés d'exposer les attributs
    public function getId(){return $this->id;}
    public function getLib(){return $this->lib;}
    public function getDesc(){return $this->desc;}
    public function getPrix(){return $this->prix;}
    
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
            'lib' => $this->lib,
            'desc' => $this->desc,
            'prix' => $this->prix
        ];
    }
    
}