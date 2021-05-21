<style>
.form-horizontal .form-group.form-md-line-input {
    padding-top: 10px;
    margin-bottom: 20px;
    margin: 0 -10px 20px -10px !important;
}

.form-horizontal .form-group.form-md-line-input .form-control~label,
.form-horizontal .form-group.form-md-line-input .form-control~.form-control-focus {
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
    </div>
<div id="content" class="account-content">
        <?php echo $this->layout->load_view('layout/alerts'); ?>
    <div class="row">
        <div class="col-md-4">
			<!-- presentation -->
                    <div class="portlet light profile">
						<div class="portlet-header profile-info-title">
							<div class="portlet-title align-items-start flex-column">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold  med-caption dark"><?php echo lang('my_profil');?></span>
									<br />
									<?php if ($abonnement->pack_name == 'FREE') {?>
										<span class="caption-subject text-bold small-caption muted pack-profil-text"><?php echo lang('Forfait'); ?> <?php echo lang('free'); ?></span>
									<?php } else { ?>
										<span class="caption-subject text-bold small-caption muted pack-profil-text"><?php echo lang('Forfait'); ?> <?php echo lang('premium'); ?></span>
									<?php }?>
								</div>
							</div>
							<div class="portlet-toolbar">
							</div>
						</div>
						<div class="portlet-body">						
<!-- photo - edit --> 
						<!--label class="col-form-label text-right"><!--?php echo lang('photo'); ?></label-->
							<div class="row card-row form-row">
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
											<!--value="<!--?php echo lang('remove'); ?>"-->
										</span>
									</div>
									<span class="form-text text-muted small-span"><?php echo lang('note_muted'); ?><span>
							</div>
<script>
$(document).ready(function() {
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    

    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
});
</script>
						<!-- end photo --> 
							<div class="separator separator-dashed border-bottom" style="border-bottom:none!important;"></div>
							<div class="d-flex-align align-items-center mb-2">
								<span class="fcol-form-label text-left profil-info-label"><?php echo lang('nom'); ?> :</span>
								<a href="javascript:;" class="text-muted text-hover-primary profil-info-text"><?php echo $this->mdl_users->form_value('user_name'); ?></a>
							</div>
							<div class="d-flex-align align-items-center mb-2">
								<span class="col-form-label text-left profil-info-label"><?php echo lang('code'); ?> :</span>
								<a href="javascript:;" class="text-muted text-hover-primary profil-info-text"><?php echo $this->mdl_users->form_value('user_code'); ?></a>
							</div>
							<div class="d-flex-align align-items-center mb-2">
								<span class="col-form-label text-left profil-info-label"><?php echo lang('email'); ?> :</span>
								<a href="javascript:;" class="text-muted text-hover-primary profil-info-text mail-user"><?php echo $this->mdl_users->form_value('user_email'); ?></a>
							</div>
							<div class="separator separator-dashed border-bottom"></div>
							<!--option -->		
							
							<div class="bloc-content">
								<div href="javascript:;" class="profil-item muted-item password-reset-link">
									<div class="profil-link rounded">
										<div class="symbol-label">
											<i class="fas fa-user-lock"></i>
										</div>
										<div class="profil-text">
										
											<span class="details font-weight-bold font-size-lg"><?php echo lang('change_password'); ?></span>
											<?php echo anchor('users/change_password/' . $id, lang('change_password')); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="bloc-content">
							<a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-groupes_users'" href="" class="profil-item muted-item">
									<div class="profil-link rounded">
										<div class="symbol-label">
											<i class="fas fa-user-circle"></i>
										</div>
										<div class="profil-text">
											<span class="details font-weight-bold font-size-lg"><?php echo lang('users_management'); ?></span>
											<span class="time text-muted"><?php echo lang('users_management_slogan'); ?></span>
										</div>
									</div>
								</a>
							</div>
						<?php if ($abonnement->pack_name == 'BUSINESS') {?>
							<div class="bloc-content">
								<a href="<?php echo base_url(); ?>settings" class="profil-item muted-item">
									<div class="profil-link">
										<div class="symbol-label">
											<i class="fas fa-cogs"></i>
										</div>
										<div class="profil-text">
											<span class="details font-weight-bold font-size-lg"><?php echo lang('param'); ?></span>
											<span class="time text-muted"><?php echo lang('param_gener'); ?></span>
										</div>
									</div>
								</a>
							</div>
							<?php } else { ?>
							<div class="bloc-content">
								<a href="<?php echo base_url(); ?>invoices/index" class="profil-item muted-item">
									<div class="profil-link rounded">
										<div class="symbol-label">
											<i class="fas fa-file-invoice-dollar"></i>
										</div>
										<div class="profil-text">
											<span class="details font-weight-bold font-size-lg"><?php echo lang('view_list_invoices'); ?></span>
											<span class="time text-muted"><?php echo lang('create_invoice'); ?></span>
										</div>
									</div>
								</a>
							</div>
							<?php }?>
							<div class="bloc-content">
								<a href="<?php echo base_url(); ?>dashboard" class="profil-item muted-item">
									<div class="profil-link rounded">
										<div class="symbol-label">
											<i class="fab fa-stack-exchange"></i>
										</div>
										<div class="profil-text">
											<span class="details font-weight-bold font-size-lg"><?php echo lang('activities'); ?></span>
											<span class="time text-muted"><?php echo lang('my_activities_slogan'); ?></span>
										</div>
									</div>
								</a>
							</div>
							<div class="separator separator-dashed border-bottom"></div>
							<!-- end option -->
									<!-- end: Item -->
		<!-- begin: Item : account -->
		<div class="bloc-content blc-bottom-side">
		<h5 class="font-weight-bold mb-6"><?php echo lang('pack_limit'); ?></h5>
			<?php if ($abonnement->pack_name == 'FREE') {?>
				<div class="d-flex align-items-center bg-light-warning rounded">
					<span class="btn-icon-warning"><i class="fab fa-servicestack"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('rapprochement_bancaires'); ?></span>
					</div>
				</div>
				<div class="d-flex align-items-center bg-light-warning rounded">
					<span class="btn-icon-warning"><i class="fab fa-servicestack"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('multilangues_multi_devises'); ?></span>
					</div>
				</div>
				<div class="d-flex align-items-center bg-light-warning rounded">
					<span class="btn-icon-warning"><i class="fab fa-servicestack"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('remises_cheques'); ?></span>
					</div>
				</div>
				<div class="d-flex align-items-center bg-light-warning rounded">
					<span class="btn-icon-warning"><i class="fab fa-servicestack"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('relance_automatique'); ?></span>
					</div>
				</div>
			<?php } else { ?>
				<div class="d-flex align-items-center bg-light-warning rounded">
					<span class="btn-icon-warning"><i class="fab fa-servicestack"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('gestion_rh'); ?></span>
					</div>
				</div>
				<div class="d-flex align-items-center bg-light-warning rounded">
					<span class="btn-icon-warning"><i class="fab fa-servicestack"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('comptabilité_declaration'); ?></span>
					</div>
				</div>
			<?php }?>
		</div>
		<!-- end: Item -->
<!-- begin: boutton : upgrade pack --> 
			<?php if ($abonnement->pack_name == 'FREE') {?>
		<div class="bloc-content blc-bottom-side btn-side ">	
			<a href="javascript:;" class="btn btn-block btn-danger btn-shadow">
				<span class="link-btn"><?php echo lang('btn_act_pack') ?></span>
			</a>
		</div>
<?php } else { ?>
		<div class="bloc-content blc-bottom-side btn-side ">
			<a href="javascript:;" class="btn btn-block btn-danger btn-shadow">
				<span class="link-btn"><?php echo lang('btn_act_option') ?></span>
			</a>
		</div>
<?php }?>
<!-- end: boutton -->
							
						</div>
					</div>
		</div>	
            <div class="col-md-8">
					<div class="portlet light profile">
						<div class="portlet-header">
							<div class="portlet-title align-items-start flex-column">
								<div class="caption font-dark-sunglo">
									<!--i class="icon-settings font-red-sunglo"></i-->
									<span class="caption-subject bold  med-caption dark">
										<?php echo lang('profile_information'); ?></span><br />
									<span class="caption-subject text-bold small-caption muted">
										<?php echo lang('update_information'); ?></span>
								</div>
								
							</div>
							<div class="portlet-toolbar">
								<?php echo $this->layout->load_view('layout/header_buttons'); ?>
							</div>
						</div>
						<div class="portlet-body">
							<!--div class="row card-row">
								<div class="col-lg-9 col-xl-6">
									<h5 class="font-weight-bold mb-6"><!--?php echo lang('update_information'); ?></h5>
								</div>
							</div-->
						
						<!-- nom - code -->
							<div class="row card-row form-row">
								<div class="col-xl-6 col-lg-6">
									<label class="col-form-label text-right"><?php echo lang('nom'); ?></label>
									 <input name="user_name" id="user_name" class="form-control form-control-lg form-control-solid" type="text" value="<?php echo $this->mdl_users->form_value('user_name'); ?>">
									 <div class="form-control-focus"></div>
								</div>
								<div class="col-xl-6 col-lg-6">
									<label class="col-form-label text-right"><?php echo lang('code'); ?></label>
									 <input name="user_code" id="user_code" disabled="disabled" class="form-control form-control-lg form-control-solid right-pos" type="text" value="<?php echo $this->mdl_users->form_value('user_code'); ?>">
									 <div class="form-control-focus"></div>
								</div>
							</div>
						<!-- end nom -code -->
						<!-- phone -->
							<div class="row card-row form-row">
								<div class="col-xl-6 col-lg-6">
									<label class="col-form-label text-right"><?php echo lang('mobile_number'); ?></label>
									 <input name="user_mobile" id="user_mobile" class="form-control form-control-lg form-control-solid" type="text" value="<?php echo $this->mdl_users->form_value('user_mobile'); ?>">
									 <div class="form-control-focus"></div>
								</div>
								<div class="col-xl-6 col-lg-6">
									<label class="col-form-label text-right"><?php echo lang('phone_number'); ?></label>
									 <input name="user_phone" id="user_phone" class="form-control form-control-lg form-control-solid right-pos" type="text" value="<?php echo $this->mdl_users->form_value('user_phone'); ?>">
									 <div class="form-control-focus"></div>
								</div>
							</div>
						<!-- end phone -->
						<!-- adress -->
							<div class="row card-row form-row">
								<div class="col-xl-6 col-lg-6">
									<label class="col-form-label text-right"><?php echo lang('email_address'); ?></label>
									 <input name="user_email" id="user_email" class="form-control form-control-lg form-control-solid" type="text" value="<?php echo $this->mdl_users->form_value('user_email'); ?>">
									 <div class="form-control-focus"></div>
								</div>
								<div class="col-xl-6 col-lg-6">
									<label class="col-form-label text-right"><?php echo lang('street_address'); ?></label>
									 <input name="user_address_1" id="user_address_1" class="form-control form-control-lg form-control-solid right-pos" type="text" value="<?php echo $this->mdl_users->form_value('user_address_1'); ?>">
									 <div class="form-control-focus"></div>
								</div>
							</div>

							<div class="row card-row form-row">
								<div class="col-xl-4 col-lg-4">
									<label class="col-form-label text-right"><?php echo lang('city'); ?></label>
									 <input name="user_city" id="user_city" class="form-control form-control-sm form-control-solid" type="text" value="<?php echo $this->mdl_users->form_value('user_city'); ?>">
									 <div class="form-control-focus"></div>
								</div>
								<div class="col-xl-4 col-lg-4">
									<label class="col-form-label text-right"><?php echo lang('zip_code'); ?></label>
									 <input name="user_zip" id="user_zip" class="form-control form-control-sm form-control-solid" type="text" value="<?php echo $this->mdl_users->form_value('user_zip'); ?>">
									 <div class="form-control-focus"></div>
								</div>
								<div class="col-xl-4 col-lg-4">
									<label class="col-form-label text-right"><?php echo lang('country'); ?></label>
									 <select name="user_country" id="user_country" class="form-control form-control-sm form-control-solid">
										<option></option>
										<?php foreach ($countries as $cldr => $country) {?>
										<option value="<?php echo $cldr; ?>"
											<?php if ($selected_country == $cldr) {?>selected="selected" <?php }?>>
											<?php echo $country ?>
										</option>
										<?php }?>
									</select>
									 <div class="form-control-focus"></div>
								</div>
							</div>
						<!-- end adress -->
						
							<div class="row card-row form-row">
								<div class="col-xs-12 col-lg-12 ">
									<h5 class="font-weight-bold mb-6"><?php echo lang('signature_mail'); ?></h5>
									
									<textarea name="signature" id="signature" class="form-control ckeditor"
											rows="8"><?php echo $this->mdl_users->form_value('signature'); ?></textarea>
							   </div>
							 </div>
						</div>
					</div>
			</div>
        <!--?php echo $this->layout->load_view('layout/header_buttons'); ?-->
    </div>
    <input type="hidden" name="groupes_user_id" value="<?php echo $this->mdl_users->form_value('groupes_user_id'); ?>">
</div>
</form>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/ckeditor.js"></script>  
  <script>
    CKEDITOR.config.toolbar = [    
	
	
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
        { name: 'my_clipboard', items: [ 'Cut', 'Copy', 'Paste' ] },
        { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] }
    ];
        // Background color
        CKEDITOR.config.uiColor = '#ffffff';       
     
        // Do not allow resizing
        CKEDITOR.config.resize_enabled = false;
    CKEDITOR.config.height = '200px';
         
    </script>
<script>
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>