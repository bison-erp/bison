<?php
$sess_product_add = $this->session->userdata['product_add'];
$sess_product_del = $this->session->userdata['product_del'];
$sess_product_index = $this->session->userdata['product_index'];
?>
<div id="headerbar" style="margin-top: -3%;">
    <?php if ($sess_product_add == 1) {?>

    <div class="pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('banque/form'); ?>"><i
                class="fa fa-plus"></i>
            <?php echo lang('new'); ?></a>
    </div>

    <div class="pull-right">
        <?php echo pager(site_url('banque/index'), 'mdl_banque'); ?>
    </div>
    <?php }?>

</div>
<br><br>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts');?>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="table-responsive">
                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th> Nom de banque</th>
                                <th style="width: 60px;"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
foreach ($mdl_banque as $family) {?>
                            <tr>
                                <td><?php echo $family->nom_banque; ?></td>
                                <td>
                                    <?php if (($sess_product_add == 1) || ($sess_product_del == 1)) {?> <div
                                        class="options btn-group">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                            href="#">
                                            <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                                        </a>
                                        <ul class="dropdown-menu" style="margin-left: -99px;margin-top: -1px;">
                                            <li>
                                                <?php if ($sess_product_add == 1) {?> <a
                                                    href="<?php echo site_url('banque/form/' . $family->id_banque); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                                </a><?php }?>
                                            </li>
                                            <li>
                                                <?php if ($sess_product_del == 1) {?><a
                                                    href="<?php echo site_url('banque/delete/' . $family->id_banque); ?>"
                                                    onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                                    <i class="fa fa-trash-o fa-margin"></i>
                                                    <?php echo lang('delete'); ?>
                                                </a><?php }?>
                                            </li>
                                        </ul>
                                    </div><?php }?>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>