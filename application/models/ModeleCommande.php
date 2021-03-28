<?php

class ModeleCommande extends CI_Model {
   public function __construct()
   {
       $this->load->database();
   } // __construct

   public function ajouterCommande($pDonneesAInserer)
   {
       $this->db->insert('commande', $pDonneesAInserer);
       return $this->db->insert_id();
   }

   public function retournerCommandesNonTraitée()
   {
       $this->db->where(array('DATETRAITEMENT' => NULL));
       $this->db->join('client', 'client.noclient = commande.noclient');
       $query=$this->db->get('commande');
       return $query->result();
   }

   public function retournerCommande($nocommande)
   {
       $this->db->where(array('NOCOMMANDE' => $nocommande));
       $this->db->join('client', 'client.noclient = commande.noclient');
       $query=$this->db->get('commande');
       return $query->row();
   }

   public function modifierCommande($nocommande,$pDonneesAInserer)
   {
    $this->db->where('NOCOMMANDE', $nocommande);
    $this->db->update('commande', $pDonneesAInserer);
   }

   public function retournerCommandeClient($noclient)
   {
    $this->db->where(array('commande.NOCLIENT' => $noclient));
    $this->db->join('client', 'client.noclient = commande.noclient');
    $query=$this->db->get('commande');
    return $query->result();
   }
      
} 