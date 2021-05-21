<script type="text/javascript">
$().ready(function() {
    $('#btn-submit').click(function() {
        $('#form-settings').submit();
    });
    $("[name='settings[default_country]']").select2({
        allowClear: true
    });
});
</script>
<div id="headerbar-index"  style="height:auto!important;min-height: auto;">
    <?php $this->layout->load_view('layout/alerts');?>	
</div> 
<div id="headerbar-index" class="profil-tab">
    <?php $this->layout->load_view('layout/header_buttons');?>     
<!--?php $this->layout->load_view('layout/alerts');?-->      
</div>
<div id="content">
		<div class="vertical-tab" role="tabpanel">
            <ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder" role="tablist">
                <li class="active">
                    <a role="tab" data-toggle="tab" href="#settings-general" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-cog" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"> <?php echo lang('param_gener'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_general_setting'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-societe" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-project-diagram" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"> <?php echo lang('company'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_company'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-taxes" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-dollar-sign" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('taxes'); ?> & <?php echo lang('devise'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_vat_currency'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-pdfdoc" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-file-pdf" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('pdf_documents'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_pdf_document'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-invoices" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('invoices'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_invoices'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-quotes" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-comment-dollar" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('quotes'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_quote'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-bl" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-file-upload" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('bon_livraison'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_bl'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-commande" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-file-download" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('bons_commande'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_commande'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-fabrication" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-clipboard" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('bf'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_bf'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-stock" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-layer-group" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('stock_general'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_stock_management'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>email_templates/index'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-envelope-open-text" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('madel_mail'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_email_template'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>import'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-database" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('import_data'); ?></span>
								<span class="time text-muted"><?php echo lang('import_manage_data'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" href="#settings-groupes_users" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-users-cog" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('groupes_users'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_users'); ?></span>
							</div>
						</div>
					</a>
                </li>
            </ul>
                <div class="tabbable tabs-below" style=" width: 100%">
				<form method="post" id="form-settings" enctype="multipart/form-data">
                    <div class="tab-content tabs">
                        <div role="tabpanel" id="settings-general" class="tab-pane fade in active">
                            <?php $this->layout->load_view('settings/partial_settings_general');?>
                        </div>
                        <div role="tabpanel" id="settings-societe" class="tab-pane fade">
                            <?php $this->layout->load_view('settings/partial_settings_societe');?>
                        </div>
                        <div role="tabpanel" id="settings-taxes" class="tab-pane fade">
                            <?php $this->layout->load_view('settings/partial_settings_taxes');?>
                        </div>
                        <div role="tabpanel" id="settings-pdfdoc" class="tab-pane fade">
                            <?php $this->layout->load_view('settings/partial_settings_pdfdoc');?>
                        </div>
                        <div role="tabpanel" id="settings-invoices" class="tab-pane fade">
                            <?php $this->layout->load_view('settings/partial_settings_invoices');?>
                        </div>
                        <div role="tabpanel" id="settings-quotes" class="tab-pane fade">
                            <?php $this->layout->load_view('settings/partial_settings_quotes');?>
                        </div>
                         <div role="tabpanel" id="settings-bl" class="tab-pane fade">
                        <?php   $this->layout->load_view('settings/partial_settings_bl');?>
                        </div>
                        <div role="tabpanel" id="settings-commande" class="tab-pane fade">
                            <?php  $this->layout->load_view('settings/partial_settings_commande');?>
                        </div>
                        <div role="tabpanel" id="settings-fabrication" class="tab-pane fade">
                            <?php  $this->layout->load_view('settings/partial_settings_fabrication');?>
                        </div>
                        <div role="tabpanel" id="settings-stock" class="tab-pane fade">
                            <?php $this->layout->load_view('settings/partial_settings_stock');?>
                        </div>
                        <div role="tabpanel" id="settings-email" class="tab-pane fade">
                            <?php $this->layout->load_view('settings/partial_settings_email');?>
                        </div>
                        <div role="tabpanel" id="settings-groupes_users" class="tab-pane fade">
                            <?php $this->layout->load_view('settings/partial_groupes_user');?>
                        </div>
                    </div>
            </form>
</div>
</div>
