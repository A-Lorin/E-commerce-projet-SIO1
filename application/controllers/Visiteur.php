<?php
class Visiteur extends CI_Controller {
   public function __construct()
   {
       parent::__construct();
       $this->load->helper('url');
       $this->load->helper('assets'); 
       $this->load->library("pagination");
       $this->load->model('ModeleProduit');
       $this->load->model('ModeleClient');
       $this->load->model('ModeleCategorie');
       $this->load->model('ModeleMarque');
       $this->load->model('ModeleAdministrateur');
       $this->load->model('ModeleNewsletter');
       $this->load->model('ModeleAnnonce');
       $this->load->model('ModeleAvis');

   }
   

   public function listerLesProduits() {
      $config = array();
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_tag_open'] = "<li class='page-item'>";
      $config['first_tag_close'] = "</li>&nbsp;"; 
      $config['prev_tag_open'] ="<li class='page-item'>"; 
      $config['prev_tag_close'] = "</li>&nbsp;";
      $config['next_tag_open'] = "<li class='page-item'>";
      $config['next_tag_close'] = "</li>&nbsp;";
      $config['last_tag_open'] = "<li class='page-item'>"; 
      $config['last_tag_close'] = "</li>&nbsp;";
      $config['cur_tag_open'] = "<li class='page-item purple'><a class='page-link purple' href=''>";
      $config['cur_tag_close'] = "</a></li>&nbsp;";
      $config['num_tag_open'] = "<li class='page-item'>";
      $config['num_tag_close'] = "</li>&nbsp;";
      $config['attributes'] = array('class' => 'page-link');

      $config["base_url"] = site_url('visiteur/listerLesProduits');
      $config["total_rows"] = $this->ModeleProduit->nombreDeProduit();
      $config["per_page"] = 12;
      $config["uri_segment"] = 3;
      $config['first_link'] = 'Premier';
      $config['last_link'] = 'Dernier';
      $config['next_link'] = '<i class="fas fa-long-arrow-alt-right"></i> Suivant';
      $config['prev_link'] = '<i class="fas fa-long-arrow-alt-left"></i> Précédent';
      $config['num_links'] = 2;
      $config['use_page_numbers'] = TRUE;
      $this->pagination->initialize($config);
      $page_num = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      $noPage = ($page_num - 1) * $config['per_page'];
      if($noPage<0){$noPage=0;}
      $DonneesInjectees['TitreDeLaPage'] = 'Nos produits';
      $DonneesInjectees['categories'] = $this->ModeleCategorie->retournerCategories();
      $DonneesInjectees['marques'] = $this->ModeleMarque->retournerMarques();
      $DonneesInjectees["lesProduits"] = $this->ModeleProduit->retournerProduitsLimite($config["per_page"], $noPage);
      $DonneesInjectees["liensPagination"] = $this->pagination->create_links();
      $this->load->view('templates/Entete',$DonneesInjectees);
      $this->load->view("visiteur/listerLesProduits", $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
   } 



   public function voirUnProduit($noProduit = NULL)
{
   $this->load->helper('form');
   $this->load->library('form_validation');
   $produit=$this->ModeleProduit->retournerProduits($noProduit);
   $DonneesInjectees['unProduit'] = $this->ModeleProduit->retournerProduits($noProduit);
   $DonneesInjectees['LesAvis'] = $this->ModeleAvis->retournerAvis($noProduit);
   $DonneesInjectees['nbavis'] = $this->ModeleAvis->nombreAvisProduit($noProduit);
   $DonneesInjectees['avgrating'] = $this->ModeleAvis->moyenneNoteUser($noProduit);
   if($this->session->id!=null){$monAvis= $this->ModeleAvis->retournerAvis($noProduit,$this->session->id); $alreadybought=$this->ModeleAvis->alreadybought($this->session->id,$noProduit);
   if($monAvis==null){$DonneesInjectees['monAvis']=false;}else{$DonneesInjectees['monAvis']=$monAvis;}
   if($alreadybought!=null){$DonneesInjectees['achat']=$alreadybought;}}

   
   
   
   
   if (empty($DonneesInjectees['unProduit'])) 
   {  
      redirect('Visiteur/erreur404','refresh');
   }
             
   $DonneesInjectees['TitreDeLaPage'] = $DonneesInjectees['unProduit']->LIBELLE;
   $categorie=$produit->NOCATEGORIE;
   $DonneesInjectees['categorie'] = $this->ModeleProduit->retounercategorie($categorie);
   $marque=$produit->NOMARQUE;
   $DonneesInjectees['marque'] = $this->ModeleProduit->retounermarque($marque);
   $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
   $this->load->view('templates/Entete',$DonneesCategorie);
   $this->load->view('visiteur/VoirUnProduit', $DonneesInjectees);
   $this->load->view('templates/PiedDePage');
} 

public function senregistrer()
   {

       $this->load->helper('form');
       $this->load->library('form_validation');
       $DonneesInjectees['TitreDeLaPage'] = "S'enregister";
       $this->form_validation->set_rules('txtNom', 'Nom', 'required');
       $this->form_validation->set_rules('txtPrenom', 'Prenom', 'required');
       $this->form_validation->set_rules('txtAdresse', 'Adresse', 'required');
       $this->form_validation->set_rules('txtVille', 'Ville', 'required');
       $this->form_validation->set_rules('txtCP', 'CP', 'required');
       $this->form_validation->set_rules('txtEmail', 'Email', 'required');
       $this->form_validation->set_rules('txtMdp', 'Mdp', 'required');
       $DonneesInjectees['mailErr'] = null;
       $DonneesInjectees['nomErr'] =null;
       $DonneesInjectees['prenomErr'] =null;
       $DonneesInjectees['adresseErr'] =null;
       $DonneesInjectees['villeErr'] =null;
       $DonneesInjectees['CPErr'] =null;

      if ($this->form_validation->run() === FALSE){ 
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
           $this->load->view('visiteur/senregistrer', $DonneesInjectees);
           $this->load->view('templates/PiedDePage');
      }
      elseif (!filter_var($this->input->post('txtEmail'), FILTER_VALIDATE_EMAIL) 
      OR (!preg_match("/^[a-zA-Zéèêëçàâôù ûïî]*$/",$this->input->post('txtNom'))) 
      OR (!preg_match("/^[a-zA-Zéèêëçàâôù ûïî]*$/",$this->input->post('txtPrenom')))
      OR (!preg_match("/^[a-zA-Z0-9 '-]*?[a-zA-Zéèêëçàâôù ûïî-]+$/",$this->input->post('txtAdresse')))
      OR (!preg_match("/^[a-zA-Zéèêëçàâôùûïî-]+$/",$this->input->post('txtVille')))
      OR (!preg_match("/^[0-9]{5,5}$/",$this->input->post('txtCP')))
      OR $this->ModeleClient->retournerClientParMail($this->input->post('txtEmail'))!=null
      )
      {
         if(!filter_var($this->input->post('txtEmail'), FILTER_VALIDATE_EMAIL)){$DonneesInjectees['mailErr'] = 'Mail non valide';}
         if (!preg_match("/^[a-zA-Zéèêëçàâôù ûïî]*$/",$this->input->post('txtNom'))) {$DonneesInjectees['nomErr'] = 'Charactère non autoriser dans le champ "nom"';}
         if (!preg_match("/^[a-zA-Zéèêëçàâôù ûïî]*$/",$this->input->post('txtPrenom'))) {$DonneesInjectees['prenomErr'] = 'Charactère non autoriser dans le champ "prénom"';}
         if (!preg_match("/^[a-zA-Z0-9 '-]*?[a-zA-Zéèêëçàâôù ûïî-]+$/",$this->input->post('txtAdresse'))) {$DonneesInjectees['adresseErr'] = 'Charactère non autoriser dans le champ "adresse"';}
         if (!preg_match("/^[a-zA-Zéèêëçàâôùûïî-]+$/",$this->input->post('txtVille'))) {$DonneesInjectees['villeErr'] = 'Charactère non autoriser dans le champ "ville"';}
         if (!preg_match("/^[0-9]{5,5}$/",$this->input->post('txtCP'))) {$DonneesInjectees['CPErr'] = 'Charactère non autoriser dans le champ "Code Postal"';}
         if ($this->ModeleClient->retournerClientParMail($this->input->post('txtEmail'))!=null) {$DonneesInjectees['mailErr'] = 'Mail déjà utilisé';}
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
         $this->load->view('visiteur/senregistrer', $DonneesInjectees);
         $this->load->view('templates/PiedDePage');
      } 
       else
       {
          $donneesAInserer = array(
            'NOM' => ucfirst(strtolower($this->input->post('txtNom'))),
             'PRENOM' => ucfirst(strtolower($this->input->post('txtPrenom'))),
             'ADRESSE' => $this->input->post('txtAdresse'),
            'VILLE' => strtoupper($this->input->post('txtVille')),
             'CODEPOSTAL' => $this->input->post('txtCP'),
            'EMAIL' => $this->input->post('txtEmail'),
            // 'MOTDEPASSE' => $this->input->post('txtMdp'),
             'MOTDEPASSE' => password_hash($this->input->post('txtMdp'), PASSWORD_DEFAULT),
            ); 
          $donnees['nbDeLignesAffectees']=$this->ModeleClient->insererUnClient($donneesAInserer);
          $donnees['nom']=$this->input->post('txtNom');
          $donnees['prenom']=$this->input->post('txtPrenom');
          $this->load->helper('url'); 
          
          redirect('visiteur/listerLesProduits','refresh');
          
       } 
   } 
  
public function seConnecter()
{
   $this->load->helper('form');
   $this->load->library('form_validation');
   $DonneesInjectees['TitreDeLaPage'] = 'Se connecter';
   $this->form_validation->set_rules('txtEmail', 'Email', 'required');
   $this->form_validation->set_rules('txtMdp', 'Mot de passe', 'required');
   if ($this->form_validation->run() === FALSE) 
   {   
       $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
       $this->load->view('templates/Entete',$DonneesCategorie);
       $this->load->view('visiteur/seConnecter', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
   }
   else
   {   
       $Identifiant = $this->input->post('txtEmail');
       $MdP = $this->input->post('txtMdp');
       $UtilisateurRetourne = $this->ModeleClient->retournerClientParMail($Identifiant);
       
      if(!$UtilisateurRetourne==null)
       {
         if (password_verify($MdP,$UtilisateurRetourne->MOTDEPASSE))
         {
          if(!empty($this->session->statut))
          {
            $this->cart->destroy();
          }
            $this->session->id = $UtilisateurRetourne->NOCLIENT;
            $this->session->statut = 1; 
            
            redirect('Visiteur/accueil');
         }
         else
         {
         $DonneesInjectees['erreur']='Mot de passe incorrecte';
          $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
          $this->load->view('templates/Entete',$DonneesCategorie);
          $this->load->view('visiteur/seConnecter', $DonneesInjectees);
          $this->load->view('templates/PiedDePage');
         }
      }

       /*
       $UtilisateurRetourne = $this->ModeleClient->retournerClient($Identifiant, $MdP);
       if (!($UtilisateurRetourne == null)) 
       {       
          $this->session->id = $UtilisateurRetourne->NOCLIENT;
          $this->session->statut = 1;
          $DonneesInjectees['Identifiant'] = $UtilisateurRetourne->NOM;; 
          $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
          $this->load->view('templates/Entete',$DonneesCategorie);
          $this->load->view('visiteur/connexionReussie', $DonneesInjectees);
          $this->load->view('templates/PiedDePage');
       }
       else
       {  
          $DonneesInjectees['erreur']='Adresse E-mail incorrecte';
          $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
          $this->load->view('templates/Entete',$DonneesCategorie);
          $this->load->view('visiteur/seConnecter', $DonneesInjectees);
          $this->load->view('templates/PiedDePage');
      }*/
   }
} 



public function ajouterAuPanier($noproduit){
   $produit = $this->ModeleProduit->retournerProduits($noproduit);
   $data = array(
       'id'    => $produit->NOPRODUIT,
       'qty'    => 1,
       'price'    => ($produit->PRIXHT)+($produit->TAUXTVA),
       'ht' => $produit->PRIXHT,
       'tva' => $produit->TAUXTVA,
       'name'    => $produit->LIBELLE,
       'image' => $produit->NOMIMAGE,
       'maxi' => $produit->QUANTITEENSTOCK
   );
   $this->cart->insert($data);
   redirect('Visiteur/afficherPanier');
}

function afficherPanier()
{
   $this->load->helper('form');
        $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
   $this->load->view('templates/Entete',$DonneesCategorie);
   $this->load->view('visiteur/afficherPanier');
   $this->load->view('templates/PiedDePage');
}

function removeItem($rowid){
   $remove = $this->cart->remove($rowid);
   redirect('visiteur/afficherPanier');
}

public function updateCart()
{

 $i = 1;
 for ($i=1; $i<=$this->cart->total_items();$i++)
 {
   $data = array(
      'rowid' => $this->input->post($i.'[rowid]'),
      'qty'   =>  $this->input->post($i.'[qty]')
   );
   $this->cart->update($data);
}
    redirect('Visiteur/afficherPanier');
}

function validationCommande()
{
   $this->load->helper('form');
   $DonneesInjectees['panier'] = $this->cart->contents();
   $DonneesInjectees['client']= $this->ModeleClient->retournerClientParNo($this->session->id);
   $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
   $this->load->view('templates/Entete',$DonneesCategorie);
   $this->load->view('Client/validationCommande', $DonneesInjectees);
   $this->load->view('templates/PiedDePage');
}

   public function accueil(){  
      $this->load->helper('form');
      $DonneesInjectees['vitrines'] = $this->ModeleProduit->retournerVitrine();
      $DonneesInjectees['categories'] = $this->ModeleCategorie->retournerCategories();
      $DonneesInjectees['marques'] = $this->ModeleMarque->retournerMarques();
      $this->load->view('templates/Entete',$DonneesInjectees);
      $this->load->view('visiteur/accueil', $DonneesInjectees);   
   $this->load->view('templates/PiedDePage');


      }  
    
    public function afficherproduitparcategorie($nocategorie)
    {
       $categorie=$this->ModeleProduit->retounercategorie($nocategorie);
      $DonneesInjectees['lesProduits'] = $this->ModeleProduit->retournerProduitParCategorie($nocategorie);
      $DonneesInjectees['TitreDeLaPage']=$categorie->LIBELLE;
      $this->load->view('templates/Entete');
      $this->load->view('visiteur/categorie', $DonneesInjectees);   
   $this->load->view('templates/PiedDePage');
    }

    public function listerLesProduitsparcategorie($nocategorie=false) 
    {
       if($nocategorie==false){redirect('visiteur/listerLesProduits');}else{
      $config = array();
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_tag_open'] = "<li class='page-item'>";
      $config['first_tag_close'] = "</li>&nbsp;"; 
      $config['prev_tag_open'] ="<li class='page-item'>"; 
      $config['prev_tag_close'] = "</li>&nbsp;";
      $config['next_tag_open'] = "<li class='page-item'>";
      $config['next_tag_close'] = "</li>&nbsp;";
      $config['last_tag_open'] = "<li class='page-item'>"; 
      $config['last_tag_close'] = "</li>&nbsp;";
      $config['cur_tag_open'] = "<li class='page-item purple'><a class='page-link purple' href=''>";
      $config['cur_tag_close'] = "</a></li>&nbsp;";
      $config['num_tag_open'] = "<li class='page-item'>";
      $config['num_tag_close'] = "</li>&nbsp;";
      $config['attributes'] = array('class' => 'page-link');

      $config["base_url"] = site_url('visiteur/listerLesProduitsparcategorie/'.$nocategorie.'');
      $config["total_rows"] = $this->ModeleProduit->nombreDeProduitCategorie($nocategorie);
      $config["per_page"] = 12; 
      $config["uri_segment"] = 4; 
      $config['first_link'] = 'Premier';
      $config['last_link'] = 'Dernier';
      $config['next_link'] = '<i class="fas fa-long-arrow-alt-right"></i> Suivant';
      $config['prev_link'] = '<i class="fas fa-long-arrow-alt-left"></i> Précédent';
      $config['num_links'] = 2;
      $config['use_page_numbers'] = TRUE;
      $this->pagination->initialize($config);
      $page_num = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $noPage = ($page_num - 1) * $config['per_page'];
      if($noPage<0){$noPage=0;}
      $categorie=$this->ModeleProduit->retounercategorie($nocategorie);
      $DonneesInjectees['TitreDeLaPage'] = $categorie->LIBELLE;
      $DonneesInjectees['categories'] = $this->ModeleCategorie->retournerCategories();
      $DonneesInjectees["lesProduits"] = $this->ModeleProduit->retournerProduitParCategorieLimite($config["per_page"], $noPage, $nocategorie);
      $DonneesInjectees["liensPagination"] = $this->pagination->create_links();
      $this->load->view('templates/Entete',$DonneesInjectees);
      $this->load->view("visiteur/listerLesProduits", $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
      } 
   }

   public function connexionAdministrateur()
{
   $this->load->helper('form');
   $this->load->library('form_validation');
   $DonneesInjectees['TitreDeLaPage'] = 'Administration';
   $this->form_validation->set_rules('txtIdentifiant', 'Identifiant', 'required');
   $this->form_validation->set_rules('txtMotDePasse', 'Mot de passe', 'required');
   if ($this->form_validation->run() === FALSE) 
   {   
       $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
       $this->load->view('templates/Entete',$DonneesCategorie);
       $this->load->view('visiteur/connexionAdministrateur', $DonneesInjectees); 
       $this->load->view('templates/PiedDePage');
   }
   else
   {
       $Identifiant = $this->input->post('txtIdentifiant');
       $MdP = $this->input->post('txtMotDePasse');
       $adminRetourne =$this->ModeleAdministrateur->retournerAdminParid($Identifiant);
       if(!$adminRetourne==null)
       {
         if (password_verify($MdP,$adminRetourne->MOTDEPASSE))
         {
          $this->session->identifiant = $adminRetourne->IDENTIFIANT;
          $this->session->mail = $adminRetourne->EMAIL;
          if($adminRetourne->PROFIL=='Employé')
          {
            $this->session->statut = 2;
          }
          elseif ($adminRetourne->PROFIL=='Super') 
          {
           $this->session->statut = 3;
          }
          $this->cart->destroy();
          redirect('Visiteur/accueil');
         }
         else
         {
         $DonneesInjectees['erreur']='Mot de passe incorrecte';
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
         $this->load->view('visiteur/connexionAdministrateur', $DonneesInjectees);
         $this->load->view('templates/PiedDePage');
         }
       }
       /*
       $adminRetourne = $this->ModeleAdministrateur->retournerAdministrateur($Identifiant, $MdP);
       if (!($adminRetourne == null)) 
       {  
          $this->session->identifiant = $adminRetourne->IDENTIFIANT;
          $this->session->mail = $adminRetourne->EMAIL;
          if($adminRetourne->PROFIL=='Employé')
          {
            $this->session->statut = 2;
          }
          elseif ($adminRetourne->PROFIL=='Super') 
          {
           $this->session->statut = 3;
          }
          $DonneesInjectees['Identifiant'] = $Identifiant; 
          $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
          $this->load->view('templates/Entete',$DonneesCategorie);
          $this->load->view('visiteur/connexionReussie', $DonneesInjectees);
          $this->load->view('templates/PiedDePage');
       }*/
       else
       { 
         $DonneesInjectees['erreur']='Identifiant incorrecte';
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
         $this->load->view('visiteur/connexionAdministrateur', $DonneesInjectees);
         $this->load->view('templates/PiedDePage');
       } 
      }
}

   

   public function recherche($match=false)
   {
      if (empty($match))
      {
         $match = $this->input->post('search');
         if($match==null)
         {
            redirect('Visiteur/listerLesProduits');
         }
         else
         {
            $match= urlencode($match);
            redirect('Visiteur/recherche/'.$match);
         }
      }
      else{
      $config = array();
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_tag_open'] = "<li class='page-item'>";
      $config['first_tag_close'] = "</li>&nbsp;"; 
      $config['prev_tag_open'] ="<li class='page-item'>"; 
      $config['prev_tag_close'] = "</li>&nbsp;";
      $config['next_tag_open'] = "<li class='page-item'>";
      $config['next_tag_close'] = "</li>&nbsp;";
      $config['last_tag_open'] = "<li class='page-item'>"; 
      $config['last_tag_close'] = "</li>&nbsp;";
      $config['cur_tag_open'] = "<li class='page-item purple'><a class='page-link purple' href=''>";
      $config['cur_tag_close'] = "</a></li>&nbsp;";
      $config['num_tag_open'] = "<li class='page-item'>";
      $config['num_tag_close'] = "</li>&nbsp;";
      $config['attributes'] = array('class' => 'page-link');

      $config["base_url"] = site_url('visiteur/recherche/'.$match.'');
      $config["total_rows"] = $this->ModeleProduit->getnb_search($match);
      $config["per_page"] = 12;
      $config["uri_segment"] = 4;
      $config['first_link'] = 'Premier';
      $config['last_link'] = 'Dernier';
      $config['next_link'] = '<i class="fas fa-long-arrow-alt-right"></i> Suivant';
      $config['prev_link'] = '<i class="fas fa-long-arrow-alt-left"></i> Précédent';
      $config['num_links'] = 2;
      $config['use_page_numbers'] = TRUE;
      $page_num = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $noPage = ($page_num - 1) * $config['per_page'];
      if($noPage<0){$noPage=0;}
      $this->pagination->initialize($config);
      $DonneesInjectees['categories'] = $this->ModeleCategorie->retournerCategories();
      $DonneesInjectees['TitreDeLaPage'] = 'recherche';
      $DonneesInjectees["lesProduits"] = $this->ModeleProduit->retournerProduitsearchLimite($config["per_page"], $noPage,$match);
      $DonneesInjectees["liensPagination"] = $this->pagination->create_links();
      $this->load->view('templates/Entete',$DonneesInjectees);
      $this->load->view("visiteur/listerLesProduits", $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
      }
   }
   public function listerLesProduitsparmarque($nomarque=false) 
    {
       if($nomarque==false){redirect('visiteur/listerLesProduits');}else{
      $config = array();
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_tag_open'] = "<li class='page-item'>";
      $config['first_tag_close'] = "</li>&nbsp;"; 
      $config['prev_tag_open'] ="<li class='page-item'>"; 
      $config['prev_tag_close'] = "</li>&nbsp;";
      $config['next_tag_open'] = "<li class='page-item'>";
      $config['next_tag_close'] = "</li>&nbsp;";
      $config['last_tag_open'] = "<li class='page-item'>"; 
      $config['last_tag_close'] = "</li>&nbsp;";
      $config['cur_tag_open'] = "<li class='page-item purple'><a class='page-link purple' href=''>";
      $config['cur_tag_close'] = "</a></li>&nbsp;";
      $config['num_tag_open'] = "<li class='page-item'>";
      $config['num_tag_close'] = "</li>&nbsp;";
      $config['attributes'] = array('class' => 'page-link');
      
      $config["base_url"] = site_url('visiteur/listerLesProduitsparmarque/'.$nomarque.'');
      $config["total_rows"] = $this->ModeleProduit->nombreDeProduitMarque($nomarque);
      $config["per_page"] = 12;
      $config["uri_segment"] = 4;
      $config['first_link'] = 'Premier';
      $config['last_link'] = 'Dernier';
      $config['next_link'] = '<i class="fas fa-long-arrow-alt-right"></i> Suivant';
      $config['prev_link'] = '<i class="fas fa-long-arrow-alt-left"></i> Précédent';
      $config['num_links'] = 2;
      $config['use_page_numbers'] = TRUE;
      $this->pagination->initialize($config);
      $page_num = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $noPage = ($page_num - 1) * $config['per_page'];
      if($noPage<0){$noPage=0;}
      $marque=$this->ModeleProduit->retounermarque($nomarque);
      $DonneesInjectees['lamarque'] = $marque->NOM;
      $DonneesInjectees['TitreDeLaPage'] = $marque->NOM;
      $DonneesInjectees['categories'] = $this->ModeleCategorie->retournerCategories();
      $DonneesInjectees["lesProduits"] = $this->ModeleProduit->retournerProduitParMarqueLimite($config["per_page"], $noPage, $nomarque);
      $DonneesInjectees["liensPagination"] = $this->pagination->create_links();
      $this->load->view('templates/Entete', $DonneesInjectees);
      $this->load->view("visiteur/listerLesProduits", $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
      } 
   }

   /*function exemple()
   {
      $this->load->helper('form');
      $this->load->view('visiteur/exemple');
   }*/

   function ajoutnewsletter()
   { 
      $this->load->library('user_agent');
      $mail=$this->input->post('mailnewsletter');
      if(!filter_var($mail, FILTER_VALIDATE_EMAIL))
      {
         echo'<script language=javascript>
         alert("Cette adresse mail n\'est pas valide");
         </script> ';
         redirect($this->agent->referrer(),'refresh');
      }
      elseif($this->ModeleNewsletter->retournerNewsletterparmail($mail)!=null)
      {
        $this->ModeleNewsletter->supprimerNewsletter($mail);
         echo'<script language=javascript>
         alert("Vous êtes désormais désinscrit de notre newsletter");
         </script> ';
         redirect($this->agent->referrer(),'refresh');
      }
      else
      {
      $donneesAInserer=array(
         'EMAIL'    => $mail
     );
     $this->ModeleNewsletter->ajouterNewsletter($donneesAInserer);

     $this->load->library('email');
   $user=$this->ModeleClient->retournerClientParNo($this->session->id);

   
   $this->email->set_mailtype("html");
   $this->email->from('Dupont@yopmail.com', 'Dupont');
   $this->email->to($mail);

   $this->email->subject('Newsletter');
   $message= '
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title>
  </head>
  <body>
    <header class="clearfix">
    <div id="logo">
    <img class="d-block" style="height:64px;" src="'.base_url()."assets/images/logo".'" alt="Logo">
      </div>
      <div id="company">
        <h2 class="name">M.Dupont\'s Shop</h2>
        <div>8, Rue Rabelais, 22000 Saint Brieuc</div>
        <div>02 96 68 32 89</div>
        <div><a href="mailto:Dupont@yopmail.com">Dupont@yopmail.com</a></div>
      </div>
      </div>
    </header>
    <main>
    <h2>Merci de vous être inscrit à notre newsletter!</h2><hr/>
      Vous pouvez vous désinscrire de la newsletter à tout moment pour ce faire, suivez les même étapes que lors de l\'inscrition à celle-ci..<hr/>


      <div id="thanks">Merci!</div>
      <div id="notices">
    </main>
  </body>
</html>
<style>
@font-face {
   font-family: SourceSansPro;
   src: url(SourceSansPro-Regular.ttf);
 }
 
 .clearfix:after {
   content: "";
   display: table;
   clear: both;
 }
 
 a {
   color: #0087C3;
   text-decoration: none;
 }
 
 body {
   position: relative;
   width: 21cm;  
   height: 29.7cm; 
   margin: 0 auto; 
   color: #555555;
   background: #FFFFFF; 
   font-family: Arial, sans-serif; 
   font-size: 14px; 
   font-family: SourceSansPro;
 }
 
 header {
   padding: 10px 0;
   margin-bottom: 20px;
   border-bottom: 1px solid #AAAAAA;
 }
 
 #logo {
   float: left;
   margin-top: 8px;
 }
 
 #logo img {
   height: 70px;
 }
 
 #company {
   float: right;
   text-align: right;
 }
 
 
 #details {
   margin-bottom: 50px;
 }
 
 #client {
   padding-left: 6px;
   border-left: 6px solid #0087C3;
   float: left;
 }
 
 #client .to {
   color: #777777;
 }
 
 h2.name {
   font-size: 1.4em;
   font-weight: normal;
   margin: 0;
 }
 
 #invoice {
   float: right;
   text-align: right;
 }
 
