<script>
function deleteClient(id) {
    if (confirm("Voulez vous supprimer ce client")) {

        $.post("ajax.php", {
                action: "delete_client",
                id_client: id,
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
    <a href="index.php?module=clients&action=add" class="btn btn-sm green" style="margin: 14px 22px;"><i
            class="fa fa-plus"></i> Nouveau client </a>
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
                                <th>Client</th>

                                <th>Soci&eacute;t&eacute;</th>
                                <th>Email</th>
                                <th style="text-align:center">Pack</th>
                                <th>Database</th>
                                <th style="text-align:center;">Licence key</th>
                                <th style="text-align:center">&Eacute;tat</th>
                                <th style="text-align:center">Date création</th>
                                <th style="text-align: center; width:115px;">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
if (count($clients) != 0) {
    $cnt = 0;
    $licences_denied = array("lvfi", "0007");
    ?>
                            <?php
foreach ($clients as $client) {
        $cnt++;
        ?>
                            <tr>
                                <td><?php echo $cnt; ?></td>
                                <td><?php echo utf8_encode($client['nom']) . " " . utf8_encode($client['prenom']); ?>
                                </td>
                                <td><?php echo utf8_encode($client['societe']) ?></td>
                                <td><?php echo $client['email'] ?></td>
                                <td align="center">
                                    <?php
$pack_info = getPackInfo($client['pack_id']);
        echo isset($pack_info['pack_name']) ? $pack_info['pack_name'] : '-';
        ?>
                                </td>
                                <td <?php if (!existDB($client['database'])) {
            echo "style='color:#D00'";
        }
        ?>><?php echo $client['database'] ?></td>
                                <td style="font-family: monospace;font-size: 14px;" align="center">
                                    <?php echo $client['licence_key'] ?></td>
                                <td align="center">
                                    <?php if ($client['statut'] == 0) {
            echo '<span class="fa fa-minus-circle font-red-soft"></span>';
        }
        ?>
                                    <?php if ($client['statut'] == 1) {
            echo '<span class="fa fa-check-circle font-green-soft"></span>';
        }
        ?>

                                </td>
                                <td align="center"><?php
$date_array = explode(" ", $client['created']);
        echo dateSlashes($date_array[0]);
        ?></td>
                                <td align="center">
                                    <div>
                                        <a href="index.php?module=clients&action=edit&id=<?php echo $client['abonne_id']; ?>"
                                            class="btn default btn-xs blue tooltips" data-placement="top"
                                            data-original-title="Modifier"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:;"
                                            onclick="deleteClient('<?php echo $client['abonne_id']; ?>')"
                                            class="btn default btn-xs red tooltips" data-placement="top"
                                            data-original-title="Supprimer"><i class="fa fa-trash-o"></i></a>
                                        <?php if (!in_array(strtolower($client['licence_key']), $licences_denied)) {?>
                                        <a href="<?php echo url() . '/superadmin_connect/index/' . strtolower($client['licence_key']); ?>"
                                            onclick="return confirm('Voulez vous connecter en tant que <?php echo $client['licence_key'] ?> ?\n cela permet de déconnecter de la session activé');"
                                            target="_blank" class="btn default btn-xs tooltips" data-placement="top"
                                            data-original-title="Connecter à ce compte"><i
                                                class="fa fa-external-link"></i></a>
                                        <?php }?>
                                    </div>
                                </td>
                            </tr><?php }?>
                            <?php } else {?>
                            <tr>
                                <td colspan="8" align="center" style="line-height:40px;">Aucun Client</td>
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