<style>
.modal .modal-header {
    height: 79px;
}

.md-radio label {
    padding-left: 20px !important;
}

#clients_table {
    margin-top: 6px;
}
</style>
<script type="text/javascript">
$(function() {

    // Display the create invoice modal
    $('#modal-choose-items').modal('show');

    // Creates the invoice
    $('#select-items-confirmx').click(function() {

        var client_ids = $("input[name='client_ids[]']:checked").val();
        var json_response = [];
        $(".md-radiobtn:checked").each(function() {
            //$(this).closest('tr').find('td:eq(2)').text()
            $.post("<?php echo site_url('fournisseurs/ajax/get_fournisseur'); ?>", {
                    client_ids: client_ids
                }, function(data) {
                    var parsed = JSON.parse(data); 
                    for (var x in parsed) {
                       
                            json_response.push(parsed[x]);
                    }        
                        var  client= json_response;
                        if ($("#action").val() != "edit") {
                            $("#client_id").val(client[0].id_fournisseur);
                            $("#client_name").val(client[0].nom);

                            $('#symbole_devise').val(client[0].devise_symbole);
                            $('#tax_rate_decimal_places').val(client[0].number_decimal);
                            $('#currency_symbol_placement').val(client[0].symbole_placement);
                            $('#thousands_separator').val(client[0].thousands_separator);

                            $('#fact_prod .devise_view').each(function() {
                                $(this).text(client[0].devise_symbole);
                            });
                            $('#client_societe').val(client[0].raison_social_fournisseur);
                            $('#client_address').val(client[0].adresse_fournisseur);
                            $('#client_pays').val(client[0].ville_fournisseur);
                            $('#tax_code').val(client[0].matricule);
                            $('#vat_id').val('');
                            $('#quote_date_expires').attr('disabled', false);
                    } else {
                     
                       /* t = client[0].client_titre;
                        if (t == 0)
                            titr = 'M.';
                        if (t == 1)
                            titr = 'Mme.';
                        if (t == 2)
                            titr = 'Melle.';*/
                        $('#client_id').val(client[0].id_fournisseur);
                        var client_fullname =
                            '<h4><b><a href="<?php echo base_url() . 'fournisseurs/form/'; ?>' +
                            client[0].id_fournisseur + '">'+ client[0].nom + ' ' + client[0].prenom + '</a></h4></b><br>';
                       // var client_address_1 = client[0].adresse_fournisseur;
                        var client_address_1 = client[0].adresse_fournisseur?client[0].adresse_fournisseur:'';
                        var client_matricule =  client[0].matricule?client[0].matricule:'';
                        var client_address_2 = '';
                   //     var client_city = client[0].client_city;
                   //     var client_state = client[0].client_state;
                      //  var client_zip = client[0].client_zip;
                        var client_country = client[0].ville_fournisseur;
                        var client_phone = client[0].tel_fournisseur?client[0].tel_fournisseur:'';
                        var client_email = client[0].mail_fournisseur;
                        var client_societe = "<b>Sociéte:</b> " + client[0].raison_social_fournisseur;
                        var adresse = "<br><b>Adresse: </b>" + client_address_1 +" " + client_country;
                      //  var Code_tva = "<br><b>Code TVA:</b> " + client[0].client_mobile;
                        $('#client_infos_edit').html(client_fullname + "<br>" + client_societe +
                            '<br>' + adresse +
                            "<br><br><b> N°Téléphone:</b> " +
                            client_phone+"<br><br><b> Email :</b> " +
                            client_email + '<br><br><b>Registre de commerce </b>' +client_matricule);
                            $('#fact_prod .devise_view').each(function() {
                                $(this).text(client[0].devise_symbole);
                            });
                    }

                    
          
        })
       
        //    $("#client_id").val(client[0].id_fournisseur);
      //      $("#client_name").val(client[0].nom);
            
            /* $('#fournisseur_id').append('<option value="' + parseInt(client_ids) +
                 '" selected="selected">' +
                 $(this).closest('tr').find('td:eq(2)').text() + '</option>');*/
            $('#modal-choose-items').modal('hide');
        });
    });

    $('#filter_client').keyup(function() {
        clients_filter();
    });

    function clients_filter() {
        var filter_family = $('#filter_family').val();
        var filter_client = $('#filter_client').val();
        var lookup_url = "<?php echo site_url('fournisseurs/ajax/partial_modal_fournisseur_lookup'); ?>/";
        lookup_url += Math.floor(Math.random() * 1000) + '/?';
        if (filter_client) {
            lookup_url += "&filter_fournisseur=" + filter_client;
        }
        $("#clients_table tbody").load(lookup_url, {});
    }

    $('#add_client_btn_modal').click(function() {
        $('#modal-choose-items').modal('hide');

        $('#modal-placeholder').load(
            "<?php echo site_url('fournisseurs/ajax/modal_fournisseur_add'); ?>/" + Math
            .floor(Math.random() * 1000), {});
    });

});
</script>
<input  type="hidden" type="checkbox" id="checkboxtest" value="">
<input type="hidden" id="type_doc" value="<?php //echo $type_doc; ?>">
<input type="hidden" id="action" value="<?php echo $action; ?>">
<div id="modal-choose-items" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true"
    style="display: block;width: 65%;height: 85%;overflow:hidden !important;z-index: 99999;background-color: #Fffff;margin-top: 22px;border-radius: 6px;">
    <div class="modal-content" style=" width: 100%">
        <div class="modal-header"
            style=" width: 61%;position: fixed; z-index: 999 ;border-bottom: 0px;height: 100xp;  background-color: rgb(255, 255, 255) !important; ">
            <div class="form-inline" style="border-bottom: 1px solid #e5e5e5; width: 100%">
                <div class="row">
                    <div class="col-md-3" style="font-weight: 600;font-size: 18px;margin-bottom: 14px;">
                        <?php echo lang('add_four');?> </div>
                    <div class=" col-md-3">
                        <input type="text" class="form-control" name="filter_client" id="filter_client"
                            placeholder="<?php echo lang('name') ?>" value="<?php echo $filter_client ?>" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="add_client_btn_modal" class="btn btn-default">
                            <?php echo lang('create_fournisseur');?></button>
                    </div>
                    <div class=" col-md-3" id="mod_footer" style=" white-space: nowrap;width: 250px;display: none">
                        <div class="btn-group">
                            <button class="btn default" type="button" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                                <?php echo lang('cancel'); ?>
                            </button>
                            <button class="btn blue btn-success" id="select-items-confirmx" type="button">
                                <i class="fa fa-check"></i>
                                <?php echo lang('submit'); ?>
                            </button>
                        </div>
                    </div>
                    <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                        style="width: 22px; height: 20px; color: #FFF !important; background-image: none !important; background-color: rgb(220, 53, 88) !important; text-align: center; position: absolute; text-indent: 0px; opacity: 1; top: 10px; right: 0px;">
                        <i class="fa fa-close"></i></button>
                </div>
            </div>

        </div>
        <div class="modal-body" style="  z-index: 888; margin-top: 94px;  ">
            <div class="table-responsive">
                <table id="clients_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style=" width: 20px">&nbsp;</th>
                            <th><?php echo lang('client_name_tab'); ?></th>
                            <th><?php echo lang('company'); ?></th>
                            <th><?php echo lang('client_email_tab'); ?></th>
                            <th><?php echo lang('client_telFix_tab'); ?></th>
                            <th><?php echo lang('client_telmobile_tab'); ?></th>
                            <th style=" display: none"><?php echo lang('active'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fournisseurs as $fournisseur) {?>
                        <tr>
                            <td style=" width: 30px">
                                <div class="md-radio">
                                    <input type="radio" id="radio1<?php echo $fournisseur->id_fournisseur; ?>"
                                        name="client_ids[]" onclick="myFunction()" class="md-radiobtn"
                                        value="<?php echo $fournisseur->id_fournisseur; ?>">
                                    <label for="radio1<?php echo $fournisseur->id_fournisseur; ?>">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td nowrap class="nom<?php echo $fournisseur->id_fournisseur; ?> text-left">
                                <b><?php echo $fournisseur->nom . ' ' . $fournisseur->prenom; ?></b>
                            </td>
                            <td>
                                <b><?php echo $fournisseur->raison_social_fournisseur; ?></b>
                            </td>
                            <td>
                                <?php echo $fournisseur->mail_fournisseur; ?>
                            </td>
                            <td>
                                <?php echo $fournisseur->tel_fournisseur; ?>
                            </td>
                            <td>
                                <?php echo $fournisseur->mobile; ?>
                            </td>
                            <td style=" display: none">
                                <?php echo ($fournisseur->client_active) ? lang('yes') : lang('no'); ?>
                            </td>
                        </tr>

                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
        function myFunction() {
            $("#mod_footer").show();
        }
        </script>
    </div>

</div>