<?php
$db = $this->load->database('default');
$this->load->model('groupes_users/mdl_groupes_users');
$this->load->model('users/mdl_users');
//$query = $this->db->query('SELECT * FROM  `ip_devises` ')->get()->result();
$groupes_users = $this->mdl_groupes_users->get()->result();

$users = $this->mdl_users->get()->result();
//$row = $query->row();
?>
<!--<pre>
 
</pre>-->
<style>
.col-md-12.bg-light-warning-k, .col-md-12.bg-light-success-k {
    border-radius: 8px;
}
.portlet-title.left-title.title-light-warning, .portlet-title.left-title.title-light-success {
    padding: 20px 0px 0;
    margin: 0 0 20px!important;
    background: transparent;
}
.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 1px solid #ddd;
}
</style>


<div id="div-smtp-settings" class="tab-info">

<div class="espace" style="padding: 10px 0;"></div>
    <div id="content" class="table-content">

        <?php $this->layout->load_view('layout/alerts'); ?>
        <div class="col-md-12 bg-light-warning-k">
            <div id="headerbar">
				<div class="content-heading">
					<div class="portlet-title left-title title-light-warning">
						<div class="caption font-dark-sunglo">
							<span class="caption-subject bold med-caption dark">
								<?php echo lang('user_groups'); ?>
							</span>
						</div>
					</div>
				</div>
            </div>
			<div class="portlet-toolbar" style="display: inline-block;">
				<div class="pull-left btn-group">
					<a class="btn btn-danger btn-md" href="<?php echo site_url('groupes_users/form'); ?>">
						<?php echo lang('new'); ?>
					</a>
				</div>
			</div>
<div class="espace" style="padding: 10px 0;"></div>
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th><?php echo lang('designation'); ?></th>
                            <th><?php echo lang('etat'); ?></th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $cnt = 0;
                        foreach ($groupes_users as $groupes_user) {
                            ?>
                            <tr>
                                <td><?php echo $groupes_user->designation; ?></td>
                                <td><?php
                                    if ($groupes_user->etat == 1)
                                        echo"Actif";
                                    else
                                        echo 'Non actif';
                                    ?></td>

                                <td style="width: 50px;">
                                    <a href="<?php echo site_url('groupes_users/form/' . $groupes_user->groupes_user_id); ?>"
                                       title="<?php echo lang('edit'); ?>"><i class="fa fa-edit fa-margin"></i></a>
                                       <?php if ($cnt != 0 && $cnt != 1) { ?>
                                        <a href="<?php echo site_url('groupes_users/delete/' . $groupes_user->groupes_user_id); ?>"
                                           title="<?php echo lang('delete'); ?>"
                                           onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');"><i
                                                class="fa fa-trash-o fa-margin"></i></a>
                                        <?php } ?>
                                </td>
                            </tr>
                            <?php
                            $cnt++;
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
<div class="espace" style="padding: 10px 0;"></div>
        <div class="col-md-12 bg-light-success-k" style="margin: 25px 0 50px;">
            <div id="headerbar">
				<div class="content-heading">
					<div class="portlet-title left-title title-light-success">
						<div class="caption font-dark-sunglo">
							<span class="caption-subject bold med-caption dark">
								<?php echo lang('users'); ?>
							</span>
						</div>
					</div>
				</div>
            </div>
            <?php if(rightsAddCollaborateur()){ ?>
			<div class="portlet-toolbar" style="display: inline-block;">
				<div class="pull-left btn-group">
                <a class="btn btn-danger btn-md" href="<?php echo site_url('users/form'); ?>">
					<?php echo lang('new'); ?>
				</a>
				</div>
			</div>
            <?php } ?>
<div class="espace" style="padding: 10px 0;"></div>
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th><?php echo lang('name'); ?></th>
                            <th><?php echo lang('code'); ?></th>
                            <th><?php echo lang('groupe_user'); ?></th>
                            <th><?php echo lang('email_address'); ?></th>
                            <th><?php echo lang('phone'); ?></th>
                            <th style="width: 80px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($users as $user) {
                            ?>
                            <tr <?php if($user->user_active == "0"){ ?>style="background-color: blanchedalmond;" <?php } ?>>
                                <td><?php echo $user->user_name; ?></td>
                                <td><?php echo strtoupper($user->user_code); ?></td>
                                <td><?php
                                    $group = ' ';
                                    foreach ($groupes_users as $value) {
                                        if ($user->groupes_user_id == $value->groupes_user_id)
                                            $group = "<a href='" . site_url('groupes_users/form/' . $user->groupes_user_id) . "'>" . $value->designation . "</a>";
                                    }echo $group;
                                    ?></td>
                                <td><?php echo $user->user_email; ?></td>
                                <td><?php echo $user->user_phone; ?></td>
                                <td style="width: 80px;">
                                    <div class="options btn-group">
                                        <a class="btn btn-sm btn-default dropdown-toggle"
                                           data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                                        </a>
                                        <ul class="dropdown-menu" style="margin-left: -137px;">
                                            <li>
                                                <a href="<?php echo site_url('users/form/' . $user->user_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                                </a>
                                            </li>
                                            <?php if($user->user_active == "1"){ ?>
                                              <li>
                                                    <a href="<?php echo site_url('users/deactivate/' . $user->user_id); ?>"
                                                       onclick="return confirm('Voulez vous désactiver cet utilisateur ?');">
                                                        <i class="fa  fa-minus-square-o"></i> Désactiver
                                                    </a>
                                                </li>
                                            <?php }else{ ?>
                                              <li>
                                                    <a href="<?php echo site_url('users/activate/' . $user->user_id); ?>"
                                                       onclick="return confirm('Voulez vous activer cet utilisateur ?');">
                                                        <i class="fa fa-check-square-o"></i> Activer
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php //if (false) { ?>
                                                <li>
                                                <!--
                                                    <a href="<?php echo site_url('users/delete/' . $user->user_id); ?>"
                                                       onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                                        <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                                    </a>
                                                    -->
                                                    <a onclick="modaldel(<?php echo $user->user_id ?>)"><i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?></a>
                                                </li>
                                            <?php //} ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>


<div class="espace" style="padding: 10px 0;"></div>
<div class="clearfix"></div>
    </div>
</div>
<script>
function modaldel(id){
   // modal_remove_user
   
        
        $('#modal-placeholder').load("<?php echo site_url('users/ajax/modal_users_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {
                users: id 
            });
      
   
}
</script>
