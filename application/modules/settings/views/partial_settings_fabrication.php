<div class="tab-info">
<div class="espace" style="padding: 10px 0;"></div>
<div class="col-xs-12 col-md-12" style="float: none;margin: auto;">
 <br>    
	<div class="row">
        <div class="col-xs-12 col-md-12">
			<div class="content-heading">
				<div class="portlet-title left-title">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark">
							<?php echo lang('bf'); ?>
						</span>
					</div>
				</div>
			</div>
        </div>
    </div>
<div class="espace" style="padding: 10px 0;"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <!-- CODE FACTURE SUIVANT -->
            <div class="form-group">
                <label for="settings[prefix_fabrication]" class="control-label">
                    <?php echo lang('prefix_fabrication'); ?>
                </label>
                <input type="text" name="settings[prefix_fabrication]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('prefix_fabrication'); ?>">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <!-- CODE FACTURE SUIVANT -->
            <div class="form-group">
                <label for="settings[next_code_bf]" class="control-label">
                    <?php echo lang('next_code_fabrication'); ?>
                </label>
                <?php $val=$this->mdl_settings->setting('next_code_bf');?>
                <input type="text" name="settings[next_code_bf]" class="form-control form-control-lg form-control-light"
                    value="<?php echo ($val); ?>">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[pdf_fabrication_template]" class="control-label">
                    <?php echo lang('default_pdf_template'); ?>
                </label>
                <select id="settingspdf_fabrication_template" name="settings[pdf_fabrication_template]"
                    class="form-control form-control-lg form-control-light">
                    <?php foreach ($pdf_invoice_templates as $invoice_template) {?>
                    <option value="<?php echo $invoice_template; ?>"
                        <?php if ($this->mdl_settings->setting('pdf_fabrication_template') == $invoice_template) {?>selected="selected"
                        <?php }?>><?php echo $invoice_template; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
    </div>  
<div class="espace" style="padding: 10px 0;"></div>
</div>
</div>
<script>
var optionText = $("#settingspdf_fabrication_template option:selected").val();
if (optionText == 'default') {
    $('#settingspdf_fabrication_template option:eq(2)').prop('selected', true)
    $("#settingspdf_fabrication_template option[value='default']").hide();
} else {
    $("#settingspdf_fabrication_template option[value='default']").hide();
}
</script>