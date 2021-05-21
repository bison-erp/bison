<?php
$sess_product_add = $this->session->userdata['product_add'];
$sess_product_del = $this->session->userdata['product_del'];
$sess_product_index = $this->session->userdata['product_index'];
?>
<style>
#fournisseur_cat thead tr th {
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
}

#fournisseur_cat {
    // table-layout: fixed;
}

#fournisseur_cat tbody tr:hover {
    background: aliceblue;
}
</style>
<div id="headerbar">
    <?php if ($sess_product_add == 1) {?>

    <div class="pull-right" style="margin: 15px 7px;">
        <a class="btn btn-sm btn-primary btn-light-success" href="<?php echo site_url('group_option/form'); ?>">
            <?php echo 'Ajouter une group option' ?>
		</a>
    </div>
	
    <!--div class="pull-right">
        <!--?php echo pager(site_url('categorie_fournisseur/index'), 'mdl_option_attribut'); ?>
    </div-->
    <?php }?>

</div>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts');?>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="fournisseur_cat">

                        <thead>
                            <tr>
                                <th><?php echo "Nom de group option"; ?></th>
                               
                            </tr>
                        </thead>

                        <tbody>
                            <?php
foreach ($mdl_group_option as $groupe_option) {?>
                            <tr class="odd gradeX">
                                <td><?php echo $groupe_option->name; ?></td>
                                
                              <!--  <td>
                                    <?php if (($sess_product_add == 1) || ($sess_product_del == 1)) {?> <div
                                        class="options btn-group">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                            href="#">
                                            <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                                        </a>
                                       <!-- <ul class="dropdown-menu" style="margin-left: -114px;margin-top: 1px;">
                                            <li>
                                                <?php if ($sess_product_add == 1) {?> <a
                                                    href="<?php echo site_url('categorie_fournisseur/form/' . $family->id_categorie_fournisseur); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                                </a><?php }?>
                                            </li>
                                            <li>
                                                <?php if ($sess_product_del == 1) {?><a
                                                    href="<?php echo site_url('categorie_fournisseur/delete/' . $family->id_categorie_fournisseur); ?>"
                                                    onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                                    <i class="fa fa-trash-o fa-margin"></i>
                                                    <?php echo lang('delete'); ?>
                                                </a><?php }?>
                                            </li>
                                        </ul>-->
                                    </div><?php }?>
                                <!--</td>-->
                            </tr>
                            <?php }?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

<div class="pag-table-content">	
    <div class="pull-right  visible-lg">
        <?php echo pager(site_url('group_option/index'), 'mdl_group_option'); ?>
    </div>
</div>
	<!-- pagination -->

	<!-- end pagination -->
</div>