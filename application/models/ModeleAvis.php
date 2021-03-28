<?php
class ModeleAvis extends CI_Model {
   public function __construct()
   {
      $this->load->database();
   }
   
   public function retournerAvis($noproduit,$noclient=false)
   {
      if($noclient==false)
      {
         $this->db->where(array('NOPRODUIT' => $noproduit));
         $this->db->join('client', 'client.noclient = avis.noclient');
         $this->db->order_by("DATEAVIS", "DESC");
         $requete = $this->db->get('avis');
         return $requete->result();
      }
      else
      {
         $this->db->where(array('NOPRODUIT' => $noproduit));
         $this->db->where(array('avis.NOCLIENT' => $noclient));
         $this->db->join('client', 'client.noclient = avis.noclient');
         $this->db->order_by("DATEAVIS", "DESC");
         $requete = $this->db->get('avis');
         return $requete->row();
      }
    
   }

   public function nombreAvisProduit($noproduit) { 
    $this->db->count_all_results('avis'); 
    $this->db->like('NOPRODUIT', $noproduit);
    $this->db->from('avis');
    return $this->db->count_all_results();
 } 

 public function moyenneNoteUser($noproduit) { 
   $this->db->select_avg('AVIS');
   $this->db->where(array('NOPRODUIT' => $noproduit));
   $query = $this->db->get('avis');
   return $query->row();
   
} 
 

   public function AjouterUnAvis($pDonneesAInserer)
   {
      return $this->db->insert('avis', $pDonneesAInserer);
   }

   public function modifierAvis($pDonneesAInserer, $noclient,$noproduit)
   {
      $this->db->where('NOCLIENT', $noclient);
      $this->db->where('NOPRODUIT', $noproduit);
      $this->db->update('avis', $pDonneesAInserer);
   }

   public function alreadybought($noclient,$noproduit)
   {
      $this->db->limit(1, 0);
      $this->db->where(array('NOPRODUIT' => $noproduit));
      $this->db->where(array('NOCLIENT' => $noclient));
      $this->db->join('commande', 'commande.nocommande = ligne.nocommande');
      $requete = $this->db->get('ligne');
      return $requete->row();
   }
    
} 