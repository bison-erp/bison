<script type="text/javascript">
$(function() {
    $('#create-client').modal('show');
    $("#create-client .close").click(function() {
        $('#modal-placeholder').load(
            "<?php echo site_url('banque/ajax/modal_banque_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {

            });
    });
    $('#banque_create_confirm').click(function() {

        if ($('#nom_banque').val()) {
            $.post("<?php echo site_url('banque/ajax/create'); ?>", {
                    nom_banque: $('#nom_banque').val(),
                    payment_method_id: $('#payment_method_id').val(),
                },
                function(data) {
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        $('#create-client').modal('hide');
                        $('#modal-placeholder').load(
                            "<?php echo site_url('banque/ajax/modal_banque_lookup'); ?>/" +
                            Math
                            .floor(Math.random() * 1000), {},

                            function() {
                                $("#radio1" + response.banque_id).prop("checked", true);
                                if (response.id_payement == 1) {

                                    $('#banque_c').append('<option value="' + response
                                        .banque_id + '" selected="selected">' + response
                                        .nom_banque + '</option>');
                                } else {
                                    $('#banque_v').append('<option value="' + response
                                        .banque_id + '" selected="selected">' + response
                                        .nom_banque + '</option>');
                                }

                            });
                    }
                });
        } else {
            alert('le nom du banque est obligatoire');
        }
    });
});
</script>
<style>
#create-client .form-group.form-md-line-input {
    padding-top: 0;
    margin: 0 0 25px 0;
}
</style>
<div id="create-client" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true">

    <form class="modal-content" style=" width: 100%">
        <div class="modal-header" style="height: 60px">
            <!--<a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>-->
            <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                style="width: 22px; height: 20px; color: #FFF !important; background-image: none !important; background-color: rgb(220, 53, 88) !important; text-align: center; position: absolute; text-indent: 0px; opacity: 1; top: 10px; right: 0px;">
                <i class="fa fa-close"></i></button>
            <h3 style="font-weight: 600;font-size: 18px;margin:0;"><?php echo lang('add_bank'); ?></h3>
        </div>
        <div style="clear:both"></div>
        <div class="modal-body" style="margin-top: 60px;">
            <fieldset>
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('bank_name'); ?><span class="text-danger">*</span></label>
                        <input value="<?php echo $this->mdl_banque->form_value('nom_banque'); ?>" type="text"
                            class="form-control form-control-sm form-control-light" id="nom_banque" name="nom_banque">
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

                <button class="btn btn-success btn-sm" id="banque_create_confirm" type="button" name="btn_submit">
                    <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
    </form>
</div>
<script>
$("body").on("click", "#upload", function() {
    //Reference the FileUpload element.
    var fileUpload = $("#fileUpload")[0];

    //Validate whether File is valid Excel file.
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
    if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof(FileReader) != "undefined") {
            var reader = new FileReader();

            //For Browsers other than IE.
            if (reader.readAsBinaryString) {
                reader.onload = function(e) {
                    ProcessExcel(e.target.result);
                };
                reader.readAsBinaryString(fileUpload.files[0]);
            } else {
                //For IE Browser.
                reader.onload = function(e) {
                    var data = "";
                    var bytes = new Uint8Array(e.target.result);
                    for (var i = 0; i < bytes.byteLength; i++) {
                        data += String.fromCharCode(bytes[i]);
                    }
                    ProcessExcel(data);
                };
                reader.readAsArrayBuffer(fileUpload.files[0]);
            }
        } else {
            alert("This browser does not support HTML5.");
        }
    } else {
        alert("Please upload a valid Excel file.");
    }
});

function ProcessExcel(data) {
    //Read the Excel File data.
    var workbook = XLSX.read(data, {
        type: 'binary'
    });

    //Fetch the name of First Sheet.
    var firstSheet = workbook.SheetNames[0];

    //Read all rows from First Sheet into an JSON array.
    var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

    //Add the data rows from Excel file.
    for (var i = 0; i < excelRows.length; i++) {
        $("#matricule_fournisseur").val(excelRows[i].Matricule);
        $("#refence").val(excelRows[i].Référence);
        $("#raison_social_fournisseur").val(excelRows[i].Nom_entreprise);
        $("#prenom").val(excelRows[i].Prénom);
        $("#nom").val(excelRows[i].Nom);
        $("#adresse_fournisseur").val(excelRows[i].Adresse_postal);
        $("#fax_fournisseur").val(excelRows[i].Fax);
        $("#tel_fournisseur").val(excelRows[i].téléphone);
        $("#mobile").val(excelRows[i].mobile);
        $("#site_web_fournisseur").val(excelRows[i].Site_web);
        $("#mail_fournisseur").val(excelRows[i].Email);
        $("#code_postal_fournisseur").val(excelRows[i].Code_postal);
        $("#ville_fournisseur").val(excelRows[i].Ville);
        $("#note_fournisseur").val(excelRows[i].Note);
    }

};
</script>