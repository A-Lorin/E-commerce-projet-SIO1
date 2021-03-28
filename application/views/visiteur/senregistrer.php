
    <div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12 container">
                        <?php echo validation_errors();
                            echo form_open('Visiteur/senregistrer') ?>
                            <h3 class="text-center text-primary"><?php echo $TitreDeLaPage ?></h3>
                                <label for="txtNom" class="text-primary">Nom</label><br>
                                <input class="form-control" type="input" name="txtNom" value="<?php echo set_value('txtNom'); ?>" />
                                <?php if (isset($nomErr) AND !empty($nomErr) ){ echo $nomErr; echo"<br/>" ; } ?>

                                <label for="txtPrenom" class="text-primary">Prénom</label><br>
                                <input class="form-control" type="input" name="txtPrenom" value="<?php echo set_value('txtPrenom'); ?>" />
                                <?php if (isset($prenomErr) AND !empty($prenomErr) ){echo $prenomErr; echo"<br/>" ;} ?>

                                <label for="txtAdresse" class="text-primary">Adresse</label><br>
                                <input class="form-control" type="input" name="txtAdresse" value="<?php echo set_value('txtAdresse'); ?>" />
                                <?php if (isset($adresseErr) AND !empty($adresseErr) ){echo $adresseErr; echo"<br/>" ;} ?>

                                <label for="txtVille" class="text-primary">Ville</label><br>
                                <input class="form-control" type="input" name="txtVille" value="<?php echo set_value('txtVille'); ?>" />
                                <?php if (isset($villeErr) AND !empty($villeErr) ){echo $villeErr; echo"<br/>" ;} ?>

                                <label for="txtCP" class="text-primary">Code Postal</label><br>
                                <input class="form-control" type="input" name="txtCP" value="<?php echo set_value('txtCP'); ?>" />
                                <?php if (isset($CPErr) AND !empty($CPErr) ){echo $CPErr; echo"<br/>" ;} ?>

                                <label for="txtEmail" class="text-primary">Email</label><br>
                                <input class="form-control" type="input" name="txtEmail" value="<?php echo set_value('txtEmail'); ?>" />
                                <?php if (isset($mailErr) AND !empty($mailErr) ){echo $mailErr; echo"<br/>" ;} ?>

                                <label for="txtMdp" class="text-primary">Mot de passe</label><br>
                                <input class="form-control" type="password" name="txtMdp" id="mdp" value="<?php echo set_value('txtMdp'); ?>" />
                                <input type="checkbox" onclick="Affichermasquermdp()"> Afficher le mot de passe<br/>
                                
                                
                            <input type="submit" name="submit" class="btn btn-primary btn-md" value="Valider">
                            <div class="text-primary right">
                            <a class="btn btn-primary" href="<?php echo site_url('Visiteur/seConnecter') ?>">Se connecter</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language=javascript>
     function Affichermasquermdp() {
  var x = document.getElementById("mdp");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
      </script> 