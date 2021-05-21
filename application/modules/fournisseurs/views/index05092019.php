<?php
//rebrique fournisseur: selon les droit données
$sess_fournisseur_add = $this->session->userdata['fournisseur_add'];
$sess_fournisseur_del = $this->session->userdata['fournisseur_del'];
$sess_fournisseur_index = $this->session->userdata['fournisseur_index'];
?><div id="headerbar" style=" margin-top:-3%">

    <?php if ($sess_fournisseur_add == 1) {?>
    <div class="pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('fournisseurs/form'); ?>"><i class="fa fa-plus"></i>
            <?php echo lang('new'); ?></a>
    </div>
    <?php }?>
    <div class="pull-right">
        <?php echo pager(site_url('fournisseurs/index'), 'mdl_fournisseurs'); ?>

    </div>
</div>
<br><br>
<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts');?>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="table-responsive">
                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th><?php echo lang('raison_social_fournisseur'); ?></th>
                                <th><?php echo lang('adresse_fournisseur'); ?></th>
                                <th><?php echo lang('site_web_fournisseur'); ?></th>
                                <th><?php echo lang('mail_fournisseur'); ?></th>
                                <th><?php echo lang('tel_fournisseur'); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($fournisseurs as $fournisseur) {?>
                            <tr>
                                <td><?php echo $fournisseur->raison_social_fournisseur; ?></td>
                                <td><?php echo $fournisseur->adresse_fournisseur . ' ' . $fournisseur->code_postal_fournisseur . ' ' . $fournisseur->ville_fournisseur . ', ' . $fournisseur->pays_fournisseur; ?>
                                </td>
                                <td><?php echo $fournisseur->site_web_fournisseur; ?></td>
                                <td><?php echo $fournisseur->mail_fournisseur; ?></td>
                                <td><?php echo $fournisseur->tel_fournisseur; ?></td>


                                <td>
                                    <?php if ($sess_fournisseur_add == 1) {?>
                                    <a href="<?php echo site_url('fournisseurs/form/' . $fournisseur->id_fournisseur); ?>"
                                        title="<?php echo lang('edit'); ?>"><i
                                            class="fa fa-edit fa-margin"></i></a><?php }?>
                                    <?php if ($sess_fournisseur_del == 1) {?>
                                    <a href="<?php echo site_url('fournisseurs/delete/' . $fournisseur->id_fournisseur); ?>"
                                        title="<?php echo lang('delete'); ?>"
                                        onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');"><i
                                            class="fa fa-trash-o fa-margin"></i></a><?php }?>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>