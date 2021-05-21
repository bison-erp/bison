<form method="post" class="form-horizontal">

    <div id="headerbar">

        <table style=" width: 100%">
            <tr>
                <td style=" display:none">
                    <a href="javascript:history.back()">
                        <div style=" margin-left: 18px" > 
                            <img   style="width: 24px;"src="<?php echo base_url(); ?>/assets/default/img/left.png" ><h1>

                        </div>
                    </a>
                </td>
                <td>
                    <div style=" color: #4275a8;"> 
                        <h1><b> <?php echo lang('activites'); ?></b></h1></div>

                </td>
                <td>
                    <h1><?php echo lang('activites_form'); ?></h1>
                    <?php $this->layout->load_view('layout/header_buttons'); ?>
                </td>
            </tr>
        </table>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>
<?php print_r($this->mdl_activites);?>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <fieldset>
                    <legend>
                        <?php if ($this->mdl_activites->form_value('activite_id')) : ?>
                            #<?php echo $this->mdl_activites->form_value('activite_id'); ?>&nbsp;
                            <?php echo $this->mdl_activites->form_value('descrip'); ?>
                        <?php else : ?>
                            <?php echo lang('new_activites'); ?>
                        <?php endif; ?>
                    </legend>



                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo lang('product_description2'); ?>: </label>

                    </div>







                </fieldset>
            </div>


        </div>

    </div>

</form>