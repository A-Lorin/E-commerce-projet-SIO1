<?php
class Client extends CI_Controller {
   public function __construct()
   {
       parent::__construct();
       $this->load->helper('url');
       $this->load->helper('assets');
       $this->load->library("pagination");
       $this->load->model('ModeleProduit');
       $this->load->model('ModeleClient');
       $this->load->model('ModeleCategorie');
       $this->load->model('ModeleCommande');
       $this->load->model('ModeleLigne');
       $this->load->model('ModeleIdentifiant');
       $this->load->model('ModeleAvis');
   }
public function seDeConnecter() {
   $this->session->sess_destroy();
   redirect('Visiteur/accueil','refresh');
}

public function modifierSonCompte()
   {
       $Utilisateur = $this->ModeleClient->retournerClientParNo( $this->session->id);
       $this->load->helper('form');
       $this->load->library('form_validation');
       $DonneesInjectees['TitreDeLaPage'] = "modifier son compte";
       $this->form_validation->set_rules('txtNom', 'Nom', 'required');
       $this->form_validation->set_rules('txtPrenom', 'Prenom', 'required');
       $this->form_validation->set_rules('txtAdresse', 'Adresse', 'required');
       $this->form_validation->set_rules('txtVille', 'Ville', 'required');
       $this->form_validation->set_rules('txtCP', 'CP', 'required');
       $this->form_validation->set_rules('txtEmail', 'Email', 'required');
       $DonneesInjectees['Nom'] = $Utilisateur->NOM;
       $DonneesInjectees['Prenom'] = $Utilisateur->PRENOM;
       $DonneesInjectees['Adresse'] = $Utilisateur->ADRESSE;
       $DonneesInjectees['Ville'] = $Utilisateur->VILLE;
       $DonneesInjectees['CP'] = $Utilisateur->CODEPOSTAL;
       $DonneesInjectees['Email'] = $Utilisateur->EMAIL;
       $id = $Utilisateur->NOCLIENT;
       

      if ($this->form_validation->run() === FALSE) 
       { 
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
           $this->load->view('Client/modifierSonCompte', $DonneesInjectees);
           $this->load->view('templates/PiedDePage');
      }
      elseif (!filter_var($this->input->post('txtEmail'), FILTER_VALIDATE_EMAIL) 
      OR (!preg_match("/^[a-zA-Zéèêëçàâôù ûïî]*$/",$this->input->post('txtNom'))) 
      OR (!preg_match("/^[a-zA-Zéèêëçàâôù ûïî]*$/",$this->input->post('txtPrenom')))
      OR (!preg_match("/^[a-zA-Z0-9 '-]*?[a-zA-Zéèêëçàâôù ûïî-]+$/",$this->input->post('txtAdresse')))
      OR (!preg_match("/^[a-zA-Zéèêëçàâôùûïî-]+$/",$this->input->post('txtVille')))
      OR (!preg_match("/^[0-9]{5,5}$/",$this->input->post('txtCP')))
      OR ($this->ModeleClient->retournerClientParMail($this->input->post('txtEmail'))!=null AND $this->input->post('txtEmail')!=$Utilisateur->EMAIL)
      )
      {
         if(!filter_var($this->input->post('txtEmail'), FILTER_VALIDATE_EMAIL)){$DonneesInjectees['mailErr'] = 'Mail non valide';}
         if (!preg_match("/^[a-zA-Zéèêëçàâôù ûïî]*$/",$this->input->post('txtNom'))) {$DonneesInjectees['nomErr'] = 'Charactère non autoriser dans le champ "nom"';}
         if (!preg_match("/^[a-zA-Zéèêëçàâôù ûïî]*$/",$this->input->post('txtPrenom'))) {$DonneesInjectees['prenomErr'] = 'Charactère non autoriser dans le champ "prénom"';}
         if (!preg_match("/^[a-zA-Z0-9 '-]*?[a-zA-Zéèêëçàâôù ûïî-]+$/",$this->input->post('txtAdresse'))) {$DonneesInjectees['adresseErr'] = 'Charactère non autoriser dans le champ "adresse"';}
         if (!preg_match("/^[a-zA-Zéèêëçàâôùûïî-]+$/",$this->input->post('txtVille'))) {$DonneesInjectees['villeErr'] = 'Charactère non autoriser dans le champ "ville"';}
         if (!preg_match("/^[0-9]{5,5}$/",$this->input->post('txtCP'))) {$DonneesInjectees['CPErr'] = 'Charactère non autoriser dans le champ "Code Postal"';}
         if ($this->ModeleClient->retournerClientParMail($this->input->post('txtEmail'))!=null AND $this->input->post('txtEmail')!=$Utilisateur->EMAIL) {$DonneesInjectees['mailErr'] = 'Mail déjà utilisé';}
         $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
         $this->load->view('templates/Entete',$DonneesCategorie);
         $this->load->view('Client/modifierSonCompte', $DonneesInjectees);
         $this->load->view('templates/PiedDePage');
      } 
       else
       {
         if(!empty($this->input->post('txtMdp')))
         {
          $donneesAInserer = array(
            'NOM' => ucfirst(strtolower($this->input->post('txtNom'))),
             'PRENOM' => ucfirst(strtolower($this->input->post('txtPrenom'))),
             'ADRESSE' => $this->input->post('txtAdresse'),
            'VILLE' => strtoupper($this->input->post('txtVille')),
             'CODEPOSTAL' => $this->input->post('txtCP'),
            'EMAIL' => $this->input->post('txtEmail'),
             'MOTDEPASSE' => password_hash($this->input->post('txtMdp'), PASSWORD_DEFAULT)
             ,);
         }
         else
         {
          $donneesAInserer = array(
            'NOM' => ucfirst(strtolower($this->input->post('txtNom'))),
             'PRENOM' => ucfirst(strtolower($this->input->post('txtPrenom'))),
             'ADRESSE' => $this->input->post('txtAdresse'),
            'VILLE' => strtoupper($this->input->post('txtVille')),
             'CODEPOSTAL' => $this->input->post('txtCP'),
            'EMAIL' => $this->input->post('txtEmail')
             ,);
         }
          $donnees['nbDeLignesAffectees']=$this->ModeleClient->modifierCompteClient($donneesAInserer,$id); 
          $donnees['nom']=$this->input->post('txtNom');
          $donnees['prenom']=$this->input->post('txtPrenom');
          $this->load->helper('url'); 
          $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
       
       redirect('Visiteur/accueil','refresh');
       
       } 
   } 
   function validationCommande()
   {
    $identifiantsite=$this->ModeleIdentifiant->retournerIdentifiant();
      $Utilisateur = $this->ModeleClient->retournerClientParNo( $this->session->id);
            // Identifiant de votre site de eCommerce (fournies par votre banque en production)
      $pbx_site = $identifiantsite->SITE;         // Test (voir Compte de test)
      $pbx_rang = $identifiantsite->RANG;              // Test
      $pbx_identifiant = $identifiantsite->IDENTIFIANT;        // Test

      // Identifiant de la transaction (doit être unique en prod., a générer)
      $pbx_cmd = date("d-m-Y-H-i-s")."-".$this->session->id."-cmd";   // forcé ici

      // Identifiant client du site qui souhaite faire le paiement = mail client
      $pbx_porteur = $Utilisateur->EMAIL;  // Valeur de test ici, en prod. = mail client

      // Somme à débiter de la Carte Bancaire, en centimes (forcée à 100 ici = 1 euros)
      $pbx_total =  $this->cart->total()*100;

      // Suppression des points ou virgules dans le montant                      
      $pbx_total = str_replace(",", "", $pbx_total);
      $pbx_total = str_replace(".", "", $pbx_total);

      // Paramétrage des urls de redirection après paiement
      // $pbx_effectue = Page renvoyée si paiement accepté (voir ex. Annexe : accepte.php)
      // $pbx_effectue = 'http://www.votre-site.extention/page-de-confirmation';
      $pbx_effectue = site_url('Client/paiementAccepte');
      // $pbx_annule = Page renvoyée si paiement annulé, par le client (voir ex. Annexe : annule.php)
      // $pbx_annule = 'http://www.votre-site.extention/page-d-annulation';
      $pbx_annule =site_url('Client/paiementAnnule');
      // $pbx_refuse = Page renvoyée si paiement refuse, par PayBox (voir ex. Annexe : refuse.php)
      // $pbx_refuse = 'http://www.votre-site.extention/page-de-refus';
      $pbx_refuse =site_url('Client/paiementRefuse');

      
      /* url de retour back office site : $pbx_repondre_a
      Cette URL est appelée de serveur à serveur dès que le client valide son paiement (que ce dernier soit autorisé ou refusé). Cela permet ainsi de valider automatiquement le bon de commande correspondant même si le client coupe la connexion ou décide de ne pas revenir sur la boutique, car cet appel ne transite pas par le navigateur du porteur de carte.
      */
      $pbx_repondre_a = site_url('Client/retourPaybox');

      // Pour que l'URL $pbx_repondre_a puisse être appelée, il faut que le site soit hébergé
      /* Ex. Code Igniter : $pbx_repondre_a  = base_url('application/views/traitementretourpaybox.php');
      VOIR ANNEXE pour traitementretourpaybox.php
      NOTA BENE : le script retour, sur notre serveur, sera appelé par le serveur PayBox, dans ce script, on aura donc pas accès aux variables de session !
      */

      // Paramétrage du retour back office site
      $pbx_retour = 'Montant:M;Reference:R;Auto:A;Erreur:E';
      /*
      M : Montant de la transaction (précisé dans PBX_TOTAL).
      R : Référence commande (précisée dans PBX_CMD)
      A : Numéro d’autorisation délivré par le centre d’autorisation de la banque du commerçant
      si le paiement est accepté
      E : Code réponse de la transaction
      */

      /* $keyTest : clé secrète HMAC. En prod. : générée depuis le back office mise à dispo. par votre banque puis stockée dans BBD par exemple. Ici on l’a mise en dur, pour test */
      $keyTest = $identifiantsite->CLEHMAC;

      /* --------------- TESTS DE DISPONIBILITE DES SERVEURS ---------------
      PayBox dispose de plusieurs serveurs, dans ce qui suit on cherche un serveur de prod. Opérationnel pour répondre à notre demande */
      $serveurs = array('tpeweb.paybox.com', //serveur primaire
      'tpeweb1.paybox.com'); //serveur secondaire
      $serveurOK = "";
      foreach($serveurs as $serveur)
      {
      $doc = new DOMDocument();
      $doc->loadHTMLFile('https://'.$serveur.'/load.html');
      $server_status = "";
      $element = $doc->getElementById('server_status');
      if($element){
      $server_status = $element->textContent;}
      if($server_status == "OK")
      {
      // Le serveur est prêt et les services opérationnels
      $serveurOK = $serveur;
      break;
      }
      // else : La machine est disponible mais les services ne le sont pas.
      }
      if(!$serveurOK)
      {
         die("Erreur : Aucun serveur n'a été trouvé");
      }
      // Activation de l'univers de préproduction (CAS LORSQU’ON VA TRAVAILLER EN TEST)
      // On remplace le serveur de prod. trouvé ci-dessus par :
      $serveurOK = 'preprod-tpeweb.paybox.com'; // Ligne à commenter si on veut passer en prod.

      //Création de l'url cgi paybox – vers laquelle on enverra nos données (encryptées)
      $serveurOK = 'https://'.$serveurOK.'/cgi/MYchoix_pagepaiement.cgi';

      // --------------- TRAITEMENT DES VARIABLES à envoyer vers serveur PayBox ---------------
      // On récupère la date au format ISO-8601
      $dateTime = date("c");

      // On crée la chaîne à hacher sans URLencodage
      $msg = "PBX_SITE=".$pbx_site.
      "&PBX_RANG=".$pbx_rang.
      "&PBX_IDENTIFIANT=".$pbx_identifiant.
      "&PBX_TOTAL=".$pbx_total.
      "&PBX_DEVISE=978".
      "&PBX_CMD=".$pbx_cmd.
      "&PBX_PORTEUR=".$pbx_porteur.
      "&PBX_REPONDRE_A=".$pbx_repondre_a.
      "&PBX_RETOUR=".$pbx_retour.
      "&PBX_EFFECTUE=".$pbx_effectue.
      "&PBX_ANNULE=".$pbx_annule.
      "&PBX_REFUSE=".$pbx_refuse.
      "&PBX_HASH=SHA512".
      "&PBX_TIME=".$dateTime;

      // Si la clé est en ASCII, On la transforme en binaire
      $binKey = pack("H*", $keyTest);

      // On calcule l’empreinte (à renseigner dans le paramètre PBX_HMAC) grâce à la fonction hash_hmac et //
      // la clé binaire / On envoi via la variable PBX_HASH l'algorithme de hachage qui a été utilisé (SHA512 dans ce cas)
      // Pour afficher la liste des algorithmes disponibles sur votre environnement, décommentez la ligne //
      // suivante
      // print_r(hash_algos());
      $hmac = strtoupper(hash_hmac('sha512', $msg, $binKey));
      $DonneesInjectees['serveurOK']=$serveurOK;
      $DonneesInjectees['pbx_site']=$pbx_site;
      $DonneesInjectees['pbx_rang']=$pbx_rang;
      $DonneesInjectees['pbx_identifiant']=$pbx_identifiant;
      $DonneesInjectees['pbx_total']=$pbx_total;
      $DonneesInjectees['pbx_cmd']=$pbx_cmd;
      $DonneesInjectees['pbx_porteur']=$pbx_porteur;
      $DonneesInjectees['pbx_repondre_a']=$pbx_repondre_a;
      $DonneesInjectees['pbx_retour']=$pbx_retour;
      $DonneesInjectees['pbx_effectue']=$pbx_effectue;
      $DonneesInjectees['pbx_annule']=$pbx_annule;
      $DonneesInjectees['pbx_refuse']=$pbx_refuse;
      $DonneesInjectees['dateTime']=$dateTime;
      $DonneesInjectees['hmac']=$hmac;

      $this->load->helper('form');
      $DonneesInjectees['client']= $this->ModeleClient->retournerClientParNo($this->session->id);
      $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
      $this->load->view('templates/Entete',$DonneesCategorie);
      $this->load->view('Client/validationCommande', $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
   }

   /*function retourPaybox()
   {
      $MontantEuros = $_GET['Montant'];
   $Reference = $_GET['Reference'];
   $Erreur = $_GET['Erreur'];
   if ($Erreur == "00000") /* PAIEMENT OK (PayBox appelle par ailleurs le script renseigné dans $pbx_effectue, exemple : accepte.php) */
      /*{ 
      /* EN LOCAL : A TESTER 'A LA MAIN' (en forçant des valeurs pour $Reference etc…)
      (il faut que le site soit hébergé pour que traitementretourpaybox.php puisse être appelé par PayBox */
      /* ICI on fera un UPDATE sur la commande concernée par le paiement :
      - Validé : vraie
      - Montant payé
      - Mode paiement
      …
      
      - On enverra un mail de confirmation au client … etc…
      *//*
      }
   }*/

   function paiementRefuse()
   {
      echo'<script language=javascript>
      alert("Votre paiement a été refusé");
      </script> ';
      redirect('client/validationCommande','refresh');
   }

   function paiementAnnule()
   {
      redirect('client/validationCommande');
   }
   
   function paiementAccepte()
   {
      $totalht=0;
      foreach($this->cart->contents() as $item){$totalht=$totalht+($item['ht']*$item['qty']);}
      $noclient =$this->session->id;
      $donneesAInserer = array(
      'NOCLIENT' => $noclient,
      'DATECOMMANDE' => date("c"),
      'TOTALHT' => $totalht,
      'TOTALTTC' => $this->cart->total(),);
      $insertid=$this->ModeleCommande->ajouterCommande($donneesAInserer);

      foreach($this->cart->contents() as $item)
      {
         $donneesAInsererLi=null;
         $donneesAInsererLi = array(
         'NOCOMMANDE' => $insertid,
         'NOPRODUIT' => $item['id'],
         'QUANTITECOMMANDEE' =>  $item['qty']);
         $this->ModeleLigne->ajouterligne($donneesAInsererLi);
         $infoproduit= $this->ModeleProduit->retournerProduits($item['id']);
         $donneesAModifier=null;
         if($infoproduit->QUANTITEENSTOCK==$item['qty'])
         {
            $donneesAModifier= array(
            'QUANTITEENSTOCK' => (($infoproduit->QUANTITEENSTOCK) - $item['qty']),
            'DISPONIBLE ' => 0);
            $this->ModeleProduit->modifierproduit($item['id'],$donneesAModifier);
         }
         else
         {
            $donneesAModifier= array(
            'QUANTITEENSTOCK' => (($infoproduit->QUANTITEENSTOCK) - $item['qty']));
            $this->ModeleProduit->modifierproduit($item['id'],$donneesAModifier);
         }

      }
      //mail
      /*
      $this->load->library('email');
      $user=$this->ModeleClient->retournerClientParNo($this->session->id);
      $this->email->from('Dupont@yopmail.com', 'Dupont');
      $this->email->to($user->EMAIL);
   
      $this->email->subject('Merci de votre commande');
      $this->email->message("               Merci.\n                
      Bonjour ".$user->PRENOM."! \n 
      Merci d'avoir commander sur notre site. \n 
      N° de facture: ".$insertid."\n 
      Information sur votre commande: \n 
      N° de commande: ".$insertid."               Facturée à: ".$user->EMAIL." \n
      Date de commande: ".date("d-m-Y")." \n
      Le total de ce que vous avez commandé s'élève à: ".$this->cart->total()."€");
   
      $this->email->send();
      */
   $this->load->library('email');
   $user=$this->ModeleClient->retournerClientParNo($this->session->id);

   
   $this->email->set_mailtype("html");
   $this->email->from('Dupont@yopmail.com', 'Dupont');
   $this->email->to($user->EMAIL);

   $this->email->subject('Merci de votre commande');
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
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Facturer à:</div>
          <h2 class="name">'.$user->NOM.' '.$user->PRENOM.'</h2>
          <div class="address">'.$user->ADRESSE.' '.$user->VILLE.' '.$user->CODEPOSTAL.'</div>
          <div class="email">'.$user->EMAIL.'</div>
        </div>
        <div id="invoice">
          <h1>FACTURE</h1>
          <div class="date">Facture n°'.$insertid.'</div>
          <div class="date">Date de commande: '.date("d-m-Y").'</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">PRODRUIT</th>
            <th class="unit">PRIX UNITAIRE</th>
            <th class="qty">QUANTITE</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>';
        $i=1;
        foreach($this->cart->contents() as $item)
        {
           $message=$message.'<tr>
           <td class="no">'.$i.'</td>
           <td class="desc"><h3>'.$item['name'].'</h3></td>
           <td class="unit">'.$item['price'].'€</td>
           <td class="qty">'.$item['qty'].'</td>
           <td class="total">'.$item['subtotal'].'€</td>
         </tr>
           ';$i++;
        }
          $message=$message.'
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">TOTAL</td>
            <td>'.$this->cart->total().'</td>
          </tr>
        </tfoot>
      </table>
      <hr/>
      <h3>Si vous le souhaitez vous pouvez désormais donner votre avis sur ce(s) produit(s) en vous rendant sur la(/les) &nbsp&nbsp page(s) de ce(s) produit(s).</h3><hr/>
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

      $this->cart->destroy();
      redirect('visiteur/listerLesProduits','refresh');
   }

   public function historiqueCommande()
   {
       if($this->session->statut==null){redirect('Visiteur/listerLesProduits');}
       $DonneesInjectees['client']=$this->ModeleClient->retournerClientParNo($this->session->id);
       $DonneesInjectees['commandes']=$this->ModeleCommande->retournerCommandeClient($this->session->id);
       $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
       $this->load->view('templates/Entete',$DonneesCategorie);
       $this->load->view('Client/historiqueCommande', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
   }

   public function detailCommande($nocommande =false)
   {
       if(empty($nocommande))
       {
        redirect('Visiteur/listerLesProduits','refresh');
       }
    $commande =$DonneesInjectees['commande'] = $this->ModeleCommande->retournerCommande($nocommande);
    $DonneesInjectees['lignes'] = $this->ModeleLigne->retournerlignes($nocommande);
    $DonneesCategorie['categories'] = $this->ModeleCategorie->retournerCategories();
    $this->load->view('templates/Entete',$DonneesCategorie);
    $this->load->view('Client/detailscommande', $DonneesInjectees);
    $this->load->view('templates/PiedDePage');
   }

   public function Noter($noproduit)
   {
     $avis=$this->input->post('rate');
     $titre=$this->input->post('txtTitreAvis');
     $commentaire=$this->input->post('txtAvis');
     
     if(empty($avis)or empty($titre) or empty($commentaire))
     {
      redirect('visiteur/voirUnProduit/'.$noproduit,'refresh');
     }
     $donneesAInserer = array(
      'NOCLIENT' => $this->session->id,
       'NOPRODUIT' => $noproduit,
       'AVIS' => $this->input->post('rate'),
      'TITRECOMMENTAIRE' => $this->input->post('txtTitreAvis'),
       'COMMENTAIRE' => $this->input->post('txtAvis'),
       'DATEAVIS' => date('c'),
      ); 
      $this->ModeleAvis->AjouterUnAvis($donneesAInserer);
      redirect('visiteur/voirUnProduit/'.$noproduit,'refresh');
   }

   public function ModifierNote($noproduit)
   {
     $avis=$this->input->post('modifrate');
     $titre=$this->input->post('txtmodifTitreAvis');
     $commentaire=$this->input->post('txtmodifAvis');
     
     if(empty($avis)or empty($titre) or empty($commentaire))
     {
      redirect('visiteur/voirUnProduit/'.$noproduit,'refresh');
     }
     $donneesAInserer = array(
       'AVIS' => $this->input->post('modifrate'),
      'TITRECOMMENTAIRE' => $this->input->post('txtmodifTitreAvis'),
       'COMMENTAIRE' => $this->input->post('txtmodifAvis'),
       'MODIFIER' => 1,
      ); 
      $this->ModeleAvis->modifierAvis($donneesAInserer,$this->session->id,$noproduit);
      redirect('visiteur/voirUnProduit/'.$noproduit,'refresh');
   }
   
}