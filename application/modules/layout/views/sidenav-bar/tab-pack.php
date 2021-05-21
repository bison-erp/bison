<?php 
$db = $this->load->database('default');
$this->load->model('groupes_users/mdl_groupes_users');
$this->load->model('users/mdl_users'); 
$abonnement = abonnement();
?>
<div class="content-pack" id="content_sidenav_pack">
		<!-- begin::Item : title pack -->
			<?php if ($abonnement->pack_name == 'BUSINESS') {?>
			<div class="bloc-content">
				<a href="javascript:;" class="pack-item font-weight-bold text-hover-primary text-light text-left full-width-btn">
				<span class="btn-icon"><i class="flaticon-premium-badge"></i></span>
				<!--?php echo $abonnement->pack_name; ?-->
					<h3 class="title-pack"><?php echo lang('Forfait'); ?> <span class="color-gold"><?php echo lang('premium'); //echo $abonnement->pack_name; ?></span> <span class="font-size-sm">[<?php echo $this->session->userdata('licence'); ?>]</span></h3>
				</a>
				<div class="date-account font-weight-normal text-hover-primary">
					<span class="creat-date text-light text-left"><?php echo lang('created_date'); ?> : 16/06/2020<br />
					<span class="creat-date text-light text-left"><?php echo lang('expired_date'); ?> : 16/08/2020</span>
				</div>
			</div>
			<?php } else { ?>
			<div class="bloc-content">
				<a href="javascript:;" class="pack-item font-weight-bold text-hover-primary text-light text-left free-pack-bloc">
				<span class="btn-icon"><i class="fab fa-get-pocket"></i></span>
				<!--?php echo $abonnement->pack_name; ?-->
					<h3 class="title-pack"><?php echo lang('Forfait'); ?> <span class="color-normal"><?php echo $abonnement->pack_name; //echo lang('free'); ?></span> <span class="font-size-sm">[<?php echo $this->session->userdata('licence'); ?>]</span></h3>
				</a>
			</div>
			<?php }?>
		<!-- end: Item -->

		<!-- begin::Item : bg-light-success -->
		<div class="bloc-content blc-bottom-side">
		<?php if($this->session->userdata['groupes_user_id']==1){ ?>
			<div class="quick_setup btn btn-block btn-danger btn-shadow">
				<span class="quick_setup link-btn"><?php echo lang('quick_setup'); ?></span>
			</div><br><br>	
		<?php } ?>			 
			<h5 class="font-weight-bold small-h5"><?php echo lang('pack_options') ?></h5>
			<?php if ($abonnement->pack_name == 'FREE') {?>
				<div class="d-flex align-items-center bg-light-success rounded">
					<span class="btn-icon-success"><i class="fab fa-stack-overflow"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm">20 <?php echo lang('factures_par_mois'); ?></span>
					</div>
				</div>
				<div class="d-flex align-items-center bg-light-success rounded">
					<span class="btn-icon-success"><i class="fab fa-stack-overflow"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('journal_vente_achat_caisse'); ?></span>
					</div>
				</div>
				<div class="d-flex align-items-center bg-light-success rounded">
					<span class="btn-icon-success"><i class="fab fa-stack-overflow"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('personnalisation_documents'); ?></span>
					</div>
				</div>
			<?php } else { ?>
				<div class="d-flex align-items-center bg-light-success rounded">
					<span class="btn-icon-success"><i class="fab fa-stack-overflow"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('contacts_illimites'); ?></span>
					</div>
				</div>				
				<div class="d-flex align-items-center bg-light-success rounded">
					<span class="btn-icon-success"><i class="fab fa-stack-overflow"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('facture_devis_illimite'); ?></span>
					</div>
				</div>
				<div class="d-flex align-items-center bg-light-success rounded">
					<span class="btn-icon-success"><i class="fab fa-stack-overflow"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('gestion_stocks_illimite'); ?></span>
					</div>
				</div>
				<div class="d-flex align-items-center bg-light-success rounded">
					<span class="btn-icon-success"><i class="fab fa-stack-overflow"></i></span>
					<div class="txt-block flex-column-txt">
						<span class="text-warning font-size-sm"><?php echo lang('multilangues_multi_devises'); ?></span>
					</div>
				</div>			
			<?php }?>
		</div>
		<!-- end: Item -->
		<!-- begin::Item : bg-light-warning -->
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
		<div class="bloc-content blc-bottom-side btn-side">
			<button class="btn btn-block btn-danger btn-shadow" id="modal-pack-btn" data-toggle="modal" data-target="#popup-pack">
				<span class="link-btn"><?php echo lang('btn_act_pack'); ?></span>
			</button>
		</div>
	<?php } else { ?>
		<div class="bloc-content blc-bottom-side btn-side ">
			<a href="javascript:;" class="btn btn-block btn-danger btn-shadow">
				<span class="link-btn"><?php echo lang('btn_act_option'); ?></span>
			</a>
		</div>
<?php }?>
<!-- end: boutton -->
