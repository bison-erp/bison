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
add_adresse('<?php echo $id_current_societe; ?>');
</script>

<div id="headerbar-index" style="">
    <?php $this->layout->load_view('layout/alerts');?>
</div>
<form method="post" class="form-horizontal">
    <div id="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet light">
						<div class="content-heading">
							<div class="portlet-title left-title">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark">
										<?php if ($societe->id_societes): ?>
										<!-- #<?php echo $societe->id_societes; ?>-->
										<?php echo lang('new_societes'); ?> 
										<strong><?php echo $societe->raison_social_societes; ?></strong>
										<?php else: ?>
										<?php echo lang('new_societes'); ?>
										<?php endif;?>
									</span>
								</div>
							</div>
						</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <label class="control-label"
                                        style="font-size: 13px; color: #899a9a;"><?php echo lang('raison_social_societes'); ?>:
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <input readonly type="text" name="raison_social_societes"
                                        id="raison_social_societes" class="form-control"
                                        value="<?php echo $this->mdl_societes->form_value('raison_social_societes'); ?>">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <label class="control-label"
                                        style="font-size: 13px; color: #899a9a;"><?php echo lang('tax_code'); ?>:
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <input readonly type="text" name="tax_code" id="tax_code" class="form-control"
                                        value="<?php echo $this->mdl_societes->form_value('tax_code'); ?>">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <label class="control-label"
                                        style="font-size: 13px; color: #899a9a;"><?php echo lang('matricule_fiscale_societes') . '(' . lang('code_tva_societes') . ')'; ?>:
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <input readonly type="text" name="code_tva_societes" id="raison_social_societes"
                                        class="form-control"
                                        value="<?php echo $this->mdl_societes->form_value('code_tva_societes'); ?>">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <label class="control-label"
                                        style="font-size: 13px; color: #899a9a;"><?php echo lang('site_web_societes'); ?>:
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="site_web_societes" id="site_web_societes"
                                        class="form-control"
                                        value="<?php echo $this->mdl_societes->form_value('site_web_societes'); ?>">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <label class="control-label"
                                        style="font-size: 13px; color: #899a9a;"><?php echo lang('mail_societes'); ?>:
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="mail_societes" id="mail_societes" class="form-control"
                                        value="<?php echo $this->mdl_societes->form_value('mail_societes'); ?>">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <label class="control-label"
                                        style="font-size: 13px; color: #899a9a;"><?php echo lang('fax_societes'); ?>:
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="fax_societes" id="fax_societes" class="form-control"
                                        value="<?php echo $this->mdl_societes->form_value('fax_societes'); ?>">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <label class="control-label"
                                        style="font-size: 13px; color: #899a9a;"><?php echo lang('note_societes'); ?>:
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <textarea name="note_societes" id="note_societes"
                                        class="form-control"><?php echo $this->mdl_societes->form_value('note_societes'); ?></textarea>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>



                <div id="adresses_content">
                </div>


                <div>
                    <div class="btn btn-danger btn-sm default" onclick="add_adresse(0)">+Ajouter nouvelle adresse</div>
                </div>




            </div>
        </div>
    </div>
	<div class="portlet-footer">
		<div class="portlet-tool-btn">
			<div class="pull-right btn-group"><?php $this->layout->load_view('layout/header_buttons');?></div>
		</div>
	</div>
</form>