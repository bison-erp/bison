<style>
#radioBtn .notActive {
    color: #3276b1;
    background-color: #fff;
}
#radioBtnn .notActive {
    color: #3276b1;
    background-color: #fff;
}
</style>
<div class="tab-info">
<div class="espace" style="padding: 10px 0;"></div>
<div class="col-xs-12 col-md-12" style="float: none;margin: auto;">
 <br>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <!-- CODE FACTURE SUIVANT -->
            <div class="form-group">
                <label for="settings[prefix_commande]" class="control-label">
                    <?php echo "Préfixe code commande"; ?>
                </label>
                <input type="text" name="settings[prefix_commande]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('prefix_commande'); ?>">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <!-- CODE FACTURE SUIVANT -->
            <div class="form-group">
                <label for="settings[next_code_bc]" class="control-label">
                    <?php echo lang('next_code_commande'); ?>
                </label>
                <?php $val=$this->mdl_settings->setting('next_code_bc');?>
                <input type="text" name="settings[next_code_bc]" class="form-control form-control-lg form-control-light"
                    value="<?php echo ($val); ?>">

                    
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <!-- CODE FACTURE SUIVANT -->
            <div class="form-group">
                <label for="settings[limite_dlc]" class="control-label">
                    <?php echo lang('limite_dlc'); ?>
                </label>
                <?php $val=$this->mdl_settings->setting('limite_dlc');?>
                <input type="text" name="settings[limite_dlc]" class="form-control form-control-lg form-control-light"
                    value="<?php echo ($val); ?>">

                    
            </div>
        </div>
        <!--div class="col-xs-12 col-sm-4">
        </div-->
    </div>
<div class="espace" style="padding: 10px 0;"></div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
			<div class="content-heading">
				<div class="portlet-title left-title">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark">
							<?php echo lang('commande_template'); ?>
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
                <label for="settings[pdf_commande_template]" class="control-label">
                    <?php echo lang('default_pdf_template'); ?>
                </label>
                <select id="settingspdf_commande_template" name="settings[pdf_commande_template]"
                    class="form-control form-control-lg form-control-light">
                    <?php foreach ($pdf_invoice_templates as $invoice_template) {?>
                    <option value="<?php echo $invoice_template; ?>"
                        <?php if ($this->mdl_settings->setting('pdf_commande_template') == $invoice_template) {?>selected="selected"
                        <?php }?>><?php echo $invoice_template; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[email_bc_template]" class="control-label"> 
                    <?php echo lang('default_email_template'); ?>
                </label>
                 <select name="settings[email_bc_template]" class="form-control form-control-lg form-control-light">
                    <option value=""></option> 
                    <?php foreach ($email_templates_bc as $email_template) {?>
                      <option value="<?php echo $email_template->email_template_id; ?>"
                        <?php if ($this->mdl_settings->setting('email_bc_template') == $email_template->email_template_id) {?>selected="selected"
                        <?php }?>><?php echo $email_template->email_template_title; ?></option> 
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="settings[email_bc_template_relance]" class="control-label">
					<?php echo lang('reminder_email_template'); ?>
                </label>
                <select name="settings[email_bc_template_relance]" class="form-control form-control-lg form-control-light">
                    <option value=""></option>
                    <?php foreach ($email_templates_bc as $email_template) {?>
                    <option value="<?php echo $email_template->email_template_id; ?>"
                        <?php if ($this->mdl_settings->setting('email_bc_template_relance') == $email_template->email_template_id) {?>selected="selected"
                        <?php }?>><?php echo $email_template->email_template_title; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
       
    </div>
<div class="espace" style="padding: 10px 0;"></div>

			<div class="content-heading">
				<div class="portlet-title left-title">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark">
							<?php echo lang('purchase_order_management'); ?>
						</span>
					</div>
				</div>
			</div>
				<div class="espace" style="padding: 10px 0;"></div>
                <div class="form-group">
					<div class="row">
                    <label for="settings[prefix_quote]" class="col-sm-4 col-md-4 control-label padding-sm">
					<?php echo lang('purchase_order_management'); ?>
					</label>
                    <div class="col-sm-4 col-md-4">
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group switch-btn">


                                <?php
$setclass1 = "";
$setclass0 = "";
if ($this->mdl_settings->setting('setting_gestion_bc') == 0) {
    $setclass1 .= "notActive";
    $setclass0 .= "active";
} else {
    $setclass1 .= "active";
    $setclass0 .= "notActive";
}?>

<?php
$setclass3 = "";
$setclass2 = "";
if ($this->mdl_settings->setting('setting_gestion_bl') == 0) {
    $setclass3 .= "notActive";
    $setclass2 .= "active";
} else {
    $setclass3 .= "active";
    $setclass2 .= "notActive";
}?>
                                <a class="btn btn-primary btn-sm on-btn <?php echo ($setclass0) ?>"
                                    data-toggle="settings[setting_gestion_bc]" data-title="Y" data-value="0"><?php echo lang('oui'); ?></a>
                                <a class="btn btn-primary btn-sm off-btn <?php echo ($setclass1) ?>"
                                    data-toggle="settings[setting_gestion_bc]" data-title="N" data-value="1"><?php echo lang('non'); ?></a>

                                <input type="hidden" name="settings[setting_gestion_bc]" id="bc"
                                    value="<?php echo $this->mdl_settings->setting('setting_gestion_bc'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                </div>

<div class="espace" style="padding: 10px 0;"></div>
</div>
</div>
<script>
var optionText = $("#settingspdf_commande_template option:selected").val();
if (optionText == 'default') {
    $('#settingspdf_commande_template option:eq(2)').prop('selected', true)
    $("#settingspdf_commande_template option[value='default']").hide();
} else {
    $("#settingspdf_commande_template option[value='default']").hide();
}
</script>
<script>
$('#radioBtn a').on('click', function() {
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#' + tog).prop('value', sel);

    $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass(
        'notActive');
    $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
    $('#bc').val($(this).data('value'));
})
</script>