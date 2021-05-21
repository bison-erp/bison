<div class="row modal-body">
<?php if ($abonnement->pack_name == 'FREE') {?>
	<div class="col-lg-6 col-md-6 col-sm-12 col-row-modal disabled">
		<div class="card card-custom card-stretch" id="free-card">
			<!--begin::Header-->
				<div class="card-header">
					<h3 class="card-title font-weight-bolder"><?php echo lang('free'); ?></h3>
				</div>
			<!--end::Header-->
			<!--begin::Body-->
				<div class="card-body">
					<div class="price-header">
						<h2 class="card-title font-weight-bolder">0<sup> TND</sup><br /><span class="delais"><?php echo lang('month'); ?></span></h3>					
					</div>
					<div class="text-dark text-desc">
						<p class="text-center font-weight-normal font-size-sm"><?php echo lang('definition_pack_free'); ?></p>
						<ul class="pack-list"><li>1 <?php echo lang('compte_utilisateur'); ?></li><li>15 <?php echo lang('clients'); ?></li><li>20 <?php echo lang('factures_par_mois'); ?></li><li>10 <?php echo lang('gestion_stocks'); ?></li></ul>
					</div>
					<div class="btn-activate" style="display:none;">
						<a href="#" class="btn btn-md btn-light-primary font-weight-bolder"><?php echo lang('activer_pack'); ?></a>
					</div>
				</div>
			<!--end::Body-->
				<a href="#" class="link-pack-upgrade" target="_blank"><?php echo lang('activate'); ?></a>
		</div>
	</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-row-modal next-hover">
		<div class="card card-custom card-stretch" id="premium-card">
			<!--begin::Header-->
				<div class="card-header">
					<h3 class="card-title font-weight-bolder"><?php echo lang('premium'); ?></h3>
				</div>
			<!--end::Header-->
			<!--begin::Body-->
				<div class="card-body">
					<div class="price-header">
						<h2 class="card-title font-weight-bolder">98,99<sup> TND</sup><br /><span class="delais"><?php echo lang('month'); ?></span></h3>					
					</div>
					<div class="text-dark text-desc">
						<p class="text-center font-weight-normal font-size-sm"><?php echo lang('definition_pack_premium'); ?></p>
						<ul class="pack-list"><li>5 <?php echo lang('comptes_utilisateurs'); ?></li><li><?php echo lang('contacts_illimites'); ?></li><li><?php echo lang('facture_devis_illimite'); ?></li><li><?php echo lang('gestion_stocks_illimite'); ?></li></ul>
					</div>
					<div class="btn-activate" style="display:none;">
						<a href="#" class="btn btn-md btn-light-primary font-weight-bolder"><?php echo lang('activer_pack'); ?></a>
					</div>
				</div>
			<!--end::Body-->
				<a href="#" class="link-pack-upgrade" target="_blank"><?php echo lang('activate'); ?></a>
		</div>
</div>
	<?php } else { ?>
		<div class="col-lg-6 col-md-6 col-sm-12 col-row-modal next-hover">
		<div class="card card-custom card-stretch" id="free-card">
			<!--begin::Header-->
				<div class="card-header">
					<h3 class="card-title font-weight-bolder"><?php echo lang('free'); ?></h3>
				</div>
			<!--end::Header-->
			<!--begin::Body-->
				<div class="card-body">
					<div class="price-header">
						<h2 class="card-title font-weight-bolder">0<sup> TND</sup><br /><span class="delais"><?php echo lang('month'); ?></span></h3>					
					</div>
					<div class="text-dark text-desc">
						<p class="text-center font-weight-normal font-size-sm"><?php echo lang('definition_pack_free'); ?></p>
						<ul class="pack-list"><li>1 <?php echo lang('compte_utilisateur'); ?></li><li>15 <?php echo lang('clients'); ?></li><li>20 <?php echo lang('factures_par_mois'); ?></li><li>10 <?php echo lang('gestion_stocks'); ?></li></ul>
					</div>
					<div class="btn-activate" style="display:none;">
						<a href="#" class="btn btn-md btn-light-primary font-weight-bolder"><?php echo lang('activer_pack'); ?></a>
					</div>
				</div>
			<!--end::Body-->
				<a href="#" class="link-pack-upgrade" target="_blank"><?php echo lang('activate'); ?></a>
		</div>
	</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-row-modal disabled">
		<div class="card card-custom card-stretch" id="premium-card">
			<!--begin::Header-->
				<div class="card-header">
					<h3 class="card-title font-weight-bolder"><?php echo lang('premium'); ?></h3>
				</div>
			<!--end::Header-->
			<!--begin::Body-->
				<div class="card-body">
					<div class="price-header">
						<h2 class="card-title font-weight-bolder">98,99<sup> TND</sup><br /><span class="delais"><?php echo lang('month'); ?></span></h3>					
					</div>
					<div class="text-dark text-desc">
						<p class="text-center font-weight-normal font-size-sm"><?php echo lang('definition_pack_premium'); ?></p>
						<ul class="pack-list"><li>5 <?php echo lang('comptes_utilisateurs'); ?></li><li><?php echo lang('contacts_illimites'); ?></li><li><?php echo lang('facture_devis_illimite'); ?></li><li><?php echo lang('gestion_stocks_illimite'); ?></li></ul>
						
					</div>
					<div class="btn-activate" style="display:none;">
						<a href="#" class="btn btn-md btn-light-primary font-weight-bolder"><?php echo lang('activer_pack'); ?></a>
					</div>
				</div>
			<!--end::Body-->
				<a href="#" class="link-pack-upgrade" target="_blank"><?php echo lang('activate'); ?></a>
		</div>
</div>
	<?php }?>
</div>
