<script src="../../assets/js/xlsx.full.min.js"></script>

<script type="text/javascript">
$(function() {
    $('#create-client').modal('show');
    $("#create-client .close").click(function() {
        $('#modal-placeholder').load(
            "<?php echo site_url('fournisseurs/ajax/modal_fournisseur_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {

            });
    });
    $('#fournisseur_create_confirm').click(function() {
        $.post("<?php echo site_url('fournisseurs/ajax/create'); ?>", {
                refence: $('#refence').val(),
                raison_social_fournisseur: $('#raison_social_fournisseur').val(),
                ip_categorie_fournisseur: $('#ip_categorie_fournisseur').val(),
                prenom: $('#prenom').val(),
                nom: $('#nom').val(),
                matricule_fournisseur: $('#matricule_fournisseur').val(),
                id_devise: $('#id_devise').val(),
                fax_fournisseur: $('#fax_fournisseur').val(),
                tel_fournisseur: $('#tel_fournisseur').val(),
                mobile: $('#mobile').val(),
                site_web_fournisseur: $('#site_web_fournisseur').val(),
                mail_fournisseur: $('#mail_fournisseur').val(),
                code_postal_fournisseur: $('#code_postal_fournisseur').val(),
                ville_fournisseur: $('#ville_fournisseur').val(),
                pays_fournisseur: $('#pays_fournisseur').val(),
                note_fournisseur: $('#note_fournisseur').val(),
            },
            function(data) {
                var response = JSON.parse(data);
                if (response.success === 1) {
                    $('#create-client').modal('hide');
                    $('#modal-placeholder').load(
                        "<?php echo site_url('fournisseurs/ajax/modal_fournisseur_lookup'); ?>/" +
                        Math
                        .floor(Math.random() * 1000), {},
                        function() {
                            $("#radio1" + response.fournisseurs_id).prop("checked", true);
                            // window.location.hash = "#radio1" + response.client_id;
                            // myFunction();
                            $('#fournisseur_id').append('<option value="' + response
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
<div id="create-client" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true">

    <form class="modal-content" style=" width: 100%">
        <div class="modal-header" style="height: 60px">
            <!--<a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>-->
            <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                style="width: 22px; height: 20px; color: #FFF !important; background-image: none !important; background-color: rgb(220, 53, 88) !important; text-align: center; position: absolute; text-indent: 0px; opacity: 1; top: 10px; right: 0px;">
                <i class="fa fa-close"></i></button>
            <h3 style="font-weight: 600;font-size: 18px;margin:0;"><?php echo lang('add_supplier'); ?></h3>
        </div>
        <div style="clear:both"></div>
        <div class="modal-body" style="margin-top: 60px;max-height: 400px;">
            <fieldset>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('reference_fournisseur'); ?> <span class="text-danger">*</span></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('refence'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="refence" name="refence">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('raison_social_fournisseur'); ?> <span class="text-danger">*</span></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('raison_social_fournisseur'); ?>"
                            type="text" class="form-control form-control-md form-control-light" id="raison_social_fournisseur" name="raison_social_fournisseur">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('categorie'); ?></label>
                        <select id="ip_categorie_fournisseur" name="ip_categorie_fournisseur" class="form-control form-control-md form-control-light">
                            <?php for ($i = 0; $i < count($categorie); $i++) {?>
                            <option value="<?php echo $categorie[$i]->id_categorie_fournisseur ?>">
                                <?php
echo $categorie[$i]->designation;} ?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('prenom'); ?></label>
                        <input type="text" name="prenom" id="prenom"
                            value="<?php echo $this->mdl_fournisseurs->form_value('prenom'); ?>" class="form-control form-control-md form-control-light">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('nom'); ?></label>
                        <input type="text" name="nom" id="nom"
                            value="<?php echo $this->mdl_fournisseurs->form_value('nom'); ?>" class="form-control form-control-md form-control-light">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('matricule_fournisseur'); ?> <span class="text-danger">*</span></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('matricule'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="matricule_fournisseur" name="matricule">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('adresse_fournisseur'); ?></label>
                        <textarea name="adresse_fournisseur" rows="1" id="adresse_fournisseur"
                            class="form-control form-control-md form-control-light"><?php echo $this->mdl_fournisseurs->form_value('adresse_fournisseur'); ?></textarea>
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('code_postal_fournisseur'); ?></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('code_postal_fournisseur'); ?>"
                            type="text" class="form-control form-control-md form-control-light" id="code_postal_fournisseur"
                            name="code_postal_fournisseur">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('ville_fournisseur'); ?> </label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('ville_fournisseur'); ?>"
                            type="text" class="form-control form-control-md form-control-light" id="ville_fournisseur" name="ville_fournisseur">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('pays_fournisseur'); ?><span class="text-danger">*</span></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('pays_fournisseur'); ?>"
                            type="text" class="form-control form-control-md form-control-light" id="pays_fournisseur" name="pays_fournisseur">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('tel_fournisseur'); ?> <span class="text-danger">*</span></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('tel_fournisseur'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="tel_fournisseur" name="tel_fournisseur">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('mobile_fournisseur'); ?></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('mobile'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="mobile" name="mobile">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('fax_fournisseur'); ?></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('fax_fournisseur'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="fax_fournisseur" name="fax_fournisseur">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('devise'); ?></label>
                        <select class="form-control form-control-md form-control-light" name="id_devise" id="id_devise">
                            <?php foreach ($devises as $devises) {?>
                            <option value="<?php echo $devises->devise_id; ?>"
                                <?php if ($this->mdl_fournisseurs->form_value('id_devise') == $devises->devise_id) {?>
                                selected="selected" <?php }?>>
                                <?php echo $devises->devise_label; ?></option>
                            <?php }?>
                        </select>
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('mail_fournisseur'); ?> <span class="text-danger">*</span></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('mail_fournisseur'); ?>"
                            type="text" class="form-control form-control-md form-control-light" id="mail_fournisseur" name="mail_fournisseur">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('site_web_fournisseur'); ?></label>
                        <input value="<?php echo $this->mdl_fournisseurs->form_value('site_web_fournisseur'); ?>"
                            type="text" class="form-control form-control-md form-control-light" id="site_web_fournisseur" name="site_web_fournisseur">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-md-4">              
                    <div class="sup offline" style="margin-top: 15px;"></div>
                    <input type="file" id="fileUpload" />
                    <input type="button" id="upload" value="Upload" />
                    <hr />
                    <a href='../../assets/js/exemple.fournisseur.xlsx' target='__blank'>
                        <h4><b><?php echo lang('exemple_file_xlxs'); ?></b></h4>
                    </a>
                </div>
                <div class="col-md-12">
                    <div class="sup offline" style="margin-top: 15px;"></div>
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('note_fournisseur'); ?></label>
                        <textarea name="note_fournisseur" rows="1" id="note_fournisseur"
                            class="form-control form-control-light"><?php echo $this->mdl_fournisseurs->form_value('note_fournisseur'); ?></textarea>
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