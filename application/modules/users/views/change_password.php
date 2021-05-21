<style>
.form-horizontal .form-group {
    margin-right: 0;
    margin-left: 0;
}
.form-horizontal .control-label {
    font-weight: 500;
    padding-bottom: 7px;
}
.caption.font-dark-sunglo {
    padding: 10px 0 0;
}
</style>
<form method="post" class="form-horizontal">
	<div id="headerbar-index" style=" margin-top:0;margin-bottom:0;">
        <?php echo $this->layout->load_view('layout/alerts'); ?>
    </div>
    <div id="content">
		<div class="portlet light profile no-shabow bg-light-blue">
			<div class="portlet-header">
				<div class="portlet-title align-items-start flex-column">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark"><?php echo lang('change_password'); ?></span>
					</div>
				</div>
				<div class="portlet-toolbar">
					<?php echo $this->layout->load_view('layout/header_buttons'); ?>
				</div>
			</div>
			<div class="portlet-body">
                    <div  class="row">
                        <div class="col-md-6">
                            <div class="form-group has-info">
								<label class="control-label"><?php echo lang('password'); ?></label>
								<input type="password" name="user_password" id="user_password" class="form-control form-control-md form-control-light">
								<div class="form-control-focus" ></div>
							</div>
						</div>
                        <div class="col-md-6">
                            <div class="form-group has-info">
								<label class="control-label"><?php echo lang('verify_password'); ?></label>
								<input type="password" name="user_passwordv" id="user_passwordv" class="form-control form-control-md form-control-light">
								<div class="form-control-focus"></div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
</form>