<?php $this->layout->load_view('clients/jquery_client_lookup'); ?>

<script type="text/javascript">
    $(function () {
        // Display the create invoice modal
        $('#create-invoice').modal('show');

        $('#create-invoice').on('shown', function () {
            $("#client_name").focus();
        });

        $('#client_name').typeahead();

        // Creates the invoice
        $('#invoice_create_confirm').click(function () {
            // Posts the data to validate and create the invoice;
            // will create the new client if necessary
            $.post("<?php echo site_url('invoices/ajax/create'); ?>", {
                    client_name: $('#client_name').val(),
                    invoice_date_created: $('#invoice_date_created').val(),
                    invoice_group_id: $('#invoice_group_id').val(),
                    invoice_time_created: '<?php echo date('H:i:s') ?>',
                    invoice_password: $('#invoice_password').val(),
                    user_id: '<?php echo $this->session->userdata('user_id'); ?>'

                },
                function (data) {
                    var response = JSON.parse(data);
                    if (response.success == '1') {
                        // The validation was successful and invoice was created
                        window.location = "<?php echo site_url('invoices/view'); ?>/" + response.invoice_id;
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

<div id="create-invoice" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"
     role="dialog" aria-labelledby="modal_create_invoice" aria-hidden="true">
    <form class="modal-content">
        <div class="modal-header">
            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>
            <h3><?php echo lang('create_invoice'); ?></h3>
        </div>
        <div class="modal-body">

            <div class="form-group has-info">
                <label for="client_name"><?php echo lang('client'); ?></label>
                <input type="text" name="client_name" id="client_name" class="form-control form-control-md form-control-light"
                       value="<?php echo $client_name; ?>" style="margin: 0 auto;" autocomplete="off">
            </div>

            <div class="form-group has-feedback">
                <label><?php echo lang('invoice_date'); ?></label>
                <div class="input-group">
                    <input name="invoice_date_created" id="invoice_date_created"
                           class="form-control form-control-md form-control-light datepicker"
                           value="<?php echo date(date_format_setting()); ?>">
                <span class="input-group-addon">
                    <i class="fa fa-calendar fa-fw"></i>
                </span>
                </div>
            </div>
            <div class="form-group">
                <label for="invoice_password"><?php echo lang('invoice_password'); ?></label>
                <input type="text" name="invoice_password" id="invoice_password" class="form-control form-control-md form-control-light"
                       value="<?php if ($this->mdl_settings->setting('invoice_pre_password') == ''){echo '';}else{echo $this->mdl_settings->setting('invoice_pre_password');}?>" style="margin: 0 auto;" autocomplete="off">
            </div>
            <div class="form-group">
                <label><?php echo lang('invoice_group'); ?></label>
                <div class="controls">
                    <select name="invoice_group_id" id="invoice_group_id" class="form-control form-control-md form-control-light">
                        <option value=""></option>
                        <?php foreach ($invoice_groups as $invoice_group) { ?>
                            <option value="<?php echo $invoice_group->invoice_group_id; ?>"
                                    <?php if ($this->mdl_settings->setting('default_invoice_group') == $invoice_group->invoice_group_id) { ?>selected="selected"<?php } ?>><?php echo $invoice_group->invoice_group_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn default bg-cancel" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo lang('cancel'); ?>
                </button>
                <button class="btn btn-success" id="invoice_create_confirm" type="button">
                    <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>

    </form>

</div>
