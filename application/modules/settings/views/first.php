 
<script type="text/javascript">
$(function() {
  // $('#modal-choose-items').modal({backdrop: 'static', keyboard: false});
   $('#modal-choose-items').modal('show');
});
/*$('body').click(function (event) 
{
   if(!$(event.target).closest('.modal-content').length && !$(event.target).is('.modal-content')) {
     $("#modal-choose-items").hide();
   }     
});  */ 
</script>
<style>
body {
    margin-top:30px;
}
.stepwizard-step p {
    margin-top: 0px;
    color:#666;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    content:" ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
</style>

<div id="modal-choose-items" class="modal config col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true" data-keyboard="false" data-backdrop="static"
    style="display: block;width: 65%;height: auto;z-index: 99999;background-color: #Fffff;margin-top: 22px;border-radius: 6px;">
    <div class="modal-content" style=" width: 100%">
        <div class="modal-header"
            style=" width: 31.9%;position: fixed; z-index: 999 ;border-bottom: 0px;height: 100xp;  background-color: rgb(0 128 175)!important; ">
            <div class="form-inline" style="border-bottom: 1px solid #e5e5e5; width: 100%">
                 <h1> <small> <?php echo lang('setting_sub_general_setting');  ?> </small>  </h1>            
            </div>
			<button class="closebtn" onclick="CloseConfig()">×</button>
        </div>
    <div class="modal-body" style="  z-index: 888; margin-top: 94px;  ">
     
     <form role="form"  id="formreq">
      
            <div class="panel-body">
                <div class="form-group logo">
                    <label class="control-label">
                       <div class="label logo" id="myDiv"> <?php echo lang('pdf_logo'); ?> </div>
							<?php if ($this->mdl_settings->setting('invoice_logo')) {?>
                                <img class="logo-entreprise" id="logo-en" src="<?php echo base_url() ?>/uploads/<?php echo strtolower($this->session->userdata('licence'))?>/<?php echo $this->mdl_settings->setting('invoice_logo') ?>" style="max-width:50px;">
                        <input type="file" class="logo-entreprise" name="invoice_logo"  id="invoice_logo" onchange="getFileInfo()" size="40" value="<?php echo $this->mdl_settings->setting('invoice_logo'); ?>"/>

							</span></span>
                    
                    <?php }else{?> 
                        <input type="file" name="invoice_logo" required="required" id="invoice_logo" size="40" value=""/>
                    <?php }?>
					<span class="form-text text-muted small-span"><?php echo lang('note_muted'); ?><span>
                    </label>                    
                     
					
                </div>
                
            </div>     
            
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label"><?php echo lang('raison_social_societes'); ?></label>
                    <input type="text" required="required" id="raison_social_societes" value="<?php echo $societes[0]->raison_social_societes ?>" class="form-control"  />
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo lang('tax_code'); ?></label>
                    <input type="text" required="required" class="form-control" id="tax_code" value="<?php echo $societes[0]->tax_code ?>"  />
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo lang('matricule_fiscale_societes') . '(' . lang('code_tva_societes') . ')'; ?></label>
                    <input type="text" required="required" class="form-control" id="matricule_fiscale_societes" value="<?php echo $societes[0]->code_tva_societes ?>"   />
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo lang('mail_societes'); ?></label>
                    <input type="email" required="required" class="form-control"  id="mail_societes" value="<?php echo $societes[0]->mail_societes ?>"  />
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo lang('n_telephone'); ?></label>
                    <input type="text" required="required" class="form-control" id="tel_societes" value="<?php echo $societes[0]->tel_societes ?>"   />
                </div>
                <button class="btn btn-success pull-right finish" type="submit"><?php echo lang('sauvegarder'); ?></button>  
            </div>
       
        
      
                   
        </div> 
    </form>
   
  

</div>

<script>
function getFileInfo(){
    var name = document.getElementById('invoice_logo').files[0].name;
	var info = name;
	document.getElementById('myDiv').innerText =name;
}
 function CloseConfig(){   
        $('.modal.config').hide();
		$('.modal-backdrop.in').hide();
} 
$(document).ready(function () {

var navListItems = $('div.setup-panel div a'),
    allWells = $('.setup-content'),
    allNextBtn = $('.nextBtn');

allWells.hide();

navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
        $item = $(this);

    if (!$item.hasClass('disabled')) {
        navListItems.removeClass('btn-success').addClass('btn-default');
        $item.addClass('btn-success');
        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
    }
});

allNextBtn.click(function () {  
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='url'],input[type='file'],input[type='email']"),
        isValid = true;

    $(".form-group").removeClass("has-error");
    for (var i = 0; i < curInputs.length; i++) {
        if (!curInputs[i].validity.valid) {
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
    }
    if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
  
     return false;
});
$('div.setup-panel div a.btn-success').trigger('click');
});
/*
if(!$('#with_timbre').prop("checked")){
    $('#default_item_timbre').val('0.000');
    $('.default_item_timbre').hide();
    $('#with_timbrehidd').val('0');
   }else{
    $('#with_timbrehidd').val('1');
    $('.default_item_timbre').show();
}
$('#with_timbre').change(function() {
   if(!$(this).prop("checked")){
    $('#default_item_timbre').val('0.000');
    $('.default_item_timbre').hide();
    $('#with_timbrehidd').val('0');
   }else{
    $('#with_timbrehidd').val('1');
    $('.default_item_timbre').show();
   }
})
*/
$('.finish').click(function () {
   
       
        with_timbre = $('#with_timbrehidd').val(); 
        raison = $('#raison_social_societes').val();
        tax_code = $('#tax_code').val(); 
        matricule = $('#matricule_fiscale_societes').val();
        mail = $('#mail_societes').val();
        tel = $('#tel_societes').val(); 
      //  default_item_timbre = $('#default_item_timbre').val();     
      //  var form_data = new FormData();                  
     //   form_data.append('signature_logo',  $('#signature_logo')[0].files[0]);          

       
       var form_data_logo = new FormData();        
       form_data_logo.append('invoice_logo', $('#invoice_logo')[0].files[0]);
    
       $.ajax({
            url: '/settings/ajax/set_fieldrequiredinvoicelogo',  
            data:form_data_logo,                         
            type: 'POST',           
            processData: false, 
            contentType: false,  
            success: function(response){            
                
           }
        });  
  
      /* $.ajax({
            url: '/settings/ajax/set_fieldrequiredinvoicesignature', 
            type: 'POST',      
            data:form_data_logo,             
            processData: false,  
            contentType: false,               
            success: function(response){  
                 
          }
        });  */   
        $.post("<?php echo site_url('settings/ajax/set_fieldrequired'); ?>", {   
            raison: raison,
            tax_code: tax_code,
            matricule: matricule,
            mail: mail,
            tel: tel,             
           // form_data: form_data,
            }, function(data) {
                window.setTimeout(() => {
                    window.location.href = "<?php echo base_url()?>dashboard";    
                }, 1500);  
                        
            }); 
    return false;
}) 
</script>