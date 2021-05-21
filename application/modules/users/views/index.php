<div id="headerbar" style="margin-top: -32px;">
    <div class="pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('users/form'); ?>">
            <i class="fa fa-plus"></i> <?php echo lang('new'); ?>
        </a>
    </div>

    <div class="pull-right">
        <?php echo pager(site_url('users/index'), 'mdl_users'); ?>
    </div>
</div>           
<div id="content" class="table-content">
    <?php echo $this->layout->load_view('layout/alerts'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light">            
                <div class="table-responsive">
                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('groupe_user'); ?></th>
                                <th><?php echo lang('email_address'); ?></th>
                                <th><?php echo lang('address'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //
                            foreach ($users as $user) {
                                // echo $user->groupes_user_id;
                                ?>
                                <tr>
                                    <td><?php echo $user->user_name; ?></td>
                                    <td><?php echo strtoupper($user->user_code); ?></td>
                                    <td><?php
                                        $group = ' ';
                                        foreach ($groupes_users as $value) {
                                            if ($user->groupes_user_id == $value->groupes_user_id)
                                                $group = $value->designation;
                                        }echo $group;
                                        ?></td>
                                    <td><?php echo $user->user_email; ?></td>
                                    <td><?php echo $user->user_address_1; ?></td>
                                    <td><?php echo $user->user_phone; ?></td>
                                    <td>
                                        <div class="options btn-group">
                                            <a class="btn btn-sm btn-default dropdown-toggle"
                                               data-toggle="dropdown" href="#">
                                                <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                                            </a>
                                            <ul class="dropdown-menu" style="margin-left: -60px;">
                                                <li>
                                                    <a href="<?php echo site_url('users/form/' . $user->user_id); ?>">
                                                        <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                                    </a>
                                                </li>
                                                <?php if ($user->user_id <> 1) { ?>
                                                    <li>
                                                        <a href="<?php echo site_url('users/delete/' . $user->user_id); ?>"
                                                           onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                                            <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>

                    </table>
                </div>

            </div></div></div></div>