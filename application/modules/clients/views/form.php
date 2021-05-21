<style>
.md-checkbox input[type=checkbox] {
    left: 4px;
    width: 16px;
    height: 16px;
}
.md-checkbox label > span.inc {
    left: 4px;
    top: 4px;
    height: 16px;
    width: 16px;
}
</style>
<script type="text/javascript">
$(function() {
    $('#client_name').focus();

    //        $("#client_country").select2({allowClear: true});
});
</script>
    <div id="headerbar-index" style=" margin-top:0;margin-bottom:0;">
        <?php $this->layout->load_view('layout/alerts');?>
    </div>
<form method="post" class="form-horizontal" id="form1" name="form1">


        

    <div id="content">


        <fieldset>
            <div class="col-xs-12 col-sm-2" style=" display: none">
                <div class="input-group">
                    <label><?php echo lang('active_client'); ?>: </label>
                    <input id="client_active" name="client_active" checked="checked" type="checkbox" value="1" <?php
if ($this->mdl_clients->form_value('client_active') == 1
    or !is_numeric($this->mdl_clients->form_value('client_active'))
) {
    echo 'checked="checked"';
}
?>>
                </div>
            </div>

            <div class="col-xs-12 col-sm-4" style="display: none">
                <div class="form-group">
                    <?php
$dateNaiss = $this->mdl_clients->form_value('client_date_naiss');
if ($dateNaiss == '') {
    $dateNaiss = date_from_mysql('0000-00-00');
} else {
    $dateNaiss = date_from_mysql($this->mdl_clients->form_value('client_date_naiss'));
}
?>
                    <div class="col-xs-12 col-sm-4"><label for="client_titre"><?php echo lang('client_date_naiss'); ?>:
                        </label></div>
                    <div class="col-xs-12 col-sm-8">
                        <div class="input-group">
                            <input id="client_date_naiss" name="client_date_naiss" type="text"
                                class="form-control datepicker" value="<?php echo $dateNaiss; ?>">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar fa-fw"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
		
        <div class="row">
        </div>
        <?php if ($custom_fields) {?>
        <div class="row">
            <div class="col-xs-12">
                <fieldset>
                    <legend><?php echo lang('custom_fields'); ?></legend>
                    <?php foreach ($custom_fields as $custom_field) {?>
                    <div class="form-group">
                        <label><?php echo $custom_field->custom_field_label; ?>: </label>

                        <div class="controls">
                            <input type="text" class="form-control"
                                name="custom[<?php echo $custom_field->custom_field_column; ?>]"
                                id="<?php echo $custom_field->custom_field_column; ?>"
                                value="<?php echo form_prep($this->mdl_clients->form_value('custom[' . $custom_field->custom_field_column . ']')); ?>">
                        </div>
                    </div>
                    <?php }?>
                </fieldset>
            </div>
        </div>
        <?php }?>