 #invoice h1 {
   color: #0087C3;
   font-size: 2.4em;
   line-height: 1em;
   font-weight: normal;
   margin: 0  0 10px 0;
 }
 
 #invoice .date {
   font-size: 1.1em;
   color: #777777;
 }
 
 table {
   width: 100%;
   border-collapse: collapse;
   border-spacing: 0;
   margin-bottom: 20px;
 }
 
 table th,
 table td {
   padding: 20px;
   background: #EEEEEE;
   text-align: center;
   border-bottom: 1px solid #FFFFFF;
 }
 
 table th {
   white-space: nowrap;        
   font-weight: normal;
 }
 
 table td {
   text-align: right;
 }
 
 table td h3{
   color: #57B223;
   font-size: 1.2em;
   font-weight: normal;
   margin: 0 0 0.2em 0;
 }
 
 table .no {
   color: #FFFFFF;
   font-size: 1.6em;
   background: #57B223;
 }
 
 table .desc {
   text-align: left;
 }
 
 table .unit {
   background: #DDDDDD;
 }
 

 
 table .total {
   background: #57B223;
   color: #FFFFFF;
 }
 
 table td.unit,
 table td.qty,
 table td.total {
   font-size: 1.2em;
 }
 
 table tbody tr:last-child td {
   border: none;
 }
 
 table tfoot td {
   padding: 10px 20px;
   background: #FFFFFF;
   border-bottom: none;
   font-size: 1.2em;
   white-space: nowrap; 
   border-top: 1px solid #AAAAAA; 
 }
 
 table tfoot tr:first-child td {
   border-top: none; 
 }
 
 table tfoot tr:last-child td {
   color: #57B223;
   font-size: 1.4em;
   border-top: 1px solid #57B223; 
 
 }
 
 table tfoot tr td:first-child {
   border: none;
 }
 
 #thanks{
   font-size: 2em;
   margin-bottom: 50px;
 }
 
   
   ';
   $this->email->message($message);

   $this->email->send();

     
     redirect($this->agent->referrer(),'refresh');
     }
   }

   function flux_rss()
   {
      $DonneesInjectees['annonces']=$this->ModeleAnnonce->retournerAnnonce();
      $DonneesInjectees['dernieredate'] = $this->ModeleAnnonce->getlastdate();
        $this->load->view("visiteur/flux_rss.rss",$DonneesInjectees);
   }
   public function erreur404(){
    
    $this->load->view('error404');
 
  }
} 