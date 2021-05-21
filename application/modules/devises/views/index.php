<div id="headerbar">
    <h1><?php echo lang('devises'); ?></h1>

    <div class="pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('devises/form'); ?>"><i
                class="fa fa-plus"></i> <?php echo lang('new'); ?></a>
    </div>

    <div class="pull-right">
        <?php echo pager(site_url('devises/index'), 'mdl_devises'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><?php echo lang('devise_label'); ?></th>
                <th><?php echo lang('devise_symbole'); ?></th>

                
				
                
            </tr>
            </thead>

            <tbody>
            <?php foreach ($devises as $devise) { ?>
                <tr>
                    <td><?php echo $devise->devise_label; ?></td>
                    <td><?php echo $devise->devise_symbole; ?></td>
                    
                    
                    <td>
                        <a href="<?php echo site_url('devises/form/' . $devise->devise_id); ?>"
                           title="<?php echo lang('edit'); ?>"><i class="fa fa-edit fa-margin"></i></a>
                        <a  href="<?php echo site_url('devises/delete/' . $devise->devise_id); ?>"
                           title="<?php echo lang('delete'); ?>"
                           onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');"><i
                                class="fa fa-trash-o fa-margin"></i></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>