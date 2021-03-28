
    <div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12 container">
<h2 class="text-primary"><?php echo $TitreDeLaPage ?></h2>

<?php
  echo validation_errors(); 
  echo form_open('Client/modifierSonCompte');

  echo form_label('Nom','txtNom','class="text-primary"');
  echo form_input('txtNom', $Nom,'class="form-control"'); 
  if (isset($nomErr) AND !empty($nomErr) ){ echo $nomErr; echo"<br/>" ; }

  echo form_label('Prenom','txtPrenom','class="text-primary"');
  echo form_input('txtPrenom', $Prenom,'class="form-control"'); 
  if (isset($prenomErr) AND !empty($prenomErr) ){echo $prenomErr; echo"<br/>" ;}

  echo form_label('Adresse','txtAdresse','class="text-primary"');
  echo form_input('txtAdresse', $Adresse,'class="form-control"');   
  if (isset($adresseErr) AND !empty($adresseErr) ){echo $adresseErr; echo"<br/>" ;}

  echo form_label('Ville','txtVille','class="text-primary"');
  echo form_input('txtVille', $Ville,'class="form-control"'); 
  if (isset($villeErr) AND !empty($villeErr) ){echo $villeErr; echo"<br/>" ;}


  echo form_label('Code Postal','txtCP','class="text-primary"');
  echo form_input('txtCP', $CP,'class="form-control"');   
  if (isset($CPErr) AND !empty($CPErr) ){echo $CPErr; echo"<br/>" ;}

  echo form_label('Email','txtPrenom','class="text-primary"');
  echo form_input('txtEmail', $Email,'class="form-control"');  
  if (isset($mailErr) AND !empty($mailErr) ){echo $mailErr; echo"<br/>" ;}

  echo form_label('Mot de passe','txtMdp','class="text-primary"');
  echo form_password('txtMdp',set_value('txtMdp'),'class="form-control"'); 

  echo form_submit('submit', 'Modifier','class="btn btn-primary btn-md"');
  ?> <br/><br/> <?php
  if (isset($erreur) AND !empty($erreur) )
  {
    echo $erreur;
  }
  echo form_close();
?>
</div>
                </div>
            </div>
        </div>
    </div>
