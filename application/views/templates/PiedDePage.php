</main>
<Div class="navbar piedpage" style="background: #2d3246;">
<div class='container-fluid '>

        	<div class="col-md-3 col-sm-6">
            	<h2><img class="d-block" style="height:64px;" src="<?= base_url().'assets/images/logo.jpg'?>" alt="Logo"></h2>
                <a href="<?php echo site_url('Visiteur/flux_rss') ?>">
                <img src="<?= base_url().'assets/images/rss.png'?>" width="60" height="20">
                </a>
                <p>Projet web<br/>Site marchand</p>
                <p>© 2020</p>
            </div>
        	<div class="col-md-3 col-sm-6">
            	<h4>Nous contacter</h4>
                <p><a href='https://www.google.fr/maps/place/Lyc%C3%A9e+Rabelais/@48.5042205,-2.7503218,17z/data=!4m13!1m7!3m6!1s0x480e1d185a2011d3:0xca3c59f0bff91073!2s8+Rue+Rabelais,+22000+Saint-Brieuc!3b1!8m2!3d48.5042205!4d-2.7481331!3m4!1s0x480e1d18e9d8109d:0x739b07353bbf2d23!8m2!3d48.5042841!4d-2.7468056'><i class="fas fa-map-marker-alt"></i> 8 Rue Rabelais, 22000 Saint-Brieuc</a></p>
                <p><a href='mailto:Dupont@yopmail.com'><i class="fas fa-envelope"></i> Dupont@yopmail.com</a></p>
                <p><a href="#"><i class="fas fa-phone"></i> 02 96 68 32 70</a></p><br/>
            </div>
        	<div class="col-md-3 col-sm-6">
            	<h4>Nous suivre</h4>
                	<p><a href="https://www.facebook.com/DupontShop"><i class="fab fa-facebook-square"></i> Facebook</a></p>
                	<p><a href="https://www.twitter.com/DupontShop"><i class="fab fa-twitter-square"></i> Twitter</a></p>
                	<p><a href="https://www.Instagram.com/DupontShop"><i class="fab fa-instagram"></i> Instagram</a></p><br/>
            </div>
            
        	<div class="col-md-3 col-sm-6">
            	<h4>Newsletter</h4>
                <p>Abonnez vous à notre newsletter pour ne rater aucune nouveauté</p>
                <p>
                    <div class="input-group">
                    <form class="form-inline" method="post" action="<?php echo site_url('Visiteur/ajoutnewsletter') ?>">
                      <input type="email" class="form-control input-res" name="mailnewsletter" placeholder="votre mail">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span> <i class="fas fa-envelope-square"></i></span></button>
                        
                        
                      </span>
                      </form>
                    </div>
                 <br/><br/>
            </div>
        
        </div>
</div>
</body>

</html>