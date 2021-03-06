<script type="text/javascript">
    $(function () {
        // Display the create invoice modal
        $('#modal-choose-items').modal('show');

        // Creates the invoice
        $('#select-items-confirm').click(function () {
            var service_ids = [];

            $("input[name='service_ids[]']:checked").each(function () {
                service_ids.push(parseInt($(this).val()));
            });

            $.post("<?php echo site_url('services/ajax/process_service_selections'); ?>", {
                service_ids: service_ids
            }, function (data) {
                items = JSON.parse(data);

                for (var key in items) {
                    // Set default tax rate id if empty
                    if (!items[key].tax_rate_id) items[key].tax_rate_id = 0;

                    if ($('#item_table tr:last input[name=item_name]').val() !== '') {
                        $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
                    }
                    $('#item_table tr:last input[name=item_name]').val(items[key].service_name);
                    $('#item_table tr:last textarea[name=item_description]').val(items[key].service_description);
                    $('#item_table tr:last input[name=item_price]').val(items[key].service_price);
                    $('#item_table tr:last input[name=item_quantity]').val('1');
                    $('#item_table tr:last select[name=item_tax_rate_id]').val(items[key].tax_rate_id);

                    $('#modal-choose-items').modal('hide');
                }
            });
        });

        // Toggle checkbox when click on row
        $('#services_table tr').click(function (event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        // Filter on search button click
        $('#filter-button').click(function () {
            services_filter();
        });

        // Filter on family dropdown change
        $("#filter_family").change(function () {
            services_filter();
        });

        // Filter services
        function services_filter() {
            var filter_family = $('#filter_family').val();
            var filter_service = $('#filter_service').val();
            var lookup_url = "<?php echo site_url('services/ajax/modal_service_lookups'); ?>/";
            lookup_url += Math.floor(Math.random() * 1000) + '/?';

            if (filter_family) {
                lookup_url += "&filter_family=" + filter_family;
            }

            if (filter_service) {
                lookup_url += "&filter_service=" + filter_service;
            }

            // refresh modal
            $('#modal-choose-items').modal('hide');
            $('#modal-placeholder').load(lookup_url);
        }
    });
</script>

<div id="modal-choose-items" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"
     role="dialog" aria-labelledby="modal-choose-items" aria-hidden="true">
    <form class="modal-content">
        <div class="modal-header">
            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>

            <h3><?php echo lang('add_service'); ?></h3>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="form-group filter-form">
                    <!-- ToDo
					<select name="filter_family" id="filter_family" class="form-control">
						<option value=""><?php echo lang('any_family'); ?></option>
						<?php foreach ($families as $family) { ?>
						<option value="<?php echo $family->family_id; ?>"
							<?php if ($family->family_id == $filter_family) echo ' selected="selected"'; ?>><?php echo $family->family_name; ?></option>
						<?php } ?>
					</select>
					-->
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="filter_service" id="filter_service"
                           placeholder="<?php echo lang('service_name'); ?>" value="<?php echo $filter_service ?>">
                </div>
                <button type="button" id="filter-button"
                        class="btn btn-default"><?php echo lang('search_service'); ?></button>
                <!-- ToDo
				<button type="button" id="reset-button" class="btn btn-default"><?php echo lang('reset'); ?></button>
				-->
            </div>
            <br/>

            <div class="table-responsive">
                <table id="services_table" class="table table-bordered table-striped">
                    <tr>
                        <th>&nbsp;</th>
                        <th><?php echo lang('service_sku'); ?></th>
                        <th><?php echo lang('family_name'); ?></th>
                        <th><?php echo lang('service_name'); ?></th>
                        <th><?php echo lang('service_description'); ?></th>
                        <th class="text-right"><?php echo lang('service_price'); ?></th>
                    </tr>
                    <?php foreach ($services as $service) { ?>
                        <tr>
                            <td class="text-left">
                                <input type="checkbox" name="service_ids[]"
                                       value="<?php echo $service->service_id; ?>">
                            </td>
                            <td nowrap class="text-left">
                                <b><?php echo $service->service_sku; ?></b>
                            </td>
                            <td>
                                <b><?php echo $service->family_name; ?></b>
                            </td>
                            <td>
                                <b><?php echo $service->service_name; ?></b>
                            </td>
                            <td>
                                <?php echo $service->service_description; ?>
                            </td>
                            <td class="text-right">
                                <?php echo format_currency($service->service_price); ?>
                            </td>
                        </tr>
                        <!-- Todo
						<tr class="bold-border">
                            <td colspan="3">
                                <?php echo $service->service_description; ?>
                            </td>
                        </tr>
						-->
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    <?php echo lang('cancel'); ?>
                </button>
                <button class="btn btn-success" id="select-items-confirm" type="button">
                    <i class="fa fa-check"></i>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>

    </form>

</div>