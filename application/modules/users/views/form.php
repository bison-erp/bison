<style>
    .form-horizontal .form-group.form-md-line-input {
        padding-top: 10px;
        margin-bottom: 20px;
        margin: 0 -10px 20px -10px!important;
    }
    .form-horizontal .form-group.form-md-line-input .form-control ~ label, .form-horizontal
    .form-group.form-md-line-input .form-control ~ .form-control-focus {
        width: auto;
        left: 0;
        right: 0;
    }
    .form-group.form-md-line-input .form-control {
        padding-left: 0;
    }
</style>
<?php
if (isset($modal_user_client)) {
    echo $modal_user_client;
}
?>
<?php
$img_show = base_url() . "assets/admin/layout3/img/no-photo.gif";
//                                $ci = get_instance();
$path = base_url() . 'uploads/' . strtolower($this->session->userdata('licence')) . '/photos_users/';

if ($this->mdl_users->form_value('user_avatar')) {
    $img_avatar = $this->mdl_users->form_value('user_avatar');

    if ($img_avatar != "") {
        $statut = getHTTPStatus($path . $img_avatar);
        if ($statut['http_code'] == 200) {
            $img_show = $path . $img_avatar;
        }
    }
}
?>
<form method="post" class="form-horizontal" enctype="multipart/form-data">
    <div id="headerbar-index" style=" margin-top:0;margin-bottom:0;">
        <?php echo $this->layout->load_view('layout/alerts'); ?>
    </div>
    <div id="content">	
		<div class="portlet light profile no-shabow bg-light-blue">
			<div class="portlet-header">
				<div class="portlet-title align-items-start flex-column">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark"><?php echo lang('create_user_account'); ?></span><br />
						<span class="caption-subject text-bold small-caption muted"><?php echo lang('account_information'); ?></span>
					</div>
				</div>
				<div class="portlet-toolbar">
					<?php echo $this->layout->load_view('layout/header_buttons'); ?>
				</div>
			</div>
	<div class="portlet-body">
		<!-- img user -->  
		<div class="row">
			<div class="col-md-6 ">
				<div class="portlet light formulaire no-padding first">     
						<div class="row card-row form-row">   
                        <div class="col-md-12"> 
							<div id="administrator_field">
							<div class="image-input image-input-outline">
								<div class="image-input-wrapper">
									<a class="img-big fancybox" href="<?php echo $img_show; ?>" data-fancybox="gallery">
										<img class="img-square profile-pic" src="<?php echo $img_show; ?>" alt="user-photo" onClick="document.getElementById('<?php echo $img_show; ?>').style.width='400px';" />
									</a>
								</div>   
								<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow upload-button" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
									<i class="fa fa-pen icon-sm text-muted"></i> 
									<input class="file file-upload" name="user_avatar" type="file">
									<input type="hidden" name="user_avatar">
								</label>
								<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-cancel-submit btn-shadow" data-action="remove" data-toggle="tooltip" title="" data-original-title="Remove avatar">
									<i class="fa fa-times icon-sm text-muted"></i>
									<input type="submit" id="delsub" name="del_user_avatar" >
								</span>
							</div>
							<span class="form-text text-muted small-span">NB: Maximum Taille image : 1Mo (500px * 500px)<span>
						</div>
						</div>
					</div>
                    <div class="row card-row form-row">
                        <div class="col-lg-9 col-sm-9 col-xs-12">
                            <div  class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('user_namecomplet'); ?></label>
                                <input type="text" name="user_name" id="user_name" class="form-control form-control-md form-control-light" value="<?php echo $this->mdl_users->form_value('user_name'); ?>">
                                <div class="form-control-focus" ></div>
                            </div>
						</div>
                        <div class="col-lg-3 col-sm-3 col-xs-12">
                            <div  class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('code'); ?></label>
                                <input type="text" name="user_code" id="user_code"  <?php if ($id) { ?> disabled="disabled" <?php } ?> class="form-control form-control-md form-control-light" value="<?php echo $this->mdl_users->form_value('user_code'); ?>">
                                <div class="form-control-focus" ></div>
                            </div>
						</div>
					</div>
                    <div class="row card-row form-row">
                        <div class="col-lg-6 col-sm-6 col-xs-12">
                            <div  class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('mobile_number'); ?></label>
                                <input type="text" name="user_mobile" id="user_mobile" class="form-control form-control-md form-control-light" value="<?php echo $this->mdl_users->form_value('user_mobile'); ?>">
                                <div class="form-control-focus" ></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-xs-12">
                            <div  class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('phone_number'); ?></label>
                                <input type="text" name="user_phone" id="user_phone" class="form-control form-control-md form-control-light" value="<?php echo $this->mdl_users->form_value('user_phone'); ?>">
                                <div class="form-control-focus" ></div>
                            </div>
                        </div>
					</div>
                </div>     
            </div> 
				<div class="col-md-6">
					<div class="portlet light formulaire no-padding">
						<!--  detail devis -->
						<div class="row card-row form-row">
							<div class="col-lg-6 col-sm-6 col-xs-12">
								<div  class="form-group has-info">
									<label for="form_control_1"><?php echo lang('email_address'); ?></label>
									<input type="text" name="user_email" id="user_email" class="form-control form-control-md form-control-light" value="<?php echo $this->mdl_users->form_value('user_email'); ?>">
									<div class="form-control-focus" ></div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6 col-xs-12">
								<div  class="form-group has-info">
									<label for="form_control_1"> <?php echo lang('groupe_user'); ?></label>
									<select name="groupes_user_id" class="form-control form-control-md form-control-light">
										<option value=""></option>
										<?php foreach ($groupes_users as $groupes_user) { ?>
											<option value="<?php echo $groupes_user->groupes_user_id; ?>"
													<?php if (@$this->mdl_users->form_values['groupes_user_id'] == $groupes_user->groupes_user_id) { ?>selected="selected"<?php } ?>>
														<?php echo ucfirst($groupes_user->designation); ?>
											</option>
										<?php } ?>
									</select>
									<div class="form-control-focus" ></div>
								</div>
							</div>
						</div>
                    <div  class="row card-row form-row">
                        <div class="col-md-12">
                            <div  class="form-group has-info">
                                <label for="form_control_1"> <?php echo lang('street_address'); ?></label>
                                <input type="text" name="user_address_1" id="user_address_1" class="form-control form-control-md form-control-light" value="<?php echo $this->mdl_users->form_value('user_address_1'); ?>">
                                <div class="form-control-focus" ></div>
                            </div>
                        </div>
                    </div>
                    <div  class="row card-row form-row" >
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <div  class="form-group has-info">
                                <label for="form_control_1"> <?php echo lang('city'); ?></label>
                                <input type="text" name="user_city" id="user_city" class="form-control form-control-md form-control-light" value="<?php echo $this->mdl_users->form_value('user_city'); ?>">
                                <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <div  class="form-group has-info">
                                <label for="form_control_1"> <?php echo lang('zip_code'); ?></label>
                                <input type="text" name="user_zip" id="user_zip" class="form-control form-control-md form-control-light" value="<?php echo $this->mdl_users->form_value('user_zip'); ?>">
                                <div class="form-control-focus" ></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <div  class="form-group has-info">
                                <label for="form_control_1"> <?php echo lang('country'); ?></label>
                                <select name="user_country" id="user_country" class="form-control form-control-md form-control-light">
                                    <option></option>
                                    <?php foreach ($countries as $cldr => $country) { ?>
                                        <option value="<?php echo $cldr; ?>"
                                                <?php if ($selected_country == $cldr) { ?>selected="selected"<?php } ?>>
                                                    <?php echo $country ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="form-control-focus" ></div>
                            </div>
                        </div>
					</div>
                    <div  class="row card-row form-row" >
                        <?php if (!$id) { ?>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div  class="form-group has-info">
                                    <label for="form_control_1"> <?php echo lang('password'); ?></label>
                                    <input type="password" name="user_password" id="user_password" class="form-control form-control-md form-control-light">                                    
									<div class="form-control-focus" ></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div  class="form-group has-info">
                                    <label for="form_control_1"> <?php echo lang('verify_password'); ?></label>
                                    <input type="password" name="user_passwordv" id="user_passwordv" class="form-control form-control-md form-control-light">   
									<div class="form-control-focus" ></div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12">
                                <?php echo anchor('users/change_password/' . $id, lang('change_password')); ?>                                
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div> 
           </div> 
        </div> 

		<div class="portlet-footer">
			<div class="pull-left back-btn">
				<a class="back-btn" role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-groupes_users'" href="">
					<span class="back-btn">
						<?php echo lang('back_to_settings_page'); ?>
					</span>
				</a>
			</div>
			<div class="portlet-tool-btn">
				<?php echo $this->layout->load_view('layout/header_buttons'); ?>
			</div>
		</div>
          
        </div>
    </div>
</form>
