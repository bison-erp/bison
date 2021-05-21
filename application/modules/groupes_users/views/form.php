<div id="headerbar-index">
    <?php $this->layout->load_view('layout/header_buttons');?>
</div>
    <div id="content">
		<div class="vertical-tab" role="tabpanel">
            <ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder" role="tablist">
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-general'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-cog" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"> <?php echo lang('param_gener'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_general_setting'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-societe'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-project-diagram" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"> <?php echo lang('company'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_company'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-taxes'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-dollar-sign" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('taxes'); ?> & <?php echo lang('devise'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_vat_currency'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-pdfdoc'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-file-pdf" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('pdf_documents'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_pdf_document'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-invoices'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('invoices'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_invoices'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-quotes'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-comment-dollar" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('quotes'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_quote'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-bl'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-file-upload" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('bon_livraison'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_bl'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-commande'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-file-download" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('bons_commande'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_commande'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-fabrication'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-clipboard" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('bf'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_bf'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-stock'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-layer-group" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('stock_general'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_stock_management'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>email_templates/index'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-envelope-open-text" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('madel_mail'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_email_template'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li>
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>import'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-database" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('import_data'); ?></span>
								<span class="time text-muted"><?php echo lang('import_manage_data'); ?></span>
							</div>
						</div>
					</a>
                </li>
                <li class="active">
                    <a role="tab" data-toggle="tab" onclick="document.location.href = '<?php echo base_url(); ?>settings/index#settings-groupes_users'" href="" class="profil-item setting-item">
						<div class="profil-link">
							<div class="symbol-label">
								<i class="fas fa-users-cog" aria-hidden="true"></i>
							</div>
							<div class="profil-text">
								<span class="details font-weight-bold font-size-lg"><?php echo lang('groupes_users'); ?></span>
								<span class="time text-muted"><?php echo lang('setting_sub_users'); ?></span>
							</div>
						</div>
					</a>
                </li>
            </ul>
