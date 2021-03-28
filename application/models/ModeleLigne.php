<?php

class ModeleLigne extends CI_Model {
   public function __construct()
   {
       $this->load->database();
   } // __construct

   public function ajouterligne($pDonneesAInserer)
   {
      return $this->db->insert('ligne', $pDonneesAInserer);
   }

   public function retournerlignes($nocommande)
   {
      $this->db->where(array('NOCOMMANDE' => $nocommande));
      $this->db->join('produit', 'produit.noproduit = ligne.noproduit');
      $query= $this->db->get('ligne');
      return $query->result();
   }
} 