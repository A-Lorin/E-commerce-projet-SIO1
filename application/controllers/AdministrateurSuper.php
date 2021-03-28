<?php

class AdministrateurSuper extends CI_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->model('ModeleProduit');
      $this->load->model('ModeleAdministrateur');
      $this->load->model('ModeleMarque');
      $this->load->model('ModeleCategorie');
      $this->load->model('ModeleIdentifiant');
      $this->load->model('ModeleNewsletter');
      $this->load->model('ModeleAnnonce');
      $this->load->helper(array('form', 'url'));
      if ($this->session->statut!=3) 
      {   $this->load->helper('url'); 
          redirect('/visiteur/connexionAdministrateur'); 
      }
   }  

   public function ajouterUnProduit()
   {
       $this->load->helper('form');
       $this->load->library('form_validation');
       $DonneesInjectees['lesMarques'] = $this->ModeleMarque->retournerMarques();
       $DonneesInjectees['lesCategories'] = $this->ModeleCategorie->retournerCategories();
       $DonneesInjectees['TitreDeLaPage'] = 'Ajouter un produit';
       $this->form_validation->set_rules('Categorie', 'Categorie', 'required');
       $this->form_validation->set_rules('Marque', 'Marque', 'required');
       $this->form_validation->set_rules('txtLibelle', 'Libelle', 'required');
       $this->form_validation->set_rules('txtDetail', 'Detail', 'required');
       $this->form_validation->set_rules('txtPrixHT', 'Prix HT', 'required');
       $this->form_validation->set_rules('txtQuantite', 'Quantite', 'required');

       if ($this->form_validation->run() === FALSE) 
       {  
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
           $this->load->view('administrateurSuper/ajouterUnProduit', $DonneesInjectees);
           $this->load->view('templates/PiedDePage');
       } 
       else
       { if ($_FILES['image']['error'] !== 4){
          $image=$this->input->post('txtNomimage');}
          else{$image='nonimage';}


          if($this->input->post('txtQuantite')>0){
          $donneesAInserer = array(
             'NOCATEGORIE' => $this->input->post('Categorie'),
             'NOMARQUE' => $this->input->post('Marque'),
             'LIBELLE' => $this->input->post('txtLibelle'),
             'DETAIL' => $this->input->post('txtDetail'),
             'PRIXHT' => $this->input->post('txtPrixHT'),
             'TAUXTVA' => (($this->input->post('txtPrixHT')*20)/100),
             'NOMIMAGE' => $image,  
             'QUANTITEENSTOCK' => $this->input->post('txtQuantite'),
             'DATEAJOUT' => date("Y-m-d"),
             'DISPONIBLE' => 1,
          );}
          else{
            $donneesAInserer = array(
               'NOCATEGORIE' => $this->input->post('Categorie'),
               'NOMARQUE' => $this->input->post('Marque'),
               'LIBELLE' => $this->input->post('txtLibelle'),
               'DETAIL' => $this->input->post('txtDetail'),
               'PRIXHT' => $this->input->post('txtPrixHT'),
               'TAUXTVA' => (($this->input->post('txtPrixHT')*20)/100),
               'NOMIMAGE' => $image,  
               'QUANTITEENSTOCK' => $this->input->post('txtQuantite'),
               'DATEAJOUT' => date("Y-m-d"),
               'DISPONIBLE' => 0,
            );
          }
          $donnees['nbDeLignesAffectees']=$this->ModeleProduit->insererUnProduit($donneesAInserer); 
          if ($_FILES['image']['error'] !== 4){
          $nomimage=$this->input->post('txtNomimage');
          $config['upload_path']          = './assets/images/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                $config['file_name']=$nomimage;

          $this->load->library('upload', $config);

          if ( ! $this->upload->do_upload('image'))
          {
                  $error = array('error' => $this->upload->display_errors());
                  $this->load->view('upload_form', $error);
          }
          else
          {
                  $data = array('upload_data' => $this->upload->data());
                  redirect('Visiteur/listerLesProduits');;
          }
         }
         
          $this->load->helper('url'); 
          
          redirect('visiteur/listerLesProduits','refresh');
          
       }  
   } 

   public function ajouterUneMarque()
   {
       $this->load->helper('form');
       $this->load->library('form_validation');
       $DonneesInjectees['TitreDeLaPage'] = 'Ajouter une marque';
       $this->form_validation->set_rules('txtMarque', 'Marque', 'required');

       if ($this->form_validation->run() === FALSE) 
       { 
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
           $this->load->view('administrateurSuper/ajouterUneMarque', $DonneesInjectees);
           $this->load->view('templates/PiedDePage');
       } 
       else
       {
          $donneesAInserer = array(
             'NOM' => $this->input->post('txtMarque'),
          );
          $donnees['nbDeLignesAffectees']=$this->ModeleMarque->insererUneMarque($donneesAInserer); 
          redirect('visiteur/listerLesProduits','refresh');
       }  
      }

      public function ajouterUneCategorie()
      {
          $this->load->helper('form');
          $this->load->library('form_validation');
          $DonneesInjectees['TitreDeLaPage'] = 'Ajouter une categorie';
          $this->form_validation->set_rules('txtCategorie', 'Categorie', 'required');
   
          if ($this->form_validation->run() === FALSE) 
          { 
            $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
            $this->load->view('templates/Entete',$DonneesCategorie);
              $this->load->view('administrateurSuper/ajouterUneCategorie', $DonneesInjectees);
              $this->load->view('templates/PiedDePage');
          } 
          else
          {
             $donneesAInserer = array(
                'LIBELLE' => $this->input->post('txtCategorie'),
             ); 
             $donnees['nbDeLignesAffectees']=$this->ModeleCategorie->insererUneCategorie($donneesAInserer); 
             redirect('visiteur/listerLesProduits','refresh');
          }  
         }

         public function modifierSonCompte()
   {
       $admin = $this->ModeleAdministrateur->retournerAdminParid( $this->session->identifiant);
       $this->load->helper('form');
       $this->load->library('form_validation');
       $DonneesInjectees['TitreDeLaPage'] = "modifier son compte";
       $this->form_validation->set_rules('txtIdentifiant', 'identifiant', 'required');
       $this->form_validation->set_rules('txtMdp', 'mot de passe', 'required');
       $this->form_validation->set_rules('txtEmail', 'email', 'required');
       $id= $DonneesInjectees['Identifiant'] = $admin->IDENTIFIANT;
       $DonneesInjectees['Mdp'] = $admin->MOTDEPASSE;
       $DonneesInjectees['Email'] = $admin->EMAIL;

      if ($this->form_validation->run() === FALSE) 
       { 
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
           $this->load->view('administrateurSuper/modifierSonCompte', $DonneesInjectees);
           $this->load->view('templates/PiedDePage');
      } 
       else
       {
          $donneesAInserer = array(
            'IDENTIFIANT' => $this->input->post('txtIdentifiant'),
             'MOTDEPASSE' => $this->input->post('txtMdp'),
             'EMAIL' => $this->input->post('txtEmail'),);
          $donnees['nbDeLignesAffectees']=$this->ModeleAdministrateur->modifierCompteAdministrateur($donneesAInserer,$id);
          $donnees['nom']=$this->input->post('txtNom');
          $donnees['prenom']=$this->input->post('txtPrenom');
          $this->load->helper('url');
          redirect('visiteur/listerLesProduits');
       } 
   } 

   function ajouterAdministrateur()
   {
      $this->load->helper('form');
      $this->load->library('form_validation');
      $this->form_validation->set_rules('txtID', 'Identifiant', 'required');
      $this->form_validation->set_rules('txtMdp', 'Mdp', 'required');
      $this->form_validation->set_rules('txtEmail', 'Email', 'required');
      if(!empty($this->input->post('txtID')))
      {
         $verif= $this->ModeleAdministrateur->retournerAdminParid($this->input->post('txtID'));
         if((!empty($verif)))
         {
            $DonneesInjectees['erreur']='Identifiant déjà utiliser';
         }
      }
     if ($this->form_validation->run() === FALSE)
     { 
      $DonneesInjectees['titreDeLaPage']='Ajouter un Administrateur';
        $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
        $this->load->view('templates/Entete',$DonneesCategorie);
          $this->load->view('AdministrateurSuper/ajouterAdmin',$DonneesInjectees);
          $this->load->view('templates/PiedDePage');
     } 
     elseif($this->ModeleAdministrateur->retournerAdminParid($this->input->post('txtID'))!=null
     or !filter_var($this->input->post('txtEmail'), FILTER_VALIDATE_EMAIL)
     or $this->ModeleAdministrateur->retourneradminparmail($this->input->post('txtEmail'))!=null)
     {
      if(!filter_var($this->input->post('txtEmail'), FILTER_VALIDATE_EMAIL)){$DonneesInjectees['erreur']="mail invalide";}
      if($this->ModeleAdministrateur->retournerAdminParid($this->input->post('txtID'))!=null){$DonneesInjectees['erreur']='Identifient déjà utilisé';}
      if($this->ModeleAdministrateur->retourneradminparmail($this->input->post('txtEmail'))!=null){$DonneesInjectees['erreur']='Mail déjà utilisé';}
      $DonneesInjectees['titreDeLaPage']='Ajouter un Administrateur';
      $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
      $this->load->view('templates/Entete',$DonneesCategorie);
        $this->load->view('AdministrateurSuper/ajouterAdmin',$DonneesInjectees);
        $this->load->view('templates/PiedDePage');
     }
      else
      {
         $donneesAInserer = array(
           'IDENTIFIANT' => $this->input->post('txtID'),
           // 'MOTDEPASSE' => $this->input->post('txtMdp'),
            'MOTDEPASSE' => password_hash($this->input->post('txtMdp'), PASSWORD_DEFAULT),
            'EMAIL' => $this->input->post('txtEmail'),
         'PROFIL' => 'Employé',); 
         $DonneesInjectees['nbDeLignesAffectees']=$this->ModeleAdministrateur->ajouteradmin($donneesAInserer);
         $this->load->helper('url'); 
         redirect('visiteur/listerLesProduits');
      } 
   }

   function ModifSupprAdministrateur()
   {
      $DonneesInjectees['admins']= $this->ModeleAdministrateur->retournerAdmins();
      $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
      $this->load->view('templates/Entete',$DonneesCategorie);
      $this->load->view('administrateurSuper/ModifSupprAdministrateur', $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
   }

   function supprimerUnAdmin($idadmin)
   {
      $this->ModeleAdministrateur->supprimerUnAdmin($idadmin);
      redirect('administrateurSuper/ModifSupprAdministrateur');
   }

   public function modifierUnAdmin($idadmin=false)
   {
      if(empty($idadmin))
      {
       redirect('administrateurSuper/ModifSupprAdministrateur');
      }
       $admin=$this->ModeleAdministrateur->retournerAdminParid($idadmin);
       if($admin==null){redirect('administrateurSuper/ModifSupprAdministrateur');}
       
       $this->load->helper('form');
       $this->load->library('form_validation');
       $DonneesInjectees['TitreDeLaPage'] = "Modifier un admin";
       $this->form_validation->set_rules('txtIdentifiant', 'identifiant', 'required');
       $this->form_validation->set_rules('txtEmail', 'email', 'required');
       $id= $DonneesInjectees['Identifiant'] = $admin->IDENTIFIANT;
       $DonneesInjectees['mail'] = $admin->EMAIL;
       
      
      if ($this->form_validation->run() === FALSE)
       { 
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
           $this->load->view('administrateurSuper/modifierUnAdmin', $DonneesInjectees);
           $this->load->view('templates/PiedDePage');
      } 
      elseif(($this->ModeleAdministrateur->retournerAdminParid($this->input->post('txtIdentifiant'))!=null AND $this->input->post('txtIdentifiant')!=$admin->IDENTIFIANT)
      OR (!filter_var($this->input->post('txtEmail'), FILTER_VALIDATE_EMAIL))
      OR ($this->ModeleAdministrateur->retourneradminparmail($this->input->post('txtEmail'))!=null AND $this->input->post('txtEmail')!=$admin->EMAIL))
      {
         if(!filter_var($this->input->post('txtEmail'), FILTER_VALIDATE_EMAIL)) {$DonneesInjectees['mailErr'] = 'Mail non valide';}
         if($this->ModeleAdministrateur->retourneradminparmail($this->input->post('txtEmail'))!=null AND $this->input->post('txtEmail')!=$admin->EMAIL){$DonneesInjectees['mailErr'] ='Mail déjà utilisé';}
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
         $this->load->view('administrateurSuper/modifierUnAdmin', $DonneesInjectees);
         $this->load->view('templates/PiedDePage');
      }
       else
       {
          if(!empty($this->input->post('txtMdp')))
          {
            $donneesAInserer = array(
              'IDENTIFIANT' => $this->input->post('txtIdentifiant'),
              //'MOTDEPASSE' => $this->input->post('txtMdp'),
               'MOTDEPASSE' => password_hash($this->input->post('txtMdp'), PASSWORD_DEFAULT),
               'EMAIL' => $this->input->post('txtEmail'),);
          }
          else
          {
            $donneesAInserer = array(
              'IDENTIFIANT' => $this->input->post('txtIdentifiant'),
               'EMAIL' => $this->input->post('txtEmail'),);
          }
          if($admin->IDENTIFIANT==$this->session->identifiant){$this->session->identifiant=$this->input->post('txtIdentifiant');}
         
          $donnees['nbDeLignesAffectees']=$this->ModeleAdministrateur->modifierUnAdmin($id,$donneesAInserer);
          $donnees['nom']=$this->input->post('txtNom');
          $donnees['prenom']=$this->input->post('txtPrenom');
          $this->load->helper('url');
         
         redirect('administrateurSuper/ModifSupprAdministrateur');
         
       }
   }

   public function rendreIndisponible($noproduit=null)
   {
      if($noproduit==null){redirect('Visiteur/listerLesProduits','refresh');}
      $this->load->library('user_agent');
      $donneesAInserer = array(
         'DISPONIBLE' => 0);
      $this->ModeleProduit->modifierDisponibilite($noproduit, $donneesAInserer);
      redirect($this->agent->referrer(),'refresh');


   }

   public function rendreDisponible($noproduit=null)
   {
      if($noproduit==null){redirect('Visiteur/listerLesProduits','refresh');}
      $this->load->library('user_agent');
      $donneesAInserer = array(
         'DISPONIBLE' => 1);
      $this->ModeleProduit->modifierDisponibilite($noproduit, $donneesAInserer);
      redirect($this->agent->referrer(),'refresh');
   }

   public function modifierProduit($noproduit=null)
   {
      if($noproduit==null){redirect('Visiteur/listerLesProduits','refresh');}
      $produit=$this->ModeleProduit->retournerProduits($noproduit);
      $DonneesInjectees['noproduit'] = $produit->NOPRODUIT;
      $DonneesInjectees['Libelle'] = $produit->LIBELLE;
      $DonneesInjectees['Stock'] = $produit->QUANTITEENSTOCK;
      $DonneesInjectees['Prix'] = $produit->PRIXHT;
      $DonneesInjectees['Detail'] = $produit->DETAIL;
      $DonneesInjectees['Vitrine'] = $produit->VITRINE;
      $this->load->helper('form');
      $this->load->library('form_validation');
      $DonneesInjectees['TitreDeLaPage'] = "Modifier un produit";
      $this->form_validation->set_rules('txtStock', 'Stock', 'required');
      $this->form_validation->set_rules('txtPrix', 'Prix', 'required');
      $this->form_validation->set_rules('txtDetail', 'Detail', 'required');
      
      
     if ($this->form_validation->run() === FALSE) 
      { 
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
         $this->load->view('administrateurSuper/modifierProduit', $DonneesInjectees);
         $this->load->view('templates/PiedDePage');
     }
      else
      {
         if($this->input->post('checkbox')==1)
         {
            $donneesAInserer = array(
               'LIBELLE' => $this->input->post('txtLibelle'),
              'QUANTITEENSTOCK ' => $this->input->post('txtStock'),
               'PRIXHT' => $this->input->post('txtPrix'),
               'TAUXTVA' => (($this->input->post('txtPrix')*20)/100),
               'DETAIL' => $this->input->post('txtDetail'),
               'VITRINE'=> 1);
         }
         else
         {
            $donneesAInserer = array(
               'LIBELLE' => $this->input->post('txtLibelle'),
              'QUANTITEENSTOCK ' => $this->input->post('txtStock'),
               'PRIXHT' => $this->input->post('txtPrix'),
               'TAUXTVA' => (($this->input->post('txtPrix')*20)/100),
               'DETAIL' => $this->input->post('txtDetail'),
               'VITRINE'=> 0);
         }
         
         $this->ModeleProduit->modifierproduit($noproduit,$donneesAInserer);
         $this->load->helper('url');
        
         redirect('Visiteur/listerLesProduits','refresh');
        
      }
      
   }

   function Vitrine($noproduit)
   {
      if(empty($noproduit)){ redirect('Visiteur/accueil','refresh'); }
      $this->load->library('user_agent');
      $produit=$this->ModeleProduit->retournerProduits($noproduit);
      if($produit->VITRINE==1)
      {
         $donneesAInserer= array("VITRINE" => 0);
      }
      else
      {
         $donneesAInserer= array("VITRINE" => 1);
      }
      $this->ModeleProduit->modifierproduit($noproduit,$donneesAInserer);
      redirect($this->agent->referrer(),'refresh');
   }

   function modifierIdentifiantSite()
   {
      $DonneesInjectees['identifiant']=$this->ModeleIdentifiant->retournerIdentifiant();

      $this->load->library('form_validation');
      $this->form_validation->set_rules('txtSite', 'Site', 'required');
      $this->form_validation->set_rules('txtRang', 'Rang', 'required');
      $this->form_validation->set_rules('txtIdentifiant', 'Identifiant', 'required');
      $this->form_validation->set_rules('txtHmac', 'HMAC', 'required');
      
      
     if ($this->form_validation->run() === FALSE) 
      { 
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
         $this->load->view('administrateurSuper/modifierIdentifiant', $DonneesInjectees);
         $this->load->view('templates/PiedDePage');
     }
      else
      {
         if($this->input->post('checkbox')==1)
         {
            $donneesAInserer = array(
               'SITE' => $this->input->post('txtSite'),
              'RANG ' => $this->input->post('txtRang'),
               'IDENTIFIANT' => $this->input->post('txtIdentifiant'),
               'CLEHMAC' => $this->input->post('txtHmac'),
               'SITEENPRODUCTION'=> 1);
         }
         else
         {
            $donneesAInserer = array(
               'SITE' => $this->input->post('txtSite'),
              'RANG' => $this->input->post('txtRang'),
               'IDENTIFIANT' => $this->input->post('txtIdentifiant'),
               'CLEHMAC' => $this->input->post('txtHmac'),
               'SITEENPRODUCTION'=> 0);
         }
         
         $this->ModeleIdentifiant->modifierIdentifiant(1,$donneesAInserer);
         
        
         redirect('Visiteur/listerLesProduits','refresh');
        
      }

   }

   function newslettermessage()
   {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('txtObjet', 'Objet', 'required');
      $this->form_validation->set_rules('txttitle', 'Titre', 'required');
      $this->form_validation->set_rules('txtmessage', 'Message', 'required');
      
      
     if ($this->form_validation->run() === FALSE) 
      { 
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
         $this->load->view('administrateurSuper/newslettermessage');
         $this->load->view('templates/PiedDePage');
     }
      else
      {
         $this->load->library('email');
         $users=$this->ModeleNewsletter->retournerNewsletter();
      
         foreach($users as $user){
         $this->email->set_mailtype("html");
         $this->email->from('Dupont@yopmail.com', 'Dupont');
         $this->email->to($user->EMAIL);
      
         $this->email->subject($this->input->post('txtObjet'));
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
          <h2>'.$this->input->post('txttitle').'</h2><hr/>
          '.$this->input->post('txtmessage').'<hr/>
        
      
      
            <div id="thanks"></div>
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
         }
         
         $donneesAInserer=array(
           'TITRE' => $this->input->post('txtObjet'),
           'ANNONCE'=> $this->input->post('txtmessage'),
           'DATE_ANNONCE'=> date("c")
         );
         $this->ModeleAnnonce->ajouterAnnonce($donneesAInserer);
     
     redirect('visiteur/accueil','refresh');
     
        
        
      }
   }

}