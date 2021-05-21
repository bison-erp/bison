<div id="headerbar">
    <h1><?php echo lang('societes'); ?></h1>

    <!-- <div class="pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('societes/form'); ?>"><i
                class="fa fa-plus"></i> <?php echo lang('new'); ?></a>
    </div>-->

    <div class="pull-right">
        <?php echo pager(site_url('societes/index'), 'mdl_societes'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts');?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th><?php echo lang('raison_social_societes'); ?></th>
                    <th><?php echo lang('code_tva_societes'); ?></th>
                    <th><?php echo lang('adresse_societes'); ?></th>
                    <th><?php echo lang('site_web_societes'); ?></th>
                    <th><?php echo lang('mail_societes'); ?></th>
                    <th><?php echo lang('tel_societes'); ?></th>



                </tr>
            </thead>

            <tbody>
                <!-- <pre>
                <?php print_r($societes);?>
            </pre>-->
                <?php foreach ($societes as $societe) {?>
                <tr>
                    <td><?php echo $societe->raison_social_societes; ?></td>
                    <td><?php echo $societe->code_tva_societes; ?></td>
                    <td><?php echo $societe->adresse_societes . ' ' . $societe->code_postal_societes . ' ' . $societe->ville_societes . ', ' . $societe->pays_societes; ?>
                        <?php if (strcmp($societe->adresse_societes, '') != 1) {
    echo '<br>' . $societe->adresse2_societes . ' ' . $societe->code_postal2_societes . ' ' . $societe->ville2_societes . ', ' . $societe->pays2_societes;
}
    ?>
                    </td>
                    <td><?php echo $societe->site_web_societes; ?>
                    </td>
                    <td><?php echo $societe->mail_societes; ?></td>
                    <td><?php echo $societe->tel_societes; ?>
                        <?php if (strcmp($societe->tel2_societes, '') != 1) {
        echo '<br>' . $societe->tel2_societes;
    }
    ?></td>


                    <td>
                        <a href="<?php echo site_url('societes/form/' . $societe->id_societes); ?>"
                            title="<?php echo lang('edit'); ?>"><i class="fa fa-edit fa-margin"></i></a>
                        <!-- <a href="<?php echo site_url('societes/delete/' . $societe->id_societes); ?>"
                           title="<?php echo lang('delete'); ?>"
                           onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');"><i
                                class="fa fa-trash-o fa-margin"></i></a>-->
                    </td>
                </tr>
                <?php }?>
            </tbody>

        </table>
    </div>
</div>