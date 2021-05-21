<style>
    .form-group.form-md-line-input .form-control{  padding-left: 1px;}
    .datepicker table tr td.day:hover,.datepicker table tr td.day.focused{background:#eee;cursor:pointer;border-radius: 4px;}
    .datepicker .active{  background-color: #4B8DF8 !important;background-image: none !important;filter: none !important;border-radius: 4px;}
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
    $(function () {
        // Display the create quote modal
        $('#modal_quote_to_invoice').modal('show');

        // Creates the invoice
        $('#quote_to_bl_confirm').click(function () {
            $.post("<?php echo site_url('quotes/ajax/quote_to_fabrication'); ?>", {
                quote_id: <?php echo $quote_id; ?>,
                client_name: $('#client_name').val(),
                invoice_date_created: $('#invoice_date_created').val(),
                invoice_group_id: $('#invoice_group_id').val(),
                invoice_password: $('#invoice_password').val(),
                user_id: $('#user_id').val(),
                client_id: $('#client_id').val(),
                quote_number: $('#quote_number').val(),
                invoice_number: $('#invoice_number').val(),
                invoice_terms: $('#invoice_terms').val(),
                nature: $('#nature').val(),
                invoice_delai_paiement: $('#invoice_delai_paiement').val(),
                invoice_status_id: $('#invoice_status_id').val(),
                invoice_date_due: $('#invoice_date_due').val(),
                invoice_item_subtotal: $('#invoice_item_subtotal').val(),
                invoice_item_tax_total: $('#invoice_item_tax_total').val(),
                invoice_tax_total: $('#invoice_tax_total').val(),
                timbre_fiscale: $('#timbre_fiscale').val(),
                invoice_total: $('#invoice_total').val(),
                invoice_pourcent_remise: $('#invoice_pourcent_remise').val(),
                invoice_montant_remise: $('#invoice_montant_remise').val(),
                invoice_pourcent_acompte: $('#invoice_pourcent_acompte').val(),
                invoice_montant_acompte: $('#invoice_montant_acompte').val(),
                invoice_item_subtotal_final: $('#invoice_item_subtotal_final').val(),
                invoice_item_tax_total_final: $('#invoice_item_tax_total_final').val(),
                invoice_total_final: $('#invoice_total_final').val(),
                invoice_total_a_payer: $('#invoice_total_a_payer').val(),
                bl_pdf: $('#bl_pdf').val(),
                langue: $('#langue').val(),
            },
            function (data) {
                var response = JSON.parse(data);
                if (response.success == '1') {
                    window.location = "<?php echo site_url('fabrication/view'); ?>/" + response.invoice_id;
                }
                else {
                    // The validation was not successful
                    $('.control-group').removeClass('has-error');
                    for (var key in response.validation_errors) {
                        $('#' + key).parent().parent().addClass('has-error');
                    }
                }
            });
        });


    });

</script>

<div id="modal_quote_to_invoice" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"
     role="dialog" aria-labelledby="modal_quote_to_invoice" aria-hidden="true"  style="overflow: hidden;height: 95%;z-index: 10050 !important;display: block; width: 45%;margin-left: 27%;">
    <form class="modal-content">
        <div class="modal-header" style=" height: 50px !important;border-bottom: 1px solid #E5E5E5;width: 41%;">
            <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                    style="width: 22px;height: 20px;color: #FFF !important;background-image: none !important; background-color: rgb(220, 53, 88) !important;text-align: center;text-indent: 0px;opacity: 1;">
                <i class="fa fa-close"></i></button>

            <div class="col-md-10" style=" font-weight: 600;font-size: 18px;margin-bottom: 14px;">
                <?php echo lang('quote_to_fabrication'); ?>
            </div>
        </div>
        <div class="modal-body" style="margin-top: 7%;">

         

            <input type="hidden" name="client_name" id="client_name" value="<?php echo $quote->client_name; ?>">
            <input type="hidden" name="client_id" id="client_id" value="<?php echo $quote->client_id; ?>">
            <input type="hidden" name="quote_number" id="quote_number" value="<?php echo $quote->quote_number; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $quote->user_id; ?>">
            <input type="hidden" name="invoice_terms" id="invoice_terms" value="<?php echo $quote->notes; ?> (:<?php echo lang('creation_quote_fabrication') ?> <?php echo $quote->quote_number; ?>)">
            <input type="hidden" name="bl_pdf" id="bl_pdf" value=" sur devis n°: <?php echo $quote->quote_number; ?>">
            <input type="hidden" name="langue" id="langue" value="<?php echo $quote->langue; ?>">

            <input type="hidden" name="nature" id="nature" value="<?php echo $quote->quote_nature; ?>">
            <input type="hidden" name="invoice_delai_paiement" id="invoice_delai_paiement" value="<?php echo $quote->quote_delai_paiement; ?>">
            <input type="hidden" name="invoice_group_id" id="invoice_group_id" value="0">
            <input type="hidden" name="invoice_status_id" id="invoice_status_id" value="<?php echo $quote->quote_status_id; ?>">
            <input type="hidden" name="invoice_date_due" id="invoice_date_due" value="<?php echo $quote->quote_date_expires; ?>">
            <input type="hidden" name="invoice_number" id="invoice_number" value="<?php echo $next_id; ?>">

            <input type="hidden" name="invoice_item_subtotal" id="invoice_item_subtotal" value="<?php echo $quote->quote_item_subtotal; ?>">
            <input type="hidden" name="invoice_item_tax_total" id="invoice_item_tax_total" value="<?php echo $quote->quote_item_tax_total; ?>">
            <input type="hidden" name="invoice_tax_total" id="invoice_tax_total" value="<?php echo $quote->quote_tax_total; ?>">
            <input type="hidden" name="timbre_fiscale" id="timbre_fiscale" value="<?php echo $quote->timbre_fiscale; ?>">
            <input type="hidden" name="invoice_total" id="invoice_total" value="<?php echo $quote->quote_total; ?>">
            <input type="hidden" name="invoice_pourcent_remise" id="invoice_pourcent_remise" value="<?php echo $quote->quote_pourcent_remise; ?>">
            <input type="hidden" name="invoice_montant_remise" id="invoice_montant_remise" value="<?php echo $quote->quote_montant_remise; ?>">
            <input type="hidden" name="invoice_pourcent_acompte" id="invoice_pourcent_acompte" value="<?php echo $quote->quote_pourcent_acompte; ?>">
            <input type="hidden" name="invoice_montant_acompte" id="invoice_montant_acompte" value="<?php echo $quote->quote_montant_acompte; ?>">
            <input type="hidden" name="invoice_item_subtotal_final" id="invoice_item_subtotal_final" value="<?php echo $quote->quote_item_subtotal_final; ?>">
            <input type="hidden" name="invoice_item_tax_total_final" id="invoice_item_tax_total_final" value="<?php echo $quote->quote_item_tax_total_final; ?>">
            <input type="hidden" name="invoice_total_final" id="invoice_total_final" value="<?php echo $quote->quote_total_final; ?>">
            <input type="hidden" name="invoice_total_a_payer" id="invoice_total_a_payer" value="<?php echo $quote->quote_total_a_payer; ?>">
            <div  class="row">

                <div  class="col-md-6">

                    <div class="form-group form-md-line-input has-info">
                        <div class="quote-properties has-feedback">
                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('fabrication_date'); ?></label>
                            <div class="input-group">
                                <input name="invoice_date_created" id="invoice_date_created" style="text-align: left;"  class="form-control input-sm datepicker" value="<?php echo date('d/m/Y'); ?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-md-line-input has-info">
                                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;"><?php echo lang('invoice_password'); ?></label>

                        <input type="text" name="invoice_password" id="invoice_password" class="form-control"
                               value="<?php
if ($this->mdl_settings->setting('invoice_pre_password') == '') {
    echo '';
} else {
    echo $this->mdl_settings->setting('invoice_pre_password');
}
?>" style="margin: 0 auto;" autocomplete="off">

                        <div class="form-control-focus" ></div>

                    </div>

                </div>

            </div>
            <div class="form-group" style=" display:none">
                <label for="invoice_group_id">
                    <?php echo lang('invoice_group'); ?>
                </label>
                <select name="invoice_group_id" id="invoice_group_id" class="form-control">
                    <option value=""></option>
                    <?php foreach ($invoice_groups as $invoice_group) {?>
                        <option value="<?php echo $invoice_group->invoice_group_id; ?>"
                                <?php if ($this->mdl_settings->setting('default_invoice_group') == $invoice_group->invoice_group_id) {?>selected="selected"<?php }?>>
                            <?php echo $invoice_group->invoice_group_name; ?></option>
                    <?php }?>
                </select>
            </div>




        </div>

        <div class="modal-footer" >
            <div class="btn-group">
                <button class="btn  defult" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo lang('cancel'); ?>
                </button>
                <button class="btn  blue btn-success" id="quote_to_bl_confirm" type="button">
                    <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>

    </form>

</div>
