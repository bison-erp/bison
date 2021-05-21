<style>
#enter-payment .form-group.form-md-line-input {
    margin-bottom: 10px;
}

#enter-payment .datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
    background: #eee;
    cursor: pointer;
    border-radius: 4px;
}

#enter-payment .datepicker .active {
    background-color: #4B8DF8 !important;
    background-image: none !important;
    filter: none !important;
    border-radius: 4px;
}

.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top {
    z-index: 99999 !important;

    .div_cheq,
    .div_vir,
    .div_esp {
        margin: 0 !important;
        padding: 0 !important;
    }
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
    rel="stylesheet" type="text/css">

<script type="text/javascript">
$('#client_idd').val($('#client_id').val());
$(function() {
    $('#enter-payment').modal('show');

    $('.div_esp').show();
    $('.div_cheq').hide();
    $('.div_vir').hide();

    $('#enter-payment').on('shown', function() {
        $('#montant_esp').focus();
    });

    $('#btn_modal_payment_submit').click(function() {

        $.post("<?php echo site_url('payments/ajax/add'); ?>", {
                invoice_id: $('#invoice_id').val(),
                client_id: $('#client_idd').val(),
                payment_amount: $('#payment_amount').val(),
                payment_method_id: $('#payment_method_id').val(),
                num_cheq: $('#num_cheq').val(),
                montant_cheq: $('#montant_cheq').val(),
                banque_c: $('#banque_c').val(),
                proprietaire_c: $('#proprietaire_c').val(),
                date_cheq: $('#date_cheq').val(),
                montant_esp: $('#montant_esp').val(),
                reference: $('#reference').val(),
                montant_c: $('#montant_c').val(),
                banque_v: $('#banque_v').val(),
                proprietaire_v: $('#proprietaire_v').val(),
                payment_date: $('#payment_date').val(),
                payment_note: $('#payment_note').val()
            },
            function(data) {
                var response = JSON.parse(data);
                if (response.success == '1') {
                    alert("Paiement enregisté avec succèes");
                    // The validation was successful and payment was added

                    if (typeof updatePaymentList !== 'undefined') {
                        updatePaymentList($('#client_idd').val());
                        $('#enter-payment').modal('hide');
                    } else {
                        window.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
                    }
                }
                //                else {
                //                    // The validation was not successful
                //                    $('.control-group').removeClass('has-error');
                //                    for (var key in response.validation_errors) {
                //                        $('#' + key).parent().parent().addClass('has-error');
                //
                //                    }
                //                }

            });

    });

    $('#payment_method_id').change(function() {
        var meth = $('#payment_method_id').val(); //alert(meth);
        if (meth == 1) {
            $('.div_cheq').show();
            $('.div_vir').hide();
            $('.div_esp').hide();
        }
        if (meth == 3) {
            $('.div_esp').show();
            $('.div_cheq').hide();
            $('.div_vir').hide();
        }
        if ((meth == 2) || (meth == 4) || (meth == 5)) {
            $('.div_cheq').hide();
            $('.div_esp').hide();
            $('.div_vir').show();
        }
    });
});
</script>

<div id="enter-payment" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"
    style="display: block;width: 65%;height: 85%;overflow:hidden !important;z-index: 99999;;background-color: #Fffff;margin-top: 22px;border-radius: 6px;"
    role="dialog" aria-labelledby="modal_enter_payment" aria-hidden="true">
    <div class="modal-content" style=" width: 100%">
        <div class="modal-header" style=" width: 64%;position: fixed; z-index: 878 ;border-bottom: 0px;height: 55px;border-bottom: 1px solid #E5E5E5;  background-color: rgb(255, 255, 255) !important; ">
            <!--            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>-->
            <div class="col-sm-8" style="font-weight: 600;font-size: 18px;">
                <?php echo lang('enter_payment'); ?> <span>
                    <?php echo $invoice_id != 0 ? " (Facture #" . $invoice_id . ")" : ""; ?></span> </div>
            <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                style="width: 22px;height: 20px;color: #FFF !important;background-image: none !important; background-color: rgb(220, 53, 88) !important;text-align: center;text-indent: 0px;opacity: 1;">
                <i class="fa fa-close"></i></button>
        </div>
        <div class="modal-body" style="  z-index: 878; margin-top: 54px;">
            <form>
                <input type="hidden" name="client_id" id="client_idd" value="<?php echo $client_id; ?>">
                <div class="row">
                    <?php if ($invoice_id == 0) {?>
                    <div class="col-md-3">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('invoice'); ?></label>
                            <select name="invoice_id" id="invoice_id" class="form-control form-control-md form-control-light"
                                style=" padding: 0px">
                                <option value="0"><?php echo lang('select'); ?></option>
                                <?php if (isset($invoices_select) && !empty($invoices_select)) {?>
                                <?php foreach ($invoices_select as $invoice) {?>
                                <option value="<?php echo $invoice->invoice_id; ?>"><?php echo lang('invoice'); ?>
                                    #<?php echo $invoice->invoice_number; ?></option>
                                <?php }?>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <?php } else {?>
                    <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice_id; ?>">
                    <?php }?>
                    <div class="<?php if ($invoice_id == 0) {echo "col-md-3";} else {echo "col-md-5";}?>">
                        <div class="form-group has-info">
                                <label for="form_control_1" ><?php echo lang('date'); ?> </label>
                            <div class="input-group">
                                <input name="payment_date" id="payment_date" class="form-control form-control-md form-control-light datepicker"
                                    value="<?php echo date("d/m/Y") ?>">
                                <div class="form-control-focus"></div>
                                <div class="form-control-focus"></div>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>

                            </div>

                        </div>
                    </div>
                    <div class="<?php if ($invoice_id == 0) {echo "col-md-3";} else {echo "col-md-4";}?>">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('payment_method'); ?></label>
                            <select id="payment_method_id" name="payment_method_id" class="form-control form-control-md form-control-light"
                                style=" padding: 0px">
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

                    <div class="col-md-3 div_esp">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('montant_cheq'); ?></label>
                            </label>
                            <input type="text" id="montant_esp" name="montant_esp" class="form-control form-control-md form-control-light"
                                value="<?php echo $invoice_amount_restant; ?>">
                        </div>
                    </div>

                    <div class="col-md-3 div_cheq">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('montant_cheq'); ?></label>
                            </label>
                            <input type="text" id="montant_cheq" name="montant_cheq" class="form-control form-control-md form-control-light"
                                value="<?php echo $invoice_amount_restant; ?>">
                        </div>
                    </div>
                    <div class="col-md-3 div_cheq">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('num_cheq'); ?></label>
                            </label>
                            <input type="text" id="num_cheq" name="num_cheq" class="form-control form-control-md form-control-light">
                        </div>
                    </div>

                    <div class="col-md-3 div_cheq">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('due_date'); ?></label>
                            </label>
                            <input name="date_cheq" id="date_cheq" class="form-control form-control-md form-control-light datepicker"
                                value="<?php echo date('d/m/Y'); ?>">
                        </div>
                    </div>

                    <div class="col-md-3 div_cheq">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('proprietaire'); ?></label>
                            </label>
                            <input type="text" id="proprietaire_c" name="proprietaire_c" class="form-control form-control-md form-control-light">
                        </div>
                    </div>
                    <div class="col-md-3 div_cheq">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('banque'); ?></label>
                            <select name="banque_c" id="banque_c" class="form-control form-control-md form-control-light" style=" padding: 0px">
                                <option value="0">Choisir</option>
                                <?php foreach ($banque as $bq) {?>
                                <?php if ($bq->id_banque == $pieces_info->banque) {?>
                                <option value="<?php echo $bq->id_banque;

    ?>" <?php echo "selected='selected'"; ?>><?php echo $bq->nom_banque ?></option>
                                <?php } else {?>
                                <option value="<?php echo $bq->id_banque ?>"><?php echo $bq->nom_banque ?></option>

                                <?php }}?>
                            </select>
                        </div>

                    </div>


                    <div class="col-md-3 div_vir">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('montant_cheq'); ?></label>
                            </label>
                            <input type="text" id="montant_c" name="montant_c" class="form-control form-control-md form-control-light"
                                value="<?php echo $invoice_amount_restant; ?>">
                        </div>
                    </div>
                    <div class="col-md-4 div_vir">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('reference'); ?></label>
                            </label>
                            <input type="text" id="reference" name="reference" style=" width:95%"
                                class="form-control form-control-md form-control-light">
                        </div>
                    </div>
                    <div class="col-md-4 div_vir">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('proprietaire'); ?></label>
                            </label>
                            <input type="text" id="proprietaire_v" name="proprietaire_v" class="form-control form-control-md form-control-light">
                        </div>
                    </div>
                    <div class="col-md-4 div_vir">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('banque'); ?></label> </label>
                            <select name="banque_v" id="banque_v" class="form-control form-control-md form-control-light">
                                <option value="0">Choisir</option>
                                <?php foreach ($banque as $bq) {?>
                                <?php if ($bq->id_banque == $pieces_info->banque) {?>
                                <option value="<?php echo $bq->id_banque;

    ?>" <?php echo "selected='selected'"; ?>><?php echo $bq->nom_banque ?></option>
                                <?php } else {?>
                                <option value="<?php echo $bq->id_banque ?>"><?php echo $bq->nom_banque ?></option>

                                <?php }}?>
                            </select>

                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('note_societes'); ?></label>
                            <textarea name="payment_note" id="payment_note" class="form-control form-control-md form-control-light"></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn default bg-cancel" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    <?php echo lang('cancel'); ?>
                </button>
                <button class="btn btn-success" id="btn_modal_payment_submit" type="button">
                    <i class="fa fa-check"></i>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>

    </div>
</div>