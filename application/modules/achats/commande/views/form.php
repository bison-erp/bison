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
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
    rel="stylesheet" type="text/css">

<body onload="f_load()">
    <div id="headerbar-index">
    </div>
    <div id="div_err"></div>
 <div id="content">
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark"><?php echo lang('bons_commande'); ?></span><br />
					<span class="caption-subject text-bold small-caption muted"><?php echo lang('add_bc'); ?></span>
				</div>
			</div>
			<div class="portlet-toolbar">
				<div class="pull-right btn-group">
					<a href="#" class="btn btn-success btn-sm blue bg-success text-success" id="btn_save_commande">
						<?php echo lang('save'); ?>
					</a>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="row">
					<!-- contact - Info -->  
				<div class="col-md-6 ">
					<div class="portlet light formulaire no-padding first">
						<div class="content-heading">
							<div class="portlet-title left-title">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark"><?php echo lang('client'); ?></span>
								</div>
							</div>
						</div>
					<div class="row card-row form-row">
                        <div class="col-lg-12 col-sm-12 col-xl-12 col-langue">
                            <div class="form-group select-search-input has-info col-input-before-langue">
                                <label for="form_control_1"><?php echo lang('client_name'); ?><span class="text-danger">*</span></label>
                                <div class="form-control-focus"></div>
                                <input style="width: 100%;" id="client_name" class="form-control form-control-lg form-control-light" readonly="readonly" value="<?php echo $client->client_name.' '.$client->client_prenom ?> ">
								<button id="search_client" type="button" class="btn btn-success btn-select-client">
									<span class="glyphicon glyphicon-search"></span>
								</button>
                            </div>
                        <?php
                         $tabs =explode(',',$this->mdl_settings->setting('default_language_document'));                          
                       ?>
                                <div class="form-group lang-groupe">
									<label class="lang-flag-label"></label>
									<!--label><!?php echo lang('language'); ?><span class="text-danger"> *</span></label-->                                  
                                    <select class="form-control form-control-lg form-control-light language-input" name="langue" id="langue">
										<option value="<?php echo $this->mdl_settings->setting('default_language'); ?>">  
											<?php echo substr($this->mdl_settings->setting('default_language'), 0, 2); ?>												
										</option>
                                        <?php foreach (array_filter($tabs) as  $key => $value) {?>
										<?php if( $value != $this->mdl_settings->setting('default_language') ){ ?>
                                        <option value="<?php echo $value; ?>">
                                            <?php echo substr($value, 0, 2); ?>
                                        </option>
                                        <?php }?>
                                        <?php }?>
                                    </select>
                                </div>
                        </div>
						</div>
                    <div class="row card-row form-row">
                        <div class="col-lg-12 col-sm-12 col-xl-12">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('client_societe'); ?></label>
                                <div class="form-control-focus"></div>
                                <input class="form-control form-control-lg form-control-light" id="client_societe" readonly="readonly" value="<?php echo $client->client_societe ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row card-row form-row">
                        <div class="col-sm-8">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('client_address'); ?>
                                </label>
                                <div class="form-control-focus"></div>
                                <input class="form-control form-control-lg form-control-light" id="client_address" readonly="readonly" value="<?php echo $client->client_address_1 ?> ">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('client_pays'); ?>
                                </label>
                                <div class="form-control-focus"></div>
                                <input class="form-control form-control-lg form-control-light" id="client_pays" readonly="readonly" value="<?php echo $client->client_country ?>  ">
                            </div>
                        </div>
                    </div>
                    <div class="row card-row form-row">
                        <div class="col-sm-8">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('vat_id'); ?>
                                </label>
                                <div class="form-control-focus"></div>
                                <input class="form-control form-control-lg form-control-light" id="vat_id" readonly="readonly" value="<?php echo $client->client_vat_id ?> ">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('tax_code'); ?>
                                </label>
                                <div class="form-control-focus"></div>
                                <input class="form-control form-control-lg form-control-light" id="tax_code" readonly="readonly" value="<?php echo $client->client_tax_code ?> ">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
			<!-- bon de commande -->
            <div class="col-md-6">
				<div class="portlet light formulaire no-padding">
					<div class="content-heading">
						<div class="portlet-title left-title">
							<div class="caption font-dark-sunglo">
								<span class="caption-subject bold med-caption dark"><?php echo lang('bons_commande'); ?></span>
							</div>
						</div>
					</div>
					<div class="row card-row form-row">
						<div class="col-lg-4 col-sm-4 col-xl-12"> 
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('commande'); ?> #</label>
                                <input disabled="disabled" id="quote_number" class="form-control form-control-lg form-control-light"
                                    value="<?php echo $nextcode; ?>" title="Commande ">
                                <div class="form-control-focus"></div>
                            </div>
                        </div>
						<div class="col-lg-4 col-sm-4 col-xl-12"> 
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('quote_nature'); ?></label><a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_nature'); ?>"></a>
									
                                <input disabled="disabled" id="quote_nature" class="form-control form-control-lg form-control-light" value="">
                                <div class="form-control-focus"></div>
                            </div>
                        </div>
						<div class="col-lg-4 col-sm-4 col-xl-12"> 
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('status'); ?></label>
                                <select name="quote_status_id" id="quote_status_id"
                                    title="<?php echo lang('status'); ?>"
                                    class="form-control form-control-lg form-control-light">
                                    <?php foreach ($quote_statuses as $key => $status) {?>
                                    <option value="<?php echo $key; ?>">
                                        <?php echo $status['label']; ?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>                  
						</div>
					</div>
					<div class="row card-row form-row">
						<div class="col-lg-6 col-sm-6 col-xl-12"> 
                            <div class="form-group has-info">
                                <div class="quote-properties has-feedback">
                                    <label for="form_control_1"><?php echo lang('date'); ?></label>
                                    <div class="input-group">
                                        <input name="quote_date_created" id="quote_date_created"
                                            class="form-control form-control-lg form-control-light datepicker"
                                            value="<?php echo date('d/m/Y'); ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-6 col-sm-6 col-xl-12">
                            <div class="form-group has-info">
                                <div class="quote-properties has-feedback">
                                        <label for="form_control_1"><?php echo lang('expires'); ?></label>
                                    <div class="input-group">
                                        <input name="quote_date_expires" id="quote_date_expires" disabled="disabled"
                                            class="form-control form-control-lg form-control-light datepicker" value=" ">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row card-row form-row">
						<div class="col-lg-6 col-sm-6 col-xl-12"> 
                            <div class="form-group has-info">
                                <div class="quote-properties has-feedback">
                                        <label for="form_control_1"><?php echo lang('accepte_le'); ?></label>
                                    <div class="input-group">
                                        <input name="quote_date_accepte" id="quote_date_accepte" title="Accepté le"
                                            class="form-control form-control-lg form-control-light datepicker" value="" disabled="disabled">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-6 col-sm-6 col-xl-12"> 
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('quote_delai_paiement'); ?></label>
                                <select name="quote_delai_paiement" id="quote_delai_paiement"
                                    class="form-control form-control-lg form-control-light">
                                    <?php foreach ($delaiPaiement as $delaiPaim) {?>
                                    <option value="<?php echo $delaiPaim->delai_paiement_id; ?>">
                                        <?php echo $delaiPaim->delai_paiement_label; ?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>                 
					<div class="row card-row form-row">
						<div class="col-sm-12">
                            <div class="md-checkbox" style="margin-top: 15px;">
                                    <input type="checkbox" value="0" name="signature" id="signature" class="md-check">
                                    <label for="signature">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>                                     
                                        <?php echo lang('bons_commande'); ?> <?php echo lang('signature'); ?>
                                    </label>
									<a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_cachet_signature'); ?>"></a>
                            </div>
                        </div> 
                        <div class="col-sm-12">
                            <div class="md-checkbox" style="margin-top: 15px;">
                                    <input type="checkbox" value="0" name="photo" id="photo" class="md-check">
                                    <label for="photo">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>                                     
                                        <?php echo lang('photo_joint') ?>
                                    </label>
									<a href="javascript:;" href="#" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_photo_joint'); ?>"></a>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
      <!--    BLOC PRODUITS-->
 <div id="fact_prod">
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark"><?php echo lang('products_bloc'); ?></span>
				</div>			
			</div>
			<div class="portlet-toolbar">
				<div class="pull-right btn-group">
					<div class="btn_add_prod" style=" text-align: right">
                        <a class="btn btn-sm btn-default" id="btn_add_row">
                            <i class="fa fa-plus"></i>
                            <?php echo lang('add_new_row'); ?>
                        </a>
                        <a class="btn btn-sm btn-default" id="btn_add_product">
                            <i class="fa fa-database"></i>
                            <?php echo lang('add_product'); ?>
                        </a>
                    </div>
				</div>
			</div>
		</div>
		<div class="portlet-body">
				<div class="portlet light formulaire">
                    <?php $this->layout->load_view('quotes/partial_item_table');?>
                    <div style="clear:both"></div>
                    <br>
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('notes'); ?></label>
                        <textarea height="40" name="notes" id="notes" style="width: 100%;padding: 5px 10px;height:80px;" class="form-control"></textarea>
                        <div class="form-control-focus"></div>
                    </div>
                    <div style="clear:both"></div>
                </div>
          </div>
			<div class="portlet-footer">
				<div class="portlet-tool-btn">
					<div class="pull-right btn-group">
						<a href="#" class="btn btn-success btn-sm blue bg-success text-success" id="btn_save_commande">
							<i class="fa fa-check"></i>
							<?php echo lang('save'); ?>
						</a>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
</body>

<input type="hidden" id="etat_montant_acccont" value="0">
<input type="hidden" id="client_id" value=" <?php echo $client->client_id ?>">
<input type="hidden" id="symbole_devise" value="">
<input type="hidden" id="tax_rate_decimal_places" value="">
<input type="hidden" id="thousands_separator" value="">

<input type="hidden" id="user_connecte" value="<?php echo $this->session->userdata('user_id'); ?>">
<input type="hidden" id="langmsg" value="<?php echo lang('msg_lang') ?>">
<input type="hidden" id="listdocument" value="">
<input type="hidden" id="current_id_table_invoice" value="0">
<input type="hidden" id="assigite_tva" value="<?php echo $this->mdl_settings->gettypetaxeinvoice() ?>">
<?php
$this->model('settings/mdl_settings');
//return var_dump(format_devise($this->mdl_settings->setting('default_item_timbre'), 1));
$timbre_f_client = ($client->timbre_fiscale == 1) ? $this->mdl_settings->setting('default_item_timbre') : "0.000";

?>
<script>
$('#search_client').click(function() {
    if($('#langue').val()){
    $('#modal-placeholder').load("<?php echo site_url('clients/ajax/modal_client_lookup'); ?>/" + Math.floor(
        Math.random() * 1000), {
        type_doc: "quote",
    });
    }else{
        alert($('#langmsg').val())
    }
});

function f_load() {
    pat = location.pathname;
    path = pat.split("/");
    if ((path[4])) {

        $('#quote_nature').val('');
        $('#quote_delai_paiement').val('');
        $('#quote_password').val('');
        $('#quote_status_id').val('1');
        $('#payment_method').val('');

        $('.name_prod').val('');
        $('.desc_prod').val('');
        $('.item_quantity').val('1');
        $('.item_price').val('');
        $('.item_tax_rate_id').val('1');
        $('.subtotal').val('');
        $('.item_tax_total').val('');
        $('.item_total').val('');

        $('#fact_prod').show();
        $('#client_titre').attr('disabled', false);
        $('#client_name').attr('disabled', false);
        $('#client_societe').attr('disabled', false);
        $('#client_address').attr('disabled', false);
        $('#client_pays').attr('disabled', false);
        $('#vat_id').attr('disabled', false);
        $('#tax_code').attr('disabled', false);

        $('#quote_nature').attr('disabled', false);
        $('#quote_date_accepte').attr('disabled', false);
        $('#quote_date_created').attr('disabled', false);
        $('#quote_date_expires').attr('disabled', false);
        $('#quote_delai_paiement').attr('disabled', false);
        $('#quote_password').attr('disabled', false);
        $('#quote_status_id').attr('disabled', false);
        $('#payment_method').attr('disabled', false);
        $('#btn_add_row').attr('disabled', false);
        $('#btn_add_product').attr('disabled', false);

        $('.name_prod').attr('disabled', false);
        $('.desc_prod').attr('disabled', false);
        $('.item_quantity').attr('disabled', false);
        $('.item_price').attr('disabled', false);
        $('.item_tax_rate_id').attr('disabled', false);
        $('.subtotal').attr('disabled', false);
        $('.item_tax_total').attr('disabled', false);
        $('.item_total').attr('disabled', false);

        var devise_symbole = $('#symbole_devise').val();
        var tax_rate_decimal_places = $('#tax_rate_decimal_places').val();
        var currency_symbol_placement = $('#currency_symbol_placement').val();
        var thousands_separator = $('#thousands_separator').val();

        if (currency_symbol_placement == "before") {
            $('#fact_prod .devise_view').each(function() {
                if ($(this).hasClass("view_before")) {
                    $(this).show();
                } else if ($(this).hasClass("view_after")) {
                    $(this).hide();
                }
            });
        } else {
            $('#fact_prod .devise_view').each(function() {
                if ($(this).hasClass("view_after")) {
                    $(this).show();
                } else if ($(this).hasClass("view_before")) {
                    $(this).hide();
                }
            });
        }
        $('#montant_remise_invoice').val(beautifyFormat(0, "float"));
        $('#montant_acompte_invoice').val(beautifyFormat(0, "float"));
        $('#montant_sous_tot_invoice').text(beautifyFormat(0, "float"));
        $('#tot_tva_invoice').text(beautifyFormat(0, "float"));
        $('#total_invoice').text(beautifyFormat(0, "float"));
        $('#total_a_payer_invoice').text(beautifyFormat(0, "float"));
        $('#timbre_fiscale_span').text(beautifyFormat($('#timbre_fiscale_span').text(), "float"));
    } else {

        $('#devise').val('');
        $('#client_titre').val('');
        $('#client_name').val('');
        $('#client_societe').val('');
        $('#client_address').val('');
        $('#client_pays').val('');
        $('#vat_id').val('');
        $('#tax_code').val('');
        $('#quote_nature').val('');
        // $('#quote_date_created').val('');
        //$('#quote_date_expires').val('');
        $('#quote_delai_paiement').val('');
        $('#quote_password').val('');
        $('#quote_status_id').val('1');
        $('#payment_method').val('');

        $('.name_prod').val('');
        $('.desc_prod').val('');
        $('.item_quantity').val('1');
        $('.item_price').val('');
        $('.item_tax_rate_id').val('1');
        $('.subtotal').val('');
        $('.item_tax_total').val('');
        $('.item_total').val('');

        $('#fact_prod').hide();
        $('#client_titre').attr('disabled', true);
        $('#client_name').attr('disabled', true);
        $('#client_societe').attr('disabled', true);
        $('#client_address').attr('disabled', true);
        $('#client_pays').attr('disabled', true);
        $('#vat_id').attr('disabled', true);
        $('#tax_code').attr('disabled', true);

        $('#quote_nature').attr('disabled', true);
        $('#quote_date_accepte').attr('disabled', true);
        $('#quote_date_created').attr('disabled', true);
        $('#quote_date_expires').attr('disabled', true);
        $('#quote_delai_paiement').attr('disabled', true);
        $('#quote_password').attr('disabled', true);
        $('#quote_status_id').attr('disabled', true);
        $('#payment_method').attr('disabled', true);
        $('#btn_add_row').attr('disabled', true);
        $('#btn_add_product').attr('disabled', true);

        $('.name_prod').attr('disabled', true);
        $('.desc_prod').attr('disabled', true);
        $('.item_quantity').attr('disabled', true);
        $('.item_price').attr('disabled', true);
        $('.item_tax_rate_id').attr('disabled', true);
        $('.subtotal').attr('disabled', true);
        $('.item_tax_total').attr('disabled', true);
        $('.item_total').attr('disabled', true);
    }
}

function changeCalculDownTable() {
    var subtotal = 0;
    var item_total = 0;
    var item_tax_rate = 0;
    $('#item_table tr.item').each(function() {
        subtotal += Number(accepted_float_input($(this).find(".subtotal").val()));
        item_total += Number(accepted_float_input($(this).find(".item_total").val()));
        item_tax_rate += Number(accepted_float_input($(this).find(".subtotal").val())) * Number(
            accepted_float_input($(this).find(".item_tax_rate_id option:selected").text()) / 100);

    });
    var montant_remise = accepted_float_input($("#montant_remise_invoice").val());
    var persent_remise = accepted_float_input($("#pourcent_remise_invoice").val());
    var timbre_fiscale = accepted_float_input($("#timbre_fiscale_span").text());
    subtotal = subtotal * (1 - (Number(persent_remise) / 100));
    item_tax_rate = item_tax_rate * (1 - (Number(persent_remise) / 100));
    item_total = subtotal + item_tax_rate + Number(timbre_fiscale);

    $("#montant_sous_tot_invoice").text(numberFormatFloat(subtotal));
    $("#tot_tva_invoice").text(numberFormatFloat(item_tax_rate));
    $("#total_invoice").text(numberFormatFloat(item_total));
}

function changeTotalPaye() {
    var total = accepted_float_input($("#total_invoice").text());
    var montant_acompte = accepted_float_input($("#montant_acompte_invoice").val());
    var total_paye = Number(total) - Number(montant_acompte);
    if (total_paye < 0)
        $("#total_a_payer_invoice").parent().addClass("error_value");
    else
        $("#total_a_payer_invoice").parent().removeClass("error_value");
    $("#total_a_payer_invoice").text(beautifyFormat(total_paye, "float"));
}

function addRow(items) {
    var languesel = $('#langue').val();
    if (!items) {
        var item_code_value = "";
        var item_description_value = "";
        var item_quantity_value = "1";
        var item_price_value = beautifyFormat(0, "float");
        var subtotal_value = beautifyFormat(0, "float");
        var item_tax_rate_id_value = 0;
        var item_total_value = beautifyFormat(0, "float");
    } else {
        var item_code_value = items.product_sku;
        var item_description_value ="";
        
        var item_description_value ="";
        
        if(languesel=="Arabic"){
              item_description_value += items.product_description_ar;
        }
        if(languesel=="English"){
              item_description_value += items.product_description_eng;
        }
        if(languesel=="French" ){
              item_description_value += items.product_description;
        }
        var item_quantity_value = items.product_quantite ? parseInt(items.product_quantite) : 1;
        var item_price_value = beautifyFormat(items.product_price_dev, "float");
        var subtotal_value = items.product_subtotal ? beautifyFormat(items.product_subtotal, "float") : beautifyFormat(
            items.product_price_dev, "float");
        var item_tax_rate_id_value = items.tax_rate_id_dev;
        var item_total_value = beautifyFormat(items.montantTVATotal, "float");
    }
    // import tax Rate
    var row_add_tax = "";
    if ($('#assigite_tva').val() == 1) {
        $.post("<?php echo site_url('tax_rates/ajax/getTaxRate'); ?>", function(data) {
            var tax_rates_all = JSON.parse(data);
            $.each(tax_rates_all, function(k, v) {
                row_add_tax += '<option value="' + v.tax_rate_id + '"';
                if (item_tax_rate_id_value == v.tax_rate_id) {
                    row_add_tax += ' selected = "selected" ';
                }
                row_add_tax += '>' + v.tax_rate_percent + '</option>';
            });
            var current_id = $("#current_id_table_invoice").val();
            var row_add = '<tr class=" item ui-sortable-handle tr_prod_' + current_id + '">';
            row_add += '<td align="center" style="width: 25px;"><i class="fa fa-arrows cursor-move"></i></td>';
            row_add += '<td style="width: 200px;"><input type="text" name="item_code" id="item_code_' +
                current_id +
                '" class="name_prod form-control" class="form-control" value="' + item_code_value +
                '" autocomplete="off" data-id="' + current_id + '"></td>';
            row_add += '<td><textarea id="item_description_' + current_id +
                '" name="item_description" class="form-control desc_prod">' + item_description_value +
                '</textarea></td>';
            row_add += '<td><input type="number" class="input-sm form-control item_quantity" data-id="' +
                current_id + '" name="item_quantity" id="item_quantity_' + current_id + '" value="' +
                item_quantity_value + '"></td>';
            row_add +=
                '<td><input type="text" class="input-sm form-control item_price" name="item_price" value="' +
                item_price_value + '" data-id="' + current_id + '" id="item_price_' + current_id + '"></td>';
            row_add +=
                '<td style="width: 120px;"> <input name="subtotal" class="subtotal input-sm form-control" data-id="' +
                current_id + '" id="subtotal_' + current_id + '" value="' + subtotal_value + '"></td>';
            row_add +=
                '<td style="width: 110px;"><select  name="item_tax_rate_id" class="input-sm form-control item_tax_rate_id"  data-id="' +
                current_id + '" id="item_tax_rate_' + current_id + '"> ' + row_add_tax + ' </select></td>';
            row_add +=
                '<td style="width: 120px;"><input name="item_total" class="item_total input-sm form-control" data-id="' +
                current_id + '" id="item_total_' + current_id + '" value="' + item_total_value + '"></td>';
            row_add +=
                '<td style="width:40px;" class="td-icon" align="center"> <a class="delete_row" title="Supprimer" data-id="' +
                current_id + '" id="delete_row_' + current_id +
                '"><i class="fa fa-trash-o text-danger"></i></a>';
            row_add += '<input type="hidden" name="family_id" value="0">';
            row_add += '<input type="hidden" name="item_name" value="' + item_code_value + '">';
            row_add += '<input type="hidden" name="etat_champ" value="1">';
            row_add += "</td>";
            row_add += "/<tr>";

            $("#item_table tbody").append(row_add);
            $("#current_id_table_invoice").val(parseInt(current_id) + 1);
            $('#item_table').find('tr.item').find('#delete_row_' + current_id).click(function() {
                $(".tr_prod_" + current_id).remove();
                changeCalculDownTable();
                changedPercentRemise();
                changedPercentAcompte();
                changeTotalPaye();
            });
            $('#item_table').find('tr.item').find('#item_quantity_' + current_id).keyup(function() {
                changedItemTable($(this), "quantite", "float2");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "float2"));
                });
            });
            $('#item_table').find('tr.item').find('#item_quantity_' + current_id).change(function() {
                changedItemTable($(this), "quantite", "float2");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "float2"));
                });
            });
            $('#item_table').find('tr.item').find('#item_price_' + current_id).keyup(function() {
                changedItemTable($(this), "prix_unitaire", "float");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "float"));

                });
            });
            $('#item_table').find('tr.item').find('#subtotal_' + current_id).keyup(function() {
                changedItemTable($(this), "subtotal", "float");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "float"));
                });
            });
            $('#item_table').find('tr.item').find('#item_tax_rate_' + current_id).change(function() {
                changedItemTable($(this), "tax_rate", "float");
            });
            $('#item_table').find('tr.item').find('#item_total_' + current_id).keyup(function() {
                changedItemTable($(this), "total", "float");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "float"));
                });
            });

            $(".name_prod").focus();
            $('.name_prod').typeahead();

            changeCalculDownTable();
            changedPercentRemise();
            changedPercentAcompte();
            changeTotalPaye();
        });
    } else {
        row_add_tax += '<option value="3"  selected = "selected" >0</option>';
        var current_id = $("#current_id_table_invoice").val();
        var row_add = '<tr class=" item ui-sortable-handle tr_prod_' + current_id + '">';
        row_add += '<td align="center" style="width: 25px;"><i class="fa fa-arrows cursor-move"></i></td>';
        row_add += '<td style="width: 200px;"><input type="text" name="item_code" id="item_code_' +
            current_id +
            '" class="name_prod form-control" class="form-control" value="' + item_code_value +
            '" autocomplete="off" data-id="' + current_id + '"></td>';
        row_add += '<td><textarea id="item_description_' + current_id +
            '" name="item_description" class="form-control desc_prod">' + item_description_value +
            '</textarea></td>';
        row_add += '<td><input type="number" class="input-sm form-control item_quantity" data-id="' +
            current_id + '" name="item_quantity" id="item_quantity_' + current_id + '" value="' +
            item_quantity_value + '"></td>';
        row_add +=
            '<td><input type="text" class="input-sm form-control item_price" name="item_price" value="' +
            item_price_value + '" data-id="' + current_id + '" id="item_price_' + current_id + '"></td>';
        row_add +=
            '<td  style="display:none;width: 120px;"> <input name="subtotal" class="subtotal input-sm form-control" data-id="' +
            current_id + '" id="subtotal_' + current_id + '" value="' + subtotal_value + '"></td>';
        row_add +=
            '<td style="display:none;width: 110px;"><select  name="item_tax_rate_id" class="input-sm form-control item_tax_rate_id"  data-id="' +
            current_id + '" id="item_tax_rate_' + current_id + '"> ' + row_add_tax + ' </select></td>';
        row_add +=
            '<td style="width: 120px;"><input name="item_total" class="item_total input-sm form-control" data-id="' +
            current_id + '" id="item_total_' + current_id + '" value="' + subtotal_value + '"></td>';
        row_add +=
            '<td style="width:40px;" class="td-icon" align="center"> <a class="delete_row" title="Supprimer" data-id="' +
            current_id + '" id="delete_row_' + current_id +
            '"><i class="fa fa-trash-o text-danger"></i></a>';
        row_add += '<input type="hidden" name="family_id" value="0">';
        row_add += '<input type="hidden" name="item_name" value="' + item_code_value + '">';
        row_add += '<input type="hidden" name="etat_champ" value="1">';
        row_add += "</td>";
        row_add += "/<tr>";

        $("#item_table tbody").append(row_add);
        $("#current_id_table_invoice").val(parseInt(current_id) + 1);
        $('#item_table').find('tr.item').find('#delete_row_' + current_id).click(function() {
            $(".tr_prod_" + current_id).remove();
            changeCalculDownTable();
            changedPercentRemise();
            changedPercentAcompte();
            changeTotalPaye();
        });
        $('#item_table').find('tr.item').find('#item_quantity_' + current_id).keyup(function() {
            changedItemTable($(this), "quantite", "float2");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "float2"));
            });
        });
        $('#item_table').find('tr.item').find('#item_quantity_' + current_id).change(function() {
            changedItemTable($(this), "quantite", "float2");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "float2"));
            });
        });
        $('#item_table').find('tr.item').find('#item_price_' + current_id).keyup(function() {
            changedItemTable($(this), "prix_unitaire", "float");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "float"));

            });
        });
        $('#item_table').find('tr.item').find('#subtotal_' + current_id).keyup(function() {
            changedItemTable($(this), "subtotal", "float");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "float"));
            });
        });
        $('#item_table').find('tr.item').find('#item_tax_rate_' + current_id).change(function() {
            changedItemTable($(this), "tax_rate", "float");
        });
        $('#item_table').find('tr.item').find('#item_total_' + current_id).keyup(function() {
            changedItemTable($(this), "total", "float");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "float"));
            });
        });

        $(".name_prod").focus();
        $('.name_prod').typeahead();

        changeCalculDownTable();
        changedPercentRemise();
        changedPercentAcompte();
        changeTotalPaye();
    }

}

