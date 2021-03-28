<?php

class ModeleAnnonce extends CI_Model {
   public function __construct()
   {
       $this->load->database();
   } 

   function ajouterAnnonce($pDonneesAInserer)
   {
      return $this->db->insert('annonce', $pDonneesAInserer);
   }

   function retournerAnnonce($noannonce=null)
   {
       if($noannonce==null)
       {
        $this->db->order_by('DATE_ANNONCE', 'DESC');
        $requete = $this->db->get('annonce'); 
        return $requete->result(); 
       }
       else
       {
        $requete = $this->db->get_where('annonce', array('NOANNONCE' => $noannonce));
        return $requete->row();
       }
    
   }

   function supprimerAnnonce($noannonce)
   {
      $this->db->where('NOANNONCE', $noannonce);
      $this->db->delete('annonce');
   }

   function getlastdate()
  {
   $this->db->limit(1, 0);
   $this->db->order_by("DaTE_ANNONCE", "DESC");
   $this->db->from('annonce');
   $requete = $this->db->get();
   return $requete->row(); 
  }

}