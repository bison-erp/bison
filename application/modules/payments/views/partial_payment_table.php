<?php
$sess_payement_add = $this->session->userdata['payement_add'];
$sess_payement_del = $this->session->userdata['payement_del'];
$sess_payement_index = $this->session->userdata['payement_index'];
?>

<?php foreach ($payments as $payment) { ?>
    <tr>
        <td style="white-space:nowrap;"><?php echo $payment->payment_date!="" ? date_from_mysql($payment->payment_date,1):""; ?></td>
        <td style="white-space:nowrap;"><?php echo $payment->invoice_date_created != "" ? date_from_mysql($payment->invoice_date_created,1):''; ?></td>
        <td style="white-space:nowrap;"><?php if ($payment->invoice_id != 0) echo anchor('invoices/view/' . $payment->invoice_id, $payment->invoice_number); ?></td>
        <td style="white-space:nowrap;">
            <a href="<?php echo site_url('clients/view/' . $payment->client_id); ?>"
               title="<?php echo $payment->client_societe . " (" . $payment->client_name . ' ' . $payment->client_prenom . ")"; ?>">
                   <?php // echo $payment->client_name; ?>
                                <?php
                if (trim($payment->client_societe) != '')
                    $client_name = $payment->client_societe;
                else
                    $client_name = $payment->client_name . ' ' . $payment->client_prenom;
                echo substr($client_name, 0, 20);
                if (strlen($client_name) > 20)
                    echo'<b style="color:#1BC5BD">&nbsp;...</b>';
                ?>
                
            </a>
        </td>
        <td style="white-space:nowrap;"><?php echo format_devise($payment->payment_amount,$payment->client_devise_id); ?></td>
        <td style="white-space:nowrap;"><?php echo $payment->payment_method_name; ?></td>
        <td style="white-space:nowrap;"><?php echo $payment->payment_ref; ?></td>

        <td style="white-space:nowrap;" >
            <span title="<?php echo $payment->payment_note; ?>">
            <?php
            $payment_note = $payment->payment_note;
            echo mb_substr($payment_note, 0, 25, 'UTF-8');
            if (strlen($payment_note) > 25)
                echo'<b style="color:#1BC5BD">...</b>';
//            echo $payment->payment_note;
            ?>
            </span>
        </td>
       <td style="white-space:nowrap;" > 
			<div class="md-checkbox">
				<input type="checkbox" name="Choix[]" data-send_mail="1" value="<?php echo $payment->payment_id; ?>" id="checkbox30_<?php echo $payment->payment_id; ?>" class="md-check" onchange="myFunctionchech(<?php echo $payment->payment_id ?>)">
				<label for="checkbox30_<?php echo $payment->payment_id; ?>">
					<span></span>
					<span class="check"></span>
					<span class="box" ></span>
				</label>
			</div>
       </td>
        <td style="white-space:nowrap; text-align: right">
            <?php if (($sess_payement_add == 1) || ($sess_payement_del == 1)) { ?>
                <div class="options btn-group">
                    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-cog"></i> <?php //echo lang('options');  ?>
                    </a>
                    <ul class="dropdown-menu" style="margin-left: -133px;margin-top: -3px;">
                        <?php if ($sess_payement_add == 1) { ?> <li>
                                <a href="<?php echo site_url('payments/form/' . $payment->payment_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i>
                                    <?php echo lang('edit'); ?>
                                </a>
                            </li><?php } ?>
                        <?php if ($sess_payement_del == 1) { ?><li>
                                <a href="<?php echo site_url('payments/delete/' . $payment->payment_id); ?>" onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                    <i class="fa fa-trash-o fa-margin"></i>
                                    <?php echo lang('delete'); ?>
                                </a>
                            </li><?php } ?>
                    </ul>
                </div><?php } ?>
        </td>
    </tr>
<?php } ?>
    
    <?php
if (count($devises) != 0) {
    ?>
    <tr style="background:#FFF;">
        <td colspan="8" style="white-space: initial;"></td>
    </tr>
    <?php
    foreach ($devises as $devise) {
        $payment_total_amounts[$devise->devise_id]["total"] = isset($payment_total_amounts[$devise->devise_id]["total"]) ? $payment_total_amounts[$devise->devise_id]["total"] : 0;
        $payment_total_amounts[$devise->devise_id]["count"] = isset($payment_total_amounts[$devise->devise_id]["count"]) ? $payment_total_amounts[$devise->devise_id]["count"] : 0;
        ?>

        <tr style="background: #EFF3F8; font-weight:bold;">
            <td colspan="4" style=" border:none;"><?php echo (int) $payment_total_amounts[$devise->devise_id]["count"] . " (" . $devise->devise_symbole . ")"; ?></td>
            <td style=" border:none;"><?php echo format_devise($payment_total_amounts[$devise->devise_id]["total"], $devise->devise_id); ?></td>
            <td colspan="4" style="border:none;"></td>
        </tr>

        <?php
    }
}
?>
<tr 
    
<tr style="display:none">
<script>
<?php
$nb_pages = isset($nb_pages) ? $nb_pages : 1;
$start_page = isset($start_page) ? $start_page : 1;
$nb_all_lines = isset($nb_all_lines) ? $nb_all_lines : 1;
$start_line = isset($start_line) ? $start_line : 1;
?>
    nb_pages = <?php echo $nb_pages; ?>;
    start_page = <?php echo $start_page; ?>;
    nb_all_lines = <?php echo $nb_all_lines; ?>;
    start_line = <?php echo $start_line; ?>;
    if (nb_pages == 0)
        nb_pages = 1;
    $("#number_current_page").text(start_page + '/' + nb_pages);
    if (start_page == 1 || start_page == 0) {
        $("#btn_fast_backward").addClass("disabled");
        $("#btn_fa_backward").addClass("disabled");
    }
    else {
        $("#btn_fast_backward").removeClass("disabled");
        $("#btn_fa_backward").removeClass("disabled");
    }
    if (start_page == nb_pages) {
        $("#btn_fast_forward").addClass("disabled");
        $("#btn_fa_forward").addClass("disabled");
    }
    else {
        $("#btn_fast_forward").removeClass("disabled");
        $("#btn_fa_forward").removeClass("disabled");
    }



</script>
</tr>
