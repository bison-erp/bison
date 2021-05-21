<script type="text/javascript">
$(function() {
    // Display the create invoice modal
    $('#create-client').modal('show');
    $("#create-client .close").click(function() {
        $('#modal-placeholder').load("<?php echo site_url('clients/ajax/modal_client_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {
                type_doc: $('#type_doc').val()
            });
    });
    $('#client_create_confirm').click(function() {
       /* timbre=0;
        if($('#timbre_fiscale').val()==-1|| $('#timbre_fiscale').val()==1){
            timbre=1
        };*/
        $.post("<?php echo site_url('clients/ajax/create'); ?>", {
                client_titre: $('#client_titre').val(),
                client_name: $('#client_name').val(),
                client_prenom: $('#client_prenom').val(),
                client_type: $('#client_type').val(),
                client_societe: $('#client_societe').val(),
                client_devise_id: $('#client_devise_id').val(),
                client_address_1: $('#client_address_1').val(),
                client_state: $('#client_state').val(),
                client_country: $('#client_country').val(),
                client_zip: $('#client_zip').val(),
                client_phone: $('#client_phone').val(),
                client_mobile: $('#client_mobile').val(),
                client_fax: $('#client_fax').val(),
                client_email: $('#client_email').val(),
                client_web: $('#client_web').val(),
                client_vat_id: $('#client_vat_id').val(),
                client_tax_code: $('#client_tax_code').val(),
                timbre_fiscale:$('#with_timbrehidd').val(),
                contact_type :$('#with_pro-part').val(),
            },
            function(data) {
                var response = JSON.parse(data);
                if (response.success === 1) {
                    $('#create-client').modal('hide');
                    $('#modal-placeholder').load(
                        "<?php echo site_url('clients/ajax/modal_client_lookup'); ?>/" + Math
                        .floor(Math.random() * 1000), {
                            type_doc: $('#type_doc').val()
                        },
                        function() {
                            $("#radio1" + response.client_id).prop("checked", true);
                            // window.location.hash = "#radio1" + response.client_id;
                            myFunction();
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
<input type="hidden" id="type_doc" value="<?php echo $type_doc; ?>">
<style>
#create-client .form-group.form-md-line-input {
    padding-top: 0;
    margin: 0 0 25px 0;
}
</style>
<div id="create-client" class="modal  col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 ajouter-client" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true">

    <form class="modal-content" style=" width: 100%">
        <div class="modal-header" style="height: 60px">
            <!--<a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>-->
            <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                style="width: 22px; height: 20px; color: #FFF !important; background-image: none !important; background-color: rgb(220, 53, 88) !important; text-align: center; position: absolute; text-indent: 0px; opacity: 1; top: 17px; right: 15px;">
                <i class="fa fa-close"></i></button>
            <h3 style="font-weight: 600;font-size: 18px;margin:0;"><?php echo lang('add_client'); ?></h3>
        </div>
        <div style="clear:both"></div>
        <div class="modal-body" style="margin-top: 50px;">
            <fieldset>
			<div class="row card-row form-row" style=" padding-left: 15px">
							<?php  if ($this->mdl_settings->setting('with_timbre')  != 0) {?>
								<div class="col-lg-7 col-sm-7 col-xl-12">
									<div class="form-group has-info pro-part">
										<label for="form_control_1"><?php //echo lang('client_titre'); ?></label>
											<div class="btn-group" data-toggle="buttons">
										
									  <label class="btn btn-default btn-parti btn-sm">
									  <input type="radio" value="1"><?php echo lang('particulier'); ?></label>
									  <label class="btn btn-default btn-prof btn-sm">
									  <input type="radio" value="0"><?php echo lang('professionnel'); ?></label>
									</div>		
									<input type="hidden" id="with_pro-part" name="contact_type" value="<?php  
										echo $contact_type;
									 ?>">	
									</div>
								</div>
								<div class="col-lg-5 col-sm-5 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('default_item_timbre'); ?></label><br>
											<!--select name="timbre_fiscale" class="form-control form-control-md form-control-light" id="timbre_fiscale">
											<option value="0" <!?php if ($this->mdl_clients->form_value('timbre_fiscale') == 0) {
											echo "selected";
												}
											?>><!?php echo lang('non') ?></option>
											<option value="1" <!?php if (($this->mdl_clients->form_value('timbre_fiscale') == 1) || ($this->mdl_clients->form_value('timbre_fiscale') == '')) {
											echo "selected";
											}
											?>><!?php echo lang('oui') ?></option>
										   </select-->
									<div class="btn-group" data-toggle="buttons">
									  <label class="btn btn-default btn-on btn-sm">
									  <input type="radio" value="1" ><?php echo lang('oui')?></label>
									  <label class="btn btn-default btn-off btn-sm">
									  <input type="radio" value="0"><?php echo lang('non')?></label>
									</div>
									<input type="hidden" id="with_timbrehidd" name="timbre_fiscale" value="<?php  
											echo $this->mdl_clients->form_value('timbre_fiscale');
										 ?>">
									</div>
									<div class="form-control-focus"></div>
								</div>
								<?php } ?>
								
			</div>
                <div class="col-xs-12 col-md-2 col-sm-2">
                    <div class="form-grouphas-info">
                        <select class="form-control form-control-md form-control-light" name="client_titre" id="client_titre" >
                            <option value="0"><?php echo lang('mister'); ?></option>
                            <option value="1"><?php echo lang('mistress'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-sm-5">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_name'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_name" name="client_name"
                            placeholder="<?php echo lang('client_name'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4 col-sm-5">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_prenom'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_prenom" name="client_prenom"
                            placeholder="<?php echo lang('client_prenom'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>

                <!-- FIN LIGNE 1 -->
                <div class="col-xs-12 col-md-2 col-sm-4">
                    <div class="form-group has-info">
                        <select disabled class="bs-select form-control form-control-md form-control-light" placeholder="<?php echo lang('type'); ?>"
                            name="client_type" id="client_type">
                            <option value="0"><?php echo lang('prospect'); ?></option>
                            <option value="1"><?php echo lang('clt'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group  has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_societe'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_societe" name="client_societe"
                            placeholder="<?php echo lang('client_societe'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group has-info">
                        <select class="form-control form-control-md form-control-light" name="client_devise_id" id="client_devise_id">
                            <?php foreach ($devises as $devise) {?>
                            <option value="<?php echo $devise->devise_id; ?>">
                                <?php echo $devise->devise_label; ?>&nbsp;(&nbsp;<?php echo $devise->devise_symbole; ?>&nbsp;)
                            </option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <?php  if ($this->mdl_settings->setting('with_timbre')  != 0) {?>

                <!--div class="col_xs-12 col-sm-4">
                    <+?php echo lang('default_item_timbre'); ?> :
                </div-->
                <!--div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info">
                        <select name="timbre_fiscale" class="form-control form-control-md form-control-light select2me" id="timbre_fiscale">
							<option value="-1" selected="selected"><-?php echo lang('default_item_timbre')?></option>
                            <option value="1"><-?php echo lang('oui')?></option>
                            <option value="0"><-?php echo lang('non')?></option>
                        </select>
                        <div class="form-control-focus"></div>
                    </div>
                </div-->
                <?php } else { ?> 
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info disabled">
                        <select name="timbre_fiscale" class="form-control form-control-md form-control-light select2me" id="timbre_fiscale">
						<option value="-1" selected="selected"><?php echo lang('default_item_timbre')?></option>
                            <option value="1"><?php echo lang('oui')?></option>
                            <option value="0"><?php echo lang('non')?></option>
                        </select>
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <?php } ?>    
                <!-- FIN LIGNE 2 -->
				<!--div class="col-xs-12 col-sm-6">
				<select class="form-control form-control-md form-control-light" name="contact_type" id="contact_type">
					<option value="0" selected="selected" ><-?php echo lang('professionnel'); ?></option>
					<option value="1" ><-?php echo lang('particulier'); ?></option>
				</select>
				</div-->
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_address_1'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_address_1" name="client_address_1"
                            placeholder="<?php echo lang('street_address'); ?>">
                        <div class="form-control-focus">
                        </div>
                    </div>
                </div>
				
				
                <!-- FIN LIGNE 3 -->
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_email'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_email" name="client_email"
                            placeholder="<?php echo lang('client_email'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_state'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_state" name="client_state"
                            placeholder="<?php echo lang('city'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_zip'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_zip" name="client_zip"
                            placeholder="<?php echo lang('zip_code'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info">
                        <select class="form-control form-control-md form-control-light" id="client_country" name="client_country"
                            placeholder="<?php echo lang('country'); ?>" id="client_devise_id">
										   <option value=""><?php echo lang('country'); ?></option>
                            <?php foreach ($countries as $cldr => $country) {?>
                            <option value="<?php echo $cldr; ?>"
                                <?php if ($this->mdl_settings->setting('default_country') == $cldr) {?>selected="selected"
                                <?php }?>><?php echo $country ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <!-- FIN LIGNE 4 -->
                <!-- FIN BLOC 1 -->
            </fieldset>
            <fieldset>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_phone'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_phone" name="client_phone"
                            placeholder="<?php echo lang('phone_number'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_mobile'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_mobile" name="client_mobile"
                            placeholder="<?php echo lang('mobile_number'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_fax'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_fax" name="client_fax"
                            placeholder="<?php echo lang('fax_number'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>

                <!-- FIN LIGNE 1 BLOC 2-->

                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_web'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_web" name="client_web"
                            placeholder="<?php echo lang('web_address'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <!-- FIN LIGNE 2 BLOC 2-->
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group shown has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_vat_id'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_vat_id" name="client_vat_id"
                            placeholder="<?php echo lang('matricule_fisc'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group shown has-info">
                        <input value="<?php echo $this->mdl_clients->form_value('client_tax_code'); ?>" type="text"
                            class="form-control form-control-md form-control-light" id="client_tax_code" name="client_tax_code"
                            placeholder="<?php echo lang('tax_code'); ?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <!-- FIN LIGNE 3 BLOC 2 -->

            </fieldset>
        </div>
        <div class="modal-footer" style="border:none">
            <div class="btn-group">
                <button class="btn btn-sm default" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo lang('cancel'); ?>
                </button>

                <button class="btn btn-success btn-sm" id="client_create_confirm" type="button" name="btn_submit">
                    <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
    </form>
	<script>
$("#contact_type").change(function(){
	console.log($('#contact_type option:selected').val());
	if($('#contact_type option:selected').val()==0){		
	$('.shown').show();
}
if($('#contact_type option:selected').val()==1){
	$('.shown').hide();
}
})


$('.btn-parti').click(function() {
  $('#with_pro-part').val('1');
  
  $('.shown').hide();
  $('#client_societe').attr('disabled','disabled');
  
});
$('.btn-prof').click(function() {
  $('#with_pro-part').val('0');
	$('.shown').show();
	$('#client_societe').removeAttr("disabled")
  
});
 


	$('.btn-on').click(function() {
	$('#with_timbrehidd').val('1');
	
	});
	$('.btn-off').click(function() {
	$('#with_timbrehidd').val('0');
	
	});

	if ( $('#with_timbrehidd').val() == '0'){
		$( ".btn-off" ).addClass('active');
	}else{
		$( ".btn-on" ).addClass('active');
	}	 
 
	if($('#with_pro-part').val()==0){
		$('.pro').show();
		$('.particulier').hide();
		$( ".btn-prof" ).addClass('active');
	}else{
		$('.pro').hide();
		$('.particulier').show();
		$( ".btn-parti" ).addClass('active');
	}

	if(!$('#with_timbrehidd').val()){
		$('#with_timbrehidd').val(1)
	}
	if(!$('#with_pro-part').val()){
		$('#with_pro-part').val(1);
	}
</script>
</div>