<?php

class ModeleClient extends CI_Model {
   public function __construct()
   {
       $this->load->database();
   } // __construct

   public function insererUnClient($pDonneesAInserer)
   {
      return $this->db->insert('CLIENT', $pDonneesAInserer);
   }

   public function retournerClient($mail, $MotdePasse)
   {
  $requete = $this->db->get_where('CLIENT',array('EMAIL' => $mail, 'MOTDEPASSE'=>$MotdePasse));
  return $requete->row();
   } 

   public function retournerClientParNo($noclient)
   {
  $requete = $this->db->get_where('CLIENT',array('NOCLIENT' => $noclient));
  return $requete->row(); 
   } 

   public function modifierCompteClient($pDonneesAInserer, $noclient)
   {
      $this->db->where('NOCLIENT', $noclient);
      $this->db->update('client', $pDonneesAInserer);
   }

   public function retournerClients()
   {
  $requete = $this->db->get('CLIENT');
  return $requete->result();
   } 

   public function retournerClientParMail($mail)
   {
      $requete = $this->db->get_where('CLIENT',array('EMAIL' => $mail));
      return $requete->row();
   } 
} 