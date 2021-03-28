<div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12 container">
                    <h2 class="text-primary">Message pour la newsletter</h2>

<?php
  echo validation_errors(); 
  echo form_open('AdministrateurSuper/newslettermessage');

  echo form_label('Objet','txtObjet','class="text-primary"');
  echo form_input('txtObjet', '','class="form-control"');  ?> <br /><?php 

  echo form_label('Titre','txttitle','class="text-primary"');
  echo form_input('txttitle', '','class="form-control"');    ?> <br /><?php

  echo form_label('Message','txtmessage','class="text-primary"');
  echo form_textarea('txtmessage', '','class="form-control"');    ?> <br /><?php
  
  echo form_submit('submit', 'Envoyer','class="btn btn-primary btn-md"');
  ?> <br/><br/> 
            </div>
                </div>
            </div>
        </div>
    </div>
