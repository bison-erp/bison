
        <?php
    $sess_product_add = $this->session->userdata['product_add'];
    $sess_product_del = $this->session->userdata['product_del'];
    $sess_product_index = $this->session->userdata['product_index'];
    ?> 


<div id="headerbar">
<?php if ($sess_product_add == 1) { ?>
                    <div class="pull-right" style="margin: 15px 7px;">
                        <a class="btn btn-sm btn-primary btn-light-success" href="<?php echo site_url('families/form'); ?>">
							<?php echo lang('create_family'); ?>
						</a>
                    </div>

                <?php } ?>

</div>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
<div class="row">
<div class="col-md-12">
    <div class="portlet light">
    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><?php echo lang('family_name'); ?></th>
                <th  style="width: 60px;"><?php echo lang('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($families as $family) { ?>
                <tr>
                    <td><?php echo $family->family_name; ?></td>
                    <td>
                       <?php if(($sess_product_add==1)||($sess_product_del==1) ){?> <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                            </a>
                           <ul class="dropdown-menu" style="margin-left: -99px;margin-top: -1px;">
                                <li>
                                   <?php if($sess_product_add==1){?> <a href="<?php echo site_url('families/form/' . $family->family_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                   </a><?php }?>
                                </li>
                                <li>
                                    <?php if($sess_product_del==1){?><a href="<?php echo site_url('families/delete/' . $family->family_id); ?>"
                                       onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                    </a><?php }?>
                                </li>
                            </ul>
                       </div><?php }?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
        
  </div></div></div>      
  
<div class="pag-table-content">	
    <div class="pull-right  visible-lg">
		<?php echo pager(site_url('families/index'), 'mdl_families'); ?>
    </div>
</div>
</div>