<?php foreach ($families as $familie) {?>
<tr>
    <td style=" width: 30px">

        <div class="md-radio">
            <input type="radio" id="radio1<?php echo $familie->family_id; ?>" name="client_ids[]"
                onclick="myFunction()" class="md-radiobtn" value="<?php echo $familie->family_id; ?>">
            <label for="radio1<?php echo $familie->family_id; ?>">
                <span></span>
                <span class="check"></span>
                <span class="box"></span>
            </label>
        </div>
    </td>
    <td nowrap class="text-left">
        <b><?php echo $familie->family_name; ?></b>

    </td>   
</tr>

<?php }?>