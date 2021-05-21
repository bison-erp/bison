<script>
function deletePack(id) {
    if (confirm("Voulez vous supprimer ce pack")) {

        $.post("ajax.php", {
                action: "delete_pack",
                pack_id: id,
            },
            function(data) {
                location.reload();

            });

    }

}
</script>

<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="index.php">Home</a><i class="fa fa-circle"></i>
    </li>
    <!--li>
            <a href="page_about.html">Pages</a>
            <i class="fa fa-circle"></i>
    </li-->
    <li class="active">
        <?php echo $title; ?>
    </li>
</ul>
<div style="">
    <a href="index.php?module=packs&action=add" class="btn btn-sm green" style="margin: 14px 22px;"><i
            class="fa fa-plus"></i> Nouveau pack </a>
</div>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE CONTENT INNER -->
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase"><?php echo $title; ?></span>
        </div>

    </div>
    <div class="portlet-body">
        <div class="row margin-bottom-30">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pack</th>
                                <th>Description</th>
                                <th align="center" style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
if (count($packs) != 0) {
    $cnt = 0;
    ?>
                            <?php
foreach ($packs as $pack) {
        $cnt++;
        ?>
                            <tr>
                                <td><?php echo $cnt; ?></td>
                                <td><?php echo utf8_encode($pack['pack_name']); ?></td>

                                <td>
                                    <ul>
                                        <li>
                                            Nombre de collaborateurs :
                                            <?php echo $pack['nb_collaborateurs'] == "-1" ? 'Illimit&eacute;' : $pack['nb_collaborateurs']; ?>
                                        </li>
                                        <li>
                                            Nombre de factures par mois :
                                            <?php echo $pack['nb_factures_mois'] == "-1" ? 'Illimit&eacute;' : $pack['nb_factures_mois']; ?>
                                        </li>
                                        <li>
                                            Nombre de devis par mois :
                                            <?php echo $pack['nb_devis_mois'] == "-1" ? 'Illimit&eacute;' : $pack['nb_devis_mois']; ?>
                                        </li>
                                        <li>
                                            Documents multi-devises :
                                            <?php echo $pack['multi_devises'] == "1" ? 'Oui' : 'Non'; ?>
                                        </li>
                                        <li>
                                            Export PDF par lot :
                                            <?php echo $pack['export_lot_pdf'] == "1" ? 'Oui' : 'Non'; ?>
                                        </li>
                                        <li style="display: none;">
                                            Plusieurs établissements :
                                            <?php echo $pack['multi_societes'] == "1" ? 'Oui' : 'Non'; ?>
                                        </li>
                                        <li>
                                            Export de données (Excel) :
                                            <?php echo $pack['export_excel'] == "1" ? 'Oui' : 'Non'; ?>
                                        </li>
                                        <li>
                                            Relance automatique :
                                            <?php echo $pack['relance'] == "1" ? 'Oui' : 'Non'; ?>
                                        </li>
                                        <li>
                                            Export contact :
                                            <?php echo $pack['export_contact'] == "1" ? 'Oui' : 'Non'; ?>
                                        </li>
                                        <li>
                                            Avec signature bison ou sans Signature :
                                            <?php echo $pack['signature'] == "1" ? 'Oui' : 'Non'; ?>
                                        </li>
                                        <li>
                                            Gestion de stock :
                                            <?php echo $pack['gestionstock'] == "1" ? 'Oui' : 'Non'; ?>
                                        </li>

                                    </ul>
                                </td>
                                <td align="center">
                                    <div style="width: 70px;">
                                        <a href="index.php?module=packs&action=edit&id=<?php echo $pack['pack_id']; ?>"
                                            class="btn default btn-xs blue tooltips" data-placement="top"
                                            data-original-title="Modifier"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:;" onclick="deletePack('<?php echo $pack['pack_id']; ?>')"
                                            class="btn default btn-xs red tooltips" data-placement="top"
                                            data-original-title="Supprimer"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </td>
                            </tr><?php }?>
                            <?php } else {?>
                            <tr>
                                <td colspan="8" align="center" style="line-height:40px;">Aucun Pack</td>
                            </tr>

                            <?php }?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/row-->

    </div>
</div>
<!-- END PAGE CONTENT INNER -->