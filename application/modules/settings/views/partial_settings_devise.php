	<?php
$db = $this->load->database('default');
$this->load->model('devises/mdl_devises');

//$query = $this->db->query('SELECT * FROM  `ip_devises` ')->get()->result();
$devises = $this->mdl_devises->get()->result();
//$row = $query->row();
?>
<div class="tab-info">
    <?php if(rightsMultiDevises()) { ?>
        <div class="pull-left btn-group" style="padding-bottom:20px;">
			<a class="btn btn-danger btn-md" href="<?php echo site_url('devises/form'); ?>">
			<!--i class="fa fa-plus"></i--> <?php echo lang('new'); ?></a>
		</div>
    <?php } ?>
    <div class="table-responsive">
        <table class="table table-striped" style="margin-bottom: 45px;">
            <thead>
            <tr>
                <th><span class="text-sm"><?php echo lang('devise_label'); ?></span></th>
                <th><span class="text-sm"><?php echo lang('devise_symbole'); ?></span></th>
                <th><span class="text-sm"><?php echo lang('taux'); ?></span></th>
                <th><span class="text-sm"><?php echo lang('currency_symbol_placement'); ?></span></th>
                <th><span class="text-sm"><?php echo lang('tax_rate_decimal_places'); ?></span></th>
                <th><span class="text-sm"><?php echo lang('thousands_separator'); ?></span></th> 
				<th style="width:50px;"></th>
            </tr>
            </thead>

            <tbody>
            <?php 
            $cnt = 0;
            foreach ($devises as $devise) { ?>
                <tr>
                    <td><?php echo $devise->devise_label; ?></td>
                    <td><?php echo $devise->devise_symbole; ?></td>
                    <td><?php echo $devise->taux; ?></td>
                    <td><?php if($devise->symbole_placement == "before") echo "Avant le montant"; else echo "Après le montant"; ?></td>
                    <td><?php echo $devise->number_decimal; ?></td>
                    <td><?php if($devise->thousands_separator == "") echo "Aucun"; else echo "Espace"; ?></td>
                    
                    <td style="width:50px;">
                        <a href="<?php echo site_url('devises/form/' . $devise->devise_id); ?>"
                           title="<?php echo lang('edit'); ?>"><i class="fa fa-edit fa-margin"></i></a>
                        <a href="<?php echo site_url('devises/delete/' . $devise->devise_id); ?>"
                           title="<?php echo lang('delete'); ?>" <?php if($cnt == 0) echo 'style="display:none;"'; ?>
                           onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');"><i
                                class="fa fa-trash-o fa-margin"></i></a>
                    </td>
                </tr>
            <?php 
            $cnt++;
            } ?>
            </tbody>
        </table>
    </div>