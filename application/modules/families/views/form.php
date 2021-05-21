<div id="headerbar-index">
	<?php $this->layout->load_view('layout/alerts');?>
</div>
<div id="content">
<form method="post" class="form-horizontal">
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column" style="padding-top: 10px;">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark"><?php echo lang('add_family'); ?></span>
				</div>
			</div>
			<div class="portlet-toolbar">
				<?php $this->layout->load_view('layout/header_buttons'); ?>
			</div>
		</div>
		<div class="portlet-body">
			<div class="row card-row form-row">
				<div class="col-lg-4 col-md-6 col-sm-12 col-xl-12">
					<div class="form-group has-info">
						<label for="form_control_1"><?php echo lang('family_name'); ?> <span class="text-danger">*</span></label>
                                <input value="<?php echo $this->mdl_families->form_value('family_name'); ?>" type="text" class="form-control form-control-md form-control-light" id="family_name" name="family_name" >
						<div class="form-control-focus"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-footer">
			<div class="portlet-tool-btn">
				        <div class="pull-right btn-group">
							<a href="<?php echo base_url(); ?>families" class="btn btn-md-size btn-primary">
								<?php echo lang('view_families'); ?>
							</a>
						</div>
			</div>
		</div>
	</div>
</form>
</div>
