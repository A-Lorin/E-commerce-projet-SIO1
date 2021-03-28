<?php

class ModeleNewsletter extends CI_Model {
   public function __construct()
   {
       $this->load->database();
   } 

   function ajouterNewsletter($pDonneesAInserer)
   {
      return $this->db->insert('Newsletter', $pDonneesAInserer);
   }

   function retournerNewsletter()
   {
      $requete = $this->db->get('Newsletter'); 
      return $requete->result(); 
   }

   function retournerNewsletterparmail($mail)
   {
      $requete = $this->db->get_where('Newsletter',array('EMAIL' => $mail));
      return $requete->row();
   }

   function supprimerNewsletter($mail)
   {
      $this->db->where('EMAIL', $mail);
      $this->db->delete('newsletter');
   }
}