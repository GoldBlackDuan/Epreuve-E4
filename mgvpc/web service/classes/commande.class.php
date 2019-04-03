<?php
/**
 * Classe représentant les commandes.
 * 
 * Les commandes sont définis par
 *      <br>- un numéro unique
 *      <br>- une date
 *      <br>- un état
 *      <br>- un client (instance d'un objet client)
 *      <br>- un tabelau d'objet produit
 *      <br>- un tableau d'entier représentant les quantités
 * 
 * @author Ben
 */
class commande implements JsonSerializable {
    private $num;
    private $date;
    private $etat;
    private $client; // le client
    private $produits=array(); //un tableau d'objet produit
    private $quantites=array(); //un tableau de quantité

    /**
     * Instancie un objet commande.
     * 
     * @param client Client qui passe la commande.
     */
    public function __construct(client $client){
        $this->date = date('Y-m-d');
        $this->etat = "en attente";
        $this->client=$client;        
    }
    
    // Mutateurs chargés de modifier les attributs
    public function setNum($n){$this->num = $n;}    
    public function setDate($d){$this->date = $d;}
    public function setEtat($e){$this->etat = $e;}
    public function setClient($c){$this->client = $c;}
    
    // Accesseurs chargés d'exposer les attributs
    public function getNum(){return $this->num;}
    public function getDate(){return $this->date;}
    public function getEtat(){return $this->etat;}
    public function getClient(){return $this->client;}
    public function getProduits(){return $this->produits;}
    public function getQuantites(){return $this->quantites;}
    
    /**
     * Permet d'ajouter un produit à la commande.
     * 
     * @param produit Produit à ajouter à la commande.
     */
    public function addProduit(produit $prod){
        //On récupère l'id du produit
        $idP=$prod->getId();
        /* Si le produi est présent dans le tableau des quantités : */
        if (isset($this->quantites[$idP])) {
            /* MAJ de la quantité avec quantite[] */
            $this->quantites[$idP] += 1;        
        /* Sinon le produit doit être ajouté */
        } else {
            /* Ajout d’1 produit à la fin au tableau produits[] */        
            array_push($this->produits,$prod);
            $this->quantites[$idP] = 1;
        }
    }
    
    /**
     * Permet d'ajouter un produit à la commande dans une certaine quantité
     * 
     * @param produit Produit à ajouter à la commande.
     * @param int Quantité de produit à ajouter à la commande
     */
    public function addProduitQte(produit $prod, $qte){
        //On récupère l'id du produit
        $idP=$prod->getId();
        /* Si le produi est présent dans le tableau des quantités : */
        if (isset($this->quantites[$idP])) {
            /* MAJ de la quantité avec quantite[] */
            $this->quantites[$idP] += $qte;        
        /* Sinon le produit doit être ajouté */
        } else {
            /* Ajout d’1 produit à la fin au tableau produits[] */        
            array_push($this->produits,$prod);
            $this->quantites[$idP] = $qte;
        }
    }
    
    /**
     * Permet de retirer un produit de la commande.
     * 
     * Si la quantité de produit est supérieure à 1, on enlève 1 à la quantité existante.
     * Si le produit n'est présent dans la commande qu'en 1 seul exemplaire, on l'enlève complètement de la commande.
     * 
     * @param produit Produit à retirer de la commande.
     */
    public function removeProduit(produit $prod){
        //On récupère l'id du produit à retirer
        $idP=$prod->getId();
        // Si le produi est présent dans le tableau des quantités
        if (isset($this->quantites[$idP])) {
            // Si la quantité est supérieure à 1 : on enlève juste 1 exemplaire
            if ($this->quantites[$idP]>1) {
                $this->quantites[$idP] -= 1;
            }
            // Sinon la qté est 1  : le produit doit être enlevé
            else {                
                unset($this->quantites[$idP]);
                $index = array_search($prod, $this->produits);
                unset($this->produits[$index]); 
            }
            
                    
        
        } else {
                   
        }
    }
    
    /**
     * Permet de calculer le montant total de la commande.
     * 
     * @return float Montant total de la commande
     */
    public function getTotal(){
        // Calcul le montant total de la commande
        $total=0;
        // Parcours du tableau produits[]
        foreach($this->produits as $prod){
            //On trouve la quantité commandée de ce produit
            $qt=$this->quantites[$prod->getId()];
            //Cumul du total PU*Qte pour ce produit
            $total += $prod->getPrix() * $qt;
        }
        return $total;
    }
    
    /**
     * Spécifie les données qui doivent être linéarisées en JSON.
     * 
     * Linéarise l'objet en une valeur qui peut être linéarisé nativement par la fonction json_encode().
     * 
     * @return mixed Retourne les données qui peuvent être linéarisées par la fonction json_encode()
     */
    public function jsonSerialize() {
        return [
            'num' => $this->num,
            'date' => $this->date,
            'etat' => $this->etat,
            'idCli' => $this->client->getId(),
            'produits' => $this->produits,
            'quantites' => $this->quantites            
        ];
    }
}