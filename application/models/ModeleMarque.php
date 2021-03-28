<?php
class ModeleMarque extends CI_Model {
   public function __construct()
   {
      $this->load->database();
      
   }
   
   public function retournerMarques($pNoMarque = FALSE)
   {
      if ($pNoMarque === FALSE) 
      {   
         $this->db->from('marque');
          $this->db->order_by('NOM', 'ASC');
          $requete = $this->db->get(); 
          return $requete->result(); 
      }
      $requete = $this->db->get_where('produit', array('NOMARQUE' => $pNoMarque));
      return $requete->row(); 
   } 

   public function insererUneMarque($pDonneesAInserer)
   {
      return $this->db->insert('marque', $pDonneesAInserer);
   } 

    
} 