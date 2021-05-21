<style>
.hrefimg {
    display: inline-block;
    padding: 5px 0;
}
.hrefimg a {
    color: #F64E60;
}
.hrefimg a:hover, .hrefimg a:active, .hrefimg a:focus {
    color: #ec0c24;
}
</style>
<div class="tab-info">
    <div class="col-xs-12 col-md-12" style="float: none;margin: auto;"> <br>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
            </div>
            <div class="col-xs-12 col-sm-6">
            </div>        
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label for="settings[clr_pdf]" class="control-label">
                            <?php echo lang('clr_pdf'); ?>
                        </label>
                        <input type="color" id="settings[clr_pdf]" name="settings[clr_pdf]" value="<?php echo $this->mdl_settings->setting('clr_pdf');?>"> 
                    </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label for="settings[clr_pdf_somme]" class="control-label">
                            <?php echo lang('clr_pdf_somme'); ?>
                        </label>
                        <input type="color" id="settings[clr_pdf_somme]" name="settings[clr_pdf_somme]" value="<?php echo $this->mdl_settings->setting('clr_pdf_somme');?>"> 
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label">
                            <?php echo lang('signature_logo'); ?>
                        </label>
                        <input type="file" name="signature_logo" size="40" />
                     <!--   <div class="hrefimg">
                            <i style="color: #ec0c24" class="fa fa-times" aria-hidden="true"></i>
                            <?php //echo anchor('settings/remove_logo/signature', 'Supprimer signature'); ?>
                        </div>-->
                    </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?php if ($this->mdl_settings->setting('signature_logo')) {?>
                <img src="<?php echo base_url(); ?>uploads/<?php echo strtolower($this->session->userdata('licence')); ?>/<?php echo $this->mdl_settings->setting('signature_logo'); ?>"
                    class="img-insert-cachet"><br>
                <?php }?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label">
                        <?php echo lang('pdf_logo'); ?>
                    </label>
                    <input type="file" name="invoice_logo" size="40" />
                    <!--<div class="hrefimg">
                        <i style="color: #ec0c24" class="fa fa-times" aria-hidden="true"></i>
                        <?php //echo anchor('settings/remove_logo/invoice', 'Supprimer Logo'); ?>
                    </div>-->
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?php if ($this->mdl_settings->setting('invoice_logo')) {?>
                <img src="<?php echo base_url(); ?>uploads/<?php echo strtolower($this->session->userdata('licence')); ?>/<?php echo $this->mdl_settings->setting('invoice_logo'); ?>"
                    class="img-insert-entete"><br>
                <?php }?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 pied-de-page">
                <label for="settings[public_invoice_template]" class="control-label">
                    <?php echo lang('pdf_invoice_footer'); ?>
                </label>
                <textarea name="settings[pdf_invoice_footer]" class="form-control no-margin ckeditor "
                    style="max-width:100%"
                    rows="3"><?php echo $this->mdl_settings->setting('pdf_invoice_footer'); ?></textarea>
               
            </div>
        </div>

    </div>
	
<div class="espace" style="padding: 10px 0;"></div>
</div>
<script>
  var o = new Object();
        o[0] = "Arabic";
        o[1] = 'English';
        o[2] = 'French'; 
        var tab=[];
        const chars = $('#vallanguedoc').val();
        const t = chars.split(',');
        for (let i = 0; i < t.length; i++) {
            tab.push(t[i]); 
        }      
function vallangdoc(i){       
        if($('#languedoc'+i).is( ':checked' )){
        tab.push(o[i]);        
        }else{
            var index = tab.indexOf( o[i]);
            tab.splice(index, 1);
         }  
     
        $('#vallanguedoc').val(tab.sort());           
}
  $( "#with_timbre" ).click(function() {
    if($( "#with_timbre" ).is( ':checked' )){
        console.log(true);
        $('#with_timbrehidd').val('1');
    }else{
        console.log(false);
        $('#with_timbrehidd').val(0);
    }
  });
</script>