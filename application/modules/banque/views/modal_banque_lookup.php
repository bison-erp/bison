<style>
.modal .modal-header {
    height: 79px;
}

.md-radio label {
    padding-left: 20px !important;
}

#banque_table {
    margin-top: 6px;
}
</style>
<script type="text/javascript">
$(function() {

    // Display the create invoice modal
    $('#modal-choose-items').modal('show');

    // Creates the invoice
    $('#select-items-confirmx').click(function() {
        $(".md-radiobtn:checked").each(function() {
            var client_ids = $("input[name='client_ids[]']:checked").val();
            if ($('#payment_method_id').val() == 1) {
                $("#banque_c").val(parseInt(client_ids));
            } else {
                $("#banque_v").val(parseInt(client_ids));
            }
            $('#modal-choose-items').modal('hide');
        });
    });

    $('#filter_banque').keyup(function() {

        clients_filter();
    });

    function clients_filter() {
        var filter_family = $('#filter_family').val();
        var filter_banque = $('#filter_banque').val();
        var lookup_url = "<?php echo site_url('banque/ajax/partial_modal_banque_lookup'); ?>/";
        lookup_url += Math.floor(Math.random() * 1000) + '/?';
        if (filter_banque) {
            lookup_url += "&filter_banque=" + filter_banque;
        }
        $("#banque_table tbody").load(lookup_url, {});
    }

    $('#add_banque_btn_modal').click(function() {
        $('#modal-choose-items').modal('hide');

        $('#modal-placeholder').load(
            "<?php echo site_url('banque/ajax/modal_banque_add'); ?>/" + Math
            .floor(Math.random() * 1000), {});
    });

});
</script>
<input hidden type="checkbox" id="checkboxtest" value="">

<input type="hidden" id="type_doc" value="<?php echo $type_doc; ?>">
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
                        Ajouter banque </div>
                    <div class=" col-md-3">
                        <input type="text" class="form-control" name="filter_banque" id="filter_banque"
                            placeholder="Nom du banque" value="<?php echo $filter_client ?>" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="add_banque_btn_modal" class="btn btn-default">Créer
                            banque</button>
                    </div>
                    <div class=" col-md-3" id="mod_footer" style=" white-space: nowrap;width: 250px;display: none">
                        <div class="btn-group">
                            <button class="btn default" type="button" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                                <?php echo lang('cancel'); ?>
                            </button>
                            <button class="btn btn-success" id="select-items-confirmx" type="button">
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
                <table id="banque_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style=" width: 20px">&nbsp;</th>
                            <th>Nom de banque</th>
                            <th style=" display: none"><?php echo lang('active'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($banques as $banque) {?>
                        <tr>
                            <td style=" width: 30px">
                                <div class="md-radio">
                                    <input type="radio" id="radio1<?php echo $banque->id_banque; ?>" name="client_ids[]"
                                        onclick="myFunction()" class="md-radiobtn"
                                        value="<?php echo $banque->id_banque; ?>">
                                    <label for="radio1<?php echo $banque->id_banque; ?>">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td nowrap class="nom<?php echo $banque->id_banque; ?> text-left">
                                <b><?php echo $banque->nom_banque; ?></b>
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