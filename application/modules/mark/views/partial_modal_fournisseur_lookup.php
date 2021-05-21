<?php foreach ($mark as $marque) {?>
    <tr>
                            <td style=" width: 30px">
                                <div class="md-radio">
                                    <input type="radio" id="radio1<?php echo $marque->id_mark; ?>"
                                        name="client_ids[]" onclick="myFunction()" class="md-radiobtn"
                                        value="<?php echo $mark->id_mark; ?>">
                                    <label for="radio1<?php echo $mark->id_mark; ?>">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td nowrap class="nom<?php echo $mark->id_mark; ?> text-left">
                                <b><?php echo $mark->name_mark ; ?></b>
                            </td>
                           
                        </tr>

<?php }?>