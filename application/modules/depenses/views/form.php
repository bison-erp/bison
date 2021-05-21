<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
    rel="stylesheet" type="text/css">
<style>
.datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
    background: #eee;
    cursor: pointer;
    border-radius: 4px;
}  
.datepicker .active {
    background-color: #4B8DF8 !important;
    background-image: none !important;
    filter: none !important;
    border-radius: 4px;
} 
/*input.form-control[readonly] {
    background: #b0b5bb91 !important;
    color:black  !important;
}*/
</style>
<?php 
  /*   $this->load->helper('url');
     $this->load->library('zip');
     ob_end_clean();

     header("Content-Type: application/zip");
     $filepath1 = './uploads/9922/backup/20201215_074133.sql';
   //  $filepath1 = './uploads/8618/backup/20201211_105257.sql';

     $this->zip->read_file($filepath1);
     $filename = "backup.zip";
     header("Content-Disposition: attachment; filename=". pathinfo($filename , PATHINFO_BASENAME));
     header("Content-Length: " . filesize($filename ));
     readfile($fileName);
     $this->zip->archive(FCPATH.'./uploads/backup_dbs/'.$filename);
   //  $this->zip->download($filename);
   */
$param_offset = 0;
$params = array_slice($this->uri->rsegment_array(), $param_offset);?>
<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div id="headerbar-index">
	<?php $this->layout->load_view('layout/alerts');?>
</div>
<div id="content">   
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column" style="padding-top: 10px;">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark">
                                <?php if ($this->mdl_depenses->form_value('id_depense')): ?>
                                <?php echo lang('edit_expense'); ?>&nbsp;
                                #<?php echo $this->mdl_depenses->form_value('id_depense'); ?>
                                <?php else: ?>
                                <?php echo lang('new_depense'); ?>
                                <?php endif;?>
					</span>
                </div>
            </div>
			<div class="portlet-toolbar">
				<?php $this->layout->load_view('layout/header_buttons');?>
			</div>
		</div>
<div class="portlet-body">

			<div class="row">
				<div class="col-lg-6">
					<div class="portlet light formulaire first">
						<div class="row card-row form-row">
							<div class="col-lg-6 col-sm-6 col-xl-12">
								<div class="form-group select-search-input has-info">
                                    <label for="form_control_1"><?php echo lang('num_facture_depense'); ?><span class="text-danger"> *</span></label>
                                    <input value="<?php echo $this->mdl_depenses->form_value('num_facture'); ?>" type="text" class="form-control form-control-lg form-control-light" id="num_facture" name="num_facture">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>  
                            <input type="hidden" id="id_first" value="0" >
                                <input type="hidden" id="id_user" name="id_user" value="<?php echo $this->session->userdata['user_id'] ?>">
                            <div class="col-lg-6 col-sm-6 col-xl-12">  
                                <div class="form-group select-search-input has-info ">
                                    <label for="form_control_1"><?php echo lang('Fournisseurs'); ?><span class="text-danger"> *</span></label>
                                        <input style="width: 100%;" readonly="" value="<?php 
                                        if( $by_fournisseur){
                                        if( $by_fournisseur[0]->nom){
                                            echo($by_fournisseur[0]->nom . ' ' . $by_fournisseur[0]->prenom);
                                        }else{
                                            echo($by_fournisseur[0]->raison_social_fournisseur);
                                        }
                                    }
                                       ?>" autocomplete="off" type="text"  id="sel_fournisseur_id"  class="form-control form-control-lg form-control-light form-width-input" >
                                                
                                        <button id="search_client" type="button" class="btn btn-success btn-select-client fournisseur">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                        <div class="form-control-focus"></div>
                                    <input type='hidden'  id="fournisseur_id" name="id_fournisseur" value="<?php
                                       if( $by_fournisseur){
                                    echo  $by_fournisseur[0]->id_fournisseur; 
                                       }
                                    ?> ">     
                                </div>                             
                            </div> 
						 
                        </div>
						<div class="row card-row form-row">
                        <div class="col-lg-6 col-sm-6 col-xl-12">
								<div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('date_facture'); ?><span class="text-danger"> *</span></label>
										<div class="input-group">
                                    <?php
