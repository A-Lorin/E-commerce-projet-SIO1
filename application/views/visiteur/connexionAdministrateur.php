
<div  class='container'>
<h2 class="text-primary"><?php echo $TitreDeLaPage ?></h2>
<?php
  echo validation_errors(); 
  echo form_open('visiteur/connexionAdministrateur');
  echo form_label('Identifiant','txtIdentifiant', "class='text-primary'");
  echo form_input('txtIdentifiant', set_value('txtIdentifiant'), "class='col-md-3 form-control'");    
  echo form_label('Mot de passe','txtMotDePasse', "class='text-primary'");
  echo form_password('txtMotDePasse', set_value('txtMotDePasse'), "class='form-control col-md-3'");    
  echo form_submit('submit', 'Se connecter', "class='btn btn-primary'");
  ?> <br/><br/> <?php
  if (isset($erreur) AND !empty($erreur) )
  {
    echo $erreur;
  }
  echo form_close();
?></div>