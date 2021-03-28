<?php
class ModeleProduit extends CI_Model {
   public function __construct()
   {
      $this->load->database();
     
   }

   public function retournerProduits($pNoArticle = FALSE)
   {
      if ($pNoArticle === FALSE) 
      {  
          $requete = $this->db->get('produit'); 
          return $requete->result(); 
      }
      $requete = $this->db->get_where('produit', array('NOPRODUIT' => $pNoArticle));
      return $requete->row();
   } 

   public function insererUnProduit($pDonneesAInserer)
   {
      return $this->db->insert('produit', $pDonneesAInserer);
   } 

   public function retounercategorie($nocategorie)
   {
      $requete=$this->db->get_where('categorie', array('NOCATEGORIE'=>$nocategorie));
      return $requete->row();
   }

   public function retounermarque($nomarque)
   {
      $requete=$this->db->get_where('marque', array('NOMARQUE'=>$nomarque));
      return $requete->row();
   }

   public function retournerProduitsLimite($nombreDeLignesARetourner, $noPremiereLigneARetourner)
   {
     $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
     $this->db->from("produit");
     $this->db->order_by("DATEAJOUT", "DESC");
     $requete = $this->db->get();
     return $requete->result(); 
   } 

   public function nombreDeProduit() { 
      return $this->db->count_all("produit");
     
   } 

   public function retournerVitrine()
   {
      $requete=$this->db->get_where('produit', array('VITRINE' => 1));
      return $requete->result();
   }

   public function retournerProduitParCategorie($nocategorie)
   {
      $requete=$this->db->get_where('produit', array('NOCATEGORIE' => $nocategorie));
      return $requete->result();
   }

   public function retournerProduitParCategorieLimite($nombreDeLignesARetourner, $noPremiereLigneARetourner, $nocategorie)
   {
     $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
     $requete=$this->db->get_where('produit', array('NOCATEGORIE' => $nocategorie));
      return $requete->result();
   }

   public function nombreDeProduitCategorie($nocategorie) { 
      $this->db->count_all_results('produit'); 
      $this->db->like('NOCATEGORIE', $nocategorie);
      $this->db->from('produit');
      return $this->db->count_all_results();
      
   } 
    

    function getnb_search($match) {
       $match=urldecode($match);
      $this->db->like('LIBELLE',$match,'both');
      $this->db->from('produit');
      return  $this->db->count_all_results();
    }

    function retournerProduitsearchLimite($nombreDeLignesARetourner, $noPremiereLigneARetourner,$match) 
    {
      $match=urldecode($match);
      $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
      $this->db->like('LIBELLE',$match,'both');
      $this->db->from('produit');
      $query = $this->db->get();
      return $query->result(); 
   }

   public function nombreDeProduitMarque($nomarque) 
   { 
   $this->db->count_all_results('produit');  
   $this->db->like('NOMARQUE', $nomarque);
   $this->db->from('produit');
   return $this->db->count_all_results();
   }

   public function retournerProduitParMarqueLimite($nombreDeLignesARetourner, $noPremiereLigneARetourner, $nomarque)
   {
     $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
     $requete=$this->db->get_where('produit', array('NOMARQUE' => $nomarque));
     return $requete->result();
   }

  function modifierDisponibilite($noproduit, $pDonneesAInserer)
  {
   $this->db->where('NOPRODUIT', $noproduit);
   $this->db->update('produit', $pDonneesAInserer);
  }

  function modifierproduit($noproduit, $pDonneesAInserer)
  {
   $this->db->where('NOPRODUIT', $noproduit);
   $this->db->update('produit', $pDonneesAInserer);
  }

  

  function retournerProduitsetcategorie()
  {
      $this->db->select('produit.LIBELLE,NOPRODUIT,DATEAJOUT,DETAIL,categorie.LIBELLE as nomcategorie');
      $this->db->join('categorie', 'categorie.nocategorie = produit.nocategorie');
      $requete = $this->db->get('produit'); 
       return $requete->result(); 
  }
} 