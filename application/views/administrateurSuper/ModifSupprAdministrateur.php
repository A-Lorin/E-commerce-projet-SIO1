
    <div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12 container">
                        <h3> Les Admins </h3><br/>
                        
                        <?php if(empty($admins))
                        {
                            echo 'Aucun administrateur';
                        }
                        else
                        {?>
                        <table class="table table-hover">
                            
                            <?php
                        foreach($admins as $admin){?>
                        
                        <tr>
                        <td><?php echo $admin->IDENTIFIANT;?></td>
                        <td><a class="btn btn-primary btn-sm" href="<?php echo site_url('AdministrateurSuper/modifierUnAdmin/'.$admin->IDENTIFIANT);?>">Modifier</a></td>
                        <td><a class="btn btn-primary btn-sm" href="<?php echo site_url('AdministrateurSuper/supprimerUnAdmin/'.$admin->IDENTIFIANT);?>">Supprimer</a></td>
                        <?php }}?></table>

                    </div>
                </div>
            </div>
        </div>
    </div>
