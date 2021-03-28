
    <div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12 container">
<h2 class="text-primary"><?php echo $TitreDeLaPage ?></h2>
<?php echo validation_errors();
echo form_open('administrateurSuper/ajouterUneCategorie') ?>

    
    <label class="text-primary" for="txtCategorie">Nom de la categorie</label>
    <input class="form-control" type="input" name="txtCategorie" value="<?php echo set_value('txtCategorie'); ?>" /><br />

    <input class="btn btn-primary btn-md" type="submit" name="submit" value="Ajouter une categorie" />
</form>
</div>
                </div>
            </div>
        </div>
    </div>
