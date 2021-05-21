<input type="hidden" id="lgn" value="<?php echo lang('cldr') ?>">
<link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
    rel="stylesheet" type="text/css">
 <script>

         var o = new Object();
        o['Arabic'] = 'Arabic';
        o['English'] = 'English';
        o['French'] = 'French'; 
        $('.ar_dv').hide(); 
        $('.fr_dv').hide();
        $('.en_dv').hide(); 
       
      getlicountry('French');
        function getlicountry(id) {
              
   /* $('#desclang_'+id).each(function(){
    var $span = $(this);
    //if($('#langselect'))
    if($span.attr('class')==$('#langselect').val()){
        $('span.'+id).show();
    }else{
        $('span.'+id).show();
    }
    $('#langselect').val(id); 
            })*/
        //$('span.'+id).hide();
        //  $('span #Arabic').attr('visibility','hidden')    
      //  console.log(o[id]);
      
        
      switch (id) {
            case 'Arabic':
            $('.ar_dv').show(); 
            $('.fr_dv').hide();
            $('.en_dv').hide(); 
            $('.lbar_dv').show(); 
            $('.lbfr_dv').hide();
            $('.lben_dv').hide(); 
                break;
            case 'English':
            $('.en_dv').show();  
            $('.ar_dv').hide();
            $('.fr_dv').hide();
            $('.lben_dv').show();  
            $('.lbar_dv').hide();
            $('.lbfr_dv').hide();
                break;
            case 'French':
            $('.fr_dv').show();  
            $('.ar_dv').hide();
            $('.en_dv').hide();
            $('.lbfr_dv').show();  
            $('.lbar_dv').hide();
            $('.lben_dv').hide();
                break;
      }
          $('#langue').val(o[id]);        
                 
    }
 </script>
     
  <style>
 /*input[type=file]{
    width:90px;
    color:transparent;
}*/
  
table #tab_stock,td,th {
  border: 0px solid black;
  padding: 10px;
}
table td.crossed {
  background-image: -webkit-linear-gradient(top left, transparent, red, transparent);
  background-image: -moz-linear-gradient(top left, transparent, red, transparent);
  background-image: -o-linear-gradient(top left, transparent, red, transparent);
  background-image: linear-gradient(to bottom right, transparent, red, transparent);
}



 .select ul li.option {
  background-color: #FFF;
  box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
  -webkit-box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
  -moz-box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
}

.select ul li.option:hover {
  background-color: #FFF;
}

.select ul li.option {
  z-index: 1;
  padding: 5px;
  display: none;
  list-style: none;
}

.select ul li:first-child {
  display: block;
}

