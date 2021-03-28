<?php
class ModeleCategorie extends CI_Model {
   public function __construct()
   {
      $this->load->database();
   }
   
   public function retournerCategories($pNoCategorie = FALSE)
   {
      if ($pNoCategorie === FALSE) 
      {   
          $this->db->from('categorie');
          $this->db->order_by('LIBELLE', 'ASC');
          $requete = $this->db->get();
          return $requete->result();
      }
      $requete = $this->db->get_where('categories', array('NOCATEGORIE' => $pNoCategorie));
      return $requete->row();
   }

   public function insererUneCategorie($pDonneesAInserer)
   {
      return $this->db->insert('categorie', $pDonneesAInserer);
   }
    
} 