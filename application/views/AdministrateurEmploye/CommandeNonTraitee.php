
    <div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                    <div class="container">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                
                                <th width="30%">Date de commande</th>
                                <th width="15%">Client</th>
                                <th width="13%">Total</th>
                                <th width="15%">Traitée</th>
                                
                                </tr>
                            </thead>


                        <?php
                        foreach($commandenontraitee as $commande){?>
                        <tr onclick="window.location.href = '<?php echo site_url('AdministrateurEmploye/detailcommandenontraitee/'.$commande->NOCOMMANDE) ?>'" class="hover">
                       <td>
                       <?php echo substr($commande->DATECOMMANDE,0,10);?></td>
                       <td>
                        <?php echo $commande->NOM; echo ' '.$commande->PRENOM;?></td>
                       <td>
                        <?php echo $commande->TOTALTTC.'€';?></td>
                        <td><a href="<?php echo site_url('AdministrateurEmploye/passerCommandeATraiter/'.$commande->NOCOMMANDE) ?>" class="btn btn-success btn-sm">Traitée</td></a></tr>
                        <?php }?></table>
                    </div>
            </div>
        </div>
    </div>
  