<style>
.log_success {
    color: #3699FF;
}

.log_warning {
    color: #FFA800;
}

.log_danger {
    color: #F64E60;
}
.log_success span.fa.fa-user.img-circle {
    color: #ffffff!important;
    background-color: #3699FF!important;
}
.log_warning span.fa.fa-user.img-circle {
    color: #ffffff!important;
    background-color: #F64E60!important;
}
.log_danger span.fa.fa-user.img-circle {
    color: #ffffff!important;
    background-color: #F64E60!important;
}
</style>
<br />

<table class="table table-condensed table-striped " style="margin-top: 7px; width: 100%;  table-layout: fixed;">
    <tr>
        <th style="text-align:left;"><?php echo lang('user'); ?></th>
        <th><?php echo lang('date'); ?></th>
        <th><?php echo lang('field_description'); ?></th>
        <th style="width:150px;text-align:right;"><?php echo lang(ip_adress); ?></th>


    </tr>
    <?php
$path = base_url() . 'uploads/' . strtolower($this->session->userdata('licence')) . '/photos_users/';
$users_log = $this->db->get('ip_users')->result();
foreach ($users_log as $user_log) {
    $image_user[$user_log->user_id] = '<span align="center"  class="fa fa-user img-circle" style="width: 25px; height:25px;line-height:25px;background:#596572;padding: 0px;color: #DDD; "></span>';

    if ($user_log->user_avatar != "") {
        $statut = getHTTPStatus($path . $user_log->user_avatar);
        if ($statut['http_code'] == 200) {
            $image_user[$user_log->user_id] = '<img  class="img-circle fa fa-user" src="' . $path . $user_log->user_avatar . '" style="width: 25px; height:25px;line-height:25px;  padding: 0px;  background-color: #fff; color:#999;  border: 1px solid #ddd;">';
        }
    }
}
if (!empty($logs)) {
    foreach ($logs as $log) {
        ?>
    <tr class="<?php echo $log['class']; ?>">
        <td style="text-align:left;">
            <span style="padding: 0 5px;" class="image_user">
                <?php echo $image_user[$log['infos']->user_id]; ?>
            </span>
            <?php echo $log['infos']->user_name; ?></td>
        <td>
            <?php
$dt = $log['infos']->log_date;
        $dte = explode(' ', $dt);
        $dted = explode('-', $dte[0]);
        // print_r($dted);
        echo $dted[2] . '/' . $dted[1] . '/' . $dted[0] . ' ' . $dte[1];
        ?>
        </td>
        <td><?php echo $log['message2']; ?></td>
        <td style="width:150px;text-align:right;"><?php echo $log['infos']->log_ip; ?></td>
    </tr>
    <?php }?>
    <?php }?>
</table>