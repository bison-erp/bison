<style>
    .form-group.form-md-line-input .form-control{  padding-left: 1px;}
    .datepicker table tr td.day:hover,.datepicker table tr td.day.focused{background:#eee;cursor:pointer;border-radius: 4px;}
    .datepicker .active{  background-color: #4B8DF8 !important;background-image: none !important;filter: none !important;border-radius: 4px;}
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
    $(function () {
        $('#invoice_id').focus();

        amounts = JSON.parse('<?php echo $amounts;  ?>');


        $('#invoice_id').change(function () {
            
            var invoice_identifier = "invoice" + $('#invoice_id').val();
            
            amounts[invoice_identifier] = accepted_float_input(amounts[invoice_identifier]);
            
            $('#payment_amount').val(amounts[invoice_identifier]);
            $('#montant_esp').val(amounts[invoice_identifier]);
            $('#montant_cheq').val(amounts[invoice_identifier]);
            $('#montant_c').val(amounts[invoice_identifier]);

        });
        $('#payment_method_id').change(function () {
            var meth = $(this).val();//alert(meth);
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
            if ((meth == 2) || (meth == 4)) {
                $('#div_cheq').hide();
                $('#div_esp').hide();
                $('#div_vir').show();
            }

        });
    });
</script>

<form method="post" class="form-horizontal">

    <?php if ($payment_id) { ?>
        <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
    <?php } ?>


    <div id="headerbar">
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>
    <div id="content">
        <div style="clear:both"></div>
        <?php $this->layout->load_view('layout/alerts'); ?>
        <div class="row">
            <div class="col-md-12 " style="padding-top:20px;">
                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> 
                                <?php echo lang('payment_form'); ?>
                            </span>
                        </div>

                    </div>
                    <br>
                    <div  class="row" >
                        <div class="col-md-10">
                            <div class="form-group form-md-line-input has-info" style="margin-right: -26px;margin-left: 27px;" >
                                <select  class=" bs-select form-control" name="invoice_id" id="invoice_id" 
                                         <?php // if (@$this->mdl_payments->form_values['payment_id']) echo 'readonly'; ?>>
                                   <?php if (!isset($payment->invoice_id)) { ?> <option value=""></option> <?php } ?>
                                    <?php if (!$payment_id) { ?>
                                        <?php foreach ($invoices as $invoice) { ?>
                                            <option value="<?php echo $invoice->invoice_id; ?>"
                                                    <?php if (isset($payment->invoice_id) && $payment->invoice_id == $invoice->invoice_id) { ?>selected="selected"<?php } ?>>
                                                <?php echo $invoice->invoice_number . ' - ' . $invoice->client_name.' '. $invoice->client_prenom . ' - ' . format_devise($invoice->invoice_balance, $invoice->client_devise_id); ?></option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option  value="<?php echo $payment->invoice_id; ?>">
                                            <?php  echo $payment->invoice_number . ' - ' . $payment->client_name.' '. $payment->client_prenom . ' - ' . format_devise($payment->invoice_balance,$payment->client_devise_id); ?></option>
                                    <?php } ?>
                                </select>
                                <div class="form-control-focus" ></div>
                                <label for="form_control_1"  style="margin-left: -15px;font-size: 13px; color: #899a9a;margin-top: -15px;" ><?php echo lang('invoice'); ?></label>
                            </div></div>
                    </div>   


                    <div  class="row" >
                        <div class="col-md-10">
                            <div class="form-group form-md-line-input has-info" style="margin-right: -15px;margin-left: 40px;" >
                                <div class="form-group has-feedback">
                                    <div class="input-group">
                                        <input name="payment_date" id="payment_date"
                                               class="form-control datepicker" value="<?php if (isset($payment->payment_date)) echo date_from_mysql($payment->payment_date);  ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                        <div class="form-control-focus" ></div>
                                        <label for="form_control_1"  style="margin-left: -15px;font-size: 13px; color: #899a9a;margin-top: -15px;" ><?php echo lang('date'); ?></label>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div  class="row" >
                        <div class="col-md-10">
                            <div class="form-group form-md-line-input has-info" style="margin-right: -15px;margin-left: 28px;" >                   

                                <select id="payment_method_id"  name="payment_method_id" class="form-control">
                                    <?php foreach ($payment_methods as $payment_method) { ?>
                                            <option value="<?php echo $payment_method->payment_method_id; ?>"
                                        <?php if (isset($payment->payment_method_id) && $payment->payment_method_id == $payment_method->payment_method_id) { ?>selected="selected"<?php } ?>
                                        <?php if(!isset($payment->payment_method_id) && $payment_method->payment_method_id == 3)  echo 'selected="selected"'; ?>
                                                    >
                                        <?php echo $payment_method->payment_method_name; ?>
                                            </option>
                                    <?php } ?>
                                </select>
                                <div class="form-control-focus" ></div>
                                <label for="form_control_1"  style="margin-left: -22px;font-size: 13px; color: #899a9a;margin-top: -15px;" ><?php echo lang('payment_method'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div  class="row" >
                        <div class="col-md-10">
                            <div class="form-group form-md-line-input has-info" style="margin-right: -15px;margin-left: 28px;" >


                                <div  class="row" style=" margin-left: 15px;">
                                    <div class="col-md-12" id="div_esp">
                                        <div class="form-group form-md-line-input has-info">   
                                            <div class="invoice-properties col-md-4 " >
                                                <input type="text" id="montant_esp" name="montant_esp" style=" width:95%" class="form-control input-sm" value="<?php if(isset($payment->payment_amount)) echo $payment->payment_amount; ?>">
                                                <div class="form-control-focus" ></div>
                                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                    <?php echo lang('montant_cheq'); ?></label>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="div_cheq" style="width: 100%; display: none">
                                        <div class="form-group form-md-line-input has-info">           
                                            <div class="col-md-4">
                                                <input type="text"  style=" width:95%"
                                                       id="num_cheq" name="num_cheq" class="form-control input-sm" value="<?php if(isset($pieces_info->num_piece)) echo $pieces_info->num_piece; ?>">
                                                <div class="form-control-focus" ></div> 
                                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                    <?php echo lang('num_cheq'); ?></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" id="montant_cheq" name="montant_cheq"  style=" width: 95%" 
                                                       class="form-control input-sm"  value="<?php if(isset($payment->payment_amount)) echo $payment->payment_amount; ?>">
                                                <div class="form-control-focus" ></div>
                                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                    <?php echo lang('montant_cheq'); ?></label>            
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input name="date_cheq" id="date_cheq"
                                                           class="form-control input-sm datepicker" 
                                                           value="<?php echo date('d/m/Y'); ?>"><div class="form-control-focus" ></div>
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar fa-fw"></i>
                                                    </span>
                                                    <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" >
                                                        <?php echo lang('due_date'); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row col-md-12">
                                            <div class="form-group form-md-line-input has-info">           
                                                <div class="col-md-6">
                                                    <input type="text"  style=" width:95%"
                                                           id="proprietaire_c" name="proprietaire_c" class="form-control input-sm" value="<?php if(isset($pieces_info->proprietaire)) echo $pieces_info->proprietaire; ?>">
                                                    <div class="form-control-focus" ></div> 
                                                    <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                        <?php echo lang('proprietaire'); ?></label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="banque_c" name="banque_c"  style=" width: 95%" 
                                                           class="form-control input-sm" value="<?php if(isset($pieces_info->banque)) echo $pieces_info->banque; ?>">
                                                    <div class="form-control-focus" ></div>
                                                    <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                        <?php echo lang('banque'); ?></label>            
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-md-12" id="div_vir" style=" display: none">

                                        <div class="form-group form-md-line-input has-info">   

                                            <div class="invoice-properties col-md-4 " >

                                                <input type="text" id="reference"  name="reference" style=" width:95%" class="form-control input-sm" value="<?php if(isset($pieces_info->num_piece)) echo $pieces_info->num_piece; ?>">
                                                <div class="form-control-focus" ></div>
                                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                    <?php echo lang('reference'); ?></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text"  style=" width:95%"
                                                       id="proprietaire_v" name="proprietaire_v" class="form-control input-sm" value="<?php if(isset($pieces_info->proprietaire)) echo $pieces_info->proprietaire; ?>">
                                                <div class="form-control-focus" ></div> 
                                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                    <?php echo lang('proprietaire'); ?></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" id="banque_v" name="banque_v"  style=" width: 95%" 
                                                       class="form-control input-sm" value="<?php if(isset($pieces_info->banque)) echo $pieces_info->banque; ?>">
                                                <div class="form-control-focus" ></div>
                                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                    <?php echo lang('banque'); ?></label>            
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input has-info">   

                                            <div class="invoice-properties col-md-4 " >
                                                <input type="text" id="montant_c" name="montant_c" style=" width:95%" class="form-control input-sm"  value="<?php if(isset($payment->payment_amount)) echo $payment->payment_amount; ?>">
                                                <div class="form-control-focus" ></div>
                                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -20px;" >
                                                    <?php echo lang('montant_cheq'); ?></label>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div  class="row" >
                        <div class="col-md-10">
                            <div class="form-group form-md-line-input has-info" style="margin-right: -15px;margin-left: 29px;width: 102%;" >
                                <textarea name="payment_note" class="form-control"><?php if (isset($payment->payment_note)) echo $payment->payment_note;  ?></textarea>
                                <div class="form-control-focus" ></div>
                                <label for="form_control_1"  style="margin-left: -3px;font-size: 13px; color: #899a9a;margin-top: -15px;" ><?php echo lang('note'); ?></label>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div> 
        </div> 
    </div>
    <div id="headerbar">
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

</form>
