<?php foreach ($categories as $categorie) {?>
    <tr>
                            <td style=" width: 30px">
                                <div class="md-radio">
                                    <input type="radio" id="radio1<?php echo $categorie->id_categorie_fournisseur; ?>"
                                        name="client_ids[]" onclick="myFunction()" class="md-radiobtn"
                                        value="<?php echo $categorie->id_categorie_fournisseur; ?>">
                                    <label for="radio1<?php echo $categorie->id_categorie_fournisseur; ?>">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td nowrap class="nom<?php echo $categorie->id_categorie_fournisseur; ?> text-left">
                                <b><?php echo $categorie->designation ; ?></b>
                            </td>
                            <td class="rt_<?php echo $categorie->id_categorie_fournisseur ; ?>">
                                <b><?php echo $categorie->ret_source ; ?></b>
                            </td>  
                        </tr>

<?php }?>