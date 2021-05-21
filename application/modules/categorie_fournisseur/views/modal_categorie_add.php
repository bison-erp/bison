<script type="text/javascript">
$(function() {
    $('#create-client').modal('show');
    $("#create-client .close").click(function() {
        $('#modal-placeholder').load(
            "<?php echo site_url('categorie_fournisseur/categorie_fournisseur/modal_categorie_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {

            });
    });
    $('#fournisseur_create_confirm').click(function() {
        $.post("<?php echo site_url('categorie_fournisseur/categorie_fournisseur/create'); ?>", {
            designation: $('#designation').val(),
            ret_source: $('#ret_source').val(),               
            },
            function(data) {
                var response = JSON.parse(data);
                if (response.success === 1) {
                    $('#create-client').modal('hide');
                    $('#modal-placeholder').load(
                        "<?php echo site_url('categorie_fournisseur/categorie_fournisseur/modal_categorie_lookup'); ?>/" +
                        Math
                        .floor(Math.random() * 1000), {},
                        function() {
                            $("#radio1" + response.fournisseurs_id).prop("checked", true);
                            // window.location.hash = "#radio1" + response.client_id;
                            // myFunction();
                            $('#categorie_id').append('<option value="' + response
                                .fournisseurs_id + '" selected="selected">' + response
                                .nomfournisseur + '</option>');
                        });
                } else {                     
                    var output = strReplaceAll(response.validation_errors, "<p>", "- ");
                    output = strReplaceAll(output, "</p>", "");

                    alert(output);
                }
            });
    });
});
</script>
<style>
#create-client .form-group.form-md-line-input {
    padding-top: 0;
    margin: 0 0 25px 0;
}
</style>
<div id="create-client" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 ajout-fournisseur" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true">

    <form class="modal-content" style=" width: 100%">
        <div class="modal-header" style="height: 60px">
            <!--<a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>-->
            <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                style="width: 22px; height: 20px; color: #FFF !important; background-image: none !important; background-color: rgb(220, 53, 88) !important; text-align: center; position: absolute; text-indent: 0px; opacity: 1; top: 10px; right: 0px;">
                <i class="fa fa-close"></i></button>
            <h3 style="font-weight: 600;font-size: 18px;margin:0;"><?php echo lang('create_groupe'); ?></h3>
        </div>
        <div style="clear:both"></div>
        <div class="modal-body" style="margin-top: 60px;max-height: 400px;">
            <fieldset> 
                <div class="col-md-6">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('designation'); ?></label>
                        <input value="<?php echo $this->mdl_categorie_fournisseur->form_value('designation'); ?>"
                            type="text" class="form-control form-control-md form-control-light" id="designation"
                            name="designation">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('ret_source'); ?> </label>
                        <input value="<?php echo $this->mdl_categorie_fournisseur->form_value('ret_source'); ?>"
                            type="text" class="form-control form-control-md form-control-light" id="ret_source" name="ret_source">
                        <div class="form-control-focus"></div>
                    </div>
                </div>                            
            </fieldset>
        </div>
        <div class="modal-footer" style="border:none">
            <div class="btn-group">
                <button class="btn btn-sm default" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo lang('cancel'); ?>
                </button>
                <button class="btn btn-success btn-sm" id="fournisseur_create_confirm" type="button"
                    name="btn_submit">
                    <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
    </form>
</div>
 