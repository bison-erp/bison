<div id="headerbar">
    <h1><?php echo lang('fournisseurs'); ?></h1>

    <div class="pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('fournisseurs/form'); ?>"><i
                class="fa fa-plus"></i> <?php echo lang('new'); ?></a>
    </div>

    <div class="pull-right">
        <?php echo pager(site_url('fournisseurs/index'), 'mdl_fournisseurs'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

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
            <?php foreach ($fournisseurs as $fournisseur) { ?>
                <tr>
                    <td><?php echo $fournisseur->raison_social_fournisseur; ?></td>
                    <td><?php echo $fournisseur->adresse_fournisseur . ' ' . $fournisseur->code_postal_fournisseur . ' ' . $fournisseur->ville_fournisseur . ', ' . $fournisseur->pays_fournisseur; ?></td>
					<td><?php echo $fournisseur->site_web_fournisseur; ?></td>
                    <td><?php echo $fournisseur->mail_fournisseur; ?></td>
					<td><?php echo $fournisseur->tel_fournisseur; ?></td>
                    
                    
                    <td>
                        <a href="<?php echo site_url('fournisseurs/form/' . $fournisseur->id_fournisseur); ?>"
                           title="<?php echo lang('edit'); ?>"><i class="fa fa-edit fa-margin"></i></a>
                        <a href="<?php echo site_url('fournisseurs/delete/' . $fournisseur->id_fournisseur); ?>"
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