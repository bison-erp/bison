<?php
$db = $this->load->database('default');
$this->load->model('groupes_users/mdl_groupes_users');

//$query = $this->db->query('SELECT * FROM  `ip_devises` ')->get()->result();
$groupes_users = $this->mdl_groupes_users->get()->result();

$users = $this->db->get('ip_users')->result();
//$row = $query->row();
?>
<!--<pre>
<?php
foreach ($groupes_users as $qu) {
    // print_r($qu);
}
?>
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
		  <!--debut Depot-->
        <div class="col-md-12 bg-light-warning-k">
		
            <div id="headerbar">
				<div class="content-heading">
					<div class="portlet-title left-title title-light-warning">
						<div class="caption font-dark-sunglo">
							<span class="caption-subject bold med-caption dark">
								<?php echo 'Dépôt'; ?>
							</span>
						</div>
					</div>
				</div>
            </div>
			<div class="col-xs-12 col-md-6">
				<div class="portlet-toolbar" style="display: inline-block;">
					<div class="pull-left btn-group">
						<a class="btn btn-danger btn-md" href="<?php echo site_url('depot/form'); ?>">
							<?php echo lang('new'); ?>
						</a>
					</div>
				</div>	
			</div>		
				<div class="col-xs-12 col-md-6">
					<div class="espace" style="padding: 10px 0;"></div>
							<div class="form-group form-dlc">
							
								<label for="dlc" class="form-check-label">
									<?php echo 'DLC' ?>
								</label>
								<div class="btn-group form-dlc" data-toggle="buttons">
									<label class="btn btn-default btn-on-dlc btn-sm ">
									<input type="radio" value="1" class="btn-on-dlc" ><?php echo lang('oui')?></label>
									<label class="btn btn-default btn-off btn-sm ">
									<input type="radio" value="0" class="btn-off-dlc" ><?php echo lang('non')?></label>
								</div>
								<input type="hidden" id="dlc" name="settings[with_dlc]" value="<?php  echo $this->mdl_settings->setting('with_dlc') ?>">
							</div>     
				</div>   
			 
<div class="espace" style="padding: 10px 0;"></div>
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th><?php echo 'Nom dépôt' ?></th> 
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        foreach ($mdl_depot as $groupe_option) {
                            ?>
                            <tr>
                                <td><?php echo $groupe_option->libelle; ?></td>
                                 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
		  <!--fin Depot-->
		  
          <!--debut group option-->
<div class="espace" style="padding: 10px 0;"></div>
        <div class="col-md-12 bg-light-success-k" style="margin: 25px 0 50px;">
            <div id="headerbar">
				<div class="content-heading">
					<div class="portlet-title left-title title-light-success">
						<div class="caption font-dark-sunglo">
							<span class="caption-subject bold med-caption dark">
								<?php echo 'Group option'; //lang('users'); ?>
							</span>
						</div>
					</div>
				</div>
            </div>
            
			<div class="portlet-toolbar" style="display: inline-block;">
				<div class="pull-left btn-group">
                <a class="btn btn-danger btn-md" href="<?php echo site_url('group_option/form'); ?>">
					<?php echo lang('new'); ?>
				</a>
				</div>
			</div>
				
<div class="espace" style="padding: 10px 0;"></div>
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th><?php echo lang('name'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($group_options as $group_option) {
                            ?>
                            <tr>
                                <td><?php echo $group_option->name; ?></td>                                                  
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
</div>
		  <!--fin group option-->

 
  <!--debut attributs-->
  <div class="col-md-12 bg-light-warning-k">
		
		<div id="headerbar">
			<div class="content-heading">
				<div class="portlet-title left-title title-light-warning">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark">
							<?php echo 'Attributs'; ?>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-toolbar" style="display: inline-block;">
			<div class="pull-left btn-group">
				<a class="btn btn-danger btn-md" href="<?php echo site_url('attributs/form'); ?>">
					<?php echo lang('new'); ?>
				</a>
			</div>
		</div>
<div class="espace" style="padding: 10px 0;"></div>
		<div class="table-responsive">
			<table class="table table-striped">

				<thead>
					<tr>
						<th><?php echo "Nom d'attribut" ?></th> 					
						<th><?php echo "Valeur" ?></th> 
					</tr>
				</thead>

				<tbody>
					<?php 
					foreach ($mdl_option_attribut as $family) {
						?>
						<tr>
								<td><?php echo $family->name; ?></td>
                                <td><?php echo $family->valeur; ?></td>
						</tr>
						<?php
					}
					?>
				</tbody>

			</table>
		</div>
	</div>
	  <!--fin attributs-->


    </div>
</div>

<script>
$('.btn-on-dlc').click(function() {
  $('#dlc').val('1');
  
});
$('.btn-off-dlc').click(function() {
  $('#dlc').val('0');
  
});

$( document ).ready(function() {
	
if ( $('#dlc').val() == '0'){
	$( ".btn-off-dlc" ).addClass('active');
}	
if ( $('#dlc').val() == '1'){
	$( ".btn-on-dlc" ).addClass('active');
}  

});
</script>

