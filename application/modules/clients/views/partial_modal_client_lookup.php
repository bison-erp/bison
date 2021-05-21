<?php foreach ($clients as $client) { ?>
    <tr>
        <td style=" width: 30px" >

            <div class="md-radio">
                <input type="radio" id="radio1<?php echo $client->client_id; ?>" name="client_ids[]" onclick="myFunction()"
                       class="md-radiobtn" value="<?php echo $client->client_id; ?>">
                <label for="radio1<?php echo $client->client_id; ?>">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                </label>
            </div>
        </td>
        <td nowrap class="text-left">
            <b><?php echo $client->client_name . ' ' . $client->client_prenom; ?></b>
            
        </td>
        <td>
            <b><?php echo $client->client_societe; ?></b>
        </td>
        <td>
            <?php echo $client->client_email; ?>
        </td>
        <td>
            <?php echo $client->client_phone; ?>
        </td>
        <td>
            <?php echo $client->client_mobile; ?>
        </td>
        <td style=" display: none">
            <?php echo ($client->client_active) ? lang('yes') : lang('no'); ?>
        </td>
    </tr>

<?php } ?>