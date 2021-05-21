<script type="text/javascript">
$(function() {
    var template_fields = ["body", "subject", "from_name", "from_email", "cc", "bcc", "pdf_template"];
    $.post("<?php echo site_url('settings/ajax/get_signature/'); ?>", {}, function(data) {
        signature = data;
    });



});
$(document).ready(function() {
    $('.date').datepicker({
        multidate: true,
        format: 'dd/mm/yyyy'
    });
});
</script>
<input type="hidden" id="symbole_devise" value="DT">
<input type="hidden" id="tax_rate_decimal_places" value=3">
<input type="hidden" id="currency_symbol_placement" value="after">
<input type="hidden" id="thousands_separator" value=" ">
<input type="hidden" id="decimal_point" value=".">
<input type="hidden" id="invoice_idd" value="<?php echo $invoice->invoice_id ?>">

<form method="post" class="form-horizontal"
    action="<?php echo site_url('mailer/send_avoir/' . $invoice->haveinvoice_id) ?>">
<div id="headerbar_empty">
    <?php
$this->load->model('quotes/mdl_rappel');
$dateselectrappel = $this->mdl_rappel->getRappel($invoice->invoice_id, 1);
$valdaterappek = "";
if ($dateselectrappel) {
    for ($i = 0; $i < count($dateselectrappel); $i++) {
        if ((count($dateselectrappel) - 1) == $i) {
            $valdaterappek = $valdaterappek . $dateselectrappel[$i]->daterappel;
        } else {
            $valdaterappek = $valdaterappek . $dateselectrappel[$i]->daterappel . ',';
        }
    }
}
$this->layout->load_view('layout/alerts');?>
</div>
    <div id="content">
		<div class="portlet light profile no-shabow bg-light-blue">
			<div class="portlet-header">
				<div class="portlet-title align-items-start flex-column">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark"><?php echo lang('email_credit'); ?></span>
					</div>
				</div>
				<div class="portlet-toolbar">
					<div class="pull-right btn-group">
						<button class="btn btn-success btn-sm blue bg-success text-success" name="btn_send" value="1">
							<i class="fa fa-send"></i>
							<?php echo lang('send'); ?>
						</button>
						<button class="btn btn-danger btn-sm default bg-cancel text-dark" name="btn_cancel" value="1">
							<i class="fa fa-times"></i>
							<?php echo lang('cancel'); ?>
						</button>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-6">
					<div class="portlet light formulaire no-padding">
						<div class="form-group">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="to_email" class="control-label"><?php echo lang('to_email'); ?>: </label>
							</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="to_email" id="to_email" class="form-control"
									value="<?php echo $invoice->client_email; ?>">
							</div>
						</div>
						<div style="display:none " class="form-group">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="from_name" class="control-label"><?php echo lang('from_name'); ?>: </label>
							</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="from_name" id="from_name" class="form-control"
									value="<?php //echo $invoice->user_name;                                         ?>">
							</div>
						</div>
						<div style="display: none" class="form-group">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="from_email" class="control-label"><?php echo lang('from_email'); ?>: </label>
							</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="from_email" id="from_email" class="form-control"
									value="<?php //echo $invoice->user_email;                                         ?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="cc" class="control-label"><?php echo lang('cc'); ?>: </label>
							</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="cc" id="cc" value="" class="form-control">
							</div>
						</div>
					</div>
					</div>
					<div class="col-md-6">
					<div class="portlet light formulaire no-padding">
						<div class="form-group">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="subject" class="control-label"><?php echo lang('subject'); ?>: </label>
							</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="subject" id="subject" class="form-control"
									value="<?php echo lang('avoir'); ?> n° <?php echo $invoice->invoice_number; ?> sur <?php echo lang('invoice'); ?> n° <?php echo $invoice->invoice_number_origin; ?>">
								<input type="hidden" name="numbersubj" id="numbersubj" class="form-control"
									value=" <?php echo $invoice->invoice_number; ?>">
								<input type="hidden" name="invoice_number_origin" id="invoice_number_origin"
									class="form-control" value=" <?php echo $invoice->invoice_number_origin; ?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="bcc" class="control-label"><?php echo lang('bcc'); ?>: </label>
							</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="bcc" id="bcc" value="" class="form-control">
							</div>
						</div>
						<div class="form-group" style=" display: none">
							<div class="col-xs-12 col-sm-8">
								<select name="pdf_template" id="pdf_template" class="form-control">
									<option value=""></option>
									<?php foreach ($pdf_templates as $pdf_template): ?>
									<option value="<?php echo $pdf_template; ?>" <?php if ($selected_pdf_template == $pdf_template):
	?>selected="selected" <?php endif;?>>
										<?php echo $pdf_template; ?>
									</option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
					</div>
					</div>
				</div>
				
        <div class="sup offline" style="margin-top: 30px;"></div>
		<div class="row border-top">
			<div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="form-group">
                        <div class="col-xs-12 col-sm-12 text-left text-left-xs">
                            <label for="body" class="control-label" style="padding-bottom: 10px;"><?php echo lang('body'); ?>: </label>
                        </div>

                        <div class="col-xs-12 col-md-12 editt">
                            <textarea name="body" id="body" class="form-control ckeditor " rows="8">
                            <?php echo ($email_templates[0]->email_template_body); ?>
                            </textarea>
                        </div>
                </div>
            </div>
			<div class="col-md-1"></div>
         </div>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/ckeditor.js">
            </script>
            <script>
            jQuery(document).ready(function() {
                // initiate layout and plugins
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                Demo.init(); // init demo features
            });
            </script>
        </div>
    </div>
    </div>
</form>
<script>
 $("#body").text(function(index, text) {
    return text.replace('{number}', $('#numbersubj').val());
});
$("#body").text(function(index, text) {
   return text.replace('{nmberorigin}', $('#invoice_number_origin').val());
});
 </script>