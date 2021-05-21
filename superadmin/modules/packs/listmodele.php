<script>
function deleteModele(id) {
    if (confirm("Voulez vous supprimer ce modéle")) {

        $.post("ajax.php", {
                action: "delete_modele",
                id_model: id,
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
    <a href="index.php?module=packs&action=addmodele" class="btn btn-sm green" style="margin: 14px 22px;"><i
            class="fa fa-plus"></i> Nouveau modéle </a>
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
                                <th>Forfait</th>
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
                                <td><?php echo  utf8_encode($pack['model_title']); ?></td>
                                <td><?php echo utf8_encode($pack['model_body']); ?></td>
                                 
                                <td align="center">
                                    <div style="width: 70px;">
                                        <a href="index.php?module=packs&action=editmodele&id=<?php echo $pack['id_model']; ?>"
                                            class="btn default btn-xs blue tooltips" data-placement="top"
                                            data-original-title="Modifier"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:;" onclick="deleteModele('<?php echo $pack['id_model']; ?>')"
                                            class="btn default btn-xs red tooltips" data-placement="top"
                                            data-original-title="Supprimer"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </td>
                            </tr><?php }?>
                            <?php } else {?>
                            <tr>
                                <td colspan="8" align="center" style="line-height:40px;">Aucun Modéle</td>
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