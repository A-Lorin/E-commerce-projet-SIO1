

    <div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12 container">
                    <h2 class="text-primary"><?php echo $TitreDeLaPage ?></h2>

<?php
  echo validation_errors(); 
  echo form_open('AdministrateurSuper/modifierProduit/'.$noproduit);

  echo form_label('Libelle','txtLibelle','class="text-primary"');
  echo form_input('txtLibelle', $Libelle,'class="form-control"');  ?> <br /><br /><?php 

  echo form_label('Detail','txtDetail','class="text-primary"');
  echo form_textarea('txtDetail', $Detail,'class="form-control"');    ?> <br /><br /><?php

  echo form_label('Prix HT','txtPrix','class="text-primary"');
  echo form_input('txtPrix', $Prix,'class="form-control"'); ?> <br /><br /><?php


  echo form_label('Stock','txtStock','class="text-primary"');
  echo form_input('txtStock', $Stock,'class="form-control"');    ?> <br /><br /><?php

  echo form_label('Vitrine', 'useCheckboxVitrinername','class="text-primary"');?><br/>
 
  <label class="switch">
          <input type="checkbox" class="primary" name="checkbox" value="1" <?php if($Vitrine==1){echo 'checked';}?>>
          <span class="slider"></span>
        </label><br/>
  
  
<?php
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