.select ul li {
  cursor: default;
}
.desc { color:#6b6b6b;}
    .desc a {color:#0092dd;}
    
    .dropdown dd, .dropdown dt, .dropdown ul { margin:0px; padding:0px; }
    .dropdown dd { position:relative; }
    .dropdown a, .dropdown a:visited { color:#816c5b; text-decoration:none; outline:none;}
    .dropdown a:hover { color:#5d4617;}
    .dropdown dt a:hover { color:#5d4617; border: 1px solid #d0c9af;}
    .dropdown dt a {background:#FFF url('/assets/default/img/arrow.png') no-repeat scroll right center; display:block; padding-right:20px;
                      width:65px;}
    .dropdown dt a span {cursor:pointer; display:block; padding:5px;}
    .dropdown dd ul { background:#fff none repeat scroll 0 0;   color:#C5C0B0; display:none;
                      left:0px; padding:5px 0px; position:absolute; top:2px; width:auto; min-width:65px; list-style:none;}
    .dropdown span.value { display:none;}
    .dropdown dd ul li a { padding:5px; display:block;}
    .dropdown dd ul li a:hover {opacity:0.6 ;  }
    
    .dropdown img.flag { border:none; vertical-align:middle; margin-left:10px; }
    .flagvisibility { display:none;}


    .datepicker table tr td.day:hover,
    .datepicker table tr td.day.focused {
        background: #eee;
        cursor: pointer;
        border-radius: 4px;
    }

    .datepicker .active {
        background-color: #4B8DF8 !important;
        background-image: none !important;
        filter: none !important;
        border-radius: 4px;
    }
 </style>
<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div id="headerbar-index">
	<?php $this->layout->load_view('layout/alerts');?>
</div>     
<div id="content">
	 <!-- begin formulaire -->
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column" style="padding-top: 10px;">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark">
                               <?php if ($this->mdl_products->form_value('product_id')): ?>
                                #<?php echo $this->mdl_products->form_value('product_id'); ?>&nbsp;
                             <span class="lbfr_dv">   <?php echo $this->mdl_products->form_value('product_name'); ?></span>
                             <span class="lbar_dv">   <?php echo $this->mdl_products->form_value('product_name_ar'); ?></span>
                             <span class="lben_dv">   <?php echo $this->mdl_products->form_value('product_name_en'); ?></span>
                                <?php else: ?>
                                <?php echo lang('new_product_service'); ?>
                                <?php endif;?>
					</span>
				</div>
			</div>
			<div class="portlet-toolbar">
				<?php $this->layout->load_view('layout/header_buttons');?>
			</div>
		</div>
		<div class="portlet-body stock"> 
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general"><?php echo lang('general'); ?></a></li>
                    <li><a data-toggle="tab" href="#desc"><?php echo lang('fiche_technique'); ?></a></li>
                    <li><a data-toggle="tab" href="#pricing"><?php echo lang('tarifs'); ?></a></li>
                    <li><a data-toggle="tab" href="#catego"><?php echo lang('family'); ?></a></li>
                    <li><a data-toggle="tab" href="#li-stock"><?php echo lang('stockage'); ?></a></li>
                    <li class="li-img"><a data-toggle="tab" href="#images"><?php echo lang('images'); ?></a></li>
                </ul>
                <div class="tab-content">
                        <div id="general" class="col-md-12 tab-pane fade in active">
<!-- Debut general -->
<div class="row">
                                <div class="lbar_dv col-md-6 padding-right-md no-padd ">
                                    <div class="has-info">
                                        <label for="form_control_1"><?php echo lang('product_name'); ?><span class="text-danger">*</span>
                                            <?php $img1 = (base_url().'/assets/default/img/Arabic.png');  ?>
                                            <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                        </label>
                                        <input value="<?php echo $this->mdl_products->form_value('product_name_ar'); ?>"
                                                    type="text" class="form-control form-control-sm form-control-light" id="product_name_ar" name="product_name_ar">
                                        <div class="form-control-focus"></div>
                                    </div>   
                                </div>   
                                <div class="lbfr_dv col-md-6 padding-right-md">
								<div class="has-info">
                                    <label for="form_control_1"><?php echo lang('product_name'); ?><span class="text-danger">*</span>
                                            <?php $img1 = (base_url().'/assets/default/img/French.png');  ?>
                                            <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                   </label>
                                    <input value="<?php echo $this->mdl_products->form_value('product_name'); ?>"
                                        type="text" class="form-control form-control-sm form-control-light" id="product_name" name="product_name">
                                    <div class="form-control-focus"></div>
                                </div> 
                                </div>   
                                <div class="lben_dv col-md-6 padding-right-md">
								<div class="has-info">
                                    <label for="form_control_1"><?php echo lang('product_name'); ?><span class="text-danger">*</span>
                                            <?php $img1 = (base_url().'/assets/default/img/English.png');  ?>
                                             <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                    </label>
                                    <input value="<?php echo $this->mdl_products->form_value('product_name_en'); ?>"
                                        type="text" class="form-control form-control-sm form-control-light" id="product_name_en" name="product_name_en">
                                    <div class="form-control-focus"></div>
								</div>      
								</div>      
                                <div class="lang-form-groupe col-md-1 no-padding">
										<div class="col-md-4 has-info langue-flag-form">
										<label class="lang-flag-label"></label>
										<!--label><!?php echo lang('language'); ?></label-->
										<input type="hidden" value="<?php echo $this->mdl_settings->setting('default_language'); ?>" name="langue" id="langue" >
												<?php $tab =explode(',',$this->mdl_settings->setting('default_language_document')); ?>
											<dl class="dropdown lang-flag">
												<dt>
													<?php if($this->mdl_products->form_value('langue')){ 
														 $imgsrc = (base_url().'/assets/default/img/' . $this->mdl_products->form_value('langue').'.png');   
														?>                                    
														<a href="javascript:void(0)"><span class="value"><img class="flag" src="<?php echo $img1; ?>" alt="" /><?php echo substr($this->mdl_products->form_value('langue'), 0, 2); ?></span></a>
													<?php } else { 
													$img1 = (base_url().'/assets/default/img/' . $this->mdl_settings->setting('default_language').'.png'); ?>
														<a href="javascript:void(0)"><span class="value"><img class="flag" src="<?php echo $img1; ?>" alt="" /><?php echo substr($this->mdl_settings->setting('default_language'), 0, 2); ?></span></a>
													   
														<?php } ?>
												</dt>
												<dd>
													<ul class="paylangue" style="display: none; z-index: 1;">
														<?php foreach(array_filter($tab) as $key => $value){                            
															$img1 = (base_url().'/assets/default/img/' . $value.'.png');  ?>
															<li onclick="getlicountry('<?php echo $value; ?>')" ><a href="javascript:void(0)"><img class="flag" src="<?php echo $img1; ?>" alt="" /><?php echo substr($value, 0, 2); ?></a></li>
														<?php  } ?>
													</ul>
												</dd>
											</dl>
									</div>
								</div>
                            </div>       
                            <div class="row card-row form-row">
                                <div class="col-lg-6 col-sm-6 col-xl-12 no-padd">
                                    <input type="hidden" id="" value="<?php  //echo(array_filter($tab[0])) ?>">
                                    <div class="has-info">
                                        <label for="form_control_1"><?php echo lang('type'); ?></label>
                                        <select class="form-control form-control-md form-control-light" name="prod_service" id="prod_service">
                                            <!--<option value=""></option>-->
                                            <?php if ($this->mdl_products->form_value('product_id')) {?>
                                            <?php if ($this->mdl_products->form_value('prod_service') == 0) {?>
                                            <option value="0" selected>
                                            <?php echo lang('product'); ?>  
                                            </option>
                                            <option value="1">
                                                <?php echo lang('service'); ?>
                                            </option>
                                            <?php } else {?>
                                            <option value="0">
                                            <?php echo lang('product'); ?>  
                                            </option>
                                            <option value="1" selected>
                                            <?php echo lang('service'); ?>
                                            </option>
                                            <?php }?>
                                            <?php } else {?>
                                            <option value="0">
                                            <?php echo lang('product'); ?>  
                                            </option>
                                            <option value="1">
                                                <?php echo lang('service'); ?>
                                            </option>
                                            <?php }?>
                                        </select>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-xl-12">                                    
                                    <div class="has-info">
                                        <label for="form_control_1"><?php echo lang('approvisionnement'); ?></label>
                                        <select class="form-control form-control-md form-control-light" name="approvisionnement" id="approvisionnement">
                                            <?php if($this->mdl_products->form_value('approvisionnement')){
                                                if(($this->mdl_products->form_value('approvisionnement'))==1){
                                                ?>
                                            <option selected value="1"><?php echo lang('acheter'); ?></option>
                                            <option value="2"><?php echo lang('produire'); ?></option>
                                            <option value="3"><?php echo lang('acheter_produire'); ?></option>
                                            <?php
                                                }elseif(($this->mdl_products->form_value('approvisionnement'))==2){
                                                ?>
                                            <option  value="1"><?php echo lang('acheter'); ?></option>
                                            <option selected value="2"><?php echo lang('produire'); ?></option>
                                            <option value="3"><?php echo lang('acheter_produire'); ?></option>
                                            <?php
                                                }elseif(($this->mdl_products->form_value('approvisionnement'))==3){
                                                ?>
                                             <option  value="1"><?php echo lang('acheter'); ?></option>
                                            <option  value="2"><?php echo lang('produire'); ?></option>
                                            <option selected value="3"><?php echo lang('acheter_produire'); ?></option>
                                            <?php
                                                }} 
                                                ?>
  <?php if(!$this->mdl_products->form_value('approvisionnement')){ ?>

                                                   <option value="1"><?php echo lang('acheter'); ?></option>
                                                   <option value="2"><?php echo lang('produire'); ?></option>
                                                   <option value="3"><?php echo lang('acheter_produire'); ?></option>
                                                   <?php } ?>
                                        </select>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6 col-sm-6 col-xl-12 no-padd select-search">
                                <div class="select-search-input has-info ">
                                        <label for="form_control_1"><?php echo lang('Fournisseurs'); ?><span class="text-danger"> *</span></label>
                                            <input style="width: 100%;" readonly="" value="<?php 
                                            if( $by_fournisseur){
                                            if( $by_fournisseur[0]->nom){
                                                echo($by_fournisseur[0]->nom . ' ' . $by_fournisseur[0]->prenom);
                                            }else{
                                                echo($by_fournisseur[0]->raison_social_fournisseur);
                                            }
                                        }
                                        ?>" autocomplete="off" type="text"  id="sel_fournisseur_id"  class="form-control form-control-lg form-control-light form-width-input" >
                                                    
                                            <button id="search_client" type="button" class="btn btn-success btn-select-client">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                            <div class="form-control-focus"></div>
                                        <input type='hidden'  id="fournisseur_id" name="fournisseur_id" value="<?php
                                        if( $by_fournisseur){
                                        echo  $by_fournisseur[0]->id_fournisseur; 
                                        }
                                        ?> ">     
                                </div>      


                                       <!-- <div class="select-search-input has-info">
                                            <select class="form-control form-control-lg form-control-light form-width-input" name="fournisseur_id" id="fournisseur_id">
                                                <!--<option value=""></option>-->
                                             
                                             
                                             
                                         <!--       <?php if (count($fournisseur) > 0) {?>
                                                <option value="0"></option>
                                                <?php foreach ($fournisseur as $fournisseur) {?>
                                                <option value="<?php echo $fournisseur->id_fournisseur; ?>"
                                                    <?php if ($this->mdl_products->form_value('fournisseur_id') == $fournisseur->id_fournisseur) {?>selected="selected"
                                                    <?php }?>><?php echo $fournisseur->raison_social_fournisseur; ?>
                                                </option>
                                                <?php }?>
                                                <?php } else {?>
                                                <option value="0"> </option>
                                                <?php }?>
											</select>
												<button id="search_client" type="button" class="btn btn-success btn-select-client">
													<span class="glyphicon glyphicon-search"></span>
												</button>
                                            <div class="form-control-focus"></div>
                                        </div>-->
                            </div>
                            
							<div class="code_barre_div" style="display:none;">
								<div class="row card-row form-row">
									<div class="col-lg-12 col-sm-12 col-xl-12">
										<div class="has-info">
											<label for="form_control_1"><?php echo lang('code_barre'); ?></label>
											<input value="<?php echo $this->mdl_products->form_value('code_barre'); ?>" type="text"
												class="form-control form-control-md form-control-light" id="code_barre" name="code_barre">
											<div class="form-control-focus"></div>
										</div>
									</div>
								</div>
							</div>
                            

                            <div class="row card-row form-row">
                                <div class="col-lg-6 col-sm-6 col-xl-12">
                                        <div class="has-info">
                                            <label for="form_control_1" style="padding-top: 3px;"><?php echo lang('product_sku'); ?><span class="text-danger">*</span></label>
                                            <input value="<?php echo $this->mdl_products->form_value('product_sku'); ?>"
                                                type="text" class="form-control form-control-md form-control-light" id="product_sku" name="product_sku">
                                            <div class="form-control-focus"></div>
                                        </div>
                                </div> 
                            </div>


                            <div class="row card-row form-row">
                                <div class="col-lg-6 col-sm-6 col-xl-12 poids no-padd">
                                    <div class="has-info">
                                        <label for="form_control_1"><?php echo lang('poids'); ?></label>
                                        <input value="<?php echo $this->mdl_products->form_value('poids'); ?>" type="text"
                                                class="form-control form-control-lg form-control-light" id="poids" name="poids">
                                            <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-xl-12 marque">
                                    <div class="has-info">
                                            <label for="form_control_1"><?php echo lang('marque'); ?></label>
                                            <input value="<?php echo $this->mdl_products->form_value('marque'); ?>" type="text"
                                                class="form-control form-control-lg form-control-light" id="marque" name="marque">
                                            <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>

                                <div class="col-lg-6 col-sm-6 col-xl-12 no-padd">
                                            <div class="quantite_div">
                                                        <div class="has-info">
                                                            <label for="form_control_1"><?php echo lang('quantity'); ?> </label>
                                                            <input value="<?php echo $this->mdl_products->form_value('quantite'); ?>"
                                                                type="text" class="form-control form-control-lg form-control-light" id="quantite" name="quantite">
                                                            <div class="form-control-focus"></div>
                                                        </div>
                                            </div>
                               </div>        
                                            
                                <div class="col-lg-6 col-sm-6 col-xl-12">
                                      <div class="stock_div">
                                           <div class="has-info">
                                                <label for="form_control_1"><?php echo lang('stock_alerte') ?></label>
                                                <input value="<?php echo $this->mdl_products->form_value('stock'); ?>" type="text"
                                                       class="form-control form-control-lg form-control-light" id="stock" name="stock">
                                                  <div class="form-control-focus"></div>
                                             </div>
                                                    
                                        </div>                               
                                 </div> 


                                 <div class="col-lg-6 col-sm-6 col-xl-12 consommation">
                                        <div class="form-group has-info">
                                            <div class="quote-properties has-feedback">
                                                    <label for="form_control_1"><?php echo lang('date_consommation'); ?> </label>
                                                <div class="input-group">
                                                    <input name="dlc" id="quote_date_accepte" title="Dlc" class="form-control form-control-lg form-control-light datepicker" value="<?php echo  ($this->mdl_products->form_value('dlc')?date_from_mysql($this->mdl_products->form_value('dlc'),1):'');  ?>">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar fa-fw" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
							    </div>


                                <div class="col-lg-4 col-sm-4 col-xl-12 unite">
                                        <div class="unite_id_div">
                                            <div class="has-info">
                                                <label for="form_control_1"><?php echo lang('unite') ?></label>
                                                <select class="form-control form-control-lg form-control-light" name="unite_id" id="unite_id">
                                                    <!--<option value=""></option>-->
                                                    <?php foreach ($unite as $unite) {?>
                                                    <option value="<?php echo $unite->id_unite; ?>"
                                                        <?php if ($this->mdl_products->form_value('unite_id') == $unite->id_unite) {?>selected="selected"
                                                        <?php } elseif ($unite->id_unite == 3) {?>selected="selected" <?php }?>>
                                                        <?php echo lang($unite->designation); ?>
                                                    </option>
                                                    <?php }?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                </div>
                       


                            <!-- fin general-->
                        </div>
                        <div id="desc" class="tab-pane fade">                            
                                <div class="fr_dv row">
                                <div class="col-md-12">
                                    <div id='French' class="has-info">
                                        <label for="form_control_1"><?php echo lang('product_description'); ?><span class="text-danger">*</span>
                                            <?php $img1 = (base_url().'/assets/default/img/French.png');  ?>
                                            <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                            </span>                                   
                                        </label>
                                        <textarea name="product_description" rows="2" id="product_description"
                                            class="form-control" style="height: 80px;"><?php echo $this->mdl_products->form_value('product_description'); ?></textarea>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="en_dv row">
                                <div class="col-md-12">
                                    <div  id='English' class="has-info">
                                        <label for="form_control_1"><?php echo lang('product_description'); ?><span class="text-danger">*</span>
                                            <?php $img1 = (base_url().'/assets/default/img/English.png');  ?>
                                            <img class="flag" src="<?php echo $img1; ?>" alt="" />                                   
                                        </label>
                                        <textarea name="product_description_eng" rows="2" id="product_description_eng"
                                            class="form-control" style="height: 80px;"><?php echo $this->mdl_products->form_value('product_description_eng'); ?></textarea>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="ar_dv row">
                                <div class="col-md-12">
                                    <div id='Arabic' class="has-info">
                                        <label for="form_control_1"><?php echo lang('product_description'); ?><span class="text-danger">*</span>
                                                <?php $img1 = (base_url().'/assets/default/img/Arabic.png');  ?>
                                                <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                            </span>                      
                                        </label>
                                        <textarea name="product_description_ar" rows="2" id="product_description_ar"
                                            class="form-control " style="height: 80px;"><?php echo $this->mdl_products->form_value('product_description_ar'); ?></textarea>
                                        <div class="form-control-focus"></div>
                                    </div>  
                                </div>   
                                         
                            </div>
                            <br>  
                                 <div class="col-md-6">
                                    <div class="has-info">
                                        <label for="form_control_1"><?php echo lang('technique'); ?></label>  
                                        <input id="fiche" type="file" name="fiche[]" multiple>
                                    </div> 
                                 </div>                                 
                           
                            <div class="col-md-6">   
                                     <ul class="list-group">
                                              <table class="table table-condensed table-striped " style="margin-top: 7px; width: 500%;  table-layout: fixed;">                                          
                                                <thead>
                                                    <tr>
                                                        <th><?php echo lang('file'); ?></th>                                                      
                                                        <th></th>
                                                    </tr>
                                                 </thead>   
                                                 <tbody> 
                                                    <?php foreach ($file_fiche as $key => $value) {
                                                   $dir_path = base_url() . 'uploads/' . strtolower($this->session->userdata['licence']) . '/fileproduct/' . $value->name_file_fiche; ?>                                   
                                                    <tr>                                                                                       
                                                        <td><?php echo  $value->name_file_fiche; ?></td>
                                                        <td>
                                                        <a target="_blank" href="<?php echo $dir_path; ?>" class="btn btn-xs blue" title="Télécharger">
                                                            <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>  
                                                        <a href="/products/deletefile_fiche/<?php echo $value->id_file_fiche?>/<?php echo $value->produit_id?>" class="btn btn-xs red" title="Supprimer" onclick="return confirm('Voulez vous supprimer ce document ?');">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </a>  
                                                        </td>    
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                           </table>                                           
                                       
                                        </ul>      
                            </div>         
                        </div>
                        <div id="pricing" class="tab-pane fade">  
                    <!--debut pricing -->     
                    <fieldset> 

                    <div class="row card-row form-row">
                                <div class="col-lg-6 col-sm-4 col-xl-12">
									<div class="has-info">
										<label for="form_control_1"><?php echo lang('purchase_price'); ?></label>
										<input value="<?php echo $this->mdl_products->form_value('purchase_price'); ?>"
											type="text" class="form-control form-control-lg form-control-light" name="purchase_price" id="purchase_price">
										<div class="form-control-focus"></div>
									</div>
                                </div>
                                <?php if ($typetaxe == 0) {?>
                                    <?php  foreach ($devises as $value) { ?>
                                <input type="hidden" name="prx[<?php echo $value->devise_id; ?>][devise]"
                                    id="prx[<?php echo $value->devise_id; ?>][devise]"
                                    value="<?php echo $value->devise_id; ?>">
                                    <?php  } ?>
                                <div class="col-lg-3 col-sm-4 col-xl-12">
									<div class="has-info">
										<label for="form_control_1"><?php echo lang('tax_rate'); ?></label>
										<select disabled="disabled" class="form-control form-control-lg form-control-light" name="tax_rate_id"
											id="tax_rate_id">
											<option value="3" selected="selected">0</option>
										</select>
										<div class="form-control-focus"></div>
									</div>
                                </div>
                                <?php } else {?>
                                <?php  foreach ($devises as $value) { ?>
                               <input type="hidden" name="prx[<?php echo $value->devise_id; ?>][devise]"
                                    id="prx[<?php echo $value->devise_id; ?>][devise]"
                                    value="<?php echo $value->devise_id; ?>">
                                <?php } ?>
                                <div class="col-lg-3 col-sm-4 col-xl-12">
									<div class="has-info">
										<label for="form_control_1"><?php echo lang('tax_rate'); ?></label>
										<select class="form-control form-control-lg form-control-light" name="tax_rate_id" id="tax_rate_id">
											<!--<option value=""></option>-->
											<?php foreach ($tax_rates as $tax_rate) {?>
											<option value="<?php echo $tax_rate->tax_rate_id; ?>"
												<?php if ($this->mdl_products->form_value('tax_rate_id') == $tax_rate->tax_rate_id) {?>
												selected="selected" <?php }?>><?php echo $tax_rate->tax_rate_name; ?>
											</option>
											<?php }?>
										</select>
										<div class="form-control-focus"></div>
									</div>
                                </div>
                                <?php }?>
                                <div class="col-lg-3 col-sm-4 col-xl-12">
									<div class="has-info">
										<label for="form_control_1"><?php echo lang('marge'); ?></label>
										<input value="<?php echo $this->mdl_products->form_value('marge'); ?>" type="text" class="form-control form-control-lg form-control-light" id="marge" name="marge">
										<div class="form-control-focus"></div>
									</div>
								</div>
							</div>
                    <?php

if ($this->mdl_products->form_value('product_id')) { //cas formulaire de modification
  //  return die('hh');
    foreach ($devises as $value) {
        $prix = '';
        $tva = '';
        foreach ($prix_ventes as $pvalue) { ///echo '<pre>'; print_r($pvalue);echo '</pre>';
            if (($pvalue->id_devise == $value->devise_id)) {
                $prix = $pvalue->prix_vente;
                $tva = $pvalue->id_tax;
            }}?>


					 	<div class="row card-row form-row">
                                <div class="col-lg-6 col-sm-6 col-xl-12">
									<div class="has-info">
										<label for="form_control_1"><?php echo lang('product_price') . '&nbsp;(' . $value->devise_symbole . ')'; ?></label>
										<input value="<?php echo $prix; ?>" type="text" class="calcvente<?php echo $value->devise_id; ?> form-control form-control-lg form-control-light"
											name="prx[<?php echo $value->devise_id; ?>][product_price]"
											id="prx[<?php echo $value->devise_id; ?>][product_price]">
										<div class="form-control-focus"></div>
									</div>
                                </div>
                                <?php if ($typetaxe == 1) {?>
                                <div class="col-lg-6 col-sm-6 col-xl-12">
									<div class="has-info">
										<label for="form_control_1"><?php echo lang('tax_rate'); ?></label>
										<select class="sl<?php echo $value->devise_id; ?> form-control form-control-lg form-control-light"
											name="prx[<?php echo $value->devise_id; ?>][tax_rate_id]"
											id="prx[<?php echo $value->devise_id; ?>][tax_rate_id]">
											<!--<option value=""></option>-->
											<?php foreach ($tax_rates as $tax_rate) {?>

											<option value="<?php echo $tax_rate->tax_rate_id; ?>"
												<?php if ($tva == $tax_rate->tax_rate_id) {?> selected="selected" <?php }?>>
												<?php echo $tax_rate->tax_rate_name; ?></option>
											<?php }?>
										</select>
										<div class="form-control-focus"></div>
									</div>
                                </div>
                                <?php } else {?>
                                <div class="col-lg-6 col-sm-6 col-xl-12">
                            <div class="has-info">
                                    <label for="form_control_1"><?php echo lang('tax_rate'); ?></label>
                                    <select readonly="readonly" class="sl<?php echo $value->devise_id; ?> form-control form-control-lg form-control-light"
                                        name="prx[<?php echo $value->devise_id; ?>][tax_rate_id]"
                                        id="prx[<?php echo $value->devise_id; ?>][tax_rate_id]">
                                        <option value="3" selected="selected">0</option>
                                    </select>
                                    <div class="form-control-focus"></div>
                                </div>
                                </div>
                                <?php }?>
                   </div>

                    <?php
}

} else {
    foreach ($devises as $value) {
        ?>
		
					 	<div class="row card-row form-row">
                                <div class="col-lg-6 col-sm-6 col-xl-12">
									<div class="has-info">
                                    <label for="form_control_1"><?php echo lang('product_price') . '&nbsp;(' . $value->devise_symbole . ')'; ?></label>
                                    <input value="" type="text" class="form-control form-control-lg form-control-light calcvente<?php echo $value->devise_id; ?>"
                                        name="prx[<?php echo $value->devise_id; ?>][product_price]"
                                        id="prx[<?php echo $value->devise_id; ?>][product_price]">
                                    <div class="form-control-focus"></div>
									</div>
                                </div>
                                <?php if ($typetaxe == 1) {?>
                                    <input type="hidden" name="prx[<?php echo $value->devise_id; ?>][devise]"
                                    id="prx[<?php echo $value->devise_id; ?>][devise]"
                                    value="<?php echo $value->devise_id; ?>">
                                <div class="col-lg-6 col-sm-6 col-xl-12">
									<div class="has-info">
                                    <label for="form_control_1"><?php echo lang('tax_rate'); ?></label>
                                    <select class="sl<?php echo $value->devise_id; ?> form-control form-control-lg form-control-light"
                                        name="prx[<?php echo $value->devise_id; ?>][tax_rate_id]"
                                        id="prx[<?php echo $value->devise_id; ?>][tax_rate_id]">
                                        <!--<option value=""></option>-->
                                        <?php foreach ($tax_rates as $tax_rate) {?>
                                        <option value="<?php echo $tax_rate->tax_rate_id; ?>">
                                            <?php echo $tax_rate->tax_rate_name; ?></option>
                                        <?php }?>
                                    </select>
                                    <div class="form-control-focus"></div>
                                </div>
                                </div>
                                <?php } else {?>
                                    <input type="hidden" name="prx[<?php echo $value->devise_id; ?>][devise]"
                                    id="prx[<?php echo $value->devise_id; ?>][devise]"
                                    value="<?php echo $value->devise_id; ?>">
                                <div class="col-lg-6 col-sm-6 col-xl-12">
									<div class="has-info">
                                    <label for="form_control_1"><?php echo lang('tax_rate'); ?></label>
                                    <select class="sl<?php echo $value->devise_id; ?> form-control form-control-lg form-control-light" readonly="readonly"
                                        name="prx[<?php echo $value->devise_id; ?>][tax_rate_id]"
                                        id="prx[<?php echo $value->devise_id; ?>][tax_rate_id]">
                                        <option value="3">0</option>
                                    </select>
                                    <div class="form-control-focus"></div>
                                </div>
                                </div>
                                <?php }?>
                            </div>
                    <?php
                    }
                    }
                    ?>

</fieldset>
                    <fieldset>
                    <table id="id_tarif_diff">
                        <tr>                               
                           <th style="width: 20%;"><?php echo lang('quantity'); ?></th>
                           <th style="width: 20%;"><?php echo lang('product_price2'); ?></th>
                           <th style="width: 10%;">
                               <button type="button"  onclick="addRowtarif_diff()" value="<?php echo count($tarif) ?>" id="add_tarif_diff" class="btn">Ajouter</button>
                            </th>
                        </tr>
                       
                            <?php $i=0;
                            foreach($tarif as $value){  ?> 
                               <tr id="row_addd_<?php echo $i?>">
                                    <td><input class="form-control form-control-lg form-control-light" type="text" name="quantdiff[]" value="<?php echo $value->quantite_tarif?>" /></td>
                                    <td><input class="form-control form-control-lg form-control-light" type="text"  name="pricediff[]"  value="<?php echo $value->prix?>"/></td>
                                    <td><input type="button" value="Supprimer" onclick="deleteRow(this)"></td>
                               </tr>

                            <?php  $i++; }  ?> 
                        
                    </table>
                    </fieldset>
                    <!-- fin pricing -->
                        </div>
                        <div id="catego" class="tab-pane fade">          
                              <div class="col-lg-6 col-sm-6 col-xl-12">
                                   <div class="select-search-input has-info ">
                                        <label for="form_control_1"><?php echo lang('select_family'); ?></label>
                                            <input style="width: 100%;" readonly="" value="<?php echo  $by_family[0]->family_name; ?>" autocomplete="off" type="text" id='select_family' class="form-control form-control-lg form-control-light form-width-input" >
                                                    
                                            <button id="search_family" type="button" class="btn btn-success">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                            <div class="form-control-focus"></div>
                                        <input type='hidden' id="family_id"  name="family_id" value="<?php echo $by_family[0]->family_id; ?> ">     
                                    </div>  
                              </div>                
                        </div>
                        <div id="li-stock" class="tab-pane fade">   
                        <!--debut stock-->  
                        <table id="tab_stock">                       
                            <tr>       
                                <th></th>                        
                                <th style="width: 10%;"><?php echo lang('reference'); ?></th>
                                <th style="width: 20%;"><?php echo lang('declinaison'); ?></th>
                                <th style="width: 20%;"><?php echo lang('quantity'); ?></th>
                                <th style="width: 20%;"><?php echo lang('product_price2'); ?></th>
                                <th style="width: 10%;"><?php echo lang('depot'); ?></th>
                                <th style="width: 10%;">
                                 <button type="button"  onclick="addRow()" value="<?php echo count($stock); ?>" id="add_aj" class="btn">Ajouter</button>
                                </th>
                            </tr> 
                             
                            <?php 
                              $i=0;
                            foreach ($stock as $keystck => $valuestck) {?>
                            <tr id="row_add_<?php echo $i ?>">   
                                <td><span style="color:red" id="ref_gen"><h4><?php echo $this->mdl_products->form_value('product_sku'); ?>/</h4></span></td>                      
                                <td><input id="ref<?php echo $i ?>" class="form-control form-control-lg form-control-light" type="text" value="<?php 
                                $sp=split('[/]',$valuestck->ref_stock);
                                echo  $sp[1]?>" name="ref[]"/></td>
                                <td id="dec<?php echo $i ?>">
                                    <?php foreach ($groupe as $key=>$value){?>
                                        <select class="form-control form-control-md form-control-light" name="dec<?php echo $i ?>[]">
                                            <?php $res= $this->mdl_option_attribut->getAttribut($value->group_id) ?>
                                            <option value="<?php echo 0 ?>"><?php echo $value->name ?></option>
                                            <?php                                                            
                                            foreach($res as $keyy=>$valuee){
                                               
                                                //return var_dump($this->mdl_declinaison->trouve($valuestck->stock_id,$valuee->id_option_attribut,$value->group_id));die('h'); 
                                                if($this->mdl_declinaison->trouve($valuestck->stock_id,$valuee->id_option_attribut,$valuee->group_id)>0){
                                                ?>                                       
                                                            <option value="<?php echo $value->group_id ?>-<?php echo $valuee->id_option_attribut?>" selected="selected"> <?php echo $valuee->valeur?> </option>
                                                            <?php }else{?>
                                                            <option value="<?php echo $value->group_id ?>-<?php echo $valuee->id_option_attribut?>"> <?php echo $valuee->valeur?> </option>
                                                         <?php }?>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </td> 
                                <td><input type="hidden" name="virtual_stock[]" id="virtual_stock<?php echo $i ?>" value="<?php echo $valuestck->virtual_stock ?>"/>
                                    <input type="hidden" name="actual_stock[]" id="actual_stock<?php echo $i ?>" value="<?php echo $valuestck->actual_stock ?>"/>                                      
                                    <input class="form-control form-control-lg form-control-light" type="text" name="quantite_stock[]" id="quantite_stock<?php echo $i ?>" value="<?php echo $valuestck->quantite_stock ?>"/>
                                </td>
                                <td><input class="form-control form-control-lg form-control-light" type="text"  value="<?php echo $valuestck->prix_stock ?>" name="prix[]"  id="prix<?php echo $i ?>"/></td>
                                <td id="depot<?php echo $i ?>">
                                    <select id="depotsel<?php echo $i ?>" class="form-control form-control-md form-control-light" multiple name="depot<?php echo $i ?>[]">
                                        <?php foreach ($depot as $key=>$value){
                                           if($this->mdl_depot->trouve($valuestck->stock_id,$value->id_depot)>0){
                                        ?>
                                            <option selected value="<?php echo $value->id_depot?>">
                                            <?php echo $value->libelle?>
                                            </option>
                                        <?php }else{ ?>
                                             <option  value="<?php echo $value->id_depot?>">
                                            <?php echo $value->libelle?>
                                            </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><input type="button" value="Supprimer" onclick="deleteRow(this)"></td><td><input type="button" value="Dupliquer" onclick="dupliquer(<?php echo $i ?>)"></td>
                             
                            </tr>  
                          
                            <?php   $i++; } ?>                      
                        </table>
                        <!--fin stock-->                                          
                        </div>
                        <div id="images" class="tab-pane fade">                          
                                   <div class="imgdown">
                                                <?php
                        //var_dump($val->name_file);

                        if (count($file) > 0) {

                            foreach ($file as $key => $val) {
                                $dir_path = base_url() . 'uploads/' . strtolower($this->session->userdata['licence']) . '/fileproduct/' . $val->name_file;

                                ?>
                                                <ul class="list-group">
                                                    <li class="col-md-6 list-group-item lidel<?php echo $val->id_file_product ?>">
                                                        <a href="<?php echo $dir_path ?>" download> <img onclick='openfile('
                                                                <?php echo $dir_path ?>')' height="100" width="150"
                                                                src="<?php echo $dir_path ?> "></a>
                                                        <button onclick=btndel(<?php echo $val->id_file_product ?>)
                                                            class="btn btn-xs btn-danger" type="button">
                                                            <i class="glyphicon glyphicon-trash"></i> <?php echo lang('delete'); ?>
                                                        </button>
                                                    </li>
                                                </ul>
                                                <?php }?>
                                                <div class="row card-row form-row">
                                                    <div class="col-md-12">
                                                        <label for="form_control_1"><?php echo lang('drop_images'); ?></label>
                                                        <br>
                                                        <input id="myFile" type="file" name="images[]" multiple>
                                                    </div>
                                                </div>
                                                <?php } else {?>
                                                <div class="row card-row form-row">
                                                    <div class="col-md-12">
                                                    <label for="form_control_1"><?php echo lang('drop_images'); ?></label>
                                                        <br>
                                                        <input id="myFile" type="file" name="images[]" multiple>
                                                    </div>
                                                </div>
                                                <?php }?>

                                </div>
                        </div>
                </div>
		</div>
	</div>    
    <input type='hidden' id="langselect" value=""> 
</div>	
<?php if ($this->mdl_products->form_value('product_id')) {if (($this->mdl_products->form_value('prod_service')) == 0) {?>
<script>
$(".code_barre_div").attr("hidden", false);
$(".unite_id_div").attr("hidden", false);
$(".quantite_div").attr("hidden", false);
$(".stock_div").attr("hidden", false);
$(".imgdown").attr("hidden", false);
$(".li-img").attr("style", "display:block");
$(".poids").attr("hidden", false);
$(".marque").attr("hidden", false);
$(".consommation").attr("hidden", false);
</script>
<?php } else {?>
<script>
$(".code_barre_div").attr("hidden", true);
$(".unite_id_div").attr("hidden", true);
$(".quantite_div").attr("hidden", true);
$(".stock_div").attr("hidden", true);
$(".imgdown").attr("hidden", true);
$(".li-img").attr("style", "display:none");
$(".poids").attr("hidden", true);
$(".marque").attr("hidden", true);
$(".consommation").attr("hidden", true);

</script>
<?php }}?>

<script>
$("#prod_service").change(function() {
    if ($("#prod_service").val() == 0) {
        $(".code_barre_div").attr("hidden", false);
        $(".unite_id_div").attr("hidden", false);
        $(".quantite_div").attr("hidden", false);
        $(".stock_div").attr("hidden", false);
        $(".imgdown").attr("hidden", false);
        $(".li-img").attr("style", "display:block");
        $(".poids").attr("hidden", false);
        $(".marque").attr("hidden", false);
        $(".consommation").attr("hidden", false);
    } else {
        $(".code_barre_div").attr("hidden", true);
        $(".unite_id_div").attr("hidden", true);
        $(".quantite_div").attr("hidden", true);
        $(".stock_div").attr("hidden", true);
        $(".imgdown").attr("hidden", true);
        $(".li-img").attr("style", "display:none");
        $(".poids").attr("hidden", true);
        $(".marque").attr("hidden", true);
        $(".consommation").attr("hidden", true);
        $("#code_barre").val('');
        $("#quantite").val('');
        $("#stock").val('');
    }
});


function btndel(e) {
    $('.lidel' + e).remove();
    $.ajax({
        url: '/products/deletefilproduct/' + e,
        type: 'POST',

    });
}
</script>
<script>
$('#search_client').click(function() {
    $('#modal-placeholder').load(
        "<?php echo site_url('fournisseurs/ajax/modal_fournisseur_lookup'); ?>/" +
        Math.floor(Math.random() * 1000), {

        });
});

$('#search_family').click(function() {
    $('#modal-placeholder').load(
        "<?php echo site_url('families/ajax/modal_families_lookup'); ?>/" +
        Math.floor(Math.random() * 1000), {

        });
});
</script>
<?php if (gestionstock() == false) {?>
<script>
$('#poids').attr("disabled", 'disabled');
$('#marque').attr("disabled", 'disabled');
$('#quantite').attr("disabled", 'disabled');
$('#stock').attr("disabled", 'disabled');
$('#unite_id').attr("disabled", 'disabled');
$('#unite_id').attr("disabled", 'disabled');
$('#myFile').attr("disabled", 'disabled');
</script>
<?php }?>

<script>

  $(".dropdown img.flag").addClass("flagvisibility");
        $(".dropdown dt a").click(function() {
            $(".dropdown dd ul").toggle();
        });
                    
        $(".dropdown dd ul li a").click(function() {
            var text = $(this).html();
            $(".dropdown dt a span").html(text);
            $(".dropdown dd ul").hide();
            $("#result").html("Selected value is: " + getSelectedValue("sample"));
        });
                    
        function getSelectedValue(id) {
            return $("#" + id).find("dt a span.value").html();
        }
    
        $(document).bind('click', function(e) {
            var $clicked = $(e.target);
            if (! $clicked.parents().hasClass("dropdown"))
                $(".dropdown dd ul").hide();
        });
    
        $(".dropdown img.flag").toggleClass("flagvisibility");
        $('.fr_dv').hide();
        $('.en_dv').hide(); 
        $('.ar_dv').hide(); 
        $('.lbar_dv').hide(); 
        $('.lbfr_dv').hide();
        $('.lben_dv').hide(); 
        getlicountry($('#langue').val());      
        var vl=$('#lgn').val();   
        if(!$('#langue').val()){
            switch (vl){
            case 'ar':
            $('.lbar_dv').show(); 
            $('.lbfr_dv').hide();
            $('.lben_dv').hide(); 
            $('.en_dv').hide();  
            $('.ar_dv').show();
            $('.fr_dv').hide();
            break;
            case 'en':
            $('.lben_dv').show();  
            $('.lbar_dv').hide();
            $('.lbfr_dv').hide();
            $('.en_dv').show();  
            $('.ar_dv').hide();
            $('.fr_dv').hide();
            break;
            case 'fr':
            $('.lbfr_dv').show();  
            $('.lbar_dv').hide();
            $('.lben_dv').hide();
            $('.en_dv').hide();  
            $('.ar_dv').hide();
            $('.fr_dv').show();
            break;
        }  
        }else{
            switch ($('#langue').val()){
            case 'Arabic':
            $('.lbar_dv').show(); 
            $('.lbfr_dv').hide();
            $('.lben_dv').hide(); 
            break;
            case 'English':
            $('.lben_dv').show();  
            $('.lbar_dv').hide();
            $('.lbfr_dv').hide();
            break;
            case 'French':
            $('.lbfr_dv').show();  
            $('.lbar_dv').hide();
            $('.lben_dv').hide();
            break;
        }
        }    
       
/*$("#quantite").keyup(function() {  
    changedItemTable($(this),"quantite", "float2")
});*/
 /* function changedItemTable(curr, item, type) {
    var dataid = curr.data('id');
    var id = curr.attr('id');
    var valeur = curr.val();
   if (accepted_float_input(valeur) != valeur) {
            $("#" + id).val(accepted_float_input(valeur));
            valeur = numberFormatFloat(valeur, "2");
        }
        $("#quantite").val(valeur);     
       // valeur =   
   
}*/
  $("#marge").keyup(function(){   
     for (let i = 0; i < 9; i++) {        
        $('.calcvente'+i).val(((Number($('#purchase_price').val())*(($("#marge").val()/100)))+ Number($('#purchase_price').val())).toFixed(3));
        
     }
  });
  $('#tax_rate_id').change(function(){
    for (let i = 0; i < 9; i++) {     
        $('.sl'+i).val($('#tax_rate_id').val())
    }
  })
  


function addRowtarif_diff(){
    var i = $('#add_tarif_diff').val();
    $("#id_tarif_diff").append('<tr id="row_addd_'+i+'"><td><input class="form-control form-control-lg form-control-light" type="text" name="quantdiff[]"/></td><td><input class="form-control form-control-lg form-control-light" type="text"  name="pricediff[]"/></td><td><input type="button" value="Supprimer" onclick="deleteRow(this)"></td></tr>');
   
    $('#add_tarif_diff').val(Number($('#add_tarif_diff').val())+1);
     
}
function addRow() {      
    var i = $('#add_aj').val();
    $("#tab_stock").append('<tr id="row_add_'+i+'"><td><span style="color:red" id="ref_gen"><h4>'+$("#product_sku").val()+'/</h4></span></td><td><input id="ref'+i+'" class="form-control form-control-lg form-control-light" type="text" name="ref[]"/></td><td id="dec'+i+'"><?php foreach ($groupe as $key=>$value){?><select class="selectpicker form-control form-control-md form-control-light" name="dec'+i+'[]"><?php $res= $this->mdl_option_attribut->getAttribut($value->group_id) ?><option value="<?php echo 0 ?>"><?php echo $value->name ?></option><?php foreach($res as $keyy=>$valuee){ ?><option value="<?php echo $value->group_id ?>-<?php echo $valuee->id_option_attribut?>"><?php echo $valuee->valeur?></option><?php } ?></select><?php } ?></td><td><input class="form-control form-control-lg form-control-light" type="text" name="quantite_stock[]" id="quantite_stock'+i+'"/><input class="form-control form-control-lg form-control-light" type="hidden" value="0" name="actual_stock[]" id="actual_stock'+i+'"/><input class="form-control form-control-lg form-control-light" type="hidden" value="0" name="virtual_stock[]" id="virtual_stock'+i+'"/></td><td><input class="form-control form-control-lg form-control-light" type="text" value="'+$('.calcvente1').val()+'" name="prix[]"  id="prix'+i+'"/></td><td id="depot'+i+'"><select id="depotsel'+i+'" class="form-control form-control-md form-control-light" multiple name="depot'+i+'[]"><?php foreach ($depot as $key=>$value){?><option value="<?php echo $value->id_depot?>"><?php echo $value->libelle?></option><?php } ?></select></td><td><input type="button" value="Supprimer" onclick="deleteRow(this)"></td><td><input type="button" value="Dupliquer" onclick="dupliquer('+i+')"></td></tr>');
    $('#add_aj').val(Number($('#add_aj').val())+1);
}

function deleteRow(button) {
  var row = button.parentNode.parentNode;
  var tbody = row.parentNode;
  tbody.removeChild(row);
  
  // refactoring numbering
 /* var rows = tbody.getElementsByTagName("tr");
  for (var i = 1; i < rows.length; i++) {
  	var currentRow = rows[i];
    currentRow.childNodes[0].innerText = i.toLocaleString() + '.';
  }*/
  
}

function dupliquer(j){
    var ref=$('#ref'+j).val();
    var quantite=$('#quantite_stock'+j).val();
    var prix=$('#prix'+j).val();
    var dec=$('#dec'+j).html();
    var depot=$('#depot'+j).clone().html();
    var product_sku=$('#product_sku').val();
    var i = Number($('#add_aj').val())+1;
    $('#add_aj').val(i);
    $("#tab_stock").append('<tr id="row_add_'+i+'"><td><span style="color:red" id="ref_gen"><h4>'+product_sku+'/</h4></span></td><td><input id="ref'+i+'" class="form-control form-control-lg form-control-light" value="'+ref+'" type="text" name="ref[]"/></td><td id="dec'+i+'">'+dec+'</td><td><input class="form-control form-control-lg form-control-light" type="hidden" value="0" id="actual_stock'+i+'" value="0" name="actual_stock[]"/><input class="form-control form-control-lg form-control-light" type="hidden" value="0" id="virtual_stock'+i+'" value="0" name="virtual_stock[]"/><input class="form-control form-control-lg form-control-light" type="text"  id="quantite_stock'+i+'" value="'+quantite+'" name="quantite_stock[]"/></td><td><input class="form-control form-control-lg form-control-light" type="text"  id="prix'+i+'" value="'+prix+'"  name="prix[]"/></td><td id="depot'+i+'">'+depot+'</td><td><input type="button" value="Supprimer" onclick="deleteRow(this)"></td><td><input type="button" value="Dupliquer" onclick="dupliquer('+i+')"></td></tr>');
    $('#row_add_'+i+' td#dec'+i+' select').removeAttr("name");
    $('#row_add_'+i+' td#dec'+i+' select').attr("name","dec"+i+"[]");
   
    $('#row_add_'+i+' td#depot'+i+' select').removeAttr("name");
    $('#row_add_'+i+' td#depot'+i+' select').attr("name","depot"+i+"[]");
}
$('#product_sku').keyup(function() {
    //$('#ref_gen').html('hh');
    $('td span#ref_gen').each(function(){
       $(this).html('<h4>'+$('#product_sku').val()+'/</h4>');
    }) 
})  
</script>
<!--
<select class="selectpicker" multiple title="Choose one of the following...">
        <option>Mustard</option>
        <option>Ketchup</option>
        <option>Relish</option>
    </select>
    -->


    