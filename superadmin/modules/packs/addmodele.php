<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

<script>
function addMail(){
   
    
    // send your ajax request with value
    $.post("ajax.php", {
       
            action: "add_modele_mail",
            title_name: $('#email_template_title').val(),
            email_template_body: CKEDITOR.instances.email_template_body.getData(),
            
        },
        function(data) {  
            window.location.href = "index.php?module=packs&action=listmodele";

        });
}
</script>
<style>
textarea {
    max-width: 100%;
}
.page-content .container {
    background: 
    white;
}
</style>

<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="index.php">Home</a><i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="index.php?module=clients">Clients</a>
        <i class="fa fa-circle"></i>
    </li>
    <li class="active">
        <?php echo $title; ?>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE CONTENT INNER -->
<div class="portlet light">
    <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase"><?php echo $titre; ?></span>
            </div>
            <div class="col-xs-12 col-sm-12">
            <div class="col-md-12">
                    <div class="form-group form-md-line-input has-info" style="padding: 0 12px;">
                           <input value="" autocomplete="off" type="text" class="form-control" name="email_template_title" id="email_template_title">
                               <div class="form-control-focus" style="left:15px;right:15px;">
                                </div>
                    </div>
            </div>
        
       </div>
    </div> 
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase"><?php echo $title; ?></span>
        </div>

    </div> 
    
  <div class="col-xs-12 col-sm-12">                          
      <div class="form-group">      
                        <div class="col-xs-12 col-sm-12">
                            <label style="font-size: 13px; color: #899a9a;" for="email_template_body">
                                <?php //echo lang('body'); ?>
                            </label>
                        </div>     
                         <div class="col-xs-12 col-sm-12">
                            <textarea name="email_template_body" id="email_template_body" style="height: 200px;"
                                class="form-control  ckeditor"><?php //echo $this->mdl_email_templates->form_value('email_template_body'); ?></textarea>
                        </div>
     </div>
                       
</div>
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs font-green-sharp"></i>
                            <span class="caption-subject font-green-sharp bold uppercase">Champs dynamiques</span>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <table width="100%" class="table table-striped table-condensed no-margin">
                            <tr style="background: #DDD;">
                                <td width="200px;"><b>Champ</b></td>
                                <td><b>Description</b></td>
                            </tr>
                            <tr>
                                <td>{licence}</td>
                                <td>Licence</td>
                            </tr>
                            <tr>
                                <td>{email}</td>
                                <td>Email</td>
                            </tr>
                            <tr>
                                <td>{password}</td>
                                <td>password</td>
                            </tr>
                            
                        </table>
                    </div>
</div>
</div>
<div style="text-align:right">
        <a href="index.php?module=clients" class="btn default">Cancel</a>
        <button class="btn blue" onclick="addMail()"><i class="fa fa-check"></i> Save</button>
    </div>
<!-- END PAGE CONTENT INNER -->
