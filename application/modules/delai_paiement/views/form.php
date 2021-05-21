<form method="post" class="form-horizontal">

    <div id="headerbar">
        <h1><?php echo lang('products_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <fieldset>
                    <legend>
                        <?php if ($this->mdl_fournisseurs->form_value('id_fournisseur')) : ?>
                            #<?php echo $this->mdl_fournisseurs->form_value('id_fournisseur'); ?>&nbsp;
                            <?php echo $this->mdl_fournisseurs->form_value('raison_social_fournisseur'); ?>
                        <?php else : ?>
                            <?php echo lang('new_fournisseur'); ?>
                        <?php endif; ?>
                    </legend>

                    

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('raison_social_fournisseur'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input type="text" name="raison_social_fournisseur" id="raison_social_fournisseur" class="form-control"
                                   value="<?php echo $this->mdl_fournisseurs->form_value('raison_social_fournisseur'); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('adresse_fournisseur'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <textarea name="adresse_fournisseur" id="adresse_fournisseur" class="form-control"><?php echo $this->mdl_fournisseurs->form_value('adresse_fournisseur'); ?></textarea>
                        </div>
                    </div>
					<div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php //echo lang('code_postal_fournisseur'); ?> </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-2">
                            <input type="text" name="code_postal_fournisseur" id="code_postal_fournisseur" class="form-control"
                                   value="<?php echo $this->mdl_fournisseurs->form_value('code_postal_fournisseur'); ?>" placeholder="<?php echo lang('code_postal_fournisseur');?>">
                        </div>
						<div class="col-xs-12 col-sm-8 col-lg-3">
                            <input type="text" name="ville_fournisseur" id="ville_fournisseur" class="form-control"
                                   value="<?php echo $this->mdl_fournisseurs->form_value('ville_fournisseur'); ?>" placeholder="<?php echo lang('ville_fournisseur');?>">
                        </div>
						<div class="col-xs-12 col-sm-8 col-lg-3">
                            <input type="text" name="pays_fournisseur" id="pays_fournisseur" class="form-control"
                                   value="<?php echo $this->mdl_fournisseurs->form_value('pays_fournisseur'); ?>" placeholder="<?php echo lang('pays_fournisseur');?>">
                        </div>
						 
                    </div>
					<div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('site_web_fournisseur'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input type="text" name="site_web_fournisseur" id="site_web_fournisseur" class="form-control"
                                   value="<?php echo $this->mdl_fournisseurs->form_value('site_web_fournisseur'); ?>">
                        </div>
						 
                    </div>
					<div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('mail_fournisseur'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input type="text" name="mail_fournisseur" id="mail_fournisseur" class="form-control"
                                   value="<?php echo $this->mdl_fournisseurs->form_value('mail_fournisseur'); ?>">
                        </div>
						 
                    </div>
					<div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('tel_fournisseur'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input type="text" name="tel_fournisseur" id="tel_fournisseur" class="form-control"
                                   value="<?php echo $this->mdl_fournisseurs->form_value('tel_fournisseur'); ?>">
                        </div>
						 
                    </div>
					<div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('fax_fournisseur'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input type="text" name="fax_fournisseur" id="fax_fournisseur" class="form-control"
                                   value="<?php echo $this->mdl_fournisseurs->form_value('fax_fournisseur'); ?>">
                        </div>
						 
                    </div>
					<div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('note_fournisseur'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <textarea name="note_fournisseur" id="note_fournisseur" class="form-control"><?php echo $this->mdl_fournisseurs->form_value('note_fournisseur'); ?></textarea>
                        </div>
						 
                    </div>

                    

                    

                </fieldset>
            </div>

           
        </div>

    </div>

</form>