<?php
$userid = $this->session->userdata['user_id'];
$sess_cont_add = $this->session->userdata['cont_add'];
$sess_cont_del = $this->session->userdata['cont_del'];
$sess_cont_index = $this->session->userdata['cont_index'];
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_facture_add = $this->session->userdata['facture_add'];
?>

<?php
foreach ($records as $client) {
    $adr = '';
    $adr = $client->client_address_1 . ' ' . $client->client_zip . ' ' . $client->client_city;
    if (strlen($client->client_address_1 . ' ' . $client->client_zip . ' ' . $client->client_city) > 2) {
        $adr .= ', ' . $client->client_country;
    } else {
        $adr .= $client->client_country;
    }
    ?>
<tr>
    <?php $fullname = $client->client_name . ' ' . $client->client_prenom;
    $fullname2 = substr($fullname, 0, 20);
    if (strlen($fullname) > 20) {
        $fullname2 .= '<b style="color:#1BC5BD">...</b>';
    }

    ?>
    <td style="white-space:nowrap;vertical-align: middle;">
        <?php echo anchor('clients/view/' . $client->client_id, $fullname2); ?></td>
    <td style="white-space:nowrap;vertical-align: middle;">
        <?php echo anchor('clients/view/' . $client->client_id, ' #' . $client->client_id); ?></td>
    <td style="white-space:nowrap;vertical-align: middle;" title="<?php echo $client->client_societe; ?> "><?php
echo substr($client->client_societe, 0, 15);
    if (strlen($client->client_societe) > 15 && trim($client->client_societe) != "") {
        echo '<b style="color:#1BC5BD">...</b>';
    }

    ?></td>
    <td style="white-space:nowrap;vertical-align: middle;" title="<?php echo $client->client_email; ?> "><?php
echo substr($client->client_email, 0, 10);
    if (strlen($client->client_email) > 10 && trim($client->client_email) != "") {
        echo '<b style="color:#1BC5BD">&nbsp;&nbsp;...</b>';
    }

    ?></td>
    <td style="white-space:nowrap;vertical-align: middle;"><?php echo ($client->client_phone); ?></td>
    <td style="white-space:nowrap;vertical-align: middle;"><?php echo ($client->client_mobile); ?></td>
    <td style="white-space:nowrap;vertical-align: middle;" title="<?php echo $client->client_web; ?> "><?php
echo substr($client->client_web, 0, 15);
    if (strlen($client->client_web) > 15 && trim($client->client_web) != "") {
        echo '<b style="color:#1BC5BD">&nbsp;&nbsp;...</b>';
    }

    ?></td>
    <td style=" white-space:nowrap;text-align: right; vertical-align: middle; <?php if ($client->solde < 0) {
        echo 'color:#EE2D41';
    }
    ?>">
        <?php echo format_devise($client->solde, $client->devise_id); ?>
    </td>
    <td style="white-space:nowrap;vertical-align: middle;"><?php
if ($client->client_type == 0) {
        echo lang('prospect_filter');
    } else {
        echo lang('client_filter');
    }

    ?></td>
    <td>

        <div class="md-checkbox">
            <input type="checkbox" name="Choix[]" value="<?php echo $client->client_id ?>"
                id="checkbox3_<?php echo $client->client_id; ?>" class="md-check">
            <label for="checkbox3_<?php echo $client->client_id; ?>">
                <span></span>
                <span class="check"
                    style="border-color: -moz-use-text-color #0AC877 #09B07B -moz-use-text-color;"></span>
                <span class="box"></span>
            </label>
        </div>
    </td>
    <td style="white-space:nowrap; text-align: right; vertical-align: middle;">
        <div class="options btn-group">
            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-cog"></i> <?php // echo lang('options');     ?>
            </a>
            <ul class="dropdown-menu dropdown-btngroup-menu">
                <?php if (($sess_cont_index == 1)) {?><li>
                    <a href="<?php echo site_url('clients/view/' . $client->client_id); ?>">
                        <i class="fa fa-eye fa-margin"></i> <?php echo lang('view'); ?>
                    </a>
                </li><?php }?>
                <?php if (($sess_cont_add == 1) && ($userid == $client->user_id)) {?><li>
                    <a href="<?php echo site_url('clients/form/' . $client->client_id); ?>">
                        <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                    </a>
                </li><?php
}
    if ($sess_devis_add == 1) {
        ?>
                <li>
                    <a href="<?php echo base_url(); ?>quotes/form/0/<?php echo $client->client_id; ?>"
                        class="client-create-quote" data-client-name="<?php echo $client->client_name; ?>">
                        <i class="fas fa-comment-dollar" aria-hidden="true"></i>  <?php echo lang('create_quote'); ?>
                    </a>
                </li>
                <?php
}
    if ($sess_facture_add == 1) {
        ?>
                <li>
                    <a href="<?php echo base_url(); ?>invoices/form/0/<?php echo $client->client_id; ?>"
                        class="client-create-invoice" class="client-create-invoice"
                        data-client-name="<?php echo $client->client_name; ?>">
                        <i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>  <?php echo lang('create_invoice'); ?>
                    </a>
                </li>
                <?php
}
    //if(($sess_cont_del==1)&&($userid==$client->user_id))
    if ($this->session->userdata['groupes_user_id'] == 1) {
        ?><li>
                    <a href="<?php echo site_url('clients/delete/' . $client->client_id); ?>"
                        onclick="return confirm('<?php echo lang('delete_client_warning'); ?>');">
                        <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                    </a>
                </li><?php }?>
            </ul>
        </div>
    </td>
</tr>
<?php }?>
<tr style="display:none">
    <script>
    nb_pages = <?php echo $nb_pages; ?>;
    start_page = <?php echo $start_page; ?>;
    nb_all_lines = <?php echo $nb_all_lines; ?>;
    start_line = <?php echo $start_line; ?>;
    if (nb_pages == 0)
        nb_pages = 1;
    $("#number_current_page").text(start_page + '/' + nb_pages);
    if (start_page == 1) {
        $("#btn_fast_backward").addClass("disabled");
        $("#btn_fa_backward").addClass("disabled");
    } else {
        $("#btn_fast_backward").removeClass("disabled");
        $("#btn_fa_backward").removeClass("disabled");
    }
    if (start_page == nb_pages) {
        $("#btn_fast_forward").addClass("disabled");
        $("#btn_fa_forward").addClass("disabled");
    } else {
        $("#btn_fast_forward").removeClass("disabled");
        $("#btn_fa_forward").removeClass("disabled");
    }
    </script>
</tr>