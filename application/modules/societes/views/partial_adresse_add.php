<div class="portlet light" id="adresse_<?php echo $code_adresse; ?>">
	<div class="portlet-title left-title nav-down-header">
<?php if ($code_adresse == '0') {?>
		<div class="caption font-dark-sunglo">
			<span class="caption-subject bold med-caption dark"><i class="fas fa-map-pin"></i>&nbsp;&nbsp;<?php echo lang('address_company'); ?></span>
		</div>
<?php } else {?>
		<div class="caption font-dark-sunglo">
			<span class="caption-subject bold med-caption dark"><i class="fas fa-map-pin"></i>&nbsp;&nbsp;<?php echo lang('other_address'); ?></span>
		</div>
<?php } ?>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title=""></a>
			<a href="javascript:;" class="remove" data-original-title="" title=""></a>
		</div>
	</div>
    <div class="portlet-body form">
        <div  class="row" >
            <div class="col-md-12">
                <div class="form-group has-info" >
                        <label class="control-label"><?php echo lang('address'); ?></label>
                        <textarea class="form-control form-control-lg form-control-light" style="max-width: 100%" name="adresse[]"><?php echo $adresse; ?></textarea>
                        <div class="form-control-focus" ></div>
                </div>
            </div>
        </div>
        <div  class="row" >
            <div class="col-md-3">
                <div class="form-group has-info" > 
                        <label class="control-label"><?php echo lang('country'); ?></label>
                        <input type="text" class="form-control form-control-lg form-control-light" name="pays[]" value="<?php echo $pays; ?>">
                        <div class="form-control-focus" ></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group has-info" > 
                        <label class="control-label"><?php echo lang('city'); ?></label>
                        <input type="text" class="form-control form-control-lg form-control-light"  name="ville[]" value="<?php echo $ville; ?>">
                        <div class="form-control-focus" ></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group has-info" > 
                        <label class="control-label"><?php echo lang('zip_code'); ?></label>
                        <input type="text" class="form-control form-control-lg form-control-light" name="code_postal[]" value="<?php echo $code_postal; ?>">
                        <div class="form-control-focus" ></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group has-info" > 
                        <label class="control-label" ><?php echo lang('n_telephone'); ?></label>
                        <input type="text" class="form-control"  name="telephone[]" value="<?php echo $telephone; ?>">
                        <div class="form-control-focus" ></div>
                </div>
            </div>
        </div>


    </div>
</div> 