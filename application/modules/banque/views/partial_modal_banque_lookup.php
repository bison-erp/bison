<?php
foreach ($fournisseurs as $fournisseur) {?>
<tr>
    <td style=" width: 30px">

        <div class="md-radio">
            <input type="radio" id="radio1<?php echo $fournisseur->id_banque; ?>" name="client_ids[]"
                onclick="myFunction()" class="md-radiobtn" value="<?php echo $fournisseur->id_banque; ?>">
            <label for="radio1<?php echo $fournisseur->id_banque; ?>">
                <span></span>
                <span class="check"></span>
                <span class="box"></span>
            </label>
        </div>
    </td>
    <td nowrap class="text-left">
        <b><?php echo $fournisseur->nom_banque; ?></b>

    </td>
</tr>

<?php }?>