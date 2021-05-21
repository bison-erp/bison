<div id="headerbar-index">
    <?php $this->layout->load_view('layout/header_buttons');?>
</div>

<div class="clearfix"></div>
<div id="content" class="table-content">
	<div class="vertical-tab" role="tabpanel">
            <ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder" role="tablist">
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-general'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-societe'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-taxes'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-pdfdoc'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-invoices'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-quotes'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-bl'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-commande'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-fabrication'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-stock'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>email_templates/index'" href="#" class="profil-item setting-item">
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
                <li class="active">
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>import'" href="#" class="profil-item setting-item">
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
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-groupes_users'" href="#" class="profil-item setting-item">
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
							<a class="create-product btn btn-danger btn-md" href="<?php echo base_url(); ?>import/form">
								<?php echo lang('new'); ?>
							</a>
						</div>
					</div>
				</div>
				<div class="portlet-body import">
				<div class="table-responsive" style=" width: 100%">
					<table class="table table-striped  table-hover" id="sample_editable_1">
						<thead>
							<tr>
								<th width="50">#</th>
								<th><?php echo lang('date'); ?></th>
								<th><?php echo lang('file'); ?></th>
								<th><?php echo lang('type'); ?></th>
								<th><?php echo lang('status'); ?></th>
								<th width="25%"><?php echo lang('actions'); ?></th>
							</tr>
						</thead>
						<tbody id="filter_results">
							<?php if (!empty($files)) { ?>
								<?php foreach ($files as $file) { ?>
									<tr>
										<td><?php echo $file->file_id; ?></td>
										<td><?php echo $file->file_date; ?></td>
										<td><?php echo $file->file_name; ?></td>
										<td><?php echo $types[$file->file_type]; ?></td>
										<td><?php echo $statuses[$file->file_status]; ?></td>
										<?php
										if ($file->file_type == 1) {
											$contr = "importClient";
										} else if ($file->file_type == 2) {
											$contr = "importFactures";
										} else if ($file->file_type == 3) {
											$contr = "importProducts";
										}
										?>

										<td><a class="btn btn-light-primary" href="<?php echo base_url(); ?>import/<?php echo $contr; ?>/<?php echo $file->file_id; ?>" title="Editer"><i class="fa fa-edit fa-margin" aria-hidden="true"></i> Editer</a>
										   &nbsp; <a class="btn btn-light-danger" onclick="return  confirm('Voulez vous supprimer ce fichier? ');" href="<?php echo base_url(); ?>import/delete/<?php echo $file->file_id; ?>" title="Supprimer"><i class="fa fa-trash-o fa-margin"></i> Supprimer</a>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
</div>
</div>
</div>
</div>
