<div id="headerbar">



    <table style=" width: 100%">
        <tr>
            <td style=" display:none">
                <a href="javascript:history.back()">
                    <div style=" margin-left: 18px" > 
                        <img   style="width: 24px;"src="<?php echo base_url(); ?>/assets/default/img/left.png" ><h1>

                    </div>
                </a>
            </td>
            <td>
                <div style=" color: #4275a8;"> 
                    <h1><b> <?php echo lang('Activites'); ?></b></h1></div>

            </td>
            <td>
               <div class="pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('activites/form'); ?>"><i
                            class="fa fa-plus"></i> <?php echo lang('new'); ?></a>
                </div>
                <div class="pull-right">
                    <?php echo pager(site_url('activites/index'), 'mdl_activites'); ?>
                </div>
            </td>
        </tr>
    </table>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th><?php echo lang('product_description2'); ?></th>
                    <th><?php echo lang('activites_date_created'); ?></th>




                </tr>
            </thead>

            <tbody>
                <?php foreach ($activites as $activite) { ?>
                    <tr>
                        <td><?php echo $activite->descrip; ?></td>
                        <td><?php echo $activite->activites_date_created  ?></td>



                        <td>
                            <a href="<?php echo site_url('activites/form/' . $activite->id_activite); ?>"
                            title="<?php echo lang('edit'); ?>"><i class="fa fa-edit fa-margin"></i></a>
                            <a href="<?php echo site_url('activites/delete/' . $activite->id_activite); ?>"
                               title="<?php echo lang('delete'); ?>"
                               onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');"><i
                            class="fa fa-trash-o fa-margin"></i></a><?php }?>
                        </td>
                    </tr>
            </tbody>

        </table>
    </div>
</div>