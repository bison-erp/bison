<script>
$('#smtp_password').val('');



$('#email_send_method').change(function() {
    toggle_smtp_settings();    
});

function toggle_smtp_settings() {

    email_send_method = $('#email_send_method').val();

    if (email_send_method == 'smtp') {
        $('#div-smtp-settings').show();
    } else {
        $('#div-smtp-settings').hide();
    }
}
</script>
<div class="tab-info">
    <div class="col-xs-12 col-md-12" style="float: none;margin: auto;"> <br>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="settings[default_language]" class="control-label">
                        <?php echo lang('language'); ?>
                    </label>
                    <select name="settings[default_language]" class="form-control form-control-md form-control-light">
                        <?php foreach ($languages as $language) {?>
                        <option value="<?php echo $language; ?>"
                            <?php if ($this->mdl_settings->setting('default_language') == $language) {?>selected="selected"
                            <?php }?>><?php echo ucfirst($language); ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="settings[default_country]" class="control-label">
                        <?php echo lang('default_country'); ?>
                    </label>
                    <select name="settings[default_country]" class="form-control form-control-md form-control-light">
                        <option></option>
                        <?php foreach ($countries as $cldr => $country) {?>
                        <option value="<?php echo $cldr; ?>"
                            <?php if ($this->mdl_settings->setting('default_country') == $cldr) {?>selected="selected"
                            <?php }?>><?php echo $country ?></option>
                        <?php }?>
                    </select>
                </div>
            </div> 
		</div>			
            <!--
        <div class="col-xs-12 col-md-3">
            <div class="form-group">
                <label for="settings[signature]" class="control-label">
                    Signature
                </label>
                <input type="text" name="settings[signature]" class="input-sm form-control"
                    value="<!?php echo $this->mdl_settings->setting('signature'); ?>">
            </div>
        </div>-->
<div class="espace" style="padding: 10px 0;"></div>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="settings[document_language]" class="control-label">
                        <?php echo lang('document_language'); ?>
                    </label>
                    <div class="form-check">                
                    <?php   $checked="";
                    $tabl = explode(',',$this->mdl_settings->setting('default_language_document'));
                   
                    ?>  
                        <?php foreach ($languagedocuments as $i => $languagedocument) {?>
						<div class="each_check_lang">
                             <?php if (in_array($languagedocument, $tabl)){ ?>
                                <input type="checkbox"  checked    <?php echo $checked ; ?>   onchange="vallangdoc(<?php echo $i ?>)"  class="form-check-input" id="languedoc<?php echo $i  ?>" >                        
                            <?php }else{ ?>
                            <input type="checkbox" onchange="vallangdoc(<?php echo $i ?>)"  class="form-check-input" id="languedoc<?php echo $i  ?>" >                        
                            <?php } ?>
                            <label class="form-check-label" for="languedoc<?php echo $i  ?>"><?php echo $languagedocument  ?> </label>
							</div>
                        <?php } ?>
                        <input type="hidden" name="settings[default_language_document]" value="<?php echo $this->mdl_settings->setting('default_language_document') ?>" id="vallanguedoc" class="input-sm form-control"
                    value="">
                     </div>                  
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
				<div class="espace" style="padding: 10px 0;"></div>
                    <div class="form-group form-timbre">
                    
                        <label for="with_timbre" class="form-check-label">
                            <?php echo lang('with_timbre'); ?>
                        </label>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default btn-on btn-sm ">
                            <input type="radio" value="1" class="btn-on" ><?php echo lang('oui')?></label>
                            <label class="btn btn-default btn-off btn-sm ">
                            <input type="radio" value="0" class="btn-off" ><?php echo lang('non')?></label>
                        </div>
                    <input type="hidden" id="with_timbrehidd" name="settings[with_timbre]" value="<?php  echo $this->mdl_settings->setting('with_timbre') ?>">
                        <!--?php if($this->mdl_settings->setting('with_timbre') == 1){ ?>
                            <input type="checkbox" checked  id="with_timbre"  value="<!--?php $this->mdl_settings->setting('with_timbre') ?>" class="form-check-input" >                        
                        <!--?php }else{ ?>
                            <input type="checkbox"   id="with_timbre"  value="<!--?php $this->mdl_settings->setting('with_timbre') ?>" class="form-check-input" style="margin:5px 4px;" >                        
                            <!--?php }  ?>
                            <input type="hidden" id="with_timbrehidd" name="settings[with_timbre]" value="<!--?php $this->mdl_settings->setting('with_timbre') ?>"-->
                    </div>     
                </div>     
            </div>
<div class="espace" style="padding: 10px 0;"></div>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="settings[quote_overview_period]" class="control-label">
                        <?php echo lang('quote_overview_period'); ?>
                    </label><br>
                    <select name="settings[quote_overview_period]" class="form-control form-control-md form-control-light">
                        <option value="this-month"
                            <?php if ($this->mdl_settings->setting('quote_overview_period') == 'this-month') {?>selected="selected"
                            <?php }?>><?php echo lang('this_month'); ?></option>
                        <option value="last-month"
                            <?php if ($this->mdl_settings->setting('quote_overview_period') == 'last-month') {?>selected="selected"
                            <?php }?>><?php echo lang('last_month'); ?></option>
                        <option value="this-quarter"
                            <?php if ($this->mdl_settings->setting('quote_overview_period') == 'this-quarter') {?>selected="selected"
                            <?php }?>><?php echo lang('this_quarter'); ?></option>
                        <option value="last-quarter"
                            <?php if ($this->mdl_settings->setting('quote_overview_period') == 'last-quarter') {?>selected="selected"
                            <?php }?>><?php echo lang('last_quarter'); ?></option>
                        <option value="this-year"
                            <?php if ($this->mdl_settings->setting('quote_overview_period') == 'this-year') {?>selected="selected"
                            <?php }?>><?php echo lang('this_year'); ?></option>
                        <option value="last-year"
                            <?php if ($this->mdl_settings->setting('quote_overview_period') == 'last-year') {?>selected="selected"
                            <?php }?>><?php echo lang('last_year'); ?></option>
                    </select>
                </div>
            </div>


            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="settings[invoice_overview_period]" class="control-label">
                        <?php echo lang('invoice_overview_period'); ?>
                    </label>
                    <select name="settings[invoice_overview_period]" class="form-control form-control-md form-control-light">
                        <option value="this-month"
                            <?php if ($this->mdl_settings->setting('invoice_overview_period') == 'this-month') {?>selected="selected"
                            <?php }?>><?php echo lang('this_month'); ?></option>
                        <option value="last-month"
                            <?php if ($this->mdl_settings->setting('invoice_overview_period') == 'last-month') {?>selected="selected"
                            <?php }?>><?php echo lang('last_month'); ?></option>
                        <option value="this-quarter"
                            <?php if ($this->mdl_settings->setting('invoice_overview_period') == 'this-quarter') {?>selected="selected"
                            <?php }?>><?php echo lang('this_quarter'); ?></option>
                        <option value="last-quarter"
                            <?php if ($this->mdl_settings->setting('invoice_overview_period') == 'last-quarter') {?>selected="selected"
                            <?php }?>><?php echo lang('last_quarter'); ?></option>
                        <option value="this-year"
                            <?php if ($this->mdl_settings->setting('invoice_overview_period') == 'this-year') {?>selected="selected"
                            <?php }?>><?php echo lang('this_year'); ?></option>
                        <option value="last-year"
                            <?php if ($this->mdl_settings->setting('invoice_overview_period') == 'last-year') {?>selected="selected"
                            <?php }?>><?php echo lang('last_year'); ?></option>
                    </select>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="espace" style="padding: 10px 0;"></div>
<div class="col-xs-12 col-md-12">
<div class="row">
    <div class="tab-info col-xs-12 col-sm-6">
        <div class="form-group">
            <label for="settings[email_send_method]" class="control-label">
                <?php echo lang('email_send_method'); ?>
            </label>
            <select name="settings[email_send_method]" id="email_send_method" onchange="toggle_smtp_settings()"
                class="form-control form-control-md form-control-light">
                <option value=""></option>
                <option value="phpmail"
                    <?php if ($this->mdl_settings->setting('email_send_method') == 'phpmail') {?>selected="selected"
                    <?php }?>>
                    <?php echo lang('email_send_method_phpmail'); ?>
                </option>
                <option value="sendmail"
                    <?php if ($this->mdl_settings->setting('email_send_method') == 'sendmail') {?>selected="selected"
                    <?php }?>>
                    <?php echo lang('email_send_method_sendmail'); ?>
                </option>
                <option value="smtp"
                    <?php if ($this->mdl_settings->setting('email_send_method') == 'smtp') {?>selected="selected"
                    <?php }?>>
                    <?php echo lang('email_send_method_smtp'); ?>
                </option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label for="settings[mail_admin]" class="control-label">
                <?php echo lang('mail_admin'); ?>
            </label>
            <input type="text" name="settings[mail_admin]" class="form-control form-control-md form-control-light"
                value="<?php echo $this->mdl_settings->setting('mail_admin'); ?>">
        </div>
    </div>
	</div>
    <div id="div-smtp-settings" class="tab-info row"
        <?php if ($this->mdl_settings->setting('email_send_method') != 'smtp') {?>style="display:none;" <?php }?>>
        <div class="form-group col-lg-4 col-md-6 col-sm-4">
            <label for="settings[smtp_server_address]" class="control-label">
                <?php echo lang('smtp_server_address'); ?>
            </label>
            <input type="text" name="settings[smtp_server_address]" class="form-control form-control-md form-control-light"
                value="<?php echo $this->mdl_settings->setting('smtp_server_address'); ?>">
        </div>
        <div class="form-group col-lg-4 col-md-6 col-sm-4">
            <label for="settings[smtp_authentication]">
                <?php echo lang('smtp_requires_authentication'); ?>
            </label>
            <select name="settings[smtp_authentication]" class="form-control form-control-md form-control-light">
                <option value="0" <?php if (!$this->mdl_settings->setting('smtp_authentication')) {?>selected="selected"
                    <?php }?>>
                    <?php echo lang('no'); ?>
                </option>
                <option value="1" <?php if ($this->mdl_settings->setting('smtp_authentication')) {?>selected="selected"
                    <?php }?>>
                    <?php echo lang('yes'); ?>
                </option>
            </select>
        </div>
        <div class="form-group col-lg-4 col-md-6 col-sm-4">
            <label for="settings[smtp_username]" class="control-label">
                <?php echo lang('smtp_username'); ?>
            </label>
            <input type="text" name="settings[smtp_username]" class="form-control form-control-md form-control-light"
                value="<?php echo $this->mdl_settings->setting('smtp_username'); ?>">
        </div>
        <div class="form-group col-lg-4 col-md-6 col-sm-4">
            <label for="smtp_password" class="control-label">
                <?php echo lang('smtp_password'); ?>
            </label>
            <input type="password" id="smtp_password" class="form-control form-control-md form-control-light" name="settings[smtp_password]">
        </div>
        <div class="form-group col-lg-4 col-md-6 col-sm-4">
            <div>
                <label for="settings[smtp_port]" class="control-label">
                    <?php echo lang('smtp_port'); ?>
                </label>
                <input type="text" name="settings[smtp_port]" class="form-control form-control-md form-control-light"
                    value="<?php echo $this->mdl_settings->setting('smtp_port'); ?>">
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-6 col-sm-4">
            <label for="settings[smtp_security]" class="control-label">
                <?php echo lang('smtp_security'); ?>
            </label>
            <select name="settings[smtp_security]" class="form-control form-control-md form-control-light">
                <option value="" <?php if (!$this->mdl_settings->setting('smtp_security')) {?>selected="selected"
                    <?php }?>>
                    <?php echo lang('none'); ?></option>
                <option value="ssl"
                    <?php if ($this->mdl_settings->setting('smtp_security') == 'ssl') {?>selected="selected" <?php }?>>
                    <?php echo lang('smtp_ssl'); ?></option>
                <option value="tls"
                    <?php if ($this->mdl_settings->setting('smtp_security') == 'tls') {?>selected="selected" <?php }?>>
                    <?php echo lang('smtp_tls'); ?></option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-md-12">
        <div class="md-checkbox col-md-12">
            <?php if ($this->mdl_settings->setting('relance_cci') == 1) {?>
            <input type="checkbox" value="1" id="idcci" checked="checked" class="relance md-check">
            <?php } else {?>
            <input type="checkbox" value="0" id="idcci" class="relance md-check">
            <?php }?>
            <label for="idcci" style="padding-left: 8px;">
                <span></span>
                <span class="check"></span>
                <span class="box" style="margin-top: 3px;"></span>
                <?php echo lang('receive_emails_close'); ?>
            </label>
        </div>

        <input type="hidden" class="relance" name="settings[relance_cci]" id="idcci"
            value="<?php echo $this->mdl_settings->setting('relance_cci'); ?>">

        <script>
        $('.relance').change(function() {
            if ($(this).prop("checked")) {
                $('.relance').val('1');
            } else {
                $('.relance').val('0');
            }

        });
        </script>
    </div>
</div>
<div class="espace" style="padding: 10px 0;"></div>
<div class="clearfix"></div>
<script>
$('.btn-on').click(function() {
  $('#with_timbrehidd').val('1');
  
});
$('.btn-off').click(function() {
  $('#with_timbrehidd').val('0');
  
});

$( document ).ready(function() {
	
if ( $('#with_timbrehidd').val() == '0'){
	$( ".btn-off" ).addClass('active');
}	
if ( $('#with_timbrehidd').val() == '1'){
	$( ".btn-on" ).addClass('active');
}  

});
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
        $('#with_timbrehidd').val('1');
    }else{      
        $('#with_timbrehidd').val(0);
    }
  });
</script>