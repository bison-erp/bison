<?php
$id_user = $this->session->userdata['user_id'];
$name_user = $this->session->userdata['user_name'];
$group_user = $this->session->userdata['groupes_user_id'];
?>
<?php
$this->db->where('user_id', $id_user);
$curr_user = $this->db->get('ip_users')->result();
$img_avatar = $curr_user[0];
$img_show = null;
$path = base_url() . 'uploads/' . strtolower($this->session->userdata('licence')) . '/photos_users/';

if ($img_avatar != "") {
    $statut = getHTTPStatus($path . $img_avatar->user_avatar);
    if ($statut['http_code'] == 200) {
        $img_show = $path . $img_avatar->user_avatar;
    }
}
?>
<?php   
$db = $this->load->database('default');
$this->load->model('groupes_users/mdl_groupes_users');
$this->load->model('users/mdl_users');
$this->load->model('users/mdl_user_clients');
?>
<?php
if (isset($modal_user_client)) {
    echo $modal_user_client;
}
?> 
<?php
$db = $this->load->database('default');
$this->load->model('groupes_users/mdl_groupes_users');
//$query = $this->db->query('SELECT * FROM  `ip_devises` ')->get()->result();
$groupes_users = $this->mdl_groupes_users->get()->result();
$users = $this->db->get('ip_users')->result();
//$row = $query->row();
?>
<div class="content-account" id="content_sidenav_account">
	<!-- begin::Item : title account -->
			<div class="bloc-content">
				<h5 class="font-weight-bold small-h5"><?php echo lang('title_profil') ?><!--small class="text-muted font-size-sm">4 New</small--></h5>
			</div>
		<!-- end: Item -->
		<!-- begin: Item : account -->       
			<div class="bloc-content">

				<div class="d-flex align-items-left col-row">
					<div class="bloc-photo">
						<div class="symbol-photo">
                            <?php if ($img_show == null) {?>
								<img class="img-square" src="<?php echo base_url(); ?>assets/admin/layout3/img/anonyme-user.png" >
                            <?php } else {?>
								<img class="img-square" src="<?php echo $img_show; ?>" >
                            <?php }?>
							<i class="symbol-badge bg-success"></i>
						</div>
					</div>
					<div class="bloc-text">				 
						<a href="<?php echo base_url(); ?>users/profil/<?php echo $id_user; ?>" class="link-user-item">
							<span class="symbol-text text-dark font-weight-bold"><?php echo $name_user; ?></span>
						</a>
						<a href="javascript:;" class="link-user-item">
							<span class="symbol-text text-muted font-weight-normal"><?php echo lang('code'); ?> : <?php echo $img_avatar->user_code; ?></span>
						</a>
						<a href="javascript:;" class="link-user-item">
							<span class="symbol-icon"><i class="fas fa-envelope-open-text"></i></span>
							<span class="symbol-text text-muted font-weight-normal"> <?php echo $img_avatar->user_email; ?></span>
						</a>
						 <a href="<?php echo site_url('sessions/logout'); ?>" class="btn btn-md btn-light-primary font-weight-bolder deconnect-btn"><?php echo lang('deconnect'); ?>
						 </a>
					</div>
				</div>
			</div>
		<!-- end: Item -->
			<div class="separator separator-dashed border-bottom"></div>
		<!-- begin: Item : account -->
			<div class="bloc-content">
				<a href="<?php echo base_url(); ?>users/profil/<?php echo $id_user; ?>" class="profil-item">
					<div class="profil-link rounded">
						<div class="symbol-label">
							<i class="fas fa-user-circle"></i>
						</div>
						<div class="profil-text">
							<span class="details font-weight-bold font-size-lg"><?php echo lang('my_profil'); ?></span>
							<span class="time text-muted"><?php echo lang('profil_setting'); ?></span>
							<span class="label label-light-danger label-inline font-weight-bold"><?php echo lang('update'); ?></span>
						</div>
					</div>
                </a>
			</div>
		<!-- end: Item -->
		<!-- begin: Item : account -->
			<div class="bloc-content">
			<?php if ($this->session->userdata['groupes_user_id'] == 1) {?>
                <a href="<?php echo base_url(); ?>settings" class="profil-item">
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
				<?php }?>
			</div>
		<!-- end: Item -->
		<!-- begin: Item : account -->
			<div class="bloc-content">
                <a href="javascript:;" class="profil-item">
					<div class="profil-link rounded">
						<div class="symbol-label">
							<i class="fab fa-stack-exchange"></i>
						</div>
						<div class="profil-text">
							<span class="details font-weight-bold font-size-lg"><?php echo lang('my_activities'); ?></span>
							<span class="time text-muted"><?php echo lang('my_activities_slogan'); ?></span>
						</div>
					</div>
                </a>
			</div>
		<!-- end: Item -->
		<!-- begin: Item : account -->
			<div class="bloc-content">
				<a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-groupes_users'" href="" class="profil-item">
					<div class="profil-link rounded">
						<div class="symbol-label">
							<i class="fas fa-tasks"></i>
						</div>
						<div class="profil-text">
							<span class="details font-weight-bold font-size-lg"><?php echo lang('collaborators'); ?></span>
							<span class="time text-muted"><?php echo lang('collab_slogan'); ?></span>
						</div>
					</div>
                </a>
			</div>
		<!-- end: Item -->
		<div class="separator separator-dashed border-bottom"></div>
		<!-- begin: Item : account -->
