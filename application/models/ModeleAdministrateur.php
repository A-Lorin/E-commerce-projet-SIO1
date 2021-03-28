<?php

class ModeleAdministrateur extends CI_Model {
   public function __construct()
   {
       $this->load->database();
   } 


   public function retournerAdministrateur($identifiant, $MotdePasse)
   {
  $requete = $this->db->get_where('administrateur',array('IDENTIFIANT' => $identifiant, 'MOTDEPASSE'=>$MotdePasse));
  return $requete->row(); 
   } 

   public function retournerAdminParid($idadmin)
   {
  $requete = $this->db->get_where('administrateur',array('IDENTIFIANT' => $idadmin));
  return $requete->row(); 
   } 

   public function modifierUnAdmin($idadmin,$pDonneesAInserer)
   {
      $this->db->where('IDENTIFIANT', $idadmin);
      $this->db->update('administrateur', $pDonneesAInserer);
   } 

   function ajouteradmin($pDonneesAInserer)
   {
      return $this->db->insert('administrateur', $pDonneesAInserer);
   }

   function retournerAdmins()
   {
      $requete = $this->db->get_where('administrateur',array('PROFIL' => 'Employé')); 
      return $requete->result(); 
   }

   function supprimerUnAdmin($admin)
   {
      $this->db->where('IDENTIFIANT', $admin);
      $this->db->delete('administrateur');
   }

   function retourneradminparmail($mail)
   {
      $requete = $this->db->get_where('administrateur',array('EMAIL' => $mail));
      return $requete->row();
   }

}