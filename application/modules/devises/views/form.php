<div id="headerbar-index">
    <?php $this->layout->load_view('layout/header_buttons');?>
</div>
    <div id="content">
		<div class="vertical-tab" role="tabpanel">
            <ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder" role="tablist">
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-general'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-societe'" href="" class="profil-item setting-item">
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
                <li class="active">
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-taxes'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-pdfdoc'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-invoices'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-quotes'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-bl'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-commande'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-fabrication'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-stock'" href="" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-groupes_users'" href="" class="profil-item setting-item">
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
        <div class="tab-content tabs">
			<form method="post" class="form-horizontal">
				<div class="portlet light">
					<div class="portlet-header">
						<div class="content-heading">
							<div class="portlet-title left-title">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark"><?php if ($this->mdl_devises->form_value('devise_id')) : ?>
                                    #<?php echo $this->mdl_devises->form_value('devise_id'); ?>&nbsp;
                                    <?php echo $this->mdl_devises->form_value('devise_label'); ?>
                                <?php else : ?>
                                    <?php echo lang('devise'); ?>
                                <?php endif; ?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="portlet-body">
					<?php $this->layout->load_view('layout/alerts'); ?>
					<div class="form-content devise-form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-info" > 
                                    <label class="control-label"><?php echo lang('devise_label'); ?><span class="text-danger"> *</span></label>
                                    <input type="text" name="devise_label" id="devise_label" class="form-control form-control-md form-control-light"
                                           value="<?php echo $this->mdl_devises->form_value('devise_label'); ?>">
                                    <div class="form-control-focus" ></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info" >
                                    <label class="control-label"><?php echo lang('devise_symbole'); ?><span class="text-danger"> *</span></label>
                                    <input name="devise_symbole" id="devise_symbole" class="form-control form-control-md form-control-light" 
                                           value="<?php echo $this->mdl_devises->form_value('devise_symbole'); ?>">
                                    <div class="form-control-focus" ></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('taux'); ?><span class="text-danger"> *</span></label>
                                    <input name="taux" id="taux" class="form-control form-control-md form-control-light" 
                                           value="<?php echo $this->mdl_devises->form_value('taux'); ?>">
                                    <div class="form-control-focus" ></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('currency_symbol_placement'); ?></label>
                                    <select name="symbole_placement" class="form-control form-control-md form-control-light">
                                        <option value="before" <?php if($this->mdl_devises->form_value('symbole_placement') == "before") echo 'selected="selected"'; ?>>Avant le montant</option>
                                        <option value="after" <?php if($this->mdl_devises->form_value('symbole_placement') == "after") echo 'selected="selected"'; ?>>Après le montant</option>
                                    </select>
                                    <div class="form-control-focus" ></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('tax_rate_decimal_places'); ?></label>
                                    <select name="number_decimal" class="form-control form-control-md form-control-light">
                                        <option value="1" <?php if($this->mdl_devises->form_value('number_decimal') == 1) echo 'selected="selected"'; ?>>1</option>
                                        <option value="2" <?php if($this->mdl_devises->form_value('number_decimal') == 2) echo 'selected="selected"'; ?>>2</option>
                                        <option value="3" <?php if($this->mdl_devises->form_value('number_decimal') == 3) echo 'selected="selected"'; ?>>3</option>
                                    </select>
                                    <div class="form-control-focus" ></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('thousands_separator'); ?></label>
                                    <select name="thousands_separator" class="form-control form-control-md form-control-light">
                                        <option value="" <?php if($this->mdl_devises->form_value('thousands_separator') == "") echo 'selected="selected"'; ?>>Aucun</option>
                                        <option value=" " <?php if($this->mdl_devises->form_value('thousands_separator') == " ") echo 'selected="selected"'; ?>>Espace</option>
                                     </select>
                                    <div class="form-control-focus" ></div>
                            </div>
                        </div>
                        <?php if($this->mdl_devises->form_value('symbole_placement')){ ?>
                        <div class="col-md-12" style="margin-top:20px;">Exemple : <?php if($this->mdl_devises->form_value('symbole_placement') == "before") echo $this->mdl_devises->form_value('devise_symbole')." "; ?>9<?php echo $this->mdl_devises->form_value('thousands_separator'); ?>876.<?php echo substr("54321",0,$this->mdl_devises->form_value('number_decimal')); ?><?php if($this->mdl_devises->form_value('symbole_placement') == "after") echo " ".$this->mdl_devises->form_value('devise_symbole'); ?></div>
                        <?php } ?>
                    </div>
					</div>
					</div>
					<div class="portlet-footer" style="padding: 15px 25px 0;">
								<div class="portlet-tool-btn" style="float: left; display: block; padding: 15px 0 30px;">
									<?php $this->layout->load_view('layout/header_buttons');?>
								</div>
					</div>
				</div>
			</form>
        </div>
	</div>
	</div>
</div>
