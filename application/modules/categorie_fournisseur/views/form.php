<div id="headerbar-index">
	<?php $this->layout->load_view('layout/alerts');?>
</div>
<div id="content">
<form method="post" class="form-horizontal">
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark"><?php echo lang('new_group');?></span><br/>
					<span class="caption-subject text-bold small-caption muted"><?php echo lang('add_edit_group');?></span>
				</div>
			</div>
			<div class="portlet-toolbar">
				<?php $this->layout->load_view('layout/header_buttons');?>
			</div>
		</div>
		<div class="portlet-body fournisseurs f1">
			<div class="row card-row form-row">
				<div class="col-lg-4 col-md-6 col-sm-12 col-xl-12">
					<div class="form-group has-info">
						<label for="form_control_1"><?php echo lang('designation'); ?><span class="text-danger">*</span></label>
						<input value="<?php echo $this->mdl_categorie_fournisseur->form_value('designation'); ?>" type="text" class="form-control form-control-md form-control-light" id="designation" name="designation">
						<div class="form-control-focus"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-body fournisseurs f2">
			<div class="row card-row form-row">
				<div class="col-lg-4 col-md-6 col-sm-12 col-xl-12">
					<div class="form-group has-info">
						<label for="form_control_1"><?php echo lang('ret_source'); ?><span class="text-danger"> (%)</span></label>
						<input value="<?php echo $this->mdl_categorie_fournisseur->form_value('ret_source'); ?>" type="text" class="form-control form-control-md form-control-light" id="ret_source" name="ret_source">
						<div class="form-control-focus"></div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="portlet-footer">
			<div class="portlet-tool-btn">
				        <div class="pull-right btn-group">
							<a href="<?php echo base_url(); ?>categorie_fournisseur" class="btn btn-md-size btn-primary">
								<?php echo lang('view_supplier_groups'); ?>
							</a>
						</div>
			</div>
		</div>
	</div>
</form>
</div>