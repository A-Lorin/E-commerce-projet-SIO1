<div class="container toppro">
	        <div class="row">
	        	<div class="col-md-5">
	        		 
            <?php  if(!empty($unProduit->NOMIMAGE)){?><img src="<?= base_url().'assets/images/'.$unProduit->NOMIMAGE.'.jpg'?>" alt="<?= $unProduit->LIBELLE ?>">
            <?php } else{?> <img src="<?= base_url().'assets/images/nonimage.jpg'?>" alt="<?= $unProduit->LIBELLE ?>"><?php } ?>
            
					
	        	</div>
	        	<div class="col-md-6">
                            <div>
                                <h3><?php echo $unProduit->LIBELLE ?></h3><hr/>
                                <?php if($nbavis==null){echo 'Aucun avis sur ce produit jusqu\'a maintenant<hr/>';}else{?>
                                Note des utilisateurs
                                <h2 class="bold padding-bottom-7"><?php $avg=number_format($avgrating->AVIS,1) ;echo $avg  ; ?> <small>/ 5</small></h2><hr/><?php }?>
                               <?php echo anchor('Visiteur/listerLesProduitsparmarque/'.$marque->NOMARQUE,$marque->NOM);echo '<hr/>';
                                    echo anchor('Visiteur/listerLesProduitsparcategorie/'.$categorie->NOCATEGORIE,$categorie->LIBELLE);echo '<hr/>';?>
                                <div>
					
                                    <h5><?php echo number_format((($unProduit->PRIXHT) + ($unProduit->TAUXTVA)), 2 , "," , ' '),' €' ?></h5>
                                </div><br/>
                                <?php if($this->session->statut==3){ ?>
                                    <a class="btn btn-warning" href="<?php echo site_url('administrateurSuper/modifierProduit/'.$unProduit->NOPRODUIT);  ?>">Modifier</a>
                                    <?php if($unProduit->DISPONIBLE==0){
                                ?>
                                <a class="btn btn-warning" href="<?php echo site_url('administrateurSuper/rendreDisponible/'.$unProduit->NOPRODUIT);  ?>">Rendre disponible</a>
                                <?php } else{?>

            <a class="btn btn-danger" href="<?php echo site_url('administrateurSuper/rendreIndisponible/'.$unProduit->NOPRODUIT);  ?>">Rendre indisponible</a>
            <?php }}else{?>
               <?php if($unProduit->DISPONIBLE==0){echo 'Rupture de stock..'; }?><br/>
                             <span class="produit"> <a class="btn ajoutpanier <?php if($unProduit->DISPONIBLE==0){echo 'disabled'; }?>" href="<?php echo site_url('Visiteur/ajouterAuPanier/'.$unProduit->NOPRODUIT);  ?>">Ajouter au panier</a></span>
            <?php } ?>
            
                           
	        	</div>
	        </div>
	       <!-- <div class="product-info-tabs">
		        <ul class="nav nav-tabs" id="myTab" role="tablist">
				  	<li class="nav-item">
				    	<a class="nav-link active" id="description-tab" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
				  	</li>
				</ul>
				<div class="tab-content" id="myTabContent">
				  	<div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
            <?php //echo $unProduit->DETAIL ?></div>
				  	
				</div>
            </div>-->
            </div>
            <div class="product-info-tabs">
		        <ul class="nav nav-tabs" id="myTab" role="tablist">
				  	<li class="nav-item">
				    	<a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
				  	</li>
				  	<li class="nav-item">
				    	<a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Avis <?php echo '('.$nbavis.')'?></a>
				  	</li>
                      <?php if(isset($monAvis) and $monAvis==false and isset($achat)){?>
                      <li class="nav-item">
				    	<a class="nav-link" id="addavis-tab" data-toggle="tab" href="#addavis" role="tab" aria-controls="addavis" aria-selected="false">Ajouter un avis</a>
				  	</li>
                      <?php }elseif(isset($monAvis) and $monAvis!=null){ ?>
                        <li class="nav-item">
				    	<a class="nav-link" id="updateavis-tab" data-toggle="tab" href="#updateavis" role="tab" aria-controls="updateavis" aria-selected="false">Modifier mon avis</a>
				  	</li>
                      <?php } ?>
				</ul>
				<div class="tab-content" id="myTabContent">
				  	<div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                      <?php echo $unProduit->DETAIL ?>
				  	</div>

                    
                      
				  	<div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                          <?php if($nbavis==null){echo '<p class="mb-20">Aucun avis à propos de ce produit pour l\'instant.</p>';}else{
                           foreach($LesAvis as $avis){ 
                               $date=date_create($avis->DATEAVIS);
                            $datetime1 = new DateTime($avis->DATEAVIS);
                            $datetime2 = new DateTime(date('c'));
                            $interval = $datetime1->diff($datetime2);
                            if($interval->format('%a')==0)
                            {
                                $diff='Aujoud\'hui';
                            }
                            if($interval->format('%a')==1)
                            {
                                $diff='Hier';
                            }
                            if($interval->format('%a')==2)
                            {
                                $diff='Avant hier';
                            }
                            if($interval->format('%a')>2 and $interval->format('%a')<7)
                            {
                                $diff='Il y a moins d\'une semaine';
                            }
                            elseif($interval->format('%a')>=7 and $interval->format('%a')<14)
                            {
                                $diff='Il y a une semaine';
                            }
                            elseif($interval->format('%a')>=14 and $interval->format('%a')<21)
                            {
                                $diff='Il y a deux semaine';
                            }
                            elseif($interval->format('%a')>=21 and $interval->format('%a')<30)
                            {
                                $diff='Il y a trois semaine';
                            }
                            elseif($interval->format('%a')>=30 and $interval->format('%a')<60)
                            {
                                $diff='Il y a un mois';
                            }
                            elseif($interval->format('%a')>60 and $interval->format('%a')<90)
                            {
                                $diff='Il y a deux mois';
                            }
                            elseif($interval->format('%a')>90 and $interval->format('%a')<180)
                            {
                                $diff='Il y a plus de deux mois';
                            }
                            elseif($interval->format('%a')>180 and $interval->format('%a')<210)
                            {
                                $diff='Il y a six mois';
                            }
                            elseif($interval->format('%a')>210 and $interval->format('%a')<365)
                            {
                                $diff='Il y a plus de six mois';
                            }
                            elseif($interval->format('%a')>365 and $interval->format('%a')<730)
                            {
                                $diff='Il y a plus d\'un an';
                            }
                            elseif($interval->format('%a')>730 and $interval->format('%a')<1095)
                            {
                                $diff='Il y a plusieurs années';
                            }
                            ?>
                            
                          
                          
                          <div class="review-block">
					<div class="row">
						<div class="col-sm-3">
							<div class="review-block-name"><h5><?php echo $avis->NOM." ".$avis->PRENOM ?></h5></div>
							<div class="review-block-date"><?php echo date_format($date,"j F Y"); ?><br/><?php echo $diff; if($avis->MODIFIER==1){echo ' <i title="modifié "class="fas fa-edit"></i>';}?></div>
						</div>
						<div class="col-sm-9">
							<div class="review-block-rate">
                                <?php if($avis->AVIS==5){?>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                <?php }elseif($avis->AVIS==4){?>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                <i class='fas fa-star'></i>
                                <?php }elseif($avis->AVIS==3){?>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                <i class='fas fa-star'></i>
                                <i class='fas fa-star'></i>
                                <?php }elseif($avis->AVIS==2) {?>
                                    <i class='fas fa-star fav'></i>
                                    <i class='fas fa-star fav'></i>
                                <i class='fas fa-star'></i>
                                <i class='fas fa-star'></i>
                                <i class='fas fa-star'></i>
                                <?php }elseif($avis->AVIS==1){?>
                                <i class='fas fa-star fav'></i>
                                <i class='fas fa-star'></i>
                                <i class='fas fa-star'></i>
                                <i class='fas fa-star'></i>
                                <i class='fas fa-star'></i>
                                <?php } ?>
							</div>
							<div class="review-block-title"><h5><?php echo $avis->TITRECOMMENTAIRE ?></h5></div>
							<div class="review-block-description"><?php echo $avis->COMMENTAIRE ?></div>
						</div>
					</div>
                    <hr/>
                    </div>
                    <?php }?> <?php }?></div>
					


                    <div class="tab-pane fade" id="addavis" role="tabpanel" aria-labelledby="addavis-tab">
				  		<form class="review-form" method='post' action="<?php echo site_url('Client/Noter/'.$unProduit->NOPRODUIT)?>">
		        			<div class="form-group">
			        			<label>Quel note donnez vous à ce produit?</label>
			        			<div class="reviews-counter">
                                    <section>
									<div class="rate">

                                    <input type="radio" id="star5" name="rate" value="5"/>
								    <label for="star5" >5 stars</label>
								    <input type="radio" id="star4" name="rate" value="4"/>
								    <label for="star4" >4 stars</label>
								    <input type="radio" id="star3" name="rate" value="3" />
								    <label for="star3" >3 stars</label>
								    <input type="radio" id="star2" name="rate" value="2" />
								    <label for="star2">2 stars</label>
								    <input type="radio" id="star1" name="rate" value="1" />
								    <label for="star1" >1 star</label>
									    
									</div></section>
								</div>
							</div>
                            <div class="form-group">
					        			<input type="text" name="txtTitreAvis" class="form-control" placeholder="Sujet de votre avis">
					        		</div>
		        			<div class="form-group">
			        			<label>Votre avis</label>
			        			<textarea class="form-control" name="txtAvis" rows="5"></textarea>
			        		</div>
					        <button class="round-black-btn" type="submit">Ajouter mon avis</button>
			        	</form>
				  	</div>
                      <!--                          -->


                      <?php if(isset($monAvis) and $monAvis!=false){?>
                      <div class="tab-pane fade" id="updateavis" role="tabpanel" aria-labelledby="updateavis-tab">
				  		<form class="review-form" method='post' action="<?php echo site_url('Client/ModifierNote/'.$unProduit->NOPRODUIT)?>">
		        			<div class="form-group">
			        			<label>Quel note donnez vous à ce produit?</label>
			        			<div class="reviews-counter">
                                <div class="modifrate">
								    <input type="radio" id="modifstar5" name="modifrate" value="5" <?php if($monAvis->AVIS==5){echo 'checked';}?> />
								    <label for="modifstar5" >5 stars</label>
								    <input type="radio" id="modifstar4" name="modifrate" value="4" <?php if($monAvis->AVIS==4){echo 'checked';}?>/>
								    <label for="modifstar4" >4 stars</label>
								    <input type="radio" id="modifstar3" name="modifrate" value="3" <?php if($monAvis->AVIS==3){echo 'checked';}?>/>
								    <label for="modifstar3" >3 stars</label>
								    <input type="radio" id="modifstar2" name="modifrate" value="2" <?php if($monAvis->AVIS==2){echo 'checked';}?>/>
								    <label for="modifstar2" >2 stars</label>
								    <input type="radio" id="modifstar1" name="modifrate" value="1" <?php if($monAvis->AVIS==1){echo 'checked';}?>/>
								    <label for="modifstar1" >1 star</label>
								  </div>
								</div>
							</div>
                            <div class="form-group">
					        			<input type="text" name="txtmodifTitreAvis" class="form-control" value="<?php echo $monAvis->TITRECOMMENTAIRE;?>">
					        		</div>
		        			<div class="form-group">
			        			<label>Votre avis</label>
			        			<textarea class="form-control" name="txtmodifAvis" rows="5"><?php echo $monAvis->COMMENTAIRE;?></textarea>
			        		</div>
					        <button class="round-black-btn" type="submit">Modifier mon avis</button>
			        	</form>
				  	</div>
                      <?php }?>
			</div>
			
			
	</div>
    