<!--------------  	Notifications profils : you can activate this block to show the style / add a news block	-------------->
			<!-- begin::Item : sub title account -->
			<!--div class="bloc-content">
				<h5 class="font-weight-bold small-h5"><!?php echo lang('recent_actus'); ?></h5>
			</div>
		<!-- end: Item -->
			<!--div class="bloc-content">
                <a href="javascript:;" class="profil-item">
					<div class="profil-link rounded box-notif bg-light-warning">
						<div class="symbol-label">
							<i class="fas fa-bookmark"></i>
						</div>
						<div class="profil-text">
							<span class="details font-weight-bold font-size-lg">Un autre objectif persuader</span>
							<span class="time text-muted">3 days</span>
						</div>
					</div>
                </a>
			</div>
		<!-- end: Item -->
		<!-- begin: Item : account -->
			<!--div class="bloc-content">
                <a href="javascript:;" class="profil-item">
					<div class="profil-link rounded box-notif bg-light-success">
						<div class="symbol-label">
							<i class="far fa-edit"></i>
						</div>
						<div class="profil-text">
							<span class="details font-weight-bold font-size-lg">Serait aux gens</span>
							<span class="time text-muted">4 days</span>
						</div>
					</div>
                </a>
			</div>
		<!-- end: Item -->
		<!-- begin: Item : account -->
			<!--div class="bloc-content">
                <a href="javascript:;" class="profil-item">
					<div class="profil-link rounded box-notif bg-light-danger">
						<div class="symbol-label">
							<i class="fas fa-comment-alt"></i>
						</div>
						<div class="profil-text">
							<span class="details font-weight-bold font-size-lg">Le but serait de persuader</span>
							<span class="time text-muted">5 days</span>
						</div>
					</div>
                </a>
			</div>
		<!-- end: Item -->
		<!-- begin: Item : account -->
			<!--div class="bloc-content">
                <a href="javascript:;" class="profil-item">
					<div class="profil-link rounded box-notif bg-light-info">
						<div class="symbol-label">
							<i class="fas fa-cubes"></i>
						</div>
						<div class="profil-text">
							<span class="details font-weight-bold font-size-lg">Le meilleur produit</span>
							<span class="time text-muted">6 days</span>
						</div>
					</div>
                </a>
			</div>
		<!-- end: Item -->
		<!--div class="separator separator-dashed border-bottom"></div-->
<!--------------------------  end Notifications -------------------------->
		<!-- begin: Item : account -->
		<div class="bloc-content blc-bottom-side">
			<h5 class="font-weight-bold small-h5"><?php echo lang('pack_limit'); ?></h5>
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
</div>
<!-- begin: boutton : upgrade pack --> 
<?php if ($abonnement->pack_name == 'FREE') {?>
		<div class="bloc-content blc-bottom-side btn-side ">
			<button class="btn btn-block btn-danger btn-shadow" id="modal-account-btn" data-toggle="modal" data-target="#popup-account">
				<span class="link-btn"><?php echo lang('btn_act_pack') ?></span>
			</button>
		</div>
<?php } else { ?>
		<div class="bloc-content blc-bottom-side btn-side ">
			<a href="javascript:;" class="btn btn-block btn-danger btn-shadow">
				<span class="link-btn"><?php echo lang('btn_act_option') ?></span>
			</a>
		</div>
<?php }?>
<!-- end: boutton -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/ckeditor.js"></script>