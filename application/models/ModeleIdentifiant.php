<?php

class ModeleIdentifiant extends CI_Model {
   public function __construct()
   {
       $this->load->database();
   } // __construct


   public function retournerIdentifiant()
   {
       $query=$this->db->get('identifiants_site');
       return $query->row();
   }

   public function modifierIdentifiant($noidentifiant,$pDonneesAInserer)
   {
    $this->db->where('NOIDENTIFIANT', $noidentifiant);
    $this->db->update('identifiants_site', $pDonneesAInserer);
   }
      
} 