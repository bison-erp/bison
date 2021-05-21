<script type="text/javascript">
function update_modele() {
    var email_template_id = $('#email_template').val();
    url = window.location.pathname;

    url_s = url.split("/");
    a = url_s.length;
    invoice = url_s[a - 1];
    if (email_template_id == '')
        return;
    $.post("<?php echo site_url('email_templates/ajax/get_content/'); ?>", {
        email_template_id: email_template_id,
    }, function(data) {
        var json_response = eval('(' + data + ')');

        // Recupérer les information devis

        $.post("<?php echo site_url('invoices/ajax/getInvoiceInfo/'); ?>", {
            invoice_id: $('#invoice_idd').val()
        }, function(data) {
            //                    document.write(data);
            var json_invoice = eval('(' + data + ')');

            // INFORMATIONS DEVIS
            var invoice_date_created = dateSlashes(json_invoice[0]['invoice_date_created']);
            var invoice_date_expires = dateSlashes(json_invoice[0]['invoice_date_due']);
            var invoice_number = json_invoice[0]['invoice_number'];
            var invoice_nature = json_invoice[0]['nature'];
            var invoice_delai_paiement = json_invoice[0]['invoice_delai_paiement'];
            // INFORMATIONS CLIENT
            var civilite = [];
            civilite[0] = "M.";
            civilite[1] = "Mme.";
            civilite[2] = "Melle.";
            var client_titre = json_invoice[0]['client_titre'];
            var client_name = json_invoice[0]['client_name'];
            var client_prenom = json_invoice[0]['client_prenom'];
            var client_fullname = civilite[client_titre] + " " + client_name + " " + client_prenom;
            var client_societe = json_invoice[0]['client_societe'];
            var client_address_1 = json_invoice[0]['client_address_1'];
            var client_address_2 = json_invoice[0]['client_address_2'];
            var client_city = json_invoice[0]['client_state'];
            var client_country = json_invoice[0]['client_country'];
            var client_phone = json_invoice[0]['client_phone'];
            var client_fax = json_invoice[0]['client_fax'];
            var client_mobile = json_invoice[0]['client_mobile'];
            var client_email = json_invoice[0]['client_email'];
            var client_web = json_invoice[0]['client_web'];
            var client_vat_id = json_invoice[0]['client_vat_id'];
            var client_tax_code = json_invoice[0]['client_tax_code'];
            var client_active = json_invoice[0]['client_active'];

            // INFORMATIONS DEVISE
            var devise_label = json_invoice[0]['devise_label'];
            var devise_symbole = json_invoice[0]['devise_symbole'];
            var symbole_placement = json_invoice[0]['symbole_placement'];
            var number_decimal = json_invoice[0]['number_decimal'];
            var thousands_separator = json_invoice[0]['thousands_separator'];

            $('#symbole_devise').val(devise_symbole);
            $('#tax_rate_decimal_places').val(number_decimal);
            $('#currency_symbol_placement').val(symbole_placement);
            $('#thousands_separator').val(thousands_separator);
            // INFORMATIONS CALCUL MONTANTS
            if (symbole_placement == "before") {
                symb_before = devise_symbole + " ";
                symb_after = "";
            } else {
                symb_before = "";
                symb_after = " " + devise_symbole;
            }
            var invoice_item_subtotal = symb_before + beautifyFormat(json_invoice[0][
                'invoice_item_subtotal'
            ], "float") + symb_after;
            var invoice_total_final = symb_before + beautifyFormat(json_invoice[0]['invoice_total'],
                "float") + symb_after;
            var invoice_item_subtotal_final = symb_before + beautifyFormat(json_invoice[0][
                'invoice_item_subtotal_final'
            ], "float") + symb_after;
            var invoice_total_a_payer = symb_before + beautifyFormat(json_invoice[0]['invoice_balance'],
                "float") + symb_after;

            var invoice_items = json_invoice[0][
                'invoice_items'
            ]; // item_code,item_name,item_description,item_quantity,item_price
            var invoice_items_table = "<table width='100%' border='1' cellpadding='0' cellspacing='0'>";
            var invoice_items_codes = "";
            invoice_items_table +=
                "<tr><th>Code</th> <th>Description</th> <th>Quantité</th> <th>Prix unitaire HT</th></tr>";
            $.each(invoice_items, function(key, value) {
                invoice_items_table += "<tr>";
                invoice_items_table += "<td width='150'>" + value['item_code'] + "</td>";
                invoice_items_table += "<td width='250'>" + value['item_description'] + "</td>";
                invoice_items_table += "<td width='100' align='center'>" + parseInt(value[
                    'item_quantity']) + "</td>";
                invoice_items_table += "<td width='150' align='center'>dd" + symb_before +
                    beautifyFormat(value['item_price'], "float") + symb_after + "</td>";

                invoice_items_table += "</tr>";
                if (key != 0)
                    invoice_items_codes += ",";
                invoice_items_codes += " " + value['item_code'];
            });

            invoice_items_table += "<table>";

            data_js = json_response["email_template_body"];
            data_js2 = json_response["email_template_subject"];
            data_js = strReplaceAll(data_js, "{date_created}", invoice_date_created);
            data_js = strReplaceAll(data_js, "{date_expires}", invoice_date_expires);
            data_js = strReplaceAll(data_js, "{number}", invoice_number);
            data_js = strReplaceAll(data_js, "{nature}", invoice_nature);
            data_js = strReplaceAll(data_js, "{signature}", signature);
            data_js = strReplaceAll(data_js, "{client_fullname}", client_fullname);
            data_js = strReplaceAll(data_js, "{client_societe}", client_societe);
            data_js = strReplaceAll(data_js, "{client_address_1}", client_address_1);
            data_js = strReplaceAll(data_js, "{client_address_2}", client_address_2);
            data_js = strReplaceAll(data_js, "{client_city}", client_city);
            data_js = strReplaceAll(data_js, "{client_country}", client_country);
            data_js = strReplaceAll(data_js, "{client_phone}", client_phone);
            data_js = strReplaceAll(data_js, "{client_fax}", client_fax);
            data_js = strReplaceAll(data_js, "{client_mobile}", client_mobile);
            data_js = strReplaceAll(data_js, "{client_email}", client_email);
            data_js = strReplaceAll(data_js, "{client_web}", client_web);
            data_js = strReplaceAll(data_js, "{items_table}", invoice_items_table);
            data_js = strReplaceAll(data_js, "{items_codes}", invoice_items_codes);
            data_js = strReplaceAll(data_js, "{item_subtotal}", invoice_item_subtotal);
            data_js = strReplaceAll(data_js, "{items_codes}", invoice_items_codes);
            data_js = strReplaceAll(data_js, "{total_a_payer}", invoice_total_a_payer);
            data_js = strReplaceAll(data_js, "{total_final}", invoice_total_final);
            data_js = strReplaceAll(data_js, "{matricule_fiscale}", client_vat_id);
            data_js = strReplaceAll(data_js, "{registre_commerce}", client_tax_code);

            data_js2 = strReplaceAll(data_js2, "{date_created}", invoice_date_created);
            data_js2 = strReplaceAll(data_js2, "{date_expires}", invoice_date_expires);
            data_js2 = strReplaceAll(data_js2, "{number}", invoice_number);
            data_js2 = strReplaceAll(data_js2, "{nature}", invoice_nature);
            data_js2 = strReplaceAll(data_js2, "{signature}", signature);
            data_js2 = strReplaceAll(data_js2, "{client_fullname}", client_fullname);
            data_js2 = strReplaceAll(data_js2, "{client_societe}", client_societe);
            data_js2 = strReplaceAll(data_js2, "{client_address_1}", client_address_1);
            data_js2 = strReplaceAll(data_js2, "{client_address_2}", client_address_2);
            data_js2 = strReplaceAll(data_js2, "{client_city}", client_city);
            data_js2 = strReplaceAll(data_js2, "{client_country}", client_country);
            data_js2 = strReplaceAll(data_js2, "{client_phone}", client_phone);
            data_js2 = strReplaceAll(data_js2, "{client_fax}", client_fax);
            data_js2 = strReplaceAll(data_js2, "{client_mobile}", client_mobile);
            data_js2 = strReplaceAll(data_js2, "{client_email}", client_email);
            data_js2 = strReplaceAll(data_js2, "{client_web}", client_web);
            data_js2 = strReplaceAll(data_js2, "{items_table}", invoice_items_table);
            data_js2 = strReplaceAll(data_js2, "{items_codes}", invoice_items_codes);
            data_js2 = strReplaceAll(data_js2, "{item_subtotal}", invoice_item_subtotal);
            data_js2 = strReplaceAll(data_js2, "{items_codes}", invoice_items_codes);
            data_js2 = strReplaceAll(data_js2, "{total_a_payer}", invoice_total_a_payer);
            data_js2 = strReplaceAll(data_js2, "{total_final}", invoice_total_final);
            data_js2 = strReplaceAll(data_js2, "{matricule_fiscale}", client_vat_id);
            data_js2 = strReplaceAll(data_js2, "{registre_commerce}", client_tax_code);


            setTimeout(function() {
                CKEDITOR.instances.body.setData(data_js);
            }, 1000);
            $('#body').html(data_js);
            $('#subject').val(data_js2);

        });
    });
}
$(function() {
    var template_fields = ["body", "subject", "from_name", "from_email", "cc", "bcc", "pdf_template"];
    $.post("<?php echo site_url('settings/ajax/get_signature/'); ?>", {}, function(data) {
        signature = data;
    });

    $('#email_template').change(function() {
        update_modele();
    });
    update_modele();
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

<form method="post" class="form-horizontal" action="<?php echo site_url('mailer/send_invoice/' . $invoice->invoice_id) ?>">

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
						<span class="caption-subject bold med-caption dark"><?php echo lang('email_invoice'); ?></span>
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
						<div class="form-group">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="cc" class="control-label"><?php echo lang('cc'); ?>: </label>
							</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="cc" id="cc" value="" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="subject" class="control-label"><?php echo lang('subject'); ?>: </label>
							</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="subject" id="subject" class="form-control"
									value="<?php echo lang('invoice'); ?> n° <?php echo $invoice->invoice_number; ?>">
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
						<div class="form-group" style=" display: none">
							<div class="col-xs-12 col-sm-4 text-left text-left-xs">
								<label for="pdf_template" class="control-label">
									<?php echo lang('pdf_template'); ?>:
								</label>
							</div>
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
						<div class="sup-offline" style="margin-top: 25px;"></div>     
						<div class="form-group">
							<div class="col-xs-12 md-checkbox col-md-4 text-left" style="">
								<?php if ($invoice->document == 1) {?>
								<input type="checkbox" value="1" name="drap" id="drap" checked="checked" class=" md-check">
								<?php } else {?>
								<input type="checkbox" value="0" name="drap" id="drap" class=" md-check">
								<?php }?>
								<label for="drap" style="margin-left: -16px;">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?php echo lang('attach_documents'); ?>
								</label>
							</div>
							<div class="md-checkbox col-md-4 text-left" style="">
								<?php if ($invoice->joindredevis == 1) {?>
								<input type="checkbox" value="1" name="joint" id="joint" checked="checked" class=" md-check">
								<?php } else {?>
								<input type="checkbox" value="0" name="joint" id="joint" class=" md-check">
								<?php }?>
								<label for="joint" style="margin-left: -16px;">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?php echo lang('attach_invoice'); ?>
								</label>
							</div>
						</div>
                <div class="form-group">
                    <div class="col-xs-12 col-md-4 text-left" style="">
                        <table name="documenttable" id="documenttable"
                            class="table table-striped table-responsive-md btn-table">
                            <thead>
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th align="center"><?php echo lang('listing_documents'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$this->db->select('file_name,doc_id as id_document');
$this->db->where("id_client", $invoice->client_id);
$this->db->where("object_id", $invoice->invoice_id);
$this->db->like('typeobject', 'invoice');
$this->db->from('ip_client_documents');
$this->db->join('ip_document_rappel', 'ip_client_documents.id_document = ip_document_rappel.doc_id', 'left');
$atbtrouve = $this->db->get()->result();
//return var_dump($atbtrouve);
$docnontrouve = $this->db->query("  SELECT  id_document,file_name FROM ip_client_documents where ip_client_documents.id_client=" . $invoice->client_id . " and id_document not in (SELECT doc_id as id_document FROM ip_document_rappel where typeobject='invoice' and ip_document_rappel.object_id =" . $invoice->invoice_id . ")");
$atbnontrouve = $docnontrouve->result();
$val = "";
foreach ($atbtrouve as $doc) {
    if (count($atbtrouve) > 0) {
        $val .= $doc->id_document . ",";
    }

    ?>
                                <tr class="tr_docselect_<?php echo $doc->id_document ?>">


                                    <td onchange="mydoc(<?php echo $doc->id_document ?>)" style="width: 25px;"
                                        align="left">
                                        <input type="checkbox" id="doccheck<?php echo $doc->id_document ?>" checked
                                            value="<?php echo $doc->id_document ?>">
                                    </td>
                                    <td class="attrValue" style="width: 25px;" align="left">
                                        <span><?php echo $doc->file_name ?></span></td>
                                    <?php }?>
                                </tr>
                                <?php
foreach ($atbnontrouve as $doc) {?>
                                <tr class="tr_docselect_<?php echo $doc->id_document ?>">
                                    <td onchange="mydoc(<?php echo $doc->id_document ?>)" style="width: 25px;"
                                        align="left">
                                        <input type="checkbox" id="doccheck<?php echo $doc->id_document ?>"
                                            value="<?php echo $doc->id_document ?>">
                                    </td>
                                    <td class="attrValue" style="width: 25px;" align="left">
                                        <span><?php echo $doc->file_name ?></span></td>
                                    <?php }?>
                                </tr>
                            </tbody>
                            <input type="hidden" id="listdocument" name="listdocument" value="<?php echo $val ?>">
                        </table>
                    </div>
                </div>
			</div>
	  </div>
            <div class="col-md-6">
				<div class="portlet light formulaire no-padding">
					<div class="form-group">
						<div class="col-xs-12 col-sm-4 text-left text-left-xs">
							<label for="email_template" class="control-label"><?php echo lang('email_template'); ?>:</label>
						</div>
						<div class="col-xs-12 col-sm-8">
							<select name="email_template" id="email_template" class="form-control">
								<?php if (!empty($email_templates)) {?>
								<?php foreach ($email_templates as $email_template): ?>
								<option value="<?php echo $email_template->email_template_id; ?>"
									<?php if ($selected_email_template == $email_template->email_template_id) {?>selected="selected"
									<?php }?>>
									<?php echo $email_template->email_template_title; ?>
								</option>
								<?php endforeach;?>
								<?php } else { ?>
								<option value=""></option>
								<?php } ?>
							</select>
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
					<div class="form-group">
						<div class="col-xs-12 col-sm-4">
							<label for="form_control_1"><?php echo lang('schedule_automatic_reminders'); ?></label>
						</div>
						<div class="col-xs-12 col-sm-8 form-md-line-input has-info">
							<input type="text" name="date_relance" id="date_relance" class="form-control date"
								value='<?php echo $valdaterappek ?>' placeholder="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12 col-sm-4">
							<label for="form_control_1"><?php echo lang('calendar_of_reminders'); ?></label>
						</div>
						<div class="col-xs-12 col-sm-8 form-md-line-input has-info">
							<table class="table">
								<tbody>

									<?php

	if ($dateselectrappel) {
		for ($i = 0; $i < count($dateselectrappel); $i++) {
			?>
									<tr>
										<td><?php echo $i + 1 ?></td>
										<td><?php echo $dateselectrappel[$i]->daterappel ?>
										</td>
										</td>
									</tr>
									<?php }} else {?>
									<tr>
										<td> <span style="color:red"> Aucune relance séléctionnée </span> </td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
            </div>
      </div>
      </div>
		<div class="row border-top">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="form-group">
					<div class="col-xs-12 col-sm-12 text-left text-left-xs">
						<label for="body" class="control-label" style="padding-bottom: 10px;"><?php echo lang('body'); ?>: </label>
					</div>
					<div class="col-xs-12 col-md-12 editt">
						<textarea name="body" id="body" class="form-control ckeditor " rows="8"></textarea>
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
            </script>
		</div>
    </div>
</div>
</form>