<?php
$db = $this->load->database('default');
$this->load->model('societes/mdl_societes');

//$query = $this->db->query('SELECT * FROM  `ip_devises` ')->get()->result();
$societes = $this->mdl_societes->get()->result();
//$row = $query->row();
?>

<div class="tab-info">

    <!-- <?php if (rightsMultiSocietes()) {?>
    <div class="pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('societes/form/'); ?>">
            <i class="fa fa-plus"></i> Nouveau</a>
    </div>
    <?php }?>-->

    <div id="content" class="table-content">

        <?php $this->layout->load_view('layout/alerts');?>

        <div class="table-responsive">
            <table class="table table-striped">

                <thead>
                    <tr>
                        <th><?php echo lang('raison_social_societes'); ?></th>
                        <th><?php echo lang('code_tva_societes'); ?></th>
                        <th><?php echo lang('site_web_societes'); ?></th>
                        <th><?php echo lang('mail_societes'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php $cnt = 0;
foreach ($societes as $societe) {?>
                    <tr>
                        <td><?php echo $societe->raison_social_societes; ?></td>
                        <td><?php echo $societe->code_tva_societes; ?></td>
                        <td><?php echo $societe->site_web_societes; ?>
                        </td>
                        <td><?php echo $societe->mail_societes; ?></td>


                        <td>
                            <a href="<?php echo site_url('societes/form/' . $societe->id_societes); ?>"
                                title="<?php echo lang('edit'); ?>"><i class="fa fa-edit fa-margin"></i></a>
                            <?php if ($cnt != 0) {?>
                            <a href="<?php echo site_url('societes/delete/' . $societe->id_societes); ?>"
                                title="<?php echo lang('delete'); ?>"
                                onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');"><i
                                    class="fa fa-trash-o fa-margin"></i></a>
                            <?php }?>
                        </td>
                    </tr>
                    <?php $cnt++;
}?>
                </tbody>

            </table>
        </div>
    </div>
</div>