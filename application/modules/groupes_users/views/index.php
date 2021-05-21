<div id="headerbar">
    <h1><?php echo lang('groupes_users'); ?></h1>

    <div class="pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('groupes_users/form'); ?>"><i
                class="fa fa-plus"></i> <?php echo lang('new'); ?></a>
    </div>

    <div class="pull-right">
        <?php echo pager(site_url('groupes_users/index'), 'mdl_groupes_users'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th><?php echo lang('designation'); ?></th>
                    <th><?php echo lang('etat'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($groupes_users as $groupes_user) { ?>
                    <tr>
                        <td><?php echo $groupes_user->designation; ?></td>
                        <td><?php  if($groupes_user->etat==1) echo"Actif";
                        else                            echo 'Non actif';?></td>
                       
                        <td>
                            <a href="<?php echo site_url('groupes_users/form/' . $groupes_user->groupes_user_id); ?>"
                               title="<?php echo lang('edit'); ?>"><i class="fa fa-edit fa-margin"></i></a>
                            <a href="<?php echo site_url('groupes_user/delete/' . $groupes_user->groupes_user_id); ?>"
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



             



                    

                    