<div class="tabbable tabs-below" style="width: 100%">
    <div class="tab-content tabs">
		<form method="post" class="form-horizontal">
		<div class="portlet light">
		<div class="portlet-header">
						<div class="content-heading">
							<div class="portlet-title left-title" style="margin: 0!important;">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark">
										<?php if ($this->mdl_groupes_users->form_value('groupes_user_id')) : ?>
												<!--#<?php echo $this->mdl_groupes_users->form_value('groupes_user_id'); ?>&nbsp;-->
											<?php echo $this->mdl_groupes_users->form_value('designation'); ?>
										<?php else : ?>
											<?php echo lang('groupes_users'); ?>
										<?php endif; ?>
									</span>
								</div>
							</div>
						</div>
					</div>
		<div class="portlet-body">
			<?php $this->layout->load_view('layout/alerts'); ?>
				<div class="form-content devise-form" style="padding: 15px 15px;">
                    <div  class="row" >
                        <div class="col-md-6">
                            <div class="form-group has-info">
								<label class="control-label"><?php echo lang('designation'); ?></label>
								<input type="text" name="designation" id="designation" class="form-control form-control-md form-control-light"
									   value="<?php echo $this->mdl_groupes_users->form_value('designation'); ?>">
								<div class="form-control-focus" ></div>
							</div>
						</div>
                        <div class="col-md-6">
                            <div class="form-group has-info">        
								<label class="control-label"><?php echo lang('etat'); ?></label>
									<select name="etat" id="etat" class="form-control form-control-md form-control-light">
										<option <?php if ($this->mdl_groupes_users->form_value('etat') == 1) {
									echo 'selected="selected"';
								} ?> value="1"><?php echo lang('active'); ?></option> 
										<option <?php if ($this->mdl_groupes_users->form_value('etat') == 0) {
									echo 'selected="selected"';
								} ?>value="0" ><?php echo lang('not_active'); ?></option>
									</select>
								<div class="form-control-focus" ></div>
							</div>
						</div>
					</div>
				</div>
				<div class="content-heading">
					<div class="portlet-title left-title">
						<div class="caption font-dark-sunglo">
							<span class="caption-subject bold med-caption dark"><?php echo lang('droit_accees'); ?></span>
						</div>
					</div>
				</div>
						<table    style=" width: 95%; margin-left: 2%; border-color: #cad5ef; border: 2px solid #cad5ef">
                        <tr  style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "></th>
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center"><?php echo lang('ajout-modif'); ?></th>
                            <th  VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center"><?php echo lang('sup'); ?></th>
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center"><?php echo lang('index'); ?></th>

                        </tr>
                        <?php 
                       $nom='';$ad='';$dell='';$cons=''; 
                      foreach ($droits as $value) { 

                            if((strcmp($value->nom,'contact') ==0)&&(strcmp($value->action,'add')==0)) {$ad=1;$nom=1;}
                            if((strcmp($value->nom,'contact') ==0)&&(strcmp($value->action,'del')==0)) {$dell=1;$nom=1;}
                            if(($value->nom=='contact')&&($value->action=='index')) {$cons=1;$nom=1;}
                            }
                        ?>
                        <tr style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "><?php echo lang('clients'); ?></th>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="add"<?php if(($nom==1)&&($ad==1)){echo 'checked="checked"';}?> name="droit[contact][add]"> </td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="del" <?php if(($nom==1)&&($dell==1)){echo 'checked="checked"';}?>name="droit[contact][del]"></td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="index" <?php if(($nom==1)&&($cons==1)){echo 'checked="checked"';}?>name="droit[contact][index]"></td>
                        </tr>
                    <?php 
                       $nom='';$ad='';$dell='';$cons=''; 
                      foreach ($droits as $value) { 

                            if((strcmp($value->nom,'devis') ==0)&&(strcmp($value->action,'add')==0)) {$ad=1;$nom=1;}
                            if((strcmp($value->nom,'devis') ==0)&&(strcmp($value->action,'del')==0)) {$dell=1;$nom=1;}
                            if(($value->nom=='devis')&&($value->action=='index')) {$cons=1;$nom=1;}
                            }
                        ?>
                        <tr style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "><?php echo lang('quotes'); ?></th>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="add" <?php if(($nom==1)&&($ad==1)){echo 'checked="checked"';}?>name="droit[devis][add]"> </td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="del" <?php if(($nom==1)&&($dell==1)){echo 'checked="checked"';}?>name="droit[devis][del]"></td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="index" <?php if(($nom==1)&&($cons==1)){echo 'checked="checked"';}?>name="droit[devis][index]"></td>
                        </tr>

                       <?php 
                       $nom='';$ad='';$dell='';$cons=''; 
                      foreach ($droits as $value) { 

                            if((strcmp($value->nom,'facture') ==0)&&(strcmp($value->action,'add')==0)) {$ad=1;$nom=1;}
                            if((strcmp($value->nom,'facture') ==0)&&(strcmp($value->action,'del')==0)) {$dell=1;$nom=1;}
                            if(($value->nom=='facture')&&($value->action=='index')) {$cons=1;$nom=1;}
                            }
                        ?>
                        <tr style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "><?php echo lang('invoices'); ?></th>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="add" <?php if(($nom==1)&&($ad==1)){echo 'checked="checked"';}?>name="droit[facture][add]"> </td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="del" <?php if(($nom==1)&&($dell==1)){echo 'checked="checked"';}?>name="droit[facture][del]"></td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="index" <?php if(($nom==1)&&($cons==1)){echo 'checked="checked"';}?>name="droit[facture][index]"></td>
                        </tr>
                        
                       <?php 
                       $nom='';$ad='';$dell='';$cons=''; 
                      foreach ($droits as $value) { 

                            if((strcmp($value->nom,'product') ==0)&&(strcmp($value->action,'add')==0)) {$ad=1;$nom=1;}
                            if((strcmp($value->nom,'product') ==0)&&(strcmp($value->action,'del')==0)) {$dell=1;$nom=1;}
                            if(($value->nom=='product')&&($value->action=='index')) {$cons=1;$nom=1;}
                            }
                        ?>
                        <tr style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "><?php echo lang('products'); ?></th>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="add" <?php if(($nom==1)&&($ad==1)){echo 'checked="checked"';}?>name="droit[product][add]"> </td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="del" <?php if(($nom==1)&&($dell==1)){echo 'checked="checked"';}?>name="droit[product][del]"></td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="index" <?php if(($nom==1)&&($cons==1)){echo 'checked="checked"';}?>name="droit[product][index]"></td>
                        </tr>
                       <?php 
                       $nom='';$ad='';$dell='';$cons=''; 
                      foreach ($droits as $value) { 

                            if((strcmp($value->nom,'fournisseur') ==0)&&(strcmp($value->action,'add')==0)) {$ad=1;$nom=1;}
                            if((strcmp($value->nom,'fournisseur') ==0)&&(strcmp($value->action,'del')==0)) {$dell=1;$nom=1;}
                            if(($value->nom=='fournisseur')&&($value->action=='index')) {$cons=1;$nom=1;}
                            }
                        ?>
                        <tr style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "><?php echo lang('Fournisseurs'); ?></th>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="add" <?php if(($nom==1)&&($ad==1)){echo 'checked="checked"';}?>name="droit[fournisseur][add]"> </td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="del" <?php if(($nom==1)&&($dell==1)){echo 'checked="checked"';}?>name="droit[fournisseur][del]"></td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="index" <?php if(($nom==1)&&($cons==1)){echo 'checked="checked"';}?>name="droit[fournisseur][index]"></td>
                        </tr>

                        <?php 
                       $nom='';$ad='';$dell='';$cons=''; 
                      foreach ($droits as $value) { 

                            if((strcmp($value->nom,'payement') ==0)&&(strcmp($value->action,'add')==0)) {$ad=1;$nom=1;}
                            if((strcmp($value->nom,'payement') ==0)&&(strcmp($value->action,'del')==0)) {$dell=1;$nom=1;}
                            if(($value->nom=='payement')&&($value->action=='index')) {$cons=1;$nom=1;}
                            }
                        ?>
                        <tr style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "><?php echo lang('payments'); ?></th>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="add" <?php if(($nom==1)&&($ad==1)){echo 'checked="checked"';}?>name="droit[payement][add]"> </td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="del" <?php if(($nom==1)&&($dell==1)){echo 'checked="checked"';}?>name="droit[payement][del]"></td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="index" <?php if(($nom==1)&&($cons==1)){echo 'checked="checked"';}?>name="droit[payement][index]"></td>
                        </tr>

                        <?php 
                       $nom='';$ad='';$dell='';$cons=''; 
                      foreach ($droits as $value) { 

                            if((strcmp($value->nom,'report') ==0)&&(strcmp($value->action,'add')==0)) {$ad=1;$nom=1;}
                            if((strcmp($value->nom,'report') ==0)&&(strcmp($value->action,'del')==0)) {$dell=1;$nom=1;}
                            if(($value->nom=='report')&&($value->action=='index')) {$cons=1;$nom=1;}
                            }
                        ?>                        
                        <tr style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "><?php echo lang('reports'); ?></th>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="add" <?php if(($nom==1)&&($ad==1)){echo 'checked="checked"';}?>name="droit[report][add]"> </td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="del" <?php if(($nom==1)&&($dell==1)){echo 'checked="checked"';}?>name="droit[report][del]"></td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="1" <?php if(($nom==1)&&($cons==1)){echo 'checked="checked"';}?>name="droit[report][index]"></td>
                        </tr>

                        <?php 
                       $nom='';$ad='';$dell='';$cons=''; 
                      foreach ($droits as $value) { 

                            if((strcmp($value->nom,'setting') ==0)&&(strcmp($value->action,'add')==0)) {$ad=1;$nom=1;}
                            if((strcmp($value->nom,'setting') ==0)&&(strcmp($value->action,'del')==0)) {$dell=1;$nom=1;}
                            if(($value->nom=='setting')&&($value->action=='index')) {$cons=1;$nom=1;}
                            }
                        ?>                         
                        <tr style=" border: 2px solid #cad5ef;  height: 45px">
                            <th VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center "><?php echo lang('settings'); ?></th>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="add" <?php if(($nom==1)&&($ad==1)){echo 'checked="checked"';}?>name="droit[setting][add]"> </td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="del" <?php if(($nom==1)&&($dell==1)){echo 'checked="checked"';}?>name="droit[setting][del]"></td>
                            <td VALIGN = " MIDDLE" style=" border: 2px solid #cad5ef; text-align: center ">
                                <INPUT type="checkbox" value="index" <?php if(($nom==1)&&($cons==1)){echo 'checked="checked"';}?>name="droit[setting][index]"></td>
                        </tr>
                    </table>     
		</div>
		<div class="portlet-footer" style="padding: 15px 15px 0;">
			<div class="portlet-tool-btn" style="float: right; display: block; padding: 15px 0 30px;">
				<?php $this->layout->load_view('layout/header_buttons');?>
			</div>
		</div>
	<div class="clearfix"></div>
		</div>
		</form>
	</div>
</div>
</div>

</div>
	
