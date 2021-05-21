
<div class="row">
<div class="col-md-12">
<div class="portlet light">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?php echo lang('tax_rate_name'); ?></th>
                <th><?php echo lang('tax_rate_percent'); ?></th>
                <th style="width:80px;"><?php echo lang('options'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tax_rates as $tax_rate) { ?>
                <tr>
                    <td><?php echo $tax_rate->tax_rate_name; ?></td>
                    <td><?php echo $tax_rate->tax_rate_percent; ?>%</td>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                            </a>
                            <ul class="dropdown-menu" style="margin-left: -137px;">
                                <li>
                                    <a href="<?php echo site_url('tax_rates/form/' . $tax_rate->tax_rate_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('tax_rates/delete/' . $tax_rate->tax_rate_id); ?>"
                                       onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>