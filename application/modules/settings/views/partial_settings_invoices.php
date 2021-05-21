<div class="tab-info">
<div class="espace" style="padding: 10px 0;"></div>
<div class="col-xs-12 col-md-12" style="float: none;margin: auto;">
 <br>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <!-- CODE FACTURE SUIVANT -->
            <div class="form-group">
                <label for="settings[prefix_invoice]" class="control-label">
                    <?php echo "Préfixe code facture"; ?>
                </label>
                <input type="text" name="settings[prefix_invoice]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('prefix_invoice'); ?>">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <!-- CODE FACTURE SUIVANT -->
            <div class="form-group">
                <label for="settings[next_code_invoice]" class="control-label">
                    <?php echo lang('next_code_invoice'); ?>
                </label>
                <input type="text" name="settings[next_code_invoice]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('next_code_invoice'); ?>">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">

            <!-- ECHEANCE DE FACTURATION -->
            <div class="form-group">
                <label for="settings[invoices_due_after]" class="control-label">
                    <?php echo lang('invoices_due_after'); ?>
                </label>
                <input type="text" name="settings[invoices_due_after]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('invoices_due_after'); ?>">
            </div>
        </div>
    </div>
<div class="espace" style="padding: 10px 0;"></div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
			<div class="content-heading">
				<div class="portlet-title left-title">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark">
							<?php echo lang('invoice_template'); ?>
						</span>
					</div>
				</div>
			</div>
        </div>
    </div>
<div class="espace" style="padding: 10px 0;"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[pdf_invoice_template]" class="control-label">
                    <?php echo lang('default_pdf_template'); ?>
                </label>
                <select id="settingspdf_invoice_template" name="settings[pdf_invoice_template]"
                    class="form-control form-control-lg form-control-light">
                    <?php foreach ($pdf_invoice_templates as $invoice_template) {?>
                    <option value="<?php echo $invoice_template; ?>"
                        <?php if ($this->mdl_settings->setting('pdf_invoice_template') == $invoice_template) {?>selected="selected"
                        <?php }?>><?php echo $invoice_template; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[email_invoice_template]" class="control-label">
                    <?php echo lang('default_email_template'); ?>
                </label>
                <select name="settings[email_invoice_template]" class="form-control form-control-lg form-control-light">
                    <option value=""></option>
                    <?php foreach ($email_templates_invoice as $email_template) {?>
                    <option value="<?php echo $email_template->email_template_id; ?>"
                        <?php if ($this->mdl_settings->setting('email_invoice_template') == $email_template->email_template_id) {?>selected="selected"
                        <?php }?>><?php echo $email_template->email_template_title; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[email_invoice_template_relance]" class="control-label"> 
					<?php echo lang('reminder_email_template'); ?>
                </label>
                <select name="settings[email_invoice_template_relance]" class="form-control form-control-lg form-control-light">
                    <option value=""></option>
                    <?php foreach ($email_templates_invoice as $email_template) {?>
                    <option value="<?php echo $email_template->email_template_id; ?>"
                        <?php if ($this->mdl_settings->setting('email_invoice_template_relance') == $email_template->email_template_id) {?>selected="selected"
                        <?php }?>><?php echo $email_template->email_template_title; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
    </div>
<div class="espace" style="padding: 10px 0;"></div>
</div>
</div>
<script>
var optionText = $("#settingspdf_invoice_template option:selected").val();
if (optionText == 'default') {
    $('#settingspdf_invoice_template option:eq(2)').prop('selected', true)
    $("#settingspdf_invoice_template option[value='default']").hide();
} else {
    $("#settingspdf_invoice_template option[value='default']").hide();
}
</script>