function changedItemTable(curr, item, type) {
    var dataid = curr.data('id');
    var id = curr.attr('id');
    var valeur = curr.val();

    if (type == "int") {
        if (accepted_integer_input(valeur) != valeur) {
            $("#" + id).val(accepted_integer_input(valeur));
            valeur = accepted_integer_input(valeur);
        }
    } else if (type == "float") {
        if (accepted_float_input(valeur) != valeur) {
            $("#" + id).val(accepted_float_input(valeur));
            valeur = accepted_float_input(valeur);
        }
    }

    switch (item) {
        case "quantite": {
            var item_price = accepted_float_input($("#item_price_" + dataid).val());
            var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
            var subtotal = item_price * valeur;
            var itemtotal = subtotal * (1 + (item_tax_rate / 100));
            $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
            $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
        }
        break;
    case "prix_unitaire": {
        var quantite = accepted_float_input($("#item_quantity_" + dataid).val());
        var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
        var subtotal = quantite * valeur;
        var itemtotal = subtotal * (1 + (item_tax_rate / 100));
        $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
        $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
    }
    break;
    case "subtotal": {
        var quantite = accepted_float_input($("#item_quantity_" + dataid).val());
        if (Number(quantite) == 0) {
            $("#item_quantity_" + dataid).val(1);
            quantite = 1;
        }
        var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
        var subtotal = valeur;
        var item_price = subtotal / quantite;
        var itemtotal = subtotal * (1 + (item_tax_rate / 100));
        $("#item_price_" + dataid).val(numberFormatFloat(item_price));
        $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
    }
    break;
    case "tax_rate": {
        var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
        var subtotal = accepted_float_input($("#subtotal_" + dataid).val());
        var itemtotal = subtotal * (1 + (item_tax_rate / 100));
        $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
    }
    break;
    case "total": {
        var quantite = accepted_float_input($("#item_quantity_" + dataid).val());
        if (Number(quantite) == 0) {
            $("#item_quantity_" + dataid).val(1);
            quantite = 1;
        }
        var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
        var item_total = accepted_float_input($("#item_total_" + dataid).val());
        var subtotal = item_total / (1 + (item_tax_rate / 100));
        var item_price = subtotal / quantite;
        $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
        $("#item_price_" + dataid).val(numberFormatFloat(item_price));
    }
    break;
    default: {
        //    alert("autre");
    }
    }
    changeCalculDownTable();
    changedPercentRemise();
    changedPercentAcompte();
    changeTotalPaye();
}

