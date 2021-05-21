<style>
    .form-horizontal .form-group.form-md-line-input {
        padding-top: 10px;
        margin-bottom: 20px;
        margin: 0 -10px 20px -10px!important;
    }
    .form-horizontal .form-group.form-md-line-input .form-control ~ label, .form-horizontal
    .form-group.form-md-line-input .form-control ~ .form-control-focus {
        width: auto;
        left: 0;
        right: 0;
    }
    .form-group.form-md-line-input .form-control {
        padding-left: 0;
    }
	.form-horizontal .form-group {
    margin-right: 0;
    margin-left: 0;
}
	.form-horizontal .form-group label {
		margin-bottom: 8px;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		border-color: #F3F6F9;
		padding: 12px 10px;
	}
.col-lg-6.col-sm-6.col-xs-12.first-col-6 {
    border-right: 1px solid #EBEDF3;
}	
label.radio.radio-outline.radio-outline-2x.radio-primary {
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.md-radio label.radio-outline-2x > .box {
    top: 0px;
    border: 2px solid #666;
    height: 20px;
    width: 20px;
    border-radius: 50% !important;
    -moz-border-radius: 50% !important;
    -webkit-border-radius: 50% !important;
    z-index: 5;
    background-color: transparent;
    border-color: #D1D3E0;
    height: 18px;
    width: 18px;
}
.md-radio label.radio-outline-2x > .check {
    top: 5px;
    left: 5px;
    width: 8px;
    height: 8px;
    background: #3699FF;
}
.md-radio input[type=radio]:checked ~ label > .box {
    border-color: #3699FF;
}
.form-horizontal .radio > span {
    margin-top: 7px;
}
.form-horizontal .md-radio-inline {
    margin-top: 6px;
    margin-bottom: 6px;
}
</style>
<form method="post" class="form-horizontal">
    <div id="headerbar-index" style=" margin-top:0;margin-bottom:0;">
        <?php echo $this->layout->load_view('layout/alerts'); ?>
    </div>
    <div id="content">
		<div class="portlet light profile no-shabow bg-light-blue">
			<div class="portlet-header">
				<div class="portlet-title align-items-start flex-column">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark"><?php echo lang('email_model_editor'); ?></span><br />
						<span class="caption-subject text-bold small-caption muted"><?php echo lang('create_edit_email_template'); ?></span>
					</div>
				</div>
				<div class="portlet-toolbar">
					<?php echo $this->layout->load_view('layout/header_buttons'); ?>
				</div>
			</div>
			<div class="portlet-body">
						<div class="row card-row form-row">   
                        <div class="col-lg-6 col-sm-6 col-xs-12">
                            <div class="form-group has-info">
                                <label for="form_control_1"><span style="font-weight: 600;"><?php echo lang('title'); ?></span></label>
                                <?php if ($this->mdl_email_templates->form_value('email_template_title') == "Relance automatique facture") {?>
                                <input
                                    value="<?php echo $this->mdl_email_templates->form_value('email_template_title'); ?>"
                                    autocomplete="off" type="text" class="form-control form-control-md form-control-light" name="email_template_title"
                                    id="email_template_title" readonly>
                                <?php } elseif ($this->mdl_email_templates->form_value('email_template_title') == "Relance automatique devis") {?>
                                <input
                                    value="<?php echo $this->mdl_email_templates->form_value('email_template_title'); ?>"
                                    autocomplete="off" type="text" class="form-control form-control-md form-control-light" name="email_template_title"
                                    id="email_template_title" readonly>
                                <?php } else {?>
                                <input
                                    value="<?php echo $this->mdl_email_templates->form_value('email_template_title'); ?>"
                                    autocomplete="off" type="text" class="form-control form-control-md form-control-light" name="email_template_title"
                                    id="email_template_title">
                                <?php }?>
                                <div class="form-control-focus">
                                </div>
                            </div>
                        </div>
                        <?php
$record_num = end($this->uri->segment_array());
if ($record_num != 'form') {
    $var = $this->mdl_email_templates->searchinsertclient($record_num);
    ?>
                        <input type="hidden" value="<?php echo ($var[0]->insertclient) ?>" name="insertclient"
                            id="insertclient">
                        <?php } else {?>
                        <input type="hidden" value="1" name="insertclient" id="insertclient">
                        <?php }?>
                        <div class="col-lg-6 col-sm-6 col-xs-12">
                            <div class="form-group has-info">
                                <label for="form_control_1"><span style="font-weight: 600;"><?php echo lang('type'); ?></span></label>
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" value="invoice" name="email_template_type"
                                            id="email_template_type_invoice" class="md-radiobtn" <?php
if ($this->mdl_email_templates->form_value('email_template_type') == 'invoice') {
    echo "checked";
}
?>>
                                        <label class="radio radio-outline radio-outline-2x radio-primary" for="email_template_type_invoice">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <?php echo lang('invoice'); ?>
										</label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" value="quote" name="email_template_type"
                                            id="email_template_type_quote" class="md-radiobtn" <?php
if ($this->mdl_email_templates->form_value('email_template_type') == 'quote') {
    echo "checked";
}
?>>
                                        <label class="radio radio-outline radio-outline-2x radio-primary" for="email_template_type_quote">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <?php echo lang('quote'); ?>
										</label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" value="bl" name="email_template_type"
                                            id="email_template_type_bl" class="md-radiobtn" <?php
if ($this->mdl_email_templates->form_value('email_template_type') == 'bon_livraison') {
    echo "checked";
}
?>>
                                        <label class="radio radio-outline radio-outline-2x radio-primary" for="email_template_type_bl">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <?php echo lang('bon_livraison'); ?>
										</label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" value="commande" name="email_template_type"
                                            id="email_template_type_commande" class="md-radiobtn" <?php
if ($this->mdl_email_templates->form_value('email_template_type') == 'commande') {
    echo "checked";
}
?>>
                                        <label class="radio radio-outline radio-outline-2x radio-primary" for="email_template_type_commande">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <?php echo lang('commande'); ?> 
										</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="col-lg-12 col-sm-12 col-xs-12" style="padding-bottom: 5px">
                    <div class="form-group has-info">
                        <label for="email_template_subject"><span style="font-weight: 600;"><?php echo lang('subject'); ?></span></label>
                        <input value="<?php echo $this->mdl_email_templates->form_value('email_template_subject'); ?>"
                            autocomplete="off" type="text" class="form-control form-control-md form-control-light" name="email_template_subject"
                            id="email_template_subject">
                        <div class="form-control-focus"></div>
                    </div>
				</div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="email_template_body"><span style="font-weight: 600;"><?php echo lang('body'); ?></span></label>
                        <textarea name="email_template_body" id="email_template_body" style="height: 200px;"
                                class="form-control form-control-md form-control-light ckeditor"><?php echo $this->mdl_email_templates->form_value('email_template_body'); ?></textarea>
                    </div>
				</div>
			</div>
			</div>
                    <script type="text/javascript"
                        src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/ckeditor.js"></script>
                    <script>
                    jQuery(document).ready(function() {
                        // initiate layout and plugins
                        Metronic.init(); // init metronic core components
                        Layout.init(); // init current layout
                        Demo.init(); // init demo features

                    });
                    </script>
			</div>
 <div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark"><?php echo lang('dynamic_fields'); ?></span><br />
					<span class="caption-subject text-bold small-caption muted"><?php echo lang('include_dynamic_fields'); ?></span>
				</div>
			</div>
			<div class="portlet-toolbar">
			</div>
		</div>
		<div class="portlet-body">
			<div class="row card-row form-row">   
                <div class="col-lg-6 col-sm-6 col-xs-12 first-col-6">
                    <table width="100%" class="table table-striped table-condensed no-margin">
						<thead>
							<tr style="background: #F3F6F9;">
								<td><span class="label-code-table"><?php echo lang('field'); ?></span></td>
								<td><span class="label-code-table"><?php echo lang('field_description'); ?></span></td>
							</tr>
						</thead>
						<tbody>
                            <tr>
                                <td>{client_fullname}</td>
                                <td><?php echo lang('df_full_name'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_societe}</td>
                                <td><?php echo lang('df_company_name'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_address_1}</td>
                                <td><?php echo lang('df_customer_address'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_address_2}</td>
                                <td><?php echo lang('df_2nd_customer_address'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_city}</td>
                                <td><?php echo lang('df_customer_city'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_country}</td>
                                <td><?php echo lang('df_customer_country'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_phone}</td>
                                <td><?php echo lang('df_customer_phone'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_fax}</td>
                                <td><?php echo lang('df_customer_fax'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_mobile}</td>
                                <td><?php echo lang('df_customer_mobile'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_email}</td>
                                <td><?php echo lang('df_customer_email'); ?></td>
                            </tr>
                            <tr>
                                <td>{client_web}</td>
                                <td><?php echo lang('df_client_website'); ?></td>
                            </tr>
                            <tr>
                                <td>{matricule_fiscale}</td>
                                <td><?php echo lang('df_customer_tax'); ?></td>
                            </tr>
                            <tr>
                                <td>{registre_commerce}</td>
                                <td><?php echo lang('df_Customer_trade_register'); ?></td>
                            </tr>
						</tbody>
                    </table>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <table width="100%" class="table table-striped table-condensed no-margin">
						<thead>
							<tr style="background: #F3F6F9;">
								<td><span class="label-code-table"><?php echo lang('field'); ?></span></td>
								<td><span class="label-code-table"><?php echo lang('field_description'); ?></span></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{number}</td>
								<td><?php echo lang('df_file_number'); ?></td>
							</tr>
							<tr>
								<td>{nature}</td>
								<td><?php echo lang('df_nature_file'); ?></td>
							</tr>
							<tr>
								<td>{date_created}</td>
								<td><?php echo lang('df_creation_date'); ?></td>
							</tr>
							<tr>
								<td>{date_expires}</td>
								<td><?php echo lang('df_expiry_date'); ?></td>
							</tr>
							<tr>
								<td>{signature}</td>
								<td><?php echo lang('df_signature'); ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<table width="100%" class="table table-striped table-condensed no-margin">
						<thead>
							<tr style="background: #F3F6F9;">
								<td><span class="label-code-table"><?php echo lang('field'); ?></span></td>
								<td><span class="label-code-table"><?php echo lang('field_description'); ?></span></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{items_table}</td>
								<td><?php echo lang('df_display_file_line'); ?></td>
							</tr>
							<tr>
								<td>{items_codes}</td>
								<td><?php echo lang('df_display_file_code'); ?></td>
							</tr>
							<tr>
								<td>{item_subtotal}</td>
								<td><?php echo lang('df_amount_ht'); ?></td>
							</tr>
							<tr>
								<td>{total_final}</td>
								<td><?php echo lang('df_amount_ttc'); ?></td>
							</tr>
							<tr>
								<td>{total_a_payer}</td>
								<td><?php echo lang('df_amount_total_ttc'); ?></td>
							</tr>
						</tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>		
		<div class="portlet-footer">
			<div class="pull-left back-btn">
				<a class="back-btn" role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>email_templates/index'" href="">
					<span class="back-btn">
						<?php echo lang('back_to_settings_page'); ?>
					</span>
				</a>
			</div>
		</div>
    </div>
</div>
</form>

<script type="text/javascript">
$(function() {
    var email_template_type = "<?php echo $this->mdl_email_templates->form_value('email_template_type'); ?>";
    var $email_template_type_options = $("[name=email_template_type]");

    $email_template_type_options.click(function() {
        // remove class "show" and deselect any selected elements.
        $(".show").removeClass("show").parent("select").each(function() {
            this.options.selectedIndex = 0;
        });
        // add show class to corresponding class
        $(".hidden-" + $(this).val()).addClass("show");
    });
    if (email_template_type === "") {
        $email_template_type_options.first().click();
    } else {
        $email_template_type_options.each(function() {
            if ($(this).val() === email_template_type) {
                $(this).click();
            }
        });
    }
});
</script>