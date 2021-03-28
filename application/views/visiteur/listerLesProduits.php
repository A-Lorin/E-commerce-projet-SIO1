
<h2 class='titrepage'><?php echo $TitreDeLaPage ?></h2><hr/> 

<div class="container-fluid">
 <div class="row">
         <div class="col-sm-2 categorie">
              <h3>Catégorie:</h3>
              <?php foreach ($categories as $categorie){ echo '<h4>'.anchor('Visiteur/listerLesProduitsparcategorie/'.$categorie->NOCATEGORIE,$categorie->LIBELLE). '</h4>'; ?><?php } ?>
              <hr/> 
         </div>
   <div class="col-sm-10">
   <div class="container">
         <div class="row">
         <?php if($lesProduits==null){echo '<h3>Aucun produit correspondant à cette recherche</h3>';} ?>
         <?php $count=0; foreach ($lesProduits as $unProduit){$count++; ?>
          

<div class="col-md-3 col-sm-6">
            <div class="product-grid">
                <div class="product-image">
                <a href="<?= base_url().'index.php/Visiteur/voirUnProduit/'.$unProduit->NOPRODUIT?>">
                                   <?php  if(!empty($unProduit->NOMIMAGE)){?><img class='img-responsive image' src="<?= base_url().'assets/images/'.$unProduit->NOMIMAGE.'.jpg'?>" alt="<?= $unProduit->LIBELLE ?>">
                                   <?php } else{?> <img class='img-responsive image' src="<?= base_url().'assets/images/nonimage.jpg'?>" alt="<?= $unProduit->LIBELLE ?>"><?php } ?>
                                   </a>
                </div>
                <div class="product-content">
                    <h3 class="title"><a href="<?= base_url().'index.php/Visiteur/voirUnProduit/'.$unProduit->NOPRODUIT?>"><?php echo $unProduit->LIBELLE ?></a>
                    <?php if($this->session->statut==3){?>
                                   <a href="<?php echo site_url('administrateurSuper/Vitrine/'.$unProduit->NOPRODUIT);  ?>"><?php if($unProduit->VITRINE==1){ echo "<i class='fas fa-star fav'></i>";}else{echo "<i class='far fa-star fav'></i>";}?> </a>
                              <?php }?></h3>
                    <div class="price">
                    <?php echo number_format((($unProduit->PRIXHT) + ($unProduit->TAUXTVA)), 2 , "," , ' '),'€' ?>
                    </div>
                    <?php if($this->session->statut==3){
                                    if($unProduit->DISPONIBLE==0){
                                ?>
                                <a class="disponible" href="<?php echo site_url('administrateurSuper/rendreDisponible/'.$unProduit->NOPRODUIT);  ?>">Rendre disponible</a>
                                <?php } else{?>

            <a class="indisponible" href="<?php echo site_url('administrateurSuper/rendreIndisponible/'.$unProduit->NOPRODUIT);  ?>">Rendre indisponible</a>
            <?php } ?>
             <?php }else{?>
               <?php if($unProduit->DISPONIBLE==0){echo 'Rupture de stock..'; }?><br/>
                            <div class='container'>  <a class="add-to-cart btn <?php if($unProduit->DISPONIBLE==0){echo 'disabled'; }?>" href="<?php echo site_url('Visiteur/ajouterAuPanier/'.$unProduit->NOPRODUIT);  ?>">Ajouter au panier</a>
             </div> <?php } ?>
                </div>
            </div>
        </div>
        
             
              <?php if($count%4 ==0){echo '</div><br/><hr/><br/><div class="row">';}
              }?>
         </div>

 </div>
 
 <p><?php echo $liensPagination; ?></p>
 
 </div>
 
 
 
</div>
</div>