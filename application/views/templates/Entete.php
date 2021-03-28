<!DOCTYPE html>
<html>

    <head>
       <title>M.Dupont's shop</title>
       <meta charset="utf-8">
       <link rel="shortcut icon" type="image/x-icon" href="<?= base_url().'assets/images/favicon.ico'?>">
       <link rel="alternate" type="application/rss+XML" title="Dupont shop" href="<?php echo site_url('administrateurSuper/flux_rss') ?>" />

       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
       
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="<?= base_url().'assets/css/style.css'?>">
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
    
<nav class="navbar navbar-expand-xl navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
    <a class="navbar-brand" href="<?php echo site_url('Visiteur/accueil') ?>">
    <img class="d-block" style="width:60px;height:38px;'" src="<?= base_url().'assets/images/logo.jpg'?>" alt="Logo">
  </a>
        <ul class="navbar-nav mr-auto">
            
   <li class="nav-item">
   <a href="<?php echo site_url('Visiteur/accueil') ?>" class="btn btn-info">
   <span class="fas fa-home"></span> accueil
   </a></li>

   <li class="nav-item">
      <a class="btn btn-primary" href="<?php echo site_url('Visiteur/listerLesProduits') ?>">Lister tous les Produits</a>
   </li>

   <li class="nav-item dropdown">
   <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
         categorie
         </button>
      <div class="dropdown-menu">
      <?php foreach ($categories as $categorie){?> <a class="dropdown-item"  href="<?php echo site_url('Visiteur/listerLesProduitsparcategorie/'.$categorie->NOCATEGORIE.'') ?>"><?php echo $categorie->LIBELLE ;?> </a><?php } ?>
   </div>
   </li>
        </ul>
    </div>




    <div class="mx-auto order-0">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class=" w-75 order-2 ">
    <ul class="navbar-nav mx-auto">
        <li class="nav-item" style=" margin-left:0px;margin-right:0px;">
    <form class="form-inline" method="post" action="<?php echo site_url('Visiteur/recherche') ?>">
   <input class="form-control mr-sm-2" type="text" name="search" id='search' placeholder="Search">
   <button class="btn btn-success" type="submit">
            <i class="fas fa-search"></i>
        </button></form></li></ul>
        </div>




    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
   <a href="<?php echo site_url('Visiteur/afficherPanier') ?>" class="btn btn-info btn-md">
   <span class="fas fa-shopping-cart"><?php if($this->cart->total_items()>0){?>(<?php echo $this->cart->total_items(); ?>)<?php }?></span>
        </a>
        </li>

        <?php if ($this->session->statut==2 or $this->session->statut==3) : ?>
   <li class="nav-item dropdown">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
         administration
         </button>
      <div class="dropdown-menu">
      <a class="dropdown-item"  href="<?php echo site_url('AdministrateurEmploye/afficherLesClients') ?>">Voir les commandes d'un client</a>
      <a class="dropdown-item"  href="<?php echo site_url('AdministrateurEmploye/CommandeNonTraitee') ?>">Commande non traitée</a>
         <?php if($this->session->statut==3){?>
         <a class="dropdown-item"  href="<?php echo site_url('administrateurSuper/ajouterUnProduit') ?>">Ajouter un produit</a>
         <a class="dropdown-item" href="<?php echo site_url('administrateurSuper/ajouterUneMarque') ?>">Ajouter une marque</a>
         <a class="dropdown-item" href="<?php echo site_url('administrateurSuper/ajouterUneCategorie') ?>">Ajouter une categorie</a>
         <a class="dropdown-item" href="<?php echo site_url('administrateurSuper/ajouterAdministrateur') ?>">Ajouter un administrateur</a>
         <a class="dropdown-item" href="<?php echo site_url('administrateurSuper/ModifSupprAdministrateur') ?>">Modifier/supprimer un administrateur</a>
         <a class="dropdown-item" href="<?php echo site_url('administrateurSuper/newslettermessage') ?>">Message newsletter</a>
         <a class="dropdown-item" href="<?php echo site_url('administrateurSuper/modifierIdentifiantSite') ?>">Modifier les identifiants du site</a>
         <?php }?> 
      </div>
   </li>
   <?php endif; ?>
   

        <li class="nav-item dropdown">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
         mon compte
         </button>
      <div class="dropdown-menu">
         <?php if (!is_null($this->session->statut)){ ?>
         <?php if($this->session->statut==1){?>
            <a class="dropdown-item" href="<?php echo site_url('Client/historiqueCommande') ?>">Mes commandes</a>
         <a class="dropdown-item" href="<?php echo site_url('Client/modifierSonCompte') ?>">Modifier son compte</a>
         <?php } elseif($this->session->statut==3){ ?>
         <a class="dropdown-item" href="<?php echo site_url('AdministrateurSuper/modifierUnAdmin/'.$this->session->identifiant) ?>">Modifier son compte</a>
         <?php } ?>
         <a class="dropdown-item" href="<?php echo site_url('Client/seDeconnecter') ?>">Se déconnecter</a>
         <?php }else{ ?>
         <a class="dropdown-item" href="<?php echo site_url('Visiteur/seConnecter') ?>">Se connecter</a>
         <a class="dropdown-item" href="<?php echo site_url('Visiteur/senregistrer') ?>">Se crée un compte</a>
         <?php } ?>
      </div>
   </li>

    <li>
    </li>
    <li>
    </li>
        <?php if (empty($this->session->statut)):?>
   <li class="nav-item droite">
   <a href="<?php echo site_url('Visiteur/connexionAdministrateur') ?>" class="fas fa-lock"></a>
        </li>
   <?php  endif; ?>
        </ul>
    </div>
</nav>
<main>