function changedPercentRemise() {
    var total = 0;
    $('#item_table tr.item').each(function() {
        total += Number(accepted_float_input($(this).find(".item_total").val()));
    });
    var persent_remise = accepted_float_input($("#pourcent_remise_invoice").val());
    if (Number(persent_remise) > 100)
        persent_remise = 100;
    $("#pourcent_remise_invoice").val(persent_remise);
    var montant_remise = total * Number(persent_remise) / 100;
    $("#montant_remise_invoice").val(beautifyFormat(montant_remise, "float"));
}

function changedMontantRemise() {
    var total = 0;
    $('#item_table tr.item').each(function() {
        total += Number(accepted_float_input($(this).find(".item_total").val()));
    });
    var montant_remise = accepted_float_input($("#montant_remise_invoice").val());
    if (Number(montant_remise) > total) {
        montant_remise = total;
    }
    $("#montant_remise_invoice").val(beautifyFormat(montant_remise));
    var persent_remise = (Number(montant_remise) * 100) / total;
    $("#pourcent_remise_invoice").val(beautifyFormat(persent_remise, "float2"));
}

function changedPercentAcompte() {
    var total = $("#total_invoice").text();
    var persent_acompte = accepted_float_input($("#pourcent_acompte_invoice").val());
    $("#pourcent_acompte_invoice").val(persent_acompte);
    var montant_acompte = Number(accepted_float_input(total)) * Number(persent_acompte) / 100;
    if ($('#etat_montant_acccont').val() == 0) {
        $("#montant_acompte_invoice").val(beautifyFormat(montant_acompte, "float"));
    }
}

