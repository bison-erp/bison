 <script src="../assets/js/xlsx.full.min.js"></script>

 <form method="post" class="form-horizontal">
     <?php
//rebrique fournisseur: selon les droit données
$sess_fournisseur_add = $this->session->userdata['fournisseur_add'];
$sess_fournisseur_del = $this->session->userdata['fournisseur_del'];
$sess_fournisseur_index = $this->session->userdata['fournisseur_index'];
?>

<div id="headerbar-index">
     <?php $this->layout->load_view('layout/alerts');?>
</div>
<div id="content">
 <!-- begin formulaire -->
	<div class="portlet light profile no-shabow bg-light-blue new_fournisseur">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column" style="padding-top: 10px;">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark">
                                 <?php if ($this->mdl_fournisseurs->form_value('id_fournisseur')): ?>
                                 #<?php echo $this->mdl_fournisseurs->form_value('id_fournisseur'); ?>&nbsp;
                                 <?php echo $this->mdl_fournisseurs->form_value('raison_social_fournisseur'); ?>
                                 <?php else: ?>
                                 <?php echo lang('new_fournisseur'); ?>
                                 <?php endif;?>
					</span>
				</div>
			</div>
			<div class="portlet-toolbar">
             <?php $this->layout->load_view('layout/header_buttons');?>
			</div>
		</div>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-6">
					<div class="portlet light formulaire first">
						<div class="row card-row form-row">
							<div class="col-lg-6 col-sm-6 col-xl-12">
								<div class="form-group has-info">
                                 <label for="form_control_1"><?php echo lang('reference_fournisseur'); ?><span class="text-danger">*</span></label>
                                 <input value="<?php echo $this->mdl_fournisseurs->form_value('refence'); ?>"
                                     type="text" class="form-control form-control-md form-control-light" id="refence" name="refence">
                                 <div class="form-control-focus"></div>
								</div>
							</div>
							 <div class="col-lg-6 col-sm-6 col-xl-12">
								 <div class="form-group has-info">
									 <label for="form_control_1"><?php echo lang('raison_social_fournisseur'); ?><span class="text-danger">*</span></label>
									 <input value="<?php echo $this->mdl_fournisseurs->form_value('raison_social_fournisseur'); ?>"
										 type="text" class="form-control form-control-md form-control-light" id="raison_social_fournisseur" 
										 name="raison_social_fournisseur">
									 <div class="form-control-focus"></div>
								 </div>
							 </div>
						</div>
						<div class="row card-row form-row">
							 <div class="col-lg-4 col-sm-4 col-xl-12">
								 <div class="form-group has-info">
									 <label for="form_control_1"><?php echo lang('matricule_fournisseur'); ?><span class="text-danger">*</span></label>
									 <input value="<?php echo $this->mdl_fournisseurs->form_value('matricule'); ?>"
										 type="text" class="form-control form-control-md form-control-light" id="matricule_fournisseur" name="matricule">
									 <div class="form-control-focus"></div>
								 </div>
							 </div>
							 <div class="col-lg-4 col-sm-4 col-xl-12">
								 <div class="form-group has-info">
									 <label for="form_control_1"><?php echo lang('group'); ?></label>
									 <select name="ip_categorie_fournisseur" class="form-control form-control-md form-control-light">
										 <?php for ($i = 0; $i < count($categorie); $i++) {?>
										 <option value="<?php echo $categorie[$i]->id_categorie_fournisseur ?>">
											 <?php
	echo $categorie[$i]->designation;} ?>
										 </option>
									 </select>
								 </div>
							 </div>
							<div class="col-lg-4 col-sm-4 col-xl-12">
								 <input type="hidden" id="id_user" name="id_user"
									 value="<?php echo $this->session->userdata['user_id'] ?>">
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
						</div>
						<div class="row card-row form-row">
							<div class="col-lg-6 col-sm-6 col-xl-12">
								 <div class="form-group has-info">
									 <label for="form_control_1"><?php echo lang('prenom'); ?></label>
									 <input type="text" name="prenom" id="prenom"
										 value="<?php echo $this->mdl_fournisseurs->form_value('prenom'); ?>"
										 class="form-control form-control-md form-control-light">
									 <div class="form-control-focus"></div>
								 </div>
							</div>
							<div class="col-lg-6 col-sm-6 col-xl-12">
								 <div class="form-group has-info">
									 <label for="form_control_1"><?php echo lang('nom'); ?></label>
									 <input type="text" name="nom" id="nom"
										 value="<?php echo $this->mdl_fournisseurs->form_value('nom'); ?>"
										 class="form-control form-control-md form-control-light">
									 <div class="form-control-focus"></div>
								 </div>
							</div>
						</div>
						<div class="row card-row form-row">
							<div class="col-lg-12 col-sm-12 col-xl-12">
								 <div class="form-group has-info">
											<label for="form_control_1"><?php echo lang('street_address'); ?></label>
											<input value="<?php echo $this->mdl_fournisseurs->form_value('adresse_fournisseur'); ?>" type="text" class="form-control form-control-md form-control-light" id="adresse_fournisseur" name="adresse_fournisseur">
									 <div class="form-control-focus"></div>
								 </div>
							</div>
						</div>
						<div class="row card-row form-row">
							<div class="col-lg-4 col-sm-4 col-xl-12">
                                 <div class="form-group has-info">
                                     <label for="form_control_1"><?php echo lang('code_postal_fournisseur'); ?></label>
                                     <input
                                         value="<?php echo $this->mdl_fournisseurs->form_value('code_postal_fournisseur'); ?>"
                                         type="text" class="form-control form-control-md form-control-light" id="code_postal_fournisseur"
                                         name="code_postal_fournisseur">
                                     <div class="form-control-focus"></div>
                                 </div>
                              </div>
							<div class="col-lg-4 col-sm-4 col-xl-12">
                                 <div class="form-group has-info">
                                     <label for="form_control_1"><?php echo lang('ville_fournisseur'); ?></label>
                                     <input
                                         value="<?php echo $this->mdl_fournisseurs->form_value('ville_fournisseur'); ?>"
                                         type="text" class="form-control form-control-md form-control-light" id="ville_fournisseur"
                                         name="ville_fournisseur">
                                     <div class="form-control-focus"></div>
                                 </div>
                             </div>
							<div class="col-lg-4 col-sm-4 col-xl-12">
                                 <div class="form-group has-info">
                                     <label for="form_control_1"><?php echo lang('pays_fournisseur'); ?><span class="text-danger">*</span></label>
                                     <input
                                         value="<?php echo $this->mdl_fournisseurs->form_value('pays_fournisseur'); ?>"
                                         type="text" class="form-control form-control-md form-control-light" id="pays_fournisseur" name="pays_fournisseur">
                                     <div class="form-control-focus"></div>
                                 </div>
                             </div>
                         </div>

                 </div>
             </div>
			<div class="col-md-6 ">
				<div class="portlet light formulaire second">
					 	<div class="row card-row form-row">
							<div class="col-lg-4 col-sm-4 col-xl-12">
                             <div class="form-group has-info">
                                 <label for="form_control_1"><?php echo lang('tel_fournisseur'); ?><span class="text-danger">*</span></label>
                                 <input value="<?php echo $this->mdl_fournisseurs->form_value('tel_fournisseur'); ?>"
                                     type="text" class="form-control form-control-md form-control-light" id="tel_fournisseur" name="tel_fournisseur">
                                 <div class="form-control-focus"></div>
                             </div>
							</div>
							<div class="col-lg-4 col-sm-4 col-xl-12">
                                 <div class="form-group has-info">
                                     <label for="form_control_1"><?php echo lang('mobile_fournisseur'); ?></label>
                                     <input value="<?php echo $this->mdl_fournisseurs->form_value('mobile'); ?>"
                                         type="text" class="form-control form-control-md form-control-light" id="mobile" name="mobile">
                                     <div class="form-control-focus"></div>
                                 </div>
                             </div>
							<div class="col-lg-4 col-sm-4 col-xl-12">
                                 <div class="form-group has-info">
                                     <label for="form_control_1"><?php echo lang('fax_fournisseur'); ?></label>
                                     <input value="<?php echo $this->mdl_fournisseurs->form_value('fax_fournisseur'); ?>"
                                         type="text" class="form-control form-control-md form-control-light" id="fax_fournisseur" name="fax_fournisseur">
                                     <div class="form-control-focus"></div>
                                 </div>
                             </div>
						</div>
					 	<div class="row card-row form-row">
							<div class="col-lg-6 col-sm-6 col-xl-12">
                                 <div class="form-group has-info">
                                     <label for="form_control_1"><?php echo lang('site_web_fournisseur'); ?>
                                     </label>
                                     <input value="<?php echo $this->mdl_fournisseurs->form_value('site_web_fournisseur'); ?>"
                                         type="text" class="form-control form-control-md form-control-light" id="site_web_fournisseur"
                                         name="site_web_fournisseur">
                                     <div class="form-control-focus"></div>
                                 </div>
                             </div>
							 <div class="col-lg-6 col-sm-6 col-xl-12">
                                 <div class="form-group has-info">
                                     <label for="form_control_1"><?php echo lang('mail_fournisseur'); ?><span class="text-danger">*</span></label>
                                     <input value="<?php echo $this->mdl_fournisseurs->form_value('mail_fournisseur'); ?>"
                                         type="text" class="form-control form-control-md form-control-light" id="mail_fournisseur" name="mail_fournisseur">
                                     <div class="form-control-focus"></div>
                                 </div>
                             </div>
						</div>
					 	<div class="row card-row form-row">
                         <div class="col-sm-12">
                             <div class="form-group has-info">
                                 <label for="form_control_1"><?php echo lang('note_fournisseur'); ?></label>
                                 <textarea name="note_fournisseur" rows="2" id="note_fournisseur" style="height:80px;"
                                     class="form-control"><?php echo $this->mdl_fournisseurs->form_value('note_fournisseur'); ?></textarea>
                                 <div class="form-control-focus"></div>
                             </div>
                         </div>
						</div>
					 	<div class="row card-row form-row">
                             <div class="col-sm-6">
                                 <input type="file" id="fileUpload" />
                                 <input type="button" id="upload" value="Upload" />
                                 <hr />
                                 <a href='../assets/js/exemple.fournisseur.xlsx' target='__blank'>
                                 <b><?php echo lang('exemple_file_xlxs'); ?></b>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
</div>
 </div>
 </div>
 </form>
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