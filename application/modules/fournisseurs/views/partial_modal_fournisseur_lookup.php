<?php foreach ($fournisseurs as $fournisseur) {?>
<tr>
    <td style=" width: 30px">

        <div class="md-radio">
            <input type="radio" id="radio1<?php echo $fournisseur->id_fournisseur; ?>" name="client_ids[]"
                onclick="myFunction()" class="md-radiobtn" value="<?php echo $fournisseur->id_fournisseur; ?>">
            <label for="radio1<?php echo $fournisseur->id_fournisseur; ?>">
                <span></span>
                <span class="check"></span>
                <span class="box"></span>
            </label>
        </div>
    </td>
    <td nowrap class="text-left">
        <b><?php echo $fournisseur->prenom . ' ' . $fournisseur->nom; ?></b>

    </td>
    <td>
        <b><?php echo $fournisseur->raison_social_fournisseur; ?></b>
    </td>
    <td>
        <?php echo $fournisseur->mail_fournisseur; ?>
    </td>
    <td>
        <?php echo $fournisseur->tel_fournisseur; ?>
    </td>
    <td>
        <?php echo $fournisseur->mobile; ?>
    </td>
    <td style=" display: none">

    </td>
</tr>

<?php }?>