function changedMontantAcompte() {
    var total = $("#total_invoice").text();
    var montant_acompte = accepted_float_input($("#montant_acompte_invoice").val());
    $("#montant_acompte_invoice").val(montant_acompte);
    var persent_acompte = (Number(montant_acompte) * 100) / Number(accepted_float_input(total));
    $("#pourcent_acompte_invoice").val(beautifyFormat(persent_acompte, "float2"));
    $('#etat_montant_acccont').val(1);
}
$("#btn_add_row").click(function() {
    addRow();
});
$('#btn_add_product').click(function() {
    if($('#langue').val()){
    $('#modal-placeholder').load("<?php echo site_url('products/ajax/modal_product_lookup'); ?>/" +
        Math.floor(Math.random() * 1000), {
            devise: $('#devise').val(),
            type_doc: "quote",
            langue: $('#langue').val(),
        });
    }else{
        alert($('#langmsg').val())
    }
});
$('#pourcent_remise_invoice').keyup(function() {
    changedPercentRemise();
    changeCalculDownTable();
    changeTotalPaye();
    $(this).focusout(function() {
        $(this).val(beautifyFormat($(this).val(), "float2"));
        changedPercentRemise();
        changeCalculDownTable();
        changeTotalPaye();
    });
});
$('#montant_remise_invoice').keyup(function() {
    changedMontantRemise();
    changeCalculDownTable();
    changeTotalPaye();
    $(this).focusout(function() {
        $(this).val(beautifyFormat($(this).val(), "float"));
        changedMontantRemise();
        changeCalculDownTable();
        changeTotalPaye();
    });
});
$('#pourcent_acompte_invoice').keyup(function() {
    changedPercentAcompte();
    changeTotalPaye();
    $(this).focusout(function() {
        $(this).val(beautifyFormat($(this).val(), "float2"));
        changeTotalPaye();
    });
});
$('#montant_acompte_invoice').keyup(function() {
    changedMontantAcompte();
    changeTotalPaye();
    $(this).focusout(function() {
        $(this).val(beautifyFormat($(this).val(), "float"));
        changeTotalPaye();
    });
});
$('#btn_save_commande, #btn_save_quote2').click(function() {
    var items = [];
    var item_order = 1;
    $('table tr.item').each(function() {
        var row = {};
        $(this).find('input,select,textarea').each(function() {
            if ($(this).is(':checkbox')) {
                row[$(this).attr('name')] = $(this).is(':checked');
            } else {
                var valeur = $(this).val();
                if ($(this).hasClass("item_price") || $(this).hasClass(
                        "subtotal") || $(this).hasClass("item_total")) {
                    valeur = Number(accepted_float_input(valeur));
                }
                row[$(this).attr('name')] = valeur;
            }
        });
        row['item_order'] = item_order;

        item_order++;
        items.push(row);
    });
    var items_count = items.length;
    var total_quote_final = $('#total_invoice').html();
    total_quote_final = Number(total_quote_final.replace(/[^0-9\.]+/g, ""));

    var total_a_payer_quote = $('#total_a_payer_invoice').html();
    total_a_payer_quote = Number(total_a_payer_quote.replace(/[^0-9\.]+/g, ""));

    var montant_sous_tot_quote = $('#montant_sous_tot_invoice').html();
    montant_sous_tot_quote = Number(montant_sous_tot_quote.replace(/[^0-9\.]+/g, ""));

    var tot_tva_quote = $('#tot_tva_invoice').html();
    tot_tva_quote = Number(tot_tva_quote.replace(/[^0-9\.]+/g, ""));
    prop = '';
    montant_cheq = '';
    banq = '';
    ref = '';
    if ($('#payment_method').val() == 1) {
        prop = $('#proprietaire_c').val();
        var montant_cheq = $('#montant_cheq').val();
        montant_cheq = Number(montant_cheq.replace(/[^0-9\.]+/g, ""));
        banq = $('#banque_c').val();
        ref = $('#num_cheq').val();
    }
    if ($('#payment_method').val() == 3) {

        var montant_cheq = $('#montant_esp').val();
        montant_cheq = Number(montant_cheq.replace(/[^0-9\.]+/g, ""));
        prop = '';
        banq = '';
        ref = '';
    }
    if (($('#payment_method').val() == 2) || ($('#payment_method').val() == 4)) {
        prop = $('#proprietaire_v').val();
        banq = $('#banque_v').val();
        var montant_cheq = $('#montant_c').val();
        montant_cheq = Number(montant_cheq.replace(/[^0-9\.]+/g, ""));
        ref = $('#reference').val();
    }
    var montant_remise_quote = $('#montant_remise_invoice').val();
    montant_remise_quote = Number(montant_remise_quote.replace(/[^0-9\.]+/g, ""));

    var montant_acompte_quote = $('#montant_acompte_invoice').val();
    montant_acompte_quote = Number(montant_acompte_quote.replace(/[^0-9\.]+/g, ""));

    var montant_sous_tot_quote = $('#montant_sous_tot_invoice').html();
    montant_sous_tot_quote = Number(montant_sous_tot_quote.replace(/[^0-9\.]+/g, ""));

    var tot_tva_quote = $('#tot_tva_invoice').html();
    tot_tva_quote = Number(tot_tva_quote.replace(/[^0-9\.]+/g, ""));

    var timbre_fiscale_span = $('#timbre_fiscale_span').html();
    timbre_fiscale_span = Number(timbre_fiscale_span.replace(/[^0-9\.]+/g, ""));

    var total_quote = $('#total_invoice').html();
    total_quote = Number(total_quote.replace(/[^0-9\.]+/g, ""));

    var total_a_payer_quote = $('#total_a_payer_invoice').html();
    total_a_payer_quote = Number(total_a_payer_quote.replace(/[^0-9\.]+/g, ""));

    /*  $("#documenttable  tr td").each(function(index) {
          console.log($(this).find(index).eq(0).html());
      });*/

    $.post("<?php echo site_url('commande/ajax/create'); ?>", {
            client_name: $('#client_name').val(),
            client_id: $('#client_id').val(),
            quote_number: $('#quote_number').val(),
            quote_date_created: $('#quote_date_created').val(),
            quote_date_expires: $('#quote_date_expires').val(),
            quote_status_id: $('#quote_status_id').val(),
            quote_password: $('#quote_password').val(),
            quote_date_accepte: $('#quote_date_accepte').val(),
            quote_nature: $('#quote_nature').val(),
            quote_delai_paiement: $('#quote_delai_paiement').val(),
            notes: $('#notes').val(),
            montant_cheq: montant_cheq,
            date_cheq: $('#date_cheq').val(),
            proprietaire: prop,
            banque: banq,
            reference: ref,
            pourcent_remise_quote: $('#pourcent_remise_invoice').val(),
            montant_remise_quote: montant_remise_quote,
            pourcent_acompte_quote: $('#pourcent_acompte_invoice').val(),
            montant_acompte_quote: montant_acompte_quote,
            montant_sous_tot_quote: montant_sous_tot_quote,
            tot_tva_quote: tot_tva_quote,
            timbre_fiscale_span: timbre_fiscale_span,
            total_quote: total_quote,
            total_a_payer_quote: total_a_payer_quote,
            payment_method: $('#payment_method').val(),
            custom: $('input[name^=custom]').serializeArray(),
            user_id: $('user_connecte').val(),
            items: JSON.stringify(items),
            items_count: items_count,
            quote_item_subtotal_final: montant_sous_tot_quote,
            quote_item_tax_total_final: tot_tva_quote,
            total_quote_final: total_quote_final,
            date_relance: $('#date_relance').val(),
            document: $('#drap').val(),
            listdocu: $('#listdocument').val(),
            joindredevis: $('#Joint').val(),
            signature: $('#signature').val(),
            langue:  $('#langue').val(),
            photo: $('#photo').val(),
        },
        function(data) {

            var response = JSON.parse(data);

            if (response.success == '1') {
                window.location = "<?php echo site_url('commande/index'); ?>";
            } else if (response.success == '0') {
                $("#div_err").empty();
                var msg_err = response.validation_errors;
                var ms_err = msg_err.split("<\/p>\n");
                for (i = 0; i < ms_err.length; i++) {
                    a = ms_err[i].replace('<p>', '');
                    if (a != '') {
                        $("#div_err").append(
                            "<div class='alert alert-danger msg_er' style='margin-left: 15px;margin-right: 15px;'>" +
                            a + "<button class='close' data-close='alert'></button></div>");
                    }
                }
                $('.control-group').removeClass('error');
                for (var key in response.validation_errors) {
                    $('#' + key).parent().parent().addClass('error');
                }
            }
        });
});
$('#signature').change(function() {
        if ($(this).prop("checked")) {
            $('#signature').val('1');
        } else {
            $('#signature').val('0');
        }
});
$('#photo').change(function() {
        if ($(this).prop("checked")) {
            $('#photo').val('1');

        } else {
            $('#photo').val('0');
        }

    });
</script>