if (count($params) > 2) {
    ?>
                                    <input name="date_facture" id="date_facture" class="form-control form-control-lg form-control-light datepicker" value="<?php
if ($this->mdl_depenses->form_value('date_facture')) {
        echo date_from_mysql($this->mdl_depenses->form_value('date_facture'), 1);
    } else {       
        echo date("d/m/Y");
    }
    ?>">


                                    <?php } else {?>
                                    <input name="date_facture" id="date_facture" class="form-control form-control-lg form-control-light datepicker" value="<?php echo date("d/m/Y") ?>">
                                    <?php }?>
											<span class="input-group-addon">
												<i class="fa fa-calendar fa-fw"></i>
											</span>
										</div>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xl-12">
								<div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('date_due'); ?><span class="text-danger"> *</span></label>
										<div class="input-group">
                                    <?php
$param_offset = 0;
$params = array_slice($this->uri->rsegment_array(), $param_offset);
if (count($params) > 2) {

    ?>
                                    <input name="date_due" id="date_due" class="form-control form-control-lg form-control-light datepicker" value="<?php
if ($this->mdl_depenses->form_value('date_due')) {
        echo date_from_mysql($this->mdl_depenses->form_value('date_due'), 1);
    } else {

        echo date("d/m/Y");
    }
    ?>">
                                    <?php } else {?>
                                    <input name="date_due" id="date_due" class="form-control form-control-lg form-control-light datepicker" value="<?php echo date("d/m/Y") ?>">
                                    <?php }?>
											<span class="input-group-addon">
												<i class="fa fa-calendar fa-fw"></i>
											</span>
										</div>
                                    <div class="form-control-focus"></div>
                                </div>

                            </div>
							
                        </div> 
						<div class="row card-row form-row">
							<div class="col-lg-3 col-sm-3 col-xl-12">
								<div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('montant_ht'); ?><span class="text-danger"> *</span></label>
                                    <input name="montant_facture" id="montant_facture" class="form-control form-control-lg form-control-light element"
                                        value="<?php echo $this->mdl_depenses->form_value('montant_facture'); ?>">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-xl-12">                           
								<div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('tva_pdf2'); ?><span class="text-danger"> *</span></label>
                                    <select class="element form-control form-control-lg form-control-light " name="id_rate" id="id_rate">
                                       <?php  foreach ($mdl_tax_ratess as $mdl_tax_rates) {?>
                                        <option value="<?php echo $mdl_tax_rates->tax_rate_id; ?>"
                                            <?php if ($this->mdl_depenses->form_value('id_rate') == $mdl_tax_rates->tax_rate_id) {?>selected="selected"
                                            <?php }?>><?php echo ($mdl_tax_rates->tax_rate_percent); ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-xl-12">  
								<div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('default_item_timbre'); ?></label>
                                    <input name="droit_timbre" id="droit_timbre" class="form-control form-control-lg form-control-light element"
                                        value="<?php
                                        if ($this->mdl_depenses->form_value('id_depense')){
                                            echo $this->mdl_depenses->form_value('droit_timbre');
                                        }else{
                                            echo $this->mdl_settings->setting('default_item_timbre');
                                        }
                                        ; ?>">
                                    <div class="form-control-focus"></div>
                                </div>               
                            </div>
                      
                            <div class="col-lg-3 col-sm-3 col-xl-12 has-info pro-part">
									<div class="form-group has-info">
										<label for="form_control_1"><?php echo lang('ret_source'); ?></label><br>
											<!--select name="timbre_fiscale" class="form-control form-control-md form-control-light" id="timbre_fiscale">
											<option value="0" <!?php if ($this->mdl_clients->form_value('timbre_fiscale') == 0) {
											echo "selected";
												}
											?>><!?php echo lang('non') ?></option>
											<option value="1" <!?php if (($this->mdl_clients->form_value('timbre_fiscale') == 1) || ($this->mdl_clients->form_value('timbre_fiscale') == '')) {
											echo "selected";
											}
											?>><!?php echo lang('oui') ?></option>
										   </select-->
                                        <div class="btn-group societe" style="margin-top: 4px;" data-toggle="buttons">
                                        <label class="btn btn-default btn-on btn-sm element">
                                        <input type="radio" value="0"><?php echo lang('yes') ?></label>
                                        <label class="btn btn-default btn-off btn-sm element">
                                        <input type="radio" value="1"><?php echo lang('no') ?></label>
                                        </div>
                                        <input name="ret_source" type='hidden' id="ret_source" value="<?php
                                            if ($this->mdl_depenses->form_value('ret_source')){
                                                echo $this->mdl_depenses->form_value('ret_source');
                                            }else{
                                                echo 0;
                                            }
                                            ; ?>">
									</div>
									<div class="form-control-focus"></div>
							</div>
                                          
                   
							 
                       
                        </div> 
                        <div class="row card-row form-row" style="display:none">
                            <!--<div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="md-checkbox">
                                <?php //if($this->mdl_depenses->form_value('retained_source')==0){ ?>
                                    <input type="checkbox" checked value="0" name="ret" id="ret" class="md-check">
                                <?php // }else{ ?>   
                                    <input type="checkbox" value="1" name="ret" id="ret" class="md-check">

                                <?php  //} ?>  
                                        <label for="ret">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>                                     
                                        <?php //echo lang('retained_source'); ?>
                                        </label>
                                </div>
                            </div> -->
 
                            
                        </div>                          
                        <div class="row card-row form-row file"> 
                            <div class="col-lg-6 col-sm-6 col-xl-12">  
                                <div class="form-group select-search-input has-info ">
                                    <label for="form_control_1"><?php echo lang('categorie'); ?><span class="text-danger"> *</span></label>
                                        <input style="width: 100%;" readonly="" value="<?php echo  $by_categorie[0]->designation; ?>" autocomplete="off" type="text" id='select_cat'class="form-control form-control-lg form-control-light form-width-input" >
                                                
                                        <button id="search_categorie" type="button" class="btn btn-success categorie_div">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                        <div class="form-control-focus"></div>
                                    <input type='hidden' name="categorie_id" id="categorie_id" value="<?php echo $by_categorie[0]->id_categorie_fournisseur; ?> ">     
                                </div>                             
                            </div> 
                            <div class="col-lg-6 col-sm-6 col-xl-12">
                                <div class="imgdown">
                                    <?php
            if (count($file) > 0) {

                foreach ($file as $key => $val) {
                    $dir_path = base_url() . 'uploads/' . strtolower($this->session->userdata['licence']) . '/fileproduct/' . $val->name_file;

                    ?>
                                    <ul class="list-group">
                                        <li class="col-md-6 list-group-item lidel<?php echo $val->id_file_depense ?>">
                                            <a href="<?php echo $dir_path ?>" download> <img onclick='openfile('
                                                    <?php echo $dir_path ?>')' height="100" width="150"
                                                    src="<?php echo $dir_path ?> "></a>
                                            <button onclick=btndel(<?php echo $val->id_file_depense ?>)
                                                class="btn btn-xs btn-danger" type="button">
                                                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('delete'); ?>
                                            </button>
                                        </li>
                                    </ul>
                                    <?php }?>
                                    <div class="col-md-12">
                                        <label for="form_control_1"><?php echo lang('download_invoice'); ?></label>
                                        <input id="myFile" type="file" name="images[]" multiple>
                                    </div>
                                    <?php } else {?>
                                    <div class="col-md-12">
                                        <label for="form_control_1"><?php echo lang('download_invoice'); ?></label>
                                        <input id="myFile" type="file" name="images[]" multiple>
                                    </div>
                                    <?php }?>                       
                                </div>
                            </div>
                        </div>   
                        <div class="row card-row form-row">
                            <div class="col-lg-12 col-sm-12 col-xl-12">
                                    <div class="form-group  has-info">
                                        <label for="form_control_1"><?php echo lang('note'); ?></label>
                                            <textarea name="note" rows="2" id="note" class="form-control" style="width: 100%;padding: 5px 10px;height:80px;"><?php echo $this->mdl_depenses->form_value('note'); ?></textarea>
                                            <div class="form-control-focus"></div>
                                    </div>
                            </div>
                        </div>   

						
                    </div>
                </div>
           
		<div class="col-lg-6 ">
		<div class="portlet light formulaire">
                    <div class="row card-row form-row">
                                <div class="col-lg-6 col-sm-6 col-xl-12">
                                    <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('all_statue');?></label>
                                            <select class="form-control form-control-lg form-control-light" name="status_id" id="status_id">
                                            <?php 
                                            $all_statues = [0 => lang('paid'), 1 => lang('overdue')];
                                            foreach ($all_statues as $key => $value) {?>
                                                <option value="<?php echo $key; ?>"
                                                    <?php if ($this->mdl_depenses->form_value('status_id') == $key) {?>selected="selected"
                                                    <?php }?>><?php echo ($value); ?>
                                                </option>
                                                <?php }?>
                                            </select>
                                         <div class="form-control-focus"></div>
                                    </div>
                                </div>							
                                <div class="col-lg-6 col-sm-6 col-xl-12 imp">
                                    <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('payed');?></label>
                                            <select class="form-control form-control-lg form-control-light" name="divussion_ch" id="divussion_ch">
                                            <?php 
                                            $paiements = [0 => lang('one_off_payment'), 1 => lang('payment_in_installments')];
                                            foreach ($paiements as $key => $value) {?>
                                                <option value="<?php echo $key; ?>"
                                                    <?php if ($this->mdl_depenses->form_value('divussion_ch') == $key) {?>selected="selected"
                                                    <?php }?>><?php echo ($value); ?>
                                                </option>
                                                <?php }?>
                                            </select>
                                        <div class="form-control-focus"></div>
                                    </div>  
                                </div>  
                   </div> 




 <div class='nbre imp'>				
                <div class="row card-row form-row">
							<div class="col-lg-6 col-sm-6 col-xl-12">
								<div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('payed'); ?><span class="text-danger"> *</span></label>
                                    <select class="form-control form-control-lg form-control-light id_moyenpayement_div" name="id_moyenpayement" id="id_moyenpayement">
                                       <?php foreach ($id_moyenpayements as $id_moyenpayement) {?>
                                        <option value="<?php echo $id_moyenpayement->payment_method_id; ?>"
                                            <?php if ($this->mdl_depenses->form_value('id_moyenpayement') == $id_moyenpayement->payment_method_id) {?>selected="selected"
                                            <?php }?>><?php echo ($id_moyenpayement->payment_method_name); ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                    <div class="form-control-focus"></div>
                                </div>
							</div>
							<div class="col-lg-6 col-sm-6 col-xl-12">
								<div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('date_paiement'); ?><span class="text-danger"> *</span></label>
										<div class="input-group">
                                    <?php
									$param_offset = 0;
									$params = array_slice($this->uri->rsegment_array(), $param_offset);
									if (count($params) > 2) {

									?>
                                    <input name="date_paiement" id="date_paiement" class="form-control form-control-lg form-control-light datepicker" value="<?php
					if ($this->mdl_depenses->form_value('date_paiement')) {
        echo date_from_mysql($this->mdl_depenses->form_value('date_paiement'), 1);
    } else {

        echo date("d/m/Y");
    }
    ?>">
                                    <?php } else {?>
                                    <input name="date_paiement" id="date_paiement" class="form-control form-control-lg form-control-light datepicker" value="<?php echo date("d/m/Y") ?>">
                                    <?php }?>
											<span class="input-group-addon">
												<i class="fa fa-calendar fa-fw"></i>
											</span>
								</div>
                                    <div class="form-control-focus"></div>
                            </div>

                        </div>
                        </div>
                        <div class="row card-row form-row">
                            <div class="col-lg-6 col-sm-6 col-xl-12 numero_cheque">
								<div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('num_cheq'); ?></label>
                                    <input type="text" class="form-control form-control-lg form-control-light" name="numero_cheque"
                                        value="<?php echo $this->mdl_depenses->form_value('numero_cheque'); ?>" id="numero_cheque">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>							
                            
                           <!-- <div class="col-lg-6 col-sm-6 col-xs-12" style="display:none">
                                        <div class="md-checkbox">
                                        <?php //if($this->mdl_depenses->form_value('divussion_ch')==0){ ?>
                                            <input type="checkbox"  value="0" name="divus_ch" id="divus_ch" class="md-check">
                                        <?php // }else{ ?>   
                                            <input type="checkbox" checked value="1" name="divus_ch" id="divus_ch" class="md-check">

                                        <?php  //} ?>  
                                                <label for="divus_ch">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>                                     
                                                <?php //echo lang('divussion_ch'); ?>
                                                </label>
                                        </div>
                                    </div> 
                                    <input type="hidden" value="<?php //echo $this->mdl_depenses->form_value('divussion_ch') ?>" name="divussion_ch" id="divussion_ch">
           
                           </div>-->
			
                </div>
            </div>			
            <table class="table table-condensed table-striped">

<tbody>
<tr>
    <td><?php echo lang('total_a_payer_pdf'); ?></td>
    <td>
    <input type='hidden' name="net_payer_depense" id="net_payer_depense" class="form-control form-control-lg form-control-light"
    value="<?php echo $this->mdl_depenses->form_value('net_payer_depense'); ?>">
    <span id="sp_net_payer_depense"><?php echo $this->mdl_depenses->form_value('net_payer_depense'); ?></span>

    </td>
</tr>
<tr>
    <td><?php echo lang('montant_tva'); ?></td>
    <td>
    <input type='hidden' name="montant_tva" id="montant_tva" class="form-control form-control-lg form-control-light element"
    value="<?php echo $this->mdl_depenses->form_value('montant_tva'); ?>">
    <span id="sp_montant_tva"><?php echo $this->mdl_depenses->form_value('montant_tva'); ?></span> </td>
</tr>
<tr>
    <td><?php echo (lang('amount').' '. lang('ttc')); ?></td>
    <td> <span id="sp_net_payer"><?php echo $this->mdl_depenses->form_value('net_payer'); ?></span>

<input  type='hidden' name="net_payer" id="net_payer" class="form-control form-control-lg form-control-light"
value="<?php echo $this->mdl_depenses->form_value('net_payer'); ?>">
    </td>
</tr>
<tr>
<td>
<label for="form_control_1"><?php echo lang('retained_source'); ?></label>
</td>
<td>
<span id="sp_id_retained_source"><?php echo $this->mdl_depenses->form_value('id_retained_source'); ?></span>

<input type='hidden' name="id_retained_source" id="id_retained_source" class="form-control form-control-lg form-control-light"
value="<?php echo $this->mdl_depenses->form_value('id_retained_source'); ?>">

</td>
</tr>
<tr>
<td>
<label for="form_control_1"><?php echo lang('mnt_rs'); ?></label>
</td>
<td>
<span id="sp_mnt_rs"><?php echo $this->mdl_depenses->form_value('mnt_rs'); ?></span>

<input type='hidden' name="mnt_rs" id="mnt_rs" class="form-control form-control-lg form-control-light"
value="<?php echo $this->mdl_depenses->form_value('mnt_rs'); ?>">     


</td>                                    
</tr> 
<tr>
<td>
<label for="form_control_1"><?php echo lang('balance'); ?></label>
</td>
<td>
<span id="sp_rest"><?php echo $this->mdl_depenses->form_value('rest'); ?></span>

<input type='hidden' name="rest" id="rest" class="form-control form-control-lg form-control-light"
    value="<?php echo $this->mdl_depenses->form_value('rest'); ?>">

</td>                                    
</tr> 
</tbody></table>
                <div class="row card-row form-row imp">
					<div class="col-lg-4 col-sm-4 col-xl-12 several_times">
                        <div class="form-group has-info">
                            <label for="form_control_1"><?php echo lang('pay_several_times'); ?></label>                            
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-xl-12 several_times">
                        <div class="form-group has-info">
                    <input type="text" class="form-control form-control-lg form-control-light" value="<?php echo count($montant_depense) ?>" id="diffusion" name="diffusion">
                            <div class="form-control-focus"></div>
                        </div>
                    </div> 
					
                   
				   
                    <div class="col-lg-12 col-sm-12 col-xl-12 several_times">
                   
						<div class="diffusionclass">
                        <?php  $js=0;
                        //var_dump(count($montant_depense));
                        //return die('511');
                        ?>
							<?php if (count($montant_depense) > 0) {foreach ($montant_depense as $value) {?>
                            <div class="row block<?php echo $js+1 ?>">
                            <div class='col-md-3'>    
                            <div class="form-group has-info">   
                            <label for="form_control_1"><?php echo lang('due_date');?><?php echo ' '+$js+1 ?></lablel>                       
                                    <select class="form-control form-control-lg form-control-light id_moyenpayement_div" name="moyenpayement[]" onchange="getval(<?php echo $js+1 ?>)" id="moy<?php echo $js+1 ?>" id="id_moyenpayement">
                                        <?php foreach ($id_moyenpayements as $id_moyenpayement) {?>
                                        <option value="<?php echo $id_moyenpayement->payment_method_id; ?>"
                                            <?php if ($value->moyenpayement == $id_moyenpayement->payment_method_id) {?>selected="selected"
                                            <?php }?>><?php echo ($id_moyenpayement->payment_method_name); ?>
                                        </option>
                                        <?php }?>
                                    </select>  
                           </div> 
                           </div> 
                           <?php if($value->num_cheque){ ?>
                           <div class='col-md-3 chq<?php echo $js+1?>' style='display:block'> 
                           <?php  }else{?>
                            <div class='col-md-3 chq<?php echo $js+1?>' style='display:none'>                             
                            <?php  }?>
                            <div class="form-group has-info " style=" "> 

                                <div class='form-group has-info ' style=' '> 
                                <label for="form_control_1"><?php echo lang('num_cheq');?>
                                        <input value='<?php echo $value->num_cheque ?>' class='num_cheque<?php echo $js+1?> form-control form-control-lg form-control-light' name='num_cheque[]' style='' ></label>
                                </div>
                           </div>
                           </div>
                           <div class='col-md-3'>      
                                <div class="form-group has-info " style=" "> 

                                    <div class='form-group has-info ' style=' '> 
                                        <label for="form_control_1"><?php echo lang('montant');?>
                                            <input value='<?PHP echo $value->montant; ?>' onkeyup='mntchange(<?PHP echo $js+1; ?>)' class='mnt<?php echo $js+1; ?> form-control form-control-lg form-control-light' name='valdifussuion[]'
                                                style=''></label>
                                    </div> 
                                </div> 
                           </div> 
                           <div class='col-md-3'>     
                           <div class="form-group has-info " style=" ">  
                                
                                        <label for="form_control_1">Date
                                                <div class="input-group">           
                                                            <input value='<?PHP if($value->date_encaissement){
                                                                echo date_from_mysql(($value->date_encaissement), 1);
                                                                } ?>' class='form-control form-control-lg form-control-light datepicker' name='date_encaissement[]'
                                                                style=''></label><span class="input-group-addon"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i></span>
                                                    
                                            </div>
                             
                               </div>
                            </div>
                            </div>
                       </div>
                       <?php  $js++; ?>
                        <?php }}  ?>
                    </div>
					</div>      
                </div>     
              
			   
			   
			   
			   
			   
			   
        </div>
    </div>
</div>
</div>
</div>
</form>
<script>

$('#search_categorie').click(function() {
    $('#modal-placeholder').load(
        "<?php echo site_url('categorie_fournisseur/categorie_fournisseur/modal_categorie_lookup'); ?>/" +
        Math.floor(Math.random() * 1000), {

        });
});
$('#search_client').click(function() {
    $('#modal-placeholder').load(
        "<?php echo site_url('fournisseurs/ajax/modal_fournisseur_lookup'); ?>/" +
        Math.floor(Math.random() * 1000), {

        });
});
function key() {
      if($('#id_first').val()==1){  
    if ($("#diffusion").val() != "") {
        $(".diffusionclass").empty();        
        val_mnt= ($('#net_payer_depense').val()/$("#diffusion").val()).toFixed(3);
        for (i = 1; i <= $("#diffusion").val(); i++) {
            $(".diffusionclass").append(
                " <div class='row block"+i+"'><div class='col-md-3' ><div class='form-group has-info'> <label for='form_control_1'><?php echo lang('due_date') ?>"+' '+i+"</span></label><select onchange='getval("+i+")' id='moy"+i+"' class='form-control form-control-lg form-control-light' name='moyenpayement[]'><?php foreach ($id_moyenpayements as $id_moyenpayement) {?></option><option value='<?php echo $id_moyenpayement->payment_method_id; ?>'><?php echo ($id_moyenpayement->payment_method_name); ?></option><?php }?></select></div></div><div class='col-md-3 chq"+i+"'> <div class='form-group has-info ' style=' '><div class='form-group has-info'> <label for='form_control_1'><?php echo lang('num_cheq') ?></span></label> <input value=''  style='text-align:center;' class='num_cheque"+i+" form-control form-control-lg form-control-light' name='num_cheque[]' style='box-shadow: 0 0 2px #181C32; margin:0px' ></div></div></div><div class='col-md-3'> <div class='form-group has-info ' style=' '><div class='form-group has-info'> <label for='form_control_1'><?php echo lang('montant') ?></span></label> <input value='"+val_mnt+"'  style='text-align:center;' onkeyup='mntchange("+i+")' class='mnt"+i+" form-control form-control-lg form-control-light' name='valdifussuion[]' style='box-shadow: 0 0 2px #181C32; margin:0px' ></div></div></div><div class='col-md-3'><div class='form-group has-info ' style=' '><div class='form-group has-info'> <label for='form_control_1'>Date</span></label><div class='input-group'><input value='' class=' form-control form-control-lg form-control-light datepicker'   style='text-align:center;' name='date_encaissement[]' style='box-shadow: 0 0 2px #181C32; margin:0px' ><span class='input-group-addon'><i class='fa fa-calendar fa-fw' aria-hidden='true'></i></span></div></div></div></div></div>"
            );          
        }
      /*for (i = 1; i <= $("#diffusion").val(); i++) {
           // console.log('.moy'+i);          
            $('.id_moyenpayement_div').clone().appendTo('.moy'+i);
            $('.moy'+i).removeClass('.id_moyenpayement_div').addClass('.id_moyenpayement_div'+i);                  
        }*/
      
    } else {
        $(".diffusionclass").empty();
        $('#net_payer_depense').val(0);
        $("#sp_net_payer_depense").text(0);

    }
  }  
}

$("#diffusion").keyup(function() {
    key();
});

function btndel(e) {
    $('.lidel' + e).remove();
    $.ajax({
        url: '/depenses/deletefildepense/' + e,
        type: 'POST',

    });
}

$('#id_moyenpayement').change(function() {
    if ($('#id_moyenpayement').val() == 1 || $('#id_moyenpayement').val() == 6) {
        $('.numero_cheque').attr('hidden', false);
    } else {
        $('.numero_cheque').attr('hidden', true);
    }

})

if (($('#id_moyenpayement').val() == 1) || ($('#id_moyenpayement').val() == 6)) {
    $('.numero_cheque').attr('hidden', false);
} else {
    $('.numero_cheque').attr('hidden', true);
}

$(".element").keyup(function() {
    var montant_facture = $("#montant_facture").val();
    var droit_timbre = $("#droit_timbre").val();
    var montant_tva = $("#montant_tva").val();
    var id_rate=$("#id_rate option:selected" ).text();
    var net_payer = Number($("#montant_facture").val()) +
        Number($("#montant_tva").val());
    $("#net_payer").val(Number(net_payer).toFixed(3));
    $("#sp_net_payer").text(Number(net_payer).toFixed(3)); 
    calclttc();
});
/*
$('#ret').change(function() {

    if ($(this).prop("checked")){
        $('.retained_source').show();
        $('#retained_source').val(0);
    }else{
        $('.retained_source').hide();
        $('#retained_source').val(1);
       $('#id_retained_source').val(1);  
    }
    calclttc();
})*/
/*
$('#divus_ch').change(function() {
    if ($('#divus_ch').prop("checked")){
    $('.nbre').show();
    $('#divussion_ch').val(1);
}else{
    $('.nbre').hide();
    $('#divussion_ch').val(0);
    $('#diffusion').val(0);
}
})

if ($('#divus_ch').prop("checked")){
    $('.nbre').show();
    $('#divussion_ch').val(1);
}else{
    $('.nbre').hide();
    $('#divussion_ch').val(0);
    $('#diffusion').val(0);
}

if ($('#ret').prop("checked")){
    $('.retained_source').show();
    $('#retained_source').val(0);
}else{
    $('.retained_source').hide();
    $('#retained_source').val(1);
    $('#id_retained_source').val(1);  
}*/
function getval(sel)
{ 
    if($('#moy'+sel+ ' option:selected').val()==1){
        $('.chq'+sel).show();
        
    }else{
        $('.chq'+sel).hide();
    }     
}

$('#id_rate').change(function() {
    // alert();
    calclttc();
})
$('#id_retained_source').change(function() {
    // alert();
    calclttc();
})

function calclttc(){
    var id_rate = $("#id_rate option:selected" ).text(); 
    var client_ids = $("input[name='client_ids[]']:checked").val();
     if($('#ret_source').val()==1){
        $('#id_retained_source').val(0);   
        $('#sp_id_retained_source').text(0);   
    }else{
        $('#id_retained_source').val($('.rt_'+parseInt(client_ids)).text().replace(' ','').trim());   
            $('#sp_id_retained_source').text($('.rt_'+parseInt(client_ids)).text().replace(' ','').trim()); 
    }
    $("#montant_tva").val(Number((id_rate/100)*Number($("#montant_facture").val())).toFixed(3));
    $("#sp_montant_tva").text(Number((id_rate/100)*Number($("#montant_facture").val())).toFixed(3));
    var net_payer = Number($("#montant_facture").val()) +
        Number($("#montant_tva").val());
    $("#net_payer").val(Number(net_payer).toFixed(3));
    $("#sp_net_payer").text(Number(net_payer).toFixed(3));
    var net_payer=$('#net_payer').val();
 
    var taux=$("#id_retained_source").val();
    if($('#ret_source').val()==0){
        $('#mnt_rs').val((net_payer*(taux/100)).toFixed(3));
        $("#sp_mnt_rs").text((net_payer*(taux/100)).toFixed(3));
    }else{ 
        $('#mnt_rs').val(0);
        $("#sp_mnt_rs").text(0);  
    }
  
  
    var total= net_payer - (net_payer*(taux/100));   
  /*  if(taux==0){
        $('.net_payer_depense_div').hide();
    }else{
        $('.net_payer_depense_div').show();
    }*/
    <?php if(!$depenses){ ?>
    $('#rest').val(0);
    $("#sp_rest").text(0);

    <?php } ?>
    $('#net_payer_depense').val((total+Number($("#droit_timbre").val())).toFixed(3));
    $("#sp_net_payer_depense").text((total+Number($("#droit_timbre").val())).toFixed(3));

}

calclttc();
 


function mntchange(i) {
   // calclttc();
   tab = 0;
   for (j = 1; j <= $("#diffusion").val(); j++) {   
     
        tab = tab + Number($('.mnt'+ j).val()); 
   }
   
   $('#rest').val((Number($('#net_payer_depense').val())-Number(tab)).toFixed(3));
   $("#sp_rest").text((Number($('#net_payer_depense').val())-Number(tab)).toFixed(3));

   if($('#rest').val()<0){
    $('#btn-submit').prop('disabled', 'disabled');   
   // $('#rest').attr("style","color:red !important"); 
    $("#sp_rest").attr("style","color:#F00 !important"); 

   }else{
    $('#btn-submit').prop('disabled', false);   
    //$('#rest').removeAttr( 'style' ); 
    $("#sp_rest").removeAttr( 'style' ); 

   }
   // $('#net_payer_depense').val(($('#net_payer_depense').val() - $('.mnt'+i).val()).toFixed(3));
} 

$("#fournisseur_id option").hide();
$("#categorie_id option").hide();

var divussion_ch= function () {
    if ($('#divussion_ch').val()==1){
     $('.several_times').show();
        $('#divussion_ch').val(1);
        $('.nbre').hide();
    }else{
     $('.several_times').hide();
        $('#divussion_ch').val(0);
     
        $('.nbre').show();
     // $('#diffusion').val(0);
    }
    key();
};

var status_ch= function () {    
    if ($('#status_id').val()==0){
        $('#divussion_ch').prop('disabled', false);
        $('.imp').show();
    //    $('#diffusion').val(0);
    }else{
        $('#divussion_ch').prop('disabled', 'disabled');
        $('.imp').hide();
    //  $('#diffusion').val(0);
    }
    key();
};
$(divussion_ch);
$(status_ch);
$('#id_first').val(1);

$('#divussion_ch').change(divussion_ch);
$('#status_id').change(status_ch);

$('.several_times').hide();
$('#divussion_ch').prop('disabled', 'disabled');
<?php if (!$this->mdl_depenses->form_value('id_depense')){ ?>
    $('#sp_id_retained_source').text(0);
    $('#id_retained_source').val(0);
<?php } ?>
$('#select_cat').val($('#select_cat').val().trim());

$('.btn-on').click(function() {
  $('#ret_source').val('0');
  calclttc();
});
$('.btn-off').click(function() {
  $('#ret_source').val('1');
  calclttc();
});
if( $('#ret_source').val()==0){
    $( ".btn-on" ).addClass('active');

}else{
    $( ".btn-off" ).addClass('active');
}
 </script>