<style>
.form-group.form-md-line-input .form-control {
    padding-left: 1px;
}

.datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
    background: #eee;
    cursor: pointer;
    border-radius: 4px;
}

.datepicker .active {
    background-color: #4B8DF8 !important;
    background-image: none !important;
    filter: none !important;
    border-radius: 4px;
}

.lenght {
    min-height: 403px;
}
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
    rel="stylesheet" type="text/css">
<div id="headerbar-index">
     <?php $this->layout->load_view('layout/alerts');?>
</div>
<div id="content">
<!-- begin formulaire -->
<form method="post"> 
   <?php if ($payment_id) {?>
    <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
    <?php }?>
	<div class="portlet light add_edit_payment profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column" style="padding-top:10px;">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark">
                            <?php if ($this->mdl_payments->form_value('payment_id')): ?>
							<?php echo lang('modify_payment'); ?>&nbsp;#<?php echo $this->mdl_products->form_value('payment_id'); ?>
                            <?php else: ?>
							<?php echo lang('add_edit_payment');?>
                            <?php endif;?>
					</span>
				</div>
			</div>
			<div class="portlet-toolbar">
             <?php $this->layout->load_view('layout/header_buttons');?>
			</div>
		</div>
<div class="portlet-body">
    <div class="row">
        <div class="col-md-6">
			<div class="portlet light formulaire first">
				<div class="row card-row form-row">
					 <div class="col-lg-6 col-sm-6 col-xl-12">
							<div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('clt'); ?></label>
                                <select name="client_id" id="client_id" class="form-control form-control-sm form-control-light">
                                    <option value="0"><?php echo lang('select'); ?></option>
                                    <?php if (!empty($clients)) {?>
                                    <?php foreach ($clients as $client) {?>
                                    <?php $client_fullname = ($client->client_societe != "") ? $client->client_name . " " . $client->client_prenom . " (" . $client->client_societe . ")" : $client->client_name . " " . $client->client_prenom;?>
                                    <option <?php if (isset($payment->client_id) && $payment->client_id == $client->client_id) {
    echo "selected='selected'";
}
    ?> value="<?php echo $client->client_id; ?>"><?php echo $client_fullname; ?></option>
                                    <?php }?>
                                    <?php }?>
                                </select>
                          </div>
                     </div>
					<div class="col-lg-6 col-sm-6 col-xl-12">
						<div class=" form-group has-info">
								<label for="form_control_1"><?php echo lang('num_facture'); ?></label>
								<select name="invoice_id" id="invoice_id" class="form-control form-control-sm form-control-light">
										<option value="0"><?php echo lang('select'); ?></option>
								</select>
							<div class="form-control-focus"></div>
						</div>
                     </div>
                     </div>
						<div class="row card-row form-row">
							<div class="col-lg-6 col-sm-6 col-xl-12">
                                <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('date'); ?></label>
                                    <div class="input-group">
                                        <input name="payment_date" id="payment_date"
                                            class="form-control form-control-sm form-control-light datepicker"
                                            value="<?php echo isset($payment->payment_date) ? date_from_mysql($payment->payment_date, 1) : date("d/m/Y") ?>">
                                        <div class="form-control-focus"></div>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-6 col-sm-6 col-xl-12">
								<div class=" form-group has-info">
								<label for="form_control_1"><?php echo lang('moyenpaiment'); ?></label>
								<select id="payment_method_id" name="payment_method_id" class="form-control form-control-sm form-control-light">
									<?php foreach ($payment_methods as $payment_method) {?>
									<option value="<?php echo $payment_method->payment_method_id; ?>"
										<?php if (isset($payment->payment_method_id) && $payment->payment_method_id == $payment_method->payment_method_id) {?>selected="selected"
										<?php }?> <?php if (!isset($payment->payment_method_id) && $payment_method->payment_method_id == 3) {
				echo 'selected="selected"';
			}
				?>>
										<?php echo $payment_method->payment_method_name; ?>
									</option>
									<?php }?>
								</select>
								</div>
							</div>
                          </div>
			<div class="row card-row form-row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="form-group has-info">
						<label for="form_control_1"><?php echo lang('note_societes'); ?></label>
							<textarea style="height: 90px;" name="payment_note" class="form-control form-control-sm form-control-light">
								<?php if (isset($payment->payment_note)) {echo $payment->payment_note;}?>
							</textarea>
                       <div class="form-control-focus"></div>
					</div>
                </div>
            </div>
      </div>
