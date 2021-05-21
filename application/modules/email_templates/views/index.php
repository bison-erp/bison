<div id="headerbar-index">
    <?php $this->layout->load_view('layout/header_buttons');?>
</div>
<div id="content" class="table-content">
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
                <li>
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
                <li class="active">
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
				<?php echo $this->layout->load_view('layout/alerts'); ?>
				
				<div class="portlet light">
					<div class="portlet-header">
							<div class="portlet-toolbar">
								<div class="pull-right btn-group">
									<a class="btn btn-danger btn-md" href="<?php echo site_url('email_templates/form'); ?>">
										<!--i class="fa fa-plus"></i--><?php echo lang('new'); ?>
									</a>
								</div>
							</div>
					</div>
					<div class="portlet-body">
				
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light max-width-md">
                <table class="table table-striped table-with-auto">
                    <thead>
                        <tr>
                            <th width="30%"><?php echo lang('title'); ?></th>
                            <th width="30%"><?php echo lang('type'); ?></th>
                            <th width="25%"><?php echo lang('options'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($email_templates as $email_template) {?>
                        <tr>
                            <td><?php echo $email_template->email_template_title; ?></td>
                            <td><?php echo lang($email_template->email_template_type); ?></td>
                            <?php
if ($email_template->insertclient == 0) {
    ?>
                            <td>
                                <a style=""
                                    class="btn btn-light-primary"
                                    onclick="location.href='<?php echo site_url('email_templates/form/' . $email_template->email_template_id); ?>'"
                                    type="button">
                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?></a>
                                <a class="btn btn-light-danger" disabled> <i
                                        class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?></a>
                            </td>
                                <?php } else {?>
                            <td>
                                <a style="" class="btn btn-light-primary"
                                    onclick="location.href='<?php echo site_url('email_templates/form/' . $email_template->email_template_id); ?>'"
                                    type="button">
                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?></a>
                                <a class="btn btn-light-danger" href="<?php echo site_url('email_templates/delete/' . $email_template->email_template_id); ?>"
								onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');" type="button"><i
                                        class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?></a>
                            </td>
                            <?php }?>
                        </tr>
                    </tbody>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
	</div>
	<div class="portlet-footer" style="padding: 0px 25px 0;">
		<div class="pag-table-content">
			<?php echo pager(site_url('email_templates/index'), 'mdl_email_templates'); ?>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
