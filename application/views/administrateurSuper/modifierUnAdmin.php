
    <div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12 container">

<?php
  echo validation_errors(); 
  echo form_open('AdministrateurSuper/modifierUnAdmin/'.$Identifiant);

  echo form_label('Identifiant','txtIdentifiant','class="text-primary"');
  echo form_input('txtIdentifiant', $Identifiant,'class="form-control"'); 
  if(isset($erreurID) AND !empty($erreurID)){echo $erreurID;echo '<br/>';}

  echo form_label('Mot de passe','txtMdp','class="text-primary"');
  echo form_password('txtMdp',set_value('txtMdp') ,'class="form-control"');  

  echo form_label('Email','txtEmail','class="text-primary"');
  echo form_input('txtEmail',$mail,'class="form-control"'); 
  if(isset($mailErr) AND !empty($mailErr)){echo $mailErr;echo '<br/>';}

  echo form_submit('submit', 'Modifier','class="btn btn-primary btn-md"');
  echo form_close();
  ?> <br/><?php /* echo validation_errors();
  echo form_open('AdministrateurSuper/modifierUnAdmin'.$Identifiant) ?>
      <label for="txtID" class="text-primary">Identifiant</label><br>
      <input class="form-control" type="input" name="txtID" value="<?php echo set_value('txtID'); ?>" />

      <label for="txtMdp" class="text-primary">Mot de passe</label><br>
      <input class="form-control" type="password" name="txtMdp" value="<?php echo set_value('txtMdp'); ?>" />

      <label for="txtEmail" class="text-primary">Email</label><br>
      <input class="form-control" type="input" name="txtEmail" value="<?php echo set_value('txtEmail'); ?>" />
      
      <?php if(isset($erreur)){echo $erreur;} ?>
      <br/>
  <input type="submit" name="submit" class="btn btn-primary btn-md" value="Valider">
</form>*/?>
  

    </div>
                </div>
            </div>
        </div>
    </div>
