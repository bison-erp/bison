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
                <label for="settings[prefix_bl]" class="control-label">
                    <?php echo "Préfixe code bl"; ?>
                </label>
                <input type="text" name="settings[prefix_bl]" class="form-control form-control-lg form-control-light"
                    value="<?php echo $this->mdl_settings->setting('prefix_bl'); ?>">
            </div>
        </div>
         <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="settings[next_code_bl]" class="control-label">
                    <?php echo lang('next_code_bl'); ?>
                </label>
                <?php $val= $this->mdl_settings->setting('next_code_bl'); ?>
                <input type="text" name="settings[next_code_bl]" class="form-control form-control-lg form-control-light"
                    value="<?php  echo ($val); ?>">
            </div>
        </div>
        <!--div class="col-xs-12 col-sm-4">
        </div-->
    </div>
<div class="espace" style="padding: 10px 0;"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
			<div class="content-heading">
				<div class="portlet-title left-title">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark">
							<?php echo lang('bl_template'); ?>
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
                <label for="settings[pdf_bl_template]" class="control-label">
                    <?php echo lang('default_pdf_template'); ?>
                </label>
                <select id="settingspdf_bl_template" name="settings[pdf_bl_template]"
                    class="form-control form-control-lg form-control-light">
                    <?php foreach ($pdf_quote_templates as $quote_template) {?>
                    <option value="<?php echo $quote_template; ?>"
                        <?php if ($this->mdl_settings->setting('pdf_bl_template') == $quote_template) {?>selected="selected"
                        <?php }?>><?php echo $quote_template; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="settings[email_bl_template]" class="control-label"> 
                    <?php echo lang('default_email_template'); ?>
                </label>
                 <select name="settings[email_bl_template]" class="form-control form-control-lg form-control-light">
                    <option value=""></option> 
                    <?php foreach ($email_templates_bl as $email_template) {?>
                      <option value="<?php echo $email_template->email_template_id; ?>"
                        <?php if ($this->mdl_settings->setting('email_bl_template') == $email_template->email_template_id) {?>selected="selected"
                        <?php }?>><?php echo $email_template->email_template_title; ?></option> 
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="settings[email_bl_template_relance]" class="control-label">
					<?php echo lang('reminder_email_template'); ?>
                </label>
                <select name="settings[email_bl_template_relance]" class="form-control form-control-lg form-control-light">
                    <option value=""></option>
                    <?php foreach ($email_templates_bl as $email_template) {?>
                    <option value="<?php echo $email_template->email_template_id; ?>"
                        <?php if ($this->mdl_settings->setting('email_bl_template_relance') == $email_template->email_template_id) {?>selected="selected"
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
							<?php echo lang('delivery_note_management'); ?>
						</span>
					</div>
				</div>
			</div>
				<div class="espace" style="padding: 10px 0;"></div>
                <div class="form-group">
					<div class="row">
                    <label for="happy" class="col-sm-4 col-md-4 control-label padding-sm">
					<?php echo lang('delivery_note_management'); ?>
					</label>
                    <div class="col-sm-4 col-md-4">
                        <div class="input-group">
                            <div id="radioBtnn" class="btn-group switch-btn">
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
                            <a class="btn btn-primary btn-sm on-btn <?php echo ($setclass2) ?>"
                                    data-toggle="settings[setting_gestion_bl]" data-title="Y" data-value="0"><?php echo lang('oui'); ?></a>
                                <a class="btn btn-primary btn-sm off-btn <?php echo ($setclass3) ?>"
                                    data-toggle="settings[setting_gestion_bl]" data-title="N" data-value="1"><?php echo lang('non'); ?></a>

                                            </div>
                                            <input type="hidden" name="settings[setting_gestion_bl]" id="bl"
                                    value="<?php echo $this->mdl_settings->setting('setting_gestion_bl'); ?>">
                                 </div>
                    </div>
					</div>
				</div>
		<div class="espace" style="padding: 10px 0;"></div>
    </div>
</div>
<script>
var optionText = $("#settingspdf_bl_template option:selected").val();
if (optionText == 'default') {
    $('#settingspdf_bl_template option:eq(2)').prop('selected', true)
    $("#settingspdf_bl_template option[value='default']").hide();

} else {
    $("#settingspdf_bl_template option[value='default']").hide();
}
</script>
<script>
$('#radioBtnn a').on('click', function() {
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#' + tog).prop('value', sel);

    $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass(
        'notActive');
    $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
    $('#bl').val($(this).data('value'));
})
</script>