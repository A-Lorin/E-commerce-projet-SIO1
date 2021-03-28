

<?php echo form_open('visiteur/updateCart'); ?>
<div class="container col-md-8 col-sm-12 toppro">
<h2>Panier</h2>

<div class="row align-items-center">
<table class="table table-responsive-md">

<tr>
        <th width="10%"></th>
        <th width="30%">Produit</th>
        <th width="15%">Prix</th>
        <th width="13%">Quantité</th>
        <th width="25%">total pour ce produit</th>
        <th width="12%"></th>
</tr>

<?php $i = 1; ?>

<?php if($this->cart->total_items() > 0){foreach ($this->cart->contents() as $items):?>
    <tr><td style="display:none;"><?php echo form_hidden($i.'[rowid]', $items['rowid']); ?></td></tr>
        <tr>
        <td>
                <?php if(!empty($items['image'])){ ?>
                <a href="<?= base_url().'index.php/Visiteur/voirUnProduit/'.$items['id']?>"><img src="<?= base_url().'assets/images/'.$items['image'].'.jpg'?>" width="80"/></a>
                <?php } else{?>
                    <a href="<?= base_url().'index.php/Visiteur/voirUnProduit/'.$items['id']?>"><img src="<?= base_url().'assets/images/nonimage.jpg'?>" width="80"/></a>
                <?php } ?>
            </td>
                <td><a  href="<?= base_url().'index.php/Visiteur/voirUnProduit/'.$items['id']?>"><?php echo $items['name']; ?></a></td>
                <td><?php echo $this->cart->format_number($items['price']); ?>€</td>
                <td><?php echo form_input(array('name' =>$i.'[qty]', 'type'=>'number','class'=>'form-control', 'style'=>'width:75px' ,'value' => $items['qty'], 'min'=>1,'max'=>$items['maxi'])); ?></td>
                <td><?php echo $this->cart->format_number($items['subtotal']); ?>€</td>
                <td><a href="<?php echo site_url('visiteur/removeItem/'.$items["rowid"]); ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                 </tr>

<?php $i++; ?>

<?php endforeach; }else{?>
<tr><td colspan="6"><p>Aucun produit dans le panier</p></td></tr>
        <?php } ?>
        <tr>
            <td><a href="<?php echo site_url('visiteur/ListerLesProduits'); ?>" class="btn btn-warning">Continuer vos achats</a></td>
            <td colspan="2"></td>
            <td><?php echo form_submit('quantité', 'Modifier la quantité', "class='btn btn-info'");?></td>
            <?php if($this->cart->total_items() > 0){ ?>
            <td>Total: <?php echo $this->cart->total().' €'; ?></td>
            <?php if (!empty($this->session->statut)){?>
            <td><a href="<?php echo site_url('Client/validationCommande'); ?>" class="btn btn-success">Passer la commande</a></td>
            <?php } else {?>
            <td><a href="<?php echo site_url('visiteur/seConnecter'); ?>" class="btn btn-success">Passer la commande</a></td>
            <?php } ;
            } ?>
        </tr>

</table>
<?php echo form_close();?>

</div>
</div>

