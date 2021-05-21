<div id="headerbar-index">
	<?php $this->layout->load_view('layout/alerts');?>
</div>
<div id="content">
<form method="post" class="form-horizontal">
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark"><?php echo lang('new_group_attr');?></span><br/>
					<!--<span class="caption-subject text-bold small-caption muted"><?php //echo lang('add_edit_group');?></span>
				-->
                </div>
			</div>
			<div class="portlet-toolbar">
				<?php $this->layout->load_view('layout/header_buttons');?>
			</div>
		</div>
		<!--<div class="portlet-body">
			<div class="row card-row form-row">
				<div class="col-lg-4 col-md-6 col-sm-12 col-xl-12">                
					<div class="form-group has-info">
                   
						<label for="form_control_1"><?php //echo lang('groupe_attr'); ?><span class="text-danger">*</span></label>
				 
					   <?php// return var_dump($groupe_option);die('h'); ?>
                        <!--<select name="id_groupe_option" class="form-control form-control-lg form-control-light">
                                    <?php // foreach ($groupe_option as $key => $groupe) {?>
                                        
                                    <option value="<?php //echo $groupe_option[$key]->group_id; ?>">
                                        <?php //echo $groupe_option[$key]->name; ?>
                                    </option>
                                    <?php // }?>
                        </select>-->
                    <!--	<div class="form-control-focus"></div>
					</div>
				</div>
			</div>
		 </div>-->

		<div class="portlet-body">
			<div class="row card-row form-row">
				<div class="col-lg-4 col-md-6 col-sm-12 col-xl-12">			 
					<div class="form-group has-info">
						<label for="form_control_1"><?php echo 'libelle'?><span class="text-danger"></span></label>
						<input value="<?php echo $this->mdl_depot->form_value('libelle'); ?>" type="text" class="form-control form-control-md form-control-light" name="libelle">
						<div class="form-control-focus"></div>
					</div>
				</div>
			</div>
		</div>
		 
	</div>
</form>
</div>