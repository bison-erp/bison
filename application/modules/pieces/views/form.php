<form method="post" class="form-horizontal">

    <div id="headerbar">

                    <h1><?php echo lang('products_form'); ?></h1>
                    <?php $this->layout->load_view('layout/header_buttons'); ?>
                
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>


 <div class="row">
        <div class="col-md-10">
            <div class="portlet light">

                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> <?php if ($this->mdl_devises->form_value('devise_id')) : ?>
                            #<?php echo $this->mdl_devises->form_value('devise_id'); ?>&nbsp;
                            <?php echo $this->mdl_devises->form_value('devise_label'); ?>
                        <?php else : ?>
                            <?php echo lang('devise'); ?>
                        <?php endif; ?></span>
                    </div>

                </div>
                    
<div class="form-group form-md-line-input">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('devise_label'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input type="text" name="devise_label" id="devise_label" class="form-control"
                                   value="<?php echo $this->mdl_devises->form_value('devise_label'); ?>">
                            <div class="form-control-focus" ></div>
                        </div>
                    </div>
</div>
<div class="form-group form-md-line-input">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('devise_symbole'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input name="devise_symbole" id="devise_symbole" class="form-control" 
                                   value="<?php echo $this->mdl_devises->form_value('devise_symbole'); ?>">
                            <div class="form-control-focus" ></div>
                        </div>
                    </div>
</div>					
<div class="form-group form-md-line-input">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('taux'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input name="taux" id="taux" class="form-control" 
                                   value="<?php echo $this->mdl_devises->form_value('taux'); ?>">
                            <div class="form-control-focus" ></div>
                        </div>
                    </div>
</div>					

                    

                    

            </div>

           
        </div>

    </div>

</form>