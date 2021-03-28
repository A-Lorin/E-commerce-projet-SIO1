<?php

class AdministrateurEmploye extends CI_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->model('ModeleProduit');
      $this->load->model('ModeleAdministrateur');
      $this->load->model('ModeleMarque');
      $this->load->model('ModeleCategorie');
      $this->load->model('ModeleCommande');
      $this->load->model('ModeleClient');
      $this->load->model('ModeleLigne');
      $this->load->helper(array('form', 'url'));
      if ($this->session->statut!=2 and $this->session->statut!=3) 
      {   $this->load->helper('url'); 
          redirect('/visiteur/connexionAdministrateur'); 
      }
   }  

   public function commandenontraitee()
   {
    $DonneesInjectees['commandenontraitee'] = $this->ModeleCommande->retournerCommandesNonTraitée();
    $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
    $this->load->view('templates/Entete',$DonneesCategorie);
    $this->load->view('AdministrateurEmploye/CommandeNonTraitee', $DonneesInjectees);
    $this->load->view('templates/PiedDePage');
   }

   public function detailCommandenontraitee($nocommande =false)
   {
       if(empty($nocommande))
       {
        redirect('AdministrateurEmploye/commandenontraitee','refresh');
       }
    $DonneesInjectees['commande'] = $this->ModeleCommande->retournerCommande($nocommande);
    $DonneesInjectees['lignes'] = $this->ModeleLigne->retournerlignes($nocommande);
    $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
    $this->load->view('templates/Entete',$DonneesCategorie);
    $this->load->view('AdministrateurEmploye/detailcommandenontraitee', $DonneesInjectees);
    $this->load->view('templates/PiedDePage');
   }

   public function passerCommandeATraiter($nocommande)
   {
    $donneesAInserer = array(
        'DATETRAITEMENT' => date("c"));
    $this->ModeleCommande->modifierCommande($nocommande, $donneesAInserer);

    $commande=$this->ModeleCommande->retournerCommande($nocommande);
    $lignes=$this->ModeleLigne->retournerlignes($nocommande);
    $this->load->library('email');
   $user=$this->ModeleClient->retournerClientParNo($commande->NOCLIENT);

   
   $this->email->set_mailtype("html");
   $this->email->from('Dupont@yopmail.com', 'Dupont');
   $this->email->to($user->EMAIL);

   $this->email->subject('Commande expédiée');
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
    <h2>Votre commande viens d\'être expédiée.</h2><hr/>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Facturer à:</div>
          <h2 class="name">'.$user->NOM.' '.$user->PRENOM.'</h2>
          <div class="address">'.$user->ADRESSE.' '.$user->VILLE.' '.$user->CODEPOSTAL.'</div>
          <div class="email">'.$user->EMAIL.'</div>
        </div>
        <div id="invoice">
          <h1>FACTURE</h1>
          <div class="date">Facture n°'.$nocommande.'</div>
          <div class="date">Date de commande: '.$commande->DATECOMMANDE.'</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">PRODRUIT</th>
            <th class="unit">PRIX HT</th>
            <th class="qty">QUANTITE</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>';
        $i=1;
        foreach($lignes as $item)
        {
           $message=$message.'<tr>
           <td class="no">'.$i.'</td>
           <td class="desc"><h3>'.$item->LIBELLE.'</h3></td>
           <td class="unit">'.number_format($item->PRIXHT+$item->TAUXTVA).'€</td>
           <td class="qty">'.$item->QUANTITECOMMANDEE.'</td>
           <td class="total">'.$item->QUANTITECOMMANDEE*($item->PRIXHT+$item->TAUXTVA).'€</td>
         </tr>
           ';$i++;
        }
          $message=$message.'
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">TOTAL</td>
            <td>'.$commande->TOTALTTC.'</td>
          </tr>
        </tfoot>
      </table>
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
 .titre{align-text:center;}
 
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
    redirect('AdministrateurEmploye/commandenontraitee','refresh');
   }

   public function afficherLesClients()
   {
       $DonneesInjectees['clients']=$this->ModeleClient->retournerClients();
       $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
       $this->load->view('templates/Entete',$DonneesCategorie);
       $this->load->view('AdministrateurEmploye/afficherLesClients', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
   }

   public function historiqueCommande($noclient=null)
   {
       if($noclient==null){redirect('AdministrateurEmploye/afficherLesClients');}
       $DonneesInjectees['client']=$this->ModeleClient->retournerClientParNo($noclient);
       $DonneesInjectees['commandes']=$this->ModeleCommande->retournerCommandeClient($noclient);
       $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
       $this->load->view('templates/Entete',$DonneesCategorie);
       $this->load->view('AdministrateurEmploye/historiqueCommande', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
   }

   public function detailCommande($nocommande =false)
   {
       if(empty($nocommande))
       {
        redirect('AdministrateurEmploye/historiqueCommande','refresh');
       }
    $commande =$DonneesInjectees['commande'] = $this->ModeleCommande->retournerCommande($nocommande);
    $DonneesInjectees['lignes'] = $this->ModeleLigne->retournerlignes($nocommande);
    $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
    $this->load->view('templates/Entete',$DonneesCategorie);
    $this->load->view('AdministrateurEmploye/detailscommande', $DonneesInjectees);
    $this->load->view('templates/PiedDePage');
   }

}

 