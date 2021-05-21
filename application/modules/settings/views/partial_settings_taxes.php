<div id="headerbar-index" style="min-height: auto!important;">
    <?php $this->layout->load_view('layout/alerts'); ?>
</div>
<div id="content" class="table-content">
<div class="content-heading">
	<div class="portlet-title left-title">
		<div class="caption font-dark-sunglo">
			<span class="caption-subject bold med-caption dark"><?php echo lang('taxes'); ?></span>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-4">	
		<div class="portlet-toolbar" style="padding-bottom: 23px;display: table;">
			<div class="pull-left btn-group">
				<a class="btn btn-danger btn-md" href="<?php echo site_url('tax_rates/form'); ?>">
					<!--i class="fa fa-plus"></i--><?php echo lang('new'); ?>
				</a>
			</div>
		</div>
        <div class="tab-info display-table">
            <div class="form-group">
                <label for="settings[default_invoice_tax_rate]" class="control-label">
                    <?php echo lang('default_invoice_tax_rate'); ?>
                </label>
                <select name="settings[default_invoice_tax_rate]" class="form-control form-control-lg form-control-light">
                    <option value=""><?php echo lang('none'); ?></option>
                    <?php foreach ($tax_rates as $tax_rate) {?>
                    <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                        <?php if ($this->mdl_settings->setting('default_invoice_tax_rate') == $tax_rate->tax_rate_id) {?>selected="selected"
                        <?php }?>><?php echo $tax_rate->tax_rate_percent . '% - ' . $tax_rate->tax_rate_name; ?>
                    </option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="settings[default_item_tax_rate]" class="control-label">
                    <?php echo lang('default_item_tax_rate'); ?>
                </label>
                <select name="settings[default_item_tax_rate]" class="form-control form-control-lg form-control-light">
                    <option value=""><?php echo lang('none'); ?></option>
                    <?php foreach ($tax_rates as $tax_rate) {?>
                    <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                        <?php if ($this->mdl_settings->setting('default_item_tax_rate') == $tax_rate->tax_rate_id) {?>selected="selected"
                        <?php }?>><?php echo $tax_rate->tax_rate_percent . '% - ' . $tax_rate->tax_rate_name; ?>
                    </option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="settings[default_item_timbre]" class="control-label">
                    <?php echo lang('default_item_timbre'); ?>
                </label>
                <input name="settings[default_item_timbre]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('default_item_timbre'); ?>" />
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <?php $this->layout->load_view('tax_rates/index');?>
    </div>
</div>
	<div class="content-heading">
		<div class="portlet-title left-title">
			<div class="caption font-dark-sunglo">
				<span class="caption-subject bold med-caption dark"><?php echo lang('devise'); ?></span>
			</div>
		</div>
	</div>

                            <?php $this->layout->load_view('settings/partial_settings_devise');?>
</div>
</div>