<!-- begin formulaire -->
					<div class="portlet light profile no-shabow bg-light-blue">
						<div class="portlet-header">
							<div class="portlet-title align-items-start flex-column">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark"><?php echo lang('new');?> <?php echo lang('client'); ?></span><br />
									<span class="caption-subject text-bold small-caption muted"><?php echo lang('add_clients'); ?></span>
								</div>
								
							</div>
							<div class="portlet-toolbar">
								<?php echo $this->layout->load_view('layout/header_buttons'); ?>
							</div>
						</div>
						<div class="portlet-body">
						<!-- nom - code -->   
						<div class="row">
						<div class="col-md-6 ">
						<div class="portlet light formulaire first pad-top">
						 
						<div class="row card-row form-row">
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
									  <input type="radio" value="1" ><?php echo lang('oui') ?></label>
									  <label class="btn btn-default btn-off btn-sm ">
									  <input type="radio" value="0"><?php echo lang('non') ?></label>
									</div>
									<input type="hidden" id="with_timbrehidd" name="timbre_fiscale" value="<?php  
										
											echo $this->mdl_clients->form_value('timbre_fiscale');
										 ?>">
									</div>
									<div class="form-control-focus"></div>
								</div>
								<?php } ?>
								
							</div>
							<div class="row card-row form-row">
								<div class="col-lg-2 col-sm-2 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('client_titre'); ?></label>
										<select class="form-control form-control-md form-control-light" name="client_titre" id="client_titre">
											<option value="0" <?php if ($selected_titre == 0) {?>selected="selected" <?php }?>><?php echo lang('mister'); ?></option>
											<option value="1" <?php if ($selected_titre == 1) {?>selected="selected" <?php }?>><?php echo lang('mistress'); ?></option>
										</select>
									</div>
								</div>
								<div class="col-lg-5 col-sm-5 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('prenom'); ?><span class="text-danger particulier">*</span></label>
										<input value="<?php echo $this->mdl_clients->form_value('client_prenom'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_prenom" name="client_prenom">
									</div>
								</div>
								<div class="col-lg-5 col-sm-5 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('nom'); ?><span class="text-danger particulier">*</span></label>
										<input value="<?php echo $this->mdl_clients->form_value('client_name'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_name" name="client_name">
									</div>
								</div>
							</div>
							<div class="row card-row form-row">
								<div class="col-lg-4 col-sm-4 col-xl-12 pro">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('client_societe'); ?><span class="text-danger">*</span></label>
										<?php if ($selected_type == 0) {?>
										<input value="<?php echo $this->mdl_clients->form_value('client_societe'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_societe" name="client_societe">
										<?php } else {?>
										<input  value="<?php echo $this->mdl_clients->form_value('client_societe'); ?>"
											type="text" class="form-control form-control-md form-control-light" id="client_societe"
											name="client_societe">
										<?php }?>
										<div class="form-control-focus"></div>
									</div>
								</div>
								<div class="col-lg-4 col-sm-4 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('devise'); ?></label>
											<?php if (rightsMultiDevises()) {?>
											<select class="form-control form-control-md form-control-light" name="client_devise_id" id="client_devise_id">
												<!--<option ></option>-->
												<?php foreach ($devises as $devise) {?>
												<option value="<?php echo $devise->devise_id; ?>"
													<?php if ($selected_devise == $devise->devise_id) {?>selected="selected" <?php }?>>
													<?php echo $devise->devise_label; ?>&nbsp;(&nbsp;<?php echo $devise->devise_symbole; ?>&nbsp;)
												</option>
												<?php }?>
											</select>
											<?php } else {?>
											<select class="form-control" name="client_devise_id" id="client_devise_id">
												<!--<option ></option>-->

												<option value="1">
													<?php echo $devises[0]->devise_label; ?>&nbsp;(&nbsp;<?php echo $devises[0]->devise_symbole; ?>&nbsp;)
												</option>

											</select>
											<?php }?>
									</div>
								</div>
								<div class="col-lg-4 col-sm-4 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('client_type'); ?></label>
										<select disabled class="bs-select form-control form-control-md form-control-light" name="client_type" id="client_type">
											<?php if ($id == 0) {?>
											<option value="0" selected="selected">
												Prospect</option>
											<?php } else {?>
											<option value="0" <?php if ($selected_type == 0) {?>selected="selected" <?php }?>>
												Prospect</option>
											<option value="1" <?php if ($selected_type == 1) {?>selected="selected" <?php }?>>
												Client</option>
											<?php
				}?>
										</select>
								</div>
								</div>
							</div>
							
							
							
							<div class="row card-row form-row">
								<div class="col-lg-12 col-sm-12 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('street_address'); ?><span class="text-danger">*</span></label>
										<input value="<?php echo $this->mdl_clients->form_value('client_address_1'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_address_1" name="client_address_1">
										<div class="form-control-focus"></div>
									</div>
								</div>
							</div>
							<div class="row card-row form-row">
								<div class="col-lg-4 col-sm-6 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('city'); ?><span class="text-danger">*</span></label>
										<input value="<?php echo $this->mdl_clients->form_value('client_state'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_state" name="client_state" />
										<div class="form-control-focus"></div>
									</div>	
								</div>
								<div class="col-lg-4 col-sm-6 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('zip_code'); ?></label>
										<input  value="<?php echo $this->mdl_clients->form_value('client_zip'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_zip" name="client_zip" />
									</div>	
									<div class="form-control-focus">
									</div>
								</div>
								<div class="col-lg-4 col-sm-6 col-xl-12">	
									<div class="form-group has-info"> 
										<label for="form_control_1"><?php echo lang('pays_fournisseur'); ?></label>
										<select class="form-control form-control-lg form-control-light" id="client_country" name="client_country" placeholder="<?php echo lang('country'); ?>">
										   <option value=""><?php echo lang('country'); ?></option>
											<?php foreach ($countries as $cldr => $country) {?>
											<option value="<?php echo $cldr; ?>"
												<?php if ($selected_country == $cldr) {?>selected="selected" <?php }?>>
												<?php echo $country ?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="row card-row form-row">
								<div class="col-lg-4 col-sm-4 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('phone_number'); ?><span class="text-danger">*</span></label>
										<input value="<?php echo $this->mdl_clients->form_value('client_phone'); ?>" type="tel" class="form-control form-control-md form-control-light" id="client_phone" name="client_phone"/>
									</div>
									<div class="form-control-focus">
									</div>
								</div>
								<div class="col-lg-4 col-sm-4 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('mobile_number'); ?></label>
										<input value="<?php echo $this->mdl_clients->form_value('client_mobile'); ?>" type="tel" class="form-control form-control-md form-control-light" id="client_mobile" name="client_mobile"/>
									</div>
									<div class="form-control-focus">
									</div>
								</div>
								<div class="col-lg-4 col-sm-4 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('fax_number'); ?></label>
										<input  value="<?php echo $this->mdl_clients->form_value('client_fax'); ?>" type="tel" class="form-control form-control-md form-control-light" id="client_fax" name="client_fax"/>
									</div>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							</div>
							</div>
						<div class="col-md-6 ">
						<div class="portlet light formulaire second">
							<div class="row card-row form-row">
								<div class="col-lg-6 col-sm-6 col-xl-12"> 
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('email_address'); ?><span class="text-danger">*</span></label>
										<input value="<?php echo $this->mdl_clients->form_value('client_email'); ?>" type="email" class="form-control form-control-md form-control-light" id="client_email" name="client_email"/>
									</div>
									<div class="form-control-focus">
									</div>
								</div>
								<div class="col-lg-6 col-sm-6 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('web_address'); ?></label>
										<input value="<?php echo $this->mdl_clients->form_value('client_web'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_web" name="client_web" />
									</div>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="row card-row form-row pro">
								<div class="col-lg-6 col-sm-6 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('matricule_fisc'); ?></label>
										<a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_matricule_fisc'); ?>"></a>
										<input value="<?php echo $this->mdl_clients->form_value('client_vat_id'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_vat_id" name="client_vat_id" />
									</div>
									<div class="form-control-focus">
									</div>	
								</div>
								<div class="col-lg-6 col-sm-6 col-xl-12">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('tax_code'); ?></label>
										<a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_tax_code'); ?>"></a>
										<input value="<?php echo $this->mdl_clients->form_value('client_tax_code'); ?>" type="text" class="form-control form-control-md form-control-light" id="client_tax_code" name="client_tax_code"/>
									</div>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<input value="<?php echo $id; ?>" type="hidden" class="form-control" id="id_client" name="id_client">

							<!-- Note -->
							<div class="row card-row form-row">
								<div class="col-lg-12 col-sm-12 col-xl-12">
									<?php if (!$id || $id == 0) {?>
										<input type="hidden" name="adr_ip" id="adr_ip"
											value="<?php echo $this->session->userdata['ip_address']; ?>">
										<input type="hidden" name="usr" id="usr"
											value="<?php echo $this->session->userdata['user_name']; ?> (<?php echo $this->session->userdata['user_mail']; ?>)">
										<input type="hidden" name="id_usr" id="id_usr"
											value="<?php echo $this->session->userdata['user_id']; ?> ">
										<label for="form_control_1"><?php echo lang('add_note'); ?></label>
										<textarea name="client_note" id="client_note" class="form-control form-max-height" rows="6"></textarea>
											<div class="md-checkbox text-left" style="with: auto;">
												<input type="checkbox" name="drap" id="drap" class="md-check">
												<label for="drap" style="margin-left:0;">
													<span></span>
													<span class="check"></span>
													<span class="box" style="top: 4px!important;"></span>
													<font class="drap-check"><?php echo lang('important'); ?></font>
										<a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_note_check'); ?>" style="position: absolute; margin-left: 15px; top: 4px;"></a>
												</label>
												</div>
									<?php }?>
								</div>
							</div>
							</div>
							</div>
							</div>
						<!-- end adress -->
						</div>
					</div>
<!-- end formulaire -->
    </div>
</form>
<script>
$('.btn-parti').click(function() {
  $('#with_pro-part').val('1');
  $('.pro').hide();
  $('.particulier').show();
  
});
$('.btn-prof').click(function() {
  $('#with_pro-part').val('0');
  $('.pro').show();
	$('.particulier').hide();
  
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
	$("#contact_type").change(function(){
		if($('#with_pro-part').val()==0){		
		$('.pro').show();
		$('.particulier').hide();
	}
	if($('#with_pro-part').val()==1){
		$('.pro').hide();
		$('.particulier').show();
	}
	})


	if(!$('#with_timbrehidd').val()){
		$('#with_timbrehidd').val(1)
	}
	if(!$('#with_pro-part').val()){
		$('#with_pro-part').val(1);
	}
</script>
    </div>