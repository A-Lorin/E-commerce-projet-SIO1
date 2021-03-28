

    <div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12 container">
                        <?php echo validation_errors();
                            echo form_open('AdministrateurSuper/ajouterAdministrateur') ?>
                            <h3 class="text-center text-primary"><?php echo $titreDeLaPage;?></h3>
                                <label for="txtID" class="text-primary">Identifiant</label><br>
                                <input class="form-control" type="input" name="txtID" value="<?php echo set_value('txtID'); ?>" />

                                <label for="txtMdp" class="text-primary">Mot de passe</label><br>
                                <input class="form-control" type="password" name="txtMdp" value="<?php echo set_value('txtMdp'); ?>" />

                                <label for="txtEmail" class="text-primary">Email</label><br>
                                <input class="form-control" type="input" name="txtEmail" value="<?php echo set_value('txtEmail'); ?>" />
                                
                                <?php if(isset($erreur)){echo $erreur;} ?>
                                <br/>
                            <input type="submit" name="submit" class="btn btn-primary btn-md" value="Valider">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
