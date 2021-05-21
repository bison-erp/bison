<input type="hidden" id="symbole_devise" value="DT">
<input type="hidden" id="tax_rate_decimal_places" value=3">
<input type="hidden" id="currency_symbol_placement" value="after">
<input type="hidden" id="thousands_separator" value=" ">
<input type="hidden" id="decimal_point" value=".">
<form method="post" class="form-horizontal"
    action="<?php echo site_url('mailer/send_bl/' . $bl->bl_id) ?>">

<div id="headerbar_empty">
    <?php $this->layout->load_view('layout/alerts');?>
</div>
    <div id="content">
	<div class="portlet light profile no-shabow bg-light-blue">
			<div class="portlet-header">
				<div class="portlet-title align-items-start flex-column">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark"><?php echo lang('email_bl'); ?></span>
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
                                value="<?php echo $bl->client_email; ?>">
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
                        <input type="hidden" name="numbersubj" id="numbersubj" class="form-control"
                            value=" <?php echo $bl->bl_number; ?>">

                        <div class="col-xs-12 col-sm-8">
                            <input type="text" name="subject" id="subject" class="form-control"
                                value="<?php echo lang('bl'); ?> n° <?php echo $bl->bl_number; ?>">
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
                    <div class="col-xs-12 col-sm-12 editt">
						<textarea name="body" id="body" class="form-control ckeditor " rows="8">
                            <?php echo ($email_templates[0]->email_template_body); ?>
						</textarea>
					</div>
				</div>
            </div>
			<div class="col-md-1"></div>
		</div>
	</div>
</div>
</div>
</form>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script>
jQuery(document).ready(function() {
    // initiate layout and plugins
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    Demo.init(); // init demo features

});
</script>
<script>
$('#drap').change(function() {
    if ($(this).prop("checked")) {
        $("#documenttable").show();
        $('#drap').val('1');

    } else {
        $("#documenttable").hide();
        $('#drap').val('0');
    }

});
$('#joint').change(function() {
    if ($(this).prop("checked")) {
        $('#joint').val('1');

    } else {
        $('#joint').val('0');
    }

});
var tab = [];

function mydoc(x) {
    var ch = "" + $('#listdocument').val();
    if ($('#doccheck' + x).prop("checked")) {
        if (ch.length > 0) {
            ch = ch + ',' + x;
        } else {
            ch = x;
        }

        $('#listdocument').val(ch);
    } else {
        var res = ch.split(",");
        for (var i = 0; i < res.length; i++) {
            if (res[i] == x) {
                res.splice(i, 1);
            }
        }

        $('#listdocument').val(res);

    }
}

$('#body').val(function(index, value) {
    return value.replace('{number}', $('#numbersubj').val());
});
</script>