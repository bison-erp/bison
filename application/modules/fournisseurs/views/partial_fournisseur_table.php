<?php
$sess_fournisseur_add = $this->session->userdata['fournisseur_add'];
$sess_fournisseur_del = $this->session->userdata['fournisseur_del'];
$sess_fournisseur_index = $this->session->userdata['fournisseur_index'];
?>
<?php foreach ($fournisseurs as $fournisseur) { //print_r($product); ?>
<tr class="odd gradeX">
    <td style="white-space:nowrap;">
        <?php
if (!empty($fournisseur->nom) && !empty($fournisseur->prenom)) {
    echo ($fournisseur->nom . ' ' . $fournisseur->prenom);
} else {
    echo ($fournisseur->raison_social_fournisseur);
}

    ?></td>
    <td tyle="white-space:nowrap;">
        <?php echo $fournisseur->adresse_fournisseur . ' ' . $fournisseur->code_postal_fournisseur . ' ' . $fournisseur->ville_fournisseur . ', ' . $fournisseur->pays_fournisseur; ?>

    </td>


    <td style=" white-space:nowrap; text-align: center; "><?php
echo $fournisseur->mail_fournisseur;

    ?></td>
    <td style="white-space:nowrap; text-align: center;">
        <?PHP echo $fournisseur->tel_fournisseur ?>
    </td>
    <td style="white-space:nowrap; text-align: center;">
        <?php if ($sess_fournisseur_add == 1) {?>
        <a class="icon-param edit-icon-th" href="<?php echo site_url('fournisseurs/form/' . $fournisseur->id_fournisseur); ?>"
            title="<?php echo lang('edit'); ?>"><i class="fas fa-edit"></i></a><?php }?>
			
	</td>
	<td style="white-space:nowrap; text-align: center;">
        <?php if ($sess_fournisseur_del == 1) {?>
        <a class="icon-param delete-icon-th" href="<?php echo site_url('fournisseurs/delete/' . $fournisseur->id_fournisseur); ?>"
            title="<?php echo lang('delete'); ?>"
            onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');"><i class="fas fa-trash-alt"></i></a><?php }?>
    </td>

</tr>
<?php }?>

<tr style="display:none">
    <?php
$nb_pages = isset($nb_pages) ? $nb_pages : 1;
$start_page = isset($start_page) ? $start_page : 1;
$nb_all_lines = isset($nb_all_lines) ? $nb_all_lines : 1;
$start_line = isset($start_line) ? $start_line : 1;
?>
    <input type="hidden" value="<?php echo $nb_pages ?>" id="nbpage">
    <input type="hidden" value="<?php echo $start_page ?>" id="start_page">
    <input type="hidden" value="<?php echo $nb_all_lines ?>" id="nb_all_lines">
    <input type="hidden" value="<?php echo $start_line ?>" id="start_line">

    <script>
    nb_pages = $('#nbpage').val();
    start_page = $('#start_page').val();
    nb_all_lines = $('#nb_all_lines').val();
    start_line = $('#start_line').val();
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