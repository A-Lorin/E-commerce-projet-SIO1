
    
        <div class="container">
            <div class="row justify-content-center align-items-center">
                    <div class="container col-md-5">
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                
                                <th width="10%">N° client</th>
                                <th width="15%">Client</th>
                                
                                </tr>
                            </thead>
                        <?php
                        foreach($clients as $client){?>
                        <tr onclick="window.location.href = '<?php echo site_url('AdministrateurEmploye/historiqueCommande/'.$client->NOCLIENT) ?>'" class="hover">
                        <td><?php echo $client->NOCLIENT;?> </td>
                        <td> <?php echo $client->NOM; echo ' '.$client->PRENOM;?> </td></tr>
                        <?php }?></table>
                    </div>
            </div>
        </div>
    
