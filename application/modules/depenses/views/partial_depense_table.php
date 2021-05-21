<?php
$sess_payement_add = $this->session->userdata['payement_add'];
$sess_payement_del = $this->session->userdata['payement_del'];
$sess_payement_index = $this->session->userdata['payement_index'];
?>



<?php
//return ('1');die();
$montanttotal = 0;
$montanttotaltva = 0;
$net_payer = 0;
foreach ($depense as $depense) {?>
<?php $montanttotal += $depense->montant_facture;?>
<?php $net_payer += $depense->net_payer;?>
<?php $montanttotaltva += $depense->montant_tva;?>
<tr>
    <td style="white-space:nowrap;">
        <?php echo $depense->date_facture != "" ? date_from_mysql($depense->date_facture, 1) : ''; ?>
    </td>
    <td style="white-space:nowrap;">

        <?php echo $depense->date_paiement != "" ? date_from_mysql($depense->date_paiement, 1) : ""; ?></td>

    <td style="white-space:nowrap;">
        <?php echo $depense->num_facture ?>

    </td>
    <td style="white-space:nowrap;">
        <?php if ($depense->id_fournisseur != 0) {?>
        <a target="_blanc" href="<?php echo ('/fournisseurs/form/' . $depense->id_fournisseur); ?>">
            <?php if (!empty($depense->nom) && !empty($depense->prenom)) {
    echo ($depense->nom . ' ' . $depense->prenom);
} else {
    echo ($depense->raison_social_fournisseur);
}

    ?>
        </a>
        <?php }?>
    </td>

    <td style="white-space:nowrap;"><?php echo $depense->montant_facture; ?>
    </td>

    <td style="white-space:nowrap;"><?php echo $depense->montant_tva; ?></td>

    <td style="white-space:nowrap;">
    <?php echo $depense->net_payer; ?>
    </td>
    <td style="white-space:nowrap;"><?php echo $depense->payment_method_name; ?></td>
    <td style="white-space:nowrap;">
        <?php
if (($sess_payement_add == 1) || ($sess_payement_del == 1)) {?>
        <div class="options btn-group">
            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-cog"></i> <?php //echo lang('options');  ?>
            </a>
            <ul class="dropdown-menu" style="margin-left: -138px;margin-top: 0px;">
                <?php if ($sess_payement_add == 1) {?> <li>
                    <a href="<?php echo site_url('depenses/form/' . $depense->id_depense); ?>">
                        <i class="fa fa-edit fa-margin"></i>
                        <?php echo lang('edit'); ?>
                    </a>
                </li><?php }?>
                <?php if ($sess_payement_del == 1) {?><li>
                    <a href="<?php echo site_url('depenses/delete/' . $depense->id_depense); ?>"
                        onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                        <i class="fa fa-trash-o fa-margin"></i>
                        <?php echo lang('delete'); ?>
                    </a>
                </li><?php }?>
            </ul>
        </div><?php }?>
    </td>
</tr>
<?php }?>

<tr style="background:#FFF;">
    <td colspan="8" style="white-space: initial;"></td>
</tr>


<tr style="background: #EFF3F8; font-weight:bold;">
    <td colspan="3" style=" border:none;">
        <?php
echo " (" . ($countdepense) . ")"; ?>
    </td>
    <td style=" border:none;">
    <td   style="border:none;text-align: center;"><?php echo " (" . ($montanttotal) . ")"; ?></td>
     <td   style="border:none;text-align: center;"><?php echo " (" . ($montanttotaltva) . ")"; ?></td>

    <td    style="border:none;text-align: center;"><?php echo " (" . ($net_payer) . ")"; ?></td>
    <td style=" border:none;"></td>

</tr>

<tr style="display:none">
    <script>
    <?php
$nb_pages = isset($nb_pages) ? $nb_pages : 1;
$start_page = isset($start_page) ? $start_page : 1;
$nb_all_lines = isset($nb_all_lines) ? $nb_all_lines : 1;
$start_line = isset($start_line) ? $start_line : 1;?>
    nb_pages = <?php echo $nb_pages; ?> ;
    start_page = <?php echo $start_page; ?> ;
    nb_all_lines = <?php echo $nb_all_lines; ?> ;
    start_line = <?php echo $start_line; ?> ;
    if (nb_pages == 0)
        nb_pages = 1;
    $("#number_current_page").text(start_page + '/' + nb_pages);
    if (start_page == 1 || start_page == 0) {
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