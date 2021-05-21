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
        $(".md-radiobtn:checked").each(function() {
            //$(this).closest('tr').find('td:eq(2)').text()
            $("#family_id").val(parseInt(client_ids));
            $('#select_family').val($('.nom'+parseInt(client_ids)).text().trim());
            /* $('#family_id').append('<option value="' + parseInt(client_ids) +
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
        var lookup_url = "<?php echo site_url('families/ajax/partial_modal_familie_lookup'); ?>/";
        lookup_url += Math.floor(Math.random() * 1000) + '/?';
        if (filter_client) {
            lookup_url += "&filter_families=" + filter_client;
        }
        $("#clients_table tbody").load(lookup_url, {}); 
    }

    $('#add_client_btn_modal').click(function() {
        $('#modal-choose-items').modal('hide');

        $('#modal-placeholder').load(
            "<?php echo site_url('families/ajax/modal_familie_add'); ?>/" + Math
            .floor(Math.random() * 1000), {}); 
    });

});
</script>
<input hidden type="checkbox" id="checkboxtest" value="">
<input type="hidden" id="type_doc" value="<?php echo $type_doc; ?>">
<input type="hidden" id="action" value="<?php echo $action; ?>">
<div id="modal-choose-items" class="modal famille col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true"
    style="display: block;width: 65%;height: 85%;overflow:hidden !important;z-index: 99999;background-color: #Fffff;margin-top: 22px;border-radius: 6px;">
    <div class="modal-content" style=" width: 100%">
        <div class="modal-header"
            style=" width: 64%;position: fixed; z-index: 999 ;border-bottom: 0px;height: 100xp;  background-color: rgb(255, 255, 255) !important; ">
            <div class="form-inline" style="border-bottom: 1px solid #e5e5e5; width: 100%">
                <div class="row">
                    <div class="col-md-5" style="font-weight: 600;font-size: 18px;margin-bottom: 14px;">
                        <?php echo lang('choose_family'); ?> </div>
                    <div class=" col-md-4">
                        <input type="text" class="form-control" name="filter_client" id="filter_client"
                            placeholder="<?php echo lang('search_name'); ?>" value="<?php //echo $filter_client ?>" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="add_client_btn_modal" class="btn btn-default"><?php echo lang('create'); ?></button>
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
                            <th colspan=2 style="text-align: center;"><?php echo lang('any_family'); ?></th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($families as $familie) {?>
                        <tr>
                            <td style=" width: 30px">
                                <div class="md-radio">
                                    <input type="radio" id="radio1<?php echo $familie->family_id; ?>"
                                        name="client_ids[]" onclick="myFunction()" class="md-radiobtn"
                                        value="<?php echo $familie->family_id; ?>">
                                    <label for="radio1<?php echo $familie->family_id; ?>">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td nowrap class="nom<?php echo $familie->family_id; ?> text-left">
                                <b><?php echo $familie->family_name; ?></b>
                            </td>
                        </tr>

                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer" id="mod_footer" style=" white-space: nowrap;display: none">
                        <div class="pull-right btn-group">
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
        <script>
        function myFunction() {
            $("#mod_footer").show();
        }
        </script>
    </div>

</div>