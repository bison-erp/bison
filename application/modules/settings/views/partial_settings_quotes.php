<div class="tab-info">
<div class="espace" style="padding: 10px 0;"></div>
<div class="col-xs-12 col-md-12" style="float: none;margin: auto;">
 <br>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <!-- CODE FACTURE SUIVANT -->
            <div class="form-group">
                <label for="settings[prefix_quote]" class="control-label">
                    <?php echo "Préfixe code devis"; ?>
                </label>
                <input type="text" name="settings[prefix_quote]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('prefix_quote'); ?>">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[next_code_devis]" class="control-label">
                    <?php echo lang('next_code_devis'); ?>
                </label>
                <input type="text" name="settings[next_code_devis]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('next_code_devis'); ?>">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[quotes_expire_after]" class="control-label">
                    <?php echo lang('quotes_expire_after'); ?>
                </label>
                <input type="text" name="settings[quotes_expire_after]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('quotes_expire_after'); ?>">
            </div>
        </div>
    </div>

<div class="espace" style="padding: 10px 0;"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
			<div class="content-heading">
				<div class="portlet-title left-title">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark">
							<?php echo lang('quote_template'); ?>
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
                <label for="settings[pdf_quote_template]" class="control-label">
                    <?php echo lang('default_pdf_template'); ?>
                </label>
                <select id="settingspdf_quote_template" name="settings[pdf_quote_template]"
                    class="form-control form-control-lg form-control-light">
                    <?php foreach ($pdf_quote_templates as $quote_template) {?>
                    <option value="<?php echo $quote_template; ?>"
                        <?php if ($this->mdl_settings->setting('pdf_quote_template') == $quote_template) {?>selected="selected"
                        <?php }?>><?php echo $quote_template; ?></option>
                    <?php }?>
                </select>
            </div>

        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[email_quote_template]" class="control-label">
                    <?php echo lang('default_email_template'); ?>
                </label>
                <select name="settings[email_quote_template]" class="form-control form-control-lg form-control-light">
                    <option value=""></option>
                    <?php foreach ($email_templates_quote as $email_template) {?>
                    <option value="<?php echo $email_template->email_template_id; ?>"
                        <?php if ($this->mdl_settings->setting('email_quote_template') == $email_template->email_template_id) {?>selected="selected"
                        <?php }?>><?php echo $email_template->email_template_title; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[email_quote_template_relance]" class="control-label">
					<?php echo lang('reminder_email_template'); ?>
                </label>
                <select name="settings[email_quote_template_relance]" class="form-control form-control-lg form-control-light">
                    <option value=""></option>
                    <?php foreach ($email_templates_quote as $email_template) {?>
                    <option value="<?php echo $email_template->email_template_id; ?>"
                        <?php if ($this->mdl_settings->setting('email_quote_template_relance') == $email_template->email_template_id) {?>selected="selected"
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
var optionText = $("#settingspdf_quote_template option:selected").val();
if (optionText == 'default') {
    $('#settingspdf_quote_template option:eq(2)').prop('selected', true)
    $("#settingspdf_quote_template option[value='default']").hide();

} else {
    $("#settingspdf_quote_template option[value='default']").hide();
}
</script>