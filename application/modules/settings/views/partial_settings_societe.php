<script>
next_code_adresse = 0;
function add_adresse(id) {
    //    alert("test");
    //    $("#adresses_content").append("test<br>");
    $.post('<?php echo site_url('societes/ajax/add_adresse'); ?>', {
        code_adresse: next_code_adresse,
        id_societe: id

    }, function(data) {
        $('#adresses_content').append(data);
        next_code_adresse++;
    });
}
add_adresse('1');
</script>
<?php
$db = $this->load->database('default');
$this->load->model('societes/mdl_societes');

//$query = $this->db->query('SELECT * FROM  `ip_devises` ')->get()->result();
$societes = $this->mdl_societes->get()->result();
 //$row = $query->row();
?>
<div class="tab-info">
<!--
<div id="headerbar-index" style="height:auto!important;min-height: auto;">
    <?php //$this->layout->load_view('layout/alerts');?>	
</div> 
-->
<form method="post" class="form-horizontal">
    <div id="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet light" style="margin-bottom: 0;">
						<div class="content-heading">
							<div class="portlet-title left-title">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark">
										<?php if ($this->mdl_societes->form_value('id_societes')): ?>
										<!-- #<?php echo $this->mdl_societes->form_value('id_societes'); ?>-->
										<?php echo lang('new_societes'); ?> 
										<strong><?php echo $this->mdl_societes->form_value('raison_social_societes'); ?></strong>
										<?php else: ?>
										<?php echo lang('new_societes'); ?>
										<?php endif;?>
									</span>
								</div>
							</div>
						</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('raison_social_societes'); ?></label><span class="text-danger">*</span>
                                    <input  type="text" name="raison_social_societes"
                                        id="raison_social_societes" class="form-control form-control-lg form-control-light"
                                        value="<?php echo $societe[0]->raison_social_societes; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('tax_code'); ?><span class="text-danger">*</span></label>
										<a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_tax_code'); ?>"></a>
                                    <input  type="text" name="tax_code" id="tax_code" class="form-control form-control-lg form-control-light"
                                        value="<?php  echo $societe[0]->tax_code; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('matricule_fiscale_societes') . '(' . lang('code_tva_societes') . ')'; ?><span class="text-danger">*</span></label>
                                    <a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_matricule_fisc'); ?>"></a>
										<input  type="text" name="code_tva_societes" id="code_tva_societes"
                                        class="form-control form-control-lg form-control-light"
                                        value="<?php echo $societe[0]->code_tva_societes; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('site_web_societes'); ?></label>
                                    <input type="text" name="site_web_societes" id="site_web_societes"
                                        class="form-control form-control-lg form-control-light"
                                        value="<?php  echo $societe[0]->site_web_societes; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('mail_societes'); ?><span class="text-danger">*</span></label>
                                    <input type="text" name="mail_societes" id="mail_societes" class="form-control form-control-lg form-control-light"
                                        value="<?php echo $societe[0]->mail_societes; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('n_telephone'); ?></label>
                                    <input type="text" name="tel_societes" id="tel_societes" class="form-control form-control-lg form-control-light"
                                        value="<?php echo $societe[0]->tel_societes; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('fax_societes'); ?></label>
                                    <input type="text" name="fax_societes" id="fax_societes" class="form-control form-control-lg form-control-light"
                                        value="<?php echo $societe[0]->fax_societes; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('manager_firstname'); ?></label>
                                    <input type="text" name="manager_firstname" id="manager_firstname" class="form-control form-control-lg form-control-light"
                                        value="<?php echo $societe[0]->manager_firstname; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('manager_lastname'); ?></label>
                                    <input type="text" name="manager_lastname" id="manager_lastname" class="form-control form-control-lg form-control-light"
                                        value="<?php echo $societe[0]->manager_lastname; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('manager_mobile'); ?></label>
                                    <input type="text" name="manager_mobile" id="manager_mobile" class="form-control form-control-lg form-control-light"
                                        value="<?php echo $societe[0]->manager_mobile; ?>">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('activity_area'); ?></label>
                                    <select name="activity_area"  id="activity_area" class="form-control form-control-lg form-control-light">
                                    <?php if($societe[0]->activity_area==1){ ?>
                                        <option value="0">										
										</option>
                                    	<option value="1" selected> 
										<?php echo lang('agroalimentaire'); ?>
										</option>
                                        <option value="2">
										<?php echo lang('agriculture'); ?>
										</option>
                                        <option value="3" >
										<?php echo lang('autres'); ?>
										</option>
                                    <?php }elseif($societe[0]->activity_area==2){ ?>
                                        <option value="0">										
										</option>
                                    	<option value="1"> 
											<?php echo lang('agroalimentaire'); ?>
										</option>
                                    	<option value="2" selected>
											<?php echo lang('agriculture'); ?>
										</option>
                                        <option value="3" >
											<?php echo lang('autres'); ?>
										</option>
                                    <?php }elseif($societe[0]->activity_area==3){ ?>
                                        <option value="0">										
										</option>
                                        <option value="1"> 
											<?php echo lang('agroalimentaire'); ?>
										</option>
                                        <option value="2">
											<?php echo lang('agriculture'); ?>
										</option>
                                    	<option value="3" selected>
											<?php echo lang('autres'); ?>
										</option>
                                    <?php }else{ ?>
                                        <option value="0" selected>										
										</option>
                                        <option value="1"> 
											<?php echo lang('agroalimentaire'); ?>
										</option>
                                        <option value="2">
											<?php echo lang('agriculture'); ?>
										</option>
                                        <option value="3">
											<?php echo lang('autres'); ?>
										</option>
                                    <?php } ?>
									</select>                             
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('number_employees'); ?></label>
                                    <select name="number_employees" id="number_employees" class="form-control form-control-lg form-control-light">
                                    <?php if($societe[0]->number_employees==1){ ?>
                                        <option value="0">										
										</option>
                                    	<option value="1" selected> 
                                       <?php echo lang('employs1_10'); ?>
										</option>
                                        <option value="2">
										<?php echo lang('employs10_20'); ?>
										</option>
                                        <option value="3" >
										<?php echo lang('employs20_30'); ?>
										</option>
                                    <?php }elseif($societe[0]->number_employees==2){ ?>
                                        <option value="0">										
										</option>
                                    	<option value="1"> 
										  <?php echo lang('employs1_10'); ?>
										</option>
                                    	<option value="2" selected>
										  <?php echo lang('employs10_20'); ?>
										</option>
                                        <option value="3" >
										<?php echo lang('employs20_30'); ?>
										</option>
                                    <?php }elseif($societe[0]->number_employees==3){ ?>
                                        <option value="0">										
										</option>
                                        <option value="1"> 
										  <?php echo lang('employs1_10'); ?>
										</option>
                                        <option value="2">
											 <?php echo lang('employs10_20'); ?>
										</option>
                                    	<option value="3" selected>
											<?php echo lang('employs20_30'); ?>
										</option>
                                    <?php }else{ ?>
                                        <option value="0" selected>										
										</option>
                                        <option value="1"> 
										  <?php echo lang('employs1_10'); ?>
										</option>
                                        <option value="2">
										  <?php echo lang('employs10_20'); ?>
										</option>
                                        <option value="3">
											<?php echo lang('employs20_30'); ?>
										</option>
                                    <?php } ?>
									</select> 
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('subject_vat'); ?></label>
									<a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php echo lang('info_subject_vat'); ?>"></a>
                                    <!--select type="text" name="subject_vat" id="subject_vat" class="form-control form-control-lg form-control-light">
									<-?php if($societe[0]->subject_vat==1){ ?>
                                        <option value="1" selected>
                                        <-?php echo lang('oui'); ?>										
										</option>
                                    	<option value="0"> 
                                        <-?php echo lang('non'); ?>
										</option>                                       
                                    <-?php }else{ ?>
                                        <option value="1">	
                                        <-?php echo lang('oui'); ?>									
										</option>
                                    	<option value="0" selected> 
                                        <-?php echo lang('non'); ?>	
										</option>                                    
                                    <-?php } ?>
									</select--><br>
									<div class="btn-group societe" style="margin-top:4px;" data-toggle="buttons">
										
									  <label class="btn btn-default btn-oui btn-sm">
									  <input type="radio" value="1" ><?php echo lang('oui') ?></label>
									  <label class="btn btn-default btn-non btn-sm ">
									  <input type="radio" value="0"><?php echo lang('non') ?></label>
									</div>
									<input type="hidden" class="subject_vat" name="subject_vat" value="<?php echo $societe[0]->subject_vat?> ">
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-info">
                                    <label class="control-label"><?php echo lang('note_societes'); ?></label>
                                    <textarea name="note_societes" id="note_societes"
                                        class="form-control " style="height:60px;"><?php  echo $societe[0]->note_societes; ?></textarea>
                                    <div class="form-control-focus"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="adresses_content">
                </div>

                <div class="col-btn-row">
                    <div class="btn btn-danger" onclick="add_adresse(0)">+ <?php echo lang('add_other_address'); ?></div>
                </div>
				
            </div>
        </div>
    </div>
<div class="espace" style="padding: 5px 0;"></div>
		<div class="portlet-tool-btn" style="float: right; display: block; padding: 15px 0 30px;">
			<?php $this->layout->load_view('layout/header_buttons');?>
		</div>
		<div class="clearfix"></div>
</form>

</div>
<script>
	$('.btn-oui').click(function() {
	$('.subject_vat').val('1');
	
	});
	$('.btn-non').click(function() {
	$('.subject_vat').val('0');
	
	}); 
	  
if ( $('.subject_vat').val() == 0){
		$( ".btn-non" ).addClass('active');
	}else{
		$( ".btn-oui" ).addClass('active');
	}	

</script>