</div>	
	<div class="col-md-6">
		<div class="portlet light formulaire no-padding">
			<div class="bg-light-blue-card payment-bloc">
				<div class="row card-row form-row" id="div_esp">
					<div class="col-lg-12 col-sm-12 col-xl-12">
						<div class="form-group has-info">
							<label for="form_control_1"><?php echo lang('montant_cheq'); ?></label>
                                  <input type="text" id="montant_esp" name="montant_esp" class="form-control form-control-sm form-control-light"
                                        value="<?php if (isset($payment->payment_amount)) {
    echo $payment->payment_amount;
}
?>">
                                    <div class="form-control-focus"></div>
                                </div>
                     </div>
				</div>
            <div class="row card-row form-row" id="div_cheq" style=" display: none">
				<div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('num_cheq'); ?></label>
                        <input type="text" id="num_cheq" name="num_cheq" class="form-control form-control-sm form-control-light" value="<?php if (isset($pieces_info->num_piece)) {
    echo $pieces_info->num_piece;
}
?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
				<div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('montant_cheq'); ?></label>
                        <input type="text" id="montant_cheq" name="montant_cheq" class="form-control form-control-sm form-control-light" value="<?php if (isset($payment->payment_amount)) {
    echo $payment->payment_amount;
}
?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
				<div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('due_date'); ?><span class="text-danger"> *</span></label>
						<div class="input-group">
                        <input name="date_cheq" id="date_cheq" class="form-control form-control-sm form-control-light datepicker" value="<?php if (isset($payment->payment_dat_eche) && $payment->payment_dat_eche != "0000-00-00") {
    echo date_from_mysql($payment->payment_dat_eche, 1);
} else {
    echo date('d/m/Y');
}
?>">

						 <span class="input-group-addon">
							<i class="fa fa-calendar fa-fw"></i>
						 </span>
						</div>
                        <div class="form-control-focus"></div>
                    </div>
                </div>
				<div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('proprietaire'); ?></label>
                        <input type="text" id="proprietaire_c" name="proprietaire_c" class="form-control form-control-sm form-control-light"
                            value="<?php if (isset($pieces_info->proprietaire)) {
    echo $pieces_info->proprietaire;
}
?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
				
				
                    <div class="form-group select-search-input has-info">
                    <label for="form_control_1"><?php echo lang('banque'); ?></label>
                    <select name="banque_v" id="banque_v" class="form-control form-control-sm form-control-light form-width-input">
                        <option value="0"><?php echo lang('select'); ?></option>
                        <?php foreach ($banque as $bq) {?>
                        <?php if ($bq->id_banque == $pieces_info->banque) {?>
                        <option value="<?php echo $bq->id_banque;

    ?>" <?php echo "selected='selected'"; ?>><?php echo $bq->nom_banque ?></option>
                        <?php } else {?>
                        <option value="<?php echo $bq->id_banque ?>"><?php echo $bq->nom_banque ?></option>

                        <?php }}?>
                    </select>
                    <button id="search_banque" type="button" class="search_banque btn btn-success">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
					</div>
                </div>
            </div>
            <div class="row card-row form-row" id="div_vir" style=" display: none">
                <div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('reference'); ?></label>
                        </label>
                        <input type="text" id="reference" name="reference"
                            class="form-control form-control-sm form-control-light" value="<?php if (isset($pieces_info->num_piece)) {
    echo $pieces_info->num_piece;
}
?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('proprietaire'); ?></label>
                        </label>
                        <input type="text" id="proprietaire_v" name="proprietaire_v" class="form-control form-control-sm form-control-light"
                            value="<?php if (isset($pieces_info->proprietaire)) {
    echo $pieces_info->proprietaire;
}
?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
                    <div class="form-group select-search-input has-info">
                    <label for="form_control_1"><?php echo lang('banque'); ?></label>
                    <select name="banque_v" id="banque_v" class="form-control form-control-sm form-control-light form-width-input">
                        <option value="0"><?php echo lang('select'); ?></option>
                        <?php foreach ($banque as $bq) {?>
                        <?php if ($bq->id_banque == $pieces_info->banque) {?>
                        <option value="<?php echo $bq->id_banque;

    ?>" <?php echo "selected='selected'"; ?>><?php echo $bq->nom_banque ?></option>
                        <?php } else {?>
                        <option value="<?php echo $bq->id_banque ?>"><?php echo $bq->nom_banque ?></option>

                        <?php }}?>
                    </select>
                    <button id="search_banque" type="button" class="search_banque btn btn-success">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
					</div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xl-12" style="margin-bottom: 5px;">
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('montant_cheq'); ?></label>
                        </label>
                        <input type="text" id="montant_c" name="montant_c" class="form-control form-control-sm form-control-light" value="<?php if (isset($payment->payment_amount)) {
    echo $payment->payment_amount;
}
?>">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
	<!--div class="portlet-footer">
		<div class="portlet-tool-btn">
			<div class="pull-right btn-group">
				<!?php $this->layout->load_view('layout/header_buttons');?>
			</div>
		</div>
	</div-->
