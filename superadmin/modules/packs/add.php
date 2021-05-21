<script>
function addPack() {
    if ($("#nb_collaborateurs_1").is(":checked")) {
        var nb_collaborateurs = "-1";
    } else {
        nb_collaborateurs = $("#nb_collaborateurs_3").val();
    }


    if ($("#nb_factures_mois_1").is(":checked")) {
        var nb_factures_mois = "-1";
    } else {
        nb_factures_mois = $("#nb_factures_mois_3").val();
    }


    if ($("#nb_devis_mois_1").is(":checked")) {
        var nb_devis_mois = "-1";
    } else {
        nb_devis_mois = $("#nb_devis_mois_3").val();
    }

    var pack_name = $("#pack_name").val();

    if ($("#multi_devises").is(":checked")) {
        var multi_devises = 1;
    } else {
        var multi_devises = 0;
    }

    if ($("#export_lot_pdf").is(":checked")) {
        var export_lot_pdf = 1;
    } else {
        var export_lot_pdf = 0;
    }

    if ($("#multi_societes").is(":checked")) {
        var multi_societes = 1;
    } else {
        var multi_societes = 0;
    }


    if ($("#export_excel").is(":checked")) {
        var export_excel = 1;
    } else {
        var export_excel = 0;
    }
    if ($("#relance").is(":checked")) {
        var relance = 1;
    } else {
        var relance = 0;
    }

    if ($("#export_contact").is(":checked")) {
        var export_contact = 1;
    } else {
        var export_contact = 0;
    }

    if ($("#signature").is(":checked")) {
        var signature = 1;
    } else {
        var signature = 0;
    }
    if ($("#gestionstock").is(":checked")) {
        var gestionstock = 1;
    } else {
        var gestionstock = 0;
    }
  //  console.log($('#packs_id').children("option:selected").val());
    $.post("ajax.php", {
            action: "add_pack",
            pack_name: pack_name,
            nb_collaborateurs: nb_collaborateurs,
            nb_factures_mois: nb_factures_mois,
            nb_devis_mois: nb_devis_mois,
            multi_devises: multi_devises,
            export_lot_pdf: export_lot_pdf,
            multi_societes: multi_societes,
            export_excel: export_excel,
            relance: relance,
            export_contact: export_contact,
            signature: signature,
            gestionstock: gestionstock,
            packs_id:$('#packs_id').children("option:selected").val(),
            montant_collaborateur:$('#montant_collaborateur').val(),
            montant_factures_mois:$('#montant_factures_mois').val(),
            montant_devis_mois:$('#montant_devis_mois').val(),
            montant_multi_devises:$('#montant_multi_devises').val(),
            montant_export_lot_pdf:$('#montant_export_lot_pdf').val(),
            montant_export_excel:$('#montant_export_excel').val(),
            montant_relance:$('#montant_relance').val(),
            montant_export_contact:$('#montant_export_contact').val(),
            montant_gestionstock:$('#montant_gestionstock').val(),
            montant_contacts:$('#montant_contacts').val(),
           
        },
        function(data) {
            window.location.href = "index.php?module=packs";

        });
}
$(function() {
    $("#nb_collaborateurs_1").click(function() {
        $("#nb_collaborateurs_3").prop("disabled", true);
    });
    $("#nb_collaborateurs_2").click(function() {
        $("#nb_collaborateurs_3").prop("disabled", false);
    });


    $("#nb_factures_mois_1").click(function() {
        $("#nb_factures_mois_3").prop("disabled", true);
    });
    $("#nb_factures_mois_2").click(function() {
        $("#nb_factures_mois_3").prop("disabled", false);
    });


    $("#nb_devis_mois_1").click(function() {
        $("#nb_devis_mois_3").prop("disabled", true);
    });
    $("#nb_devis_mois_2").click(function() {
        $("#nb_devis_mois_3").prop("disabled", false);
    });


});
</script>

<style>
textarea {
    max-width: 100%;
}

tbody tr td {
    height: 50px !important;
    vertical-align: middle !important;
}

thead tr th {
    height: 50px !important;
    vertical-align: middle !important;
    background: #F6F6F6;
}

.radio {
    margin: 0 !important;
}

input[type="radio"] {
    position: inherit !important;
    margin: 0 !important;
}
</style>

<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="index.php">Home</a><i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="index.php?module=packs">Packs</a>
        <i class="fa fa-circle"></i>
    </li>
    <li class="active">
        <?php echo $title; ?>
    </li>
</ul>
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

        <div class="row">
            <div class="col-xs-12 col-md-12">
                <table class="table table-bordered table-condensed no-margin" style="width: 700px;margin: 0 auto;">
                    <thead>
                        <tr style="font-weight: bold;">
                            <th width="300">Module</th>
                            <th>Valeur</th>
                            <th  style="text-align: center; " >Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                       <!-- <tr>
                            <td>Nom du pack</td>
                            <td align="center" colspan="2"><input type="text" class="input-sm form-control" width="50"
                                    id="pack_name"></td>
                        </tr>-->
                        <input type="hidden" class="input-sm form-control" width="50"
                                    id="pack_name">
                        <tr>
                            <td>Nombre de collaborateurs</td>
                            <td>
                                <div class="col-md-2" style="line-height: 27px; margin:0;padding:0;width:20px;">
                                    <input type="radio" id="nb_collaborateurs_1" name="nb_collaborateurs" value="0"
                                        class="input-sm form-control" checked>
                                </div>
                                <div class="col-md-4" style="line-height: 27px; margin:0;padding:0;">
                                    Illimit&eacute;
                                </div>
                                <div class="col-md-2" style="line-height: 27px; margin:0;padding:0;width:20px;">
                                    <input type="radio" id="nb_collaborateurs_2" name="nb_collaborateurs" value="1"
                                        class="input-sm form-control">
                                </div>
                                <div class="col-md-4" style="line-height: 27px; margin:0;padding:0;">
                                    <input type="number" disabled id="nb_collaborateurs_3" class="input-sm form-control"
                                        value="0" style="width: 50px; text-align: left; padding: 0 0px 0 5px;">
                                </div>
                            </td>
                            <td><input type="text"  id="montant_collaborateur" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>
                        </tr>
                        <tr>
                            <td colspan="2">Nombre de contacts</td>                            
                            <td><input type="text"  id="montant_contacts"  class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>
                        </tr>
                        <tr>
                            <td>Nombre de factures par mois</td>
                            <td>
                                <div class="col-md-2" style="line-height: 27px; margin:0;padding:0;width:20px;">
                                    <input type="radio" id="nb_factures_mois_1" name="nb_factures_mois" value="0"
                                        class="input-sm form-control" checked>
                                </div>
                                <div class="col-md-4" style="line-height: 27px; margin:0;padding:0;">
                                    Illimit&eacute;
                                </div>
                                <div class="col-md-2" style="line-height: 27px; margin:0;padding:0;width:20px;">
                                    <input type="radio" id="nb_factures_mois_2" name="nb_factures_mois" value="1"
                                        class="input-sm form-control">
                                </div>
                                <div class="col-md-4" style="line-height: 27px; margin:0;padding:0;">
                                    <input type="number" disabled id="nb_factures_mois_3" class="input-sm form-control"
                                        value="0" style="width: 50px; text-align: left; padding: 0 0px 0 5px;">
                                </div>
                            </td>
                            <td><input type="text"  id="montant_factures_mois" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>
                        </tr>

                        <tr>
                            <td>Nombre de devis par mois</td>
                            <td>
                                <div class="col-md-2" style="line-height: 27px; margin:0;padding:0;width:20px;">
                                    <input type="radio" id="nb_devis_mois_1" name="nb_devis_mois" value="0"
                                        class="input-sm form-control" checked>
                                </div>
                                <div class="col-md-4" style="line-height: 27px; margin:0;padding:0;">
                                    Illimit&eacute;
                                </div>
                                <div class="col-md-2" style="line-height: 27px; margin:0;padding:0;width:20px;">
                                    <input type="radio" id="nb_devis_mois_2" name="nb_devis_mois" value="1"
                                        class="input-sm form-control">
                                </div>
                                <div class="col-md-4" style="line-height: 27px; margin:0;padding:0;">
                                    <input type="number" disabled id="nb_devis_mois_3" class="input-sm form-control"
                                        value="0" style="width: 50px; text-align: left; padding: 0 0px 0 5px;">
                                </div>
                            </td>
                            <td><input type="text"  id="montant_devis_mois" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>
                        </tr>

                        <tr>
                            <td>Documents multi-devises </td>
                            <td align="center"><input type="checkbox" id="multi_devises" class="input-sm form-control"
                                    checked></td>
                            <td><input type="text"  id="montant_multi_devises" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>
                        </tr>

                        <tr>
                            <td>Export PDF par lot</td>
                            <td align="center"><input type="checkbox" id="export_lot_pdf" class="input-sm form-control"
                                    checked></td>
                            <td><input type="text"  id="montant_export_lot_pdf" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>        
                        </tr>

                        <tr style="display: none;">
                            <td>Plusieurs établissements</td>
                            <td align="center"><input type="checkbox" id="multi_societes" class="input-sm form-control"
                                    checked></td>
                            <td><input type="text"  id="montant_multi_societes" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>            
                        </tr>

                        <tr>
                            <td>Import/export fichiers</td>
                            <td align="center"><input type="checkbox" id="export_excel" class="input-sm form-control"
                                    checked></td>
                            <td><input type="text"  id="montant_export_excel" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>                         
                        </tr>
                        <tr>
                            <td>Relance automatique </td>
                            <td align="center"><input type="checkbox" id="relance" class="input-sm form-control"
                                    checked></td>
                            <td><input type="text"  id="montant_relance" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>                      
                        </tr>
                     <!--  <tr>
                            <td>Export contact </td>
                            <td align="center"><input type="checkbox" id="export_contact" class="input-sm form-control"
                                    checked></td>
                                    <td><input type="text"  id="montant_export_contact" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>               
                        </tr>-->
                        <input type="hidden"  id="montant_export_contact" class="input-sm form-control"
                            style="text-align: center; " value="0.000" >
                        <tr>
                            <td>Gestion de stock </td>
                            <td align="center" ><input type="checkbox" id="gestionstock" class="input-sm form-control"
                                    checked></td>                                        
                                  
                                    <td><input type="text"  id="montant_gestionstock" class="input-sm form-control"
                            style="text-align: center; " value="0.000" ></td>            
                        </tr>
                        <tr>
                            <td>Avec signature bison ou sans Signature </td>
                            <td   align="center"><input type="checkbox"  id="signature" class="input-sm form-control"
                                    checked></td>
                        </tr>
                        <!--<tr>
                            <td>Modéle d'email </td>
                            <td align="center">
                           
                            <select id="packs_id" class="form-control">
                                                                             
                                        <option value="0"> </option>
                                      <?php  
                               //  for($i=0;$i<count($packs);$i++){            
                                 ?>  
                                   <option value="<?php //echo($packs[$i]['id_model']) ?>"> <?php //echo($packs[$i]['model_title']) ?> </option>
                                 <?php //}?>
                                                        </select>-->
                           
                      <!--  </tr>-->
                    </tbody>

                </table>

            </div>
        </div>





        <div style="text-align:center; margin-top:20px;">
            <a href="index.php?module=clients" class="btn default">Cancel</a>
            <button class="btn blue" onclick="addPack()"><i class="fa fa-check"></i> Save</button>
        </div>


    </div>
</div>
<!-- END PAGE CONTENT INNER -->