</div>
</div>
</form>
</div>
<input type="hidden" id="symbole_devise" value="DT">
<input type="hidden" id="tax_rate_decimal_places" value="3">
<input type="hidden" id="currency_symbol_placement" value="after">
<input type="hidden" id="thousands_separator" value=" ">
<input type="hidden" id="decimal_point" value=".">

<script type="text/javascript">
invoice_id_def = 0; <?php
if (isset($payment->invoice_id)) {
    echo "invoice_id_def = " . $payment->invoice_id .
        ";";
}?>

function updateFactures() {
    var client_id = $("#client_id").val();
    if (client_id != "0") {
        $.post("<?php echo site_url('payments/ajax/getClientFactures'); ?>", {
            client_id: client_id
        }, function(data) {
            //                alert(data);
            var parsed = JSON.parse(data);
            json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }

            devise_info = json_response[1];

            $("#symbole_devise").val(devise_info[0]["devise_symbole"]);
            $("#currency_symbol_placement").val(devise_info[0]["symbole_placement"]);
            $("#tax_rate_decimal_places").val(devise_info[0]["number_decimal"]);
            $("#thousands_separator").val(devise_info[0]["thousands_separator"]);

            var replace_factures = "<option value='0'>Choisir</option>";
            $.each(json_response[0], function(key, value) {

                //                    if (parseFloat(value['invoice_total']) > parseFloat(value['montant_recu']) || (invoice_id_def == value['invoice_id'] && invoice_id_def != 0)) {
                if (true) {
                    if (parseFloat(value['montant_recu']) > 0) {
                        var montant_recu = beautifyFormatWithDevice(value['montant_recu']) + "/";
                        var montant_restant = beautifyFormatWithDevice(value['invoice_total'] - value[
                            'montant_recu']);

                    } else {
                        var montant_recu = "";
                        var montant_restant = value['invoice_total'];
                    }

                    if (invoice_id_def == value['invoice_id']) {
                        var selected_invoice = "selected='selected'";
                    } else {
                        var selected_invoice = "";
                    }

                    replace_factures += "<option " + selected_invoice + " amount='" + montant_restant +
                        "' value='" + value['invoice_id'] + "'>Facture #" + value['invoice_id'] + " (" +
                        montant_recu + beautifyFormatWithDevice(value['invoice_total']) + ")</option>";

                }
            });
            $("#invoice_id").html(replace_factures);
        });
    } else {
        var replace_factures = "<option value='0'>Choisir</option>";
        $("#invoice_id").html(replace_factures);
    }
}
$('.search_banque').click(function() {
     $('#modal-placeholder').load(
     "<?php echo site_url('banque/ajax/modal_banque_lookup'); ?>/" +
     Math.floor(Math.random() * 1000), {

     });
});

function updatePaymentMethod() {
    var meth = $('#payment_method_id').val(); //alert(meth);
    if (meth == 1) {
        $('#div_cheq').show();
        $('#div_vir').hide();
        $('#div_esp').hide();
    }
    if (meth == 3) {
        $('#div_esp').show();
        $('#div_cheq').hide();
        $('#div_vir').hide();
    }
    if ((meth == 2) || (meth == 4) || (meth == 5)) {
        $('#div_cheq').hide();
        $('#div_esp').hide();
        $('#div_vir').show();
    }

}

$(function() {
    $('#client_id').change(function() {
        updateFactures();
    });
    $('#invoice_id').change(function() {
        var amount = $('#invoice_id option:selected').attr("amount");
        if (amount != 'null') {
            $("#montant_cheq").val(amount);
            $("#montant_esp").val(amount);
            $("#montant_c").val(amount);
        }

    });
    $('#payment_method_id').change(function() {
        updatePaymentMethod();

    });
    updateFactures();
    updatePaymentMethod();

});
</script>