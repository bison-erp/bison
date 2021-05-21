<style>
 .select ul li.option {
  background-color: #DEDEDE;
  box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
  -webkit-box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
  -moz-box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
}

.select ul li.option:hover {
  background-color: #B8B8B8;
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

 </style>

<script type="text/javascript">
$(function() {

    // Display the create invoice modal
    $('#create-product').modal('show');
    $("#create-product .close").click(function() {
        $('#modal-placeholder').load("<?php echo site_url('products/ajax/modal_product_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {
                devise: $('#devise').val(),
                type_doc: $('#type_doc').val()
            });
    });
    $('#product_create_confirm').click(function() {
        var prx_devise = [];
        var prx_price = [];
        var prx_tax = [];

        $("input[name='prx[devise][]']").each(function(key, value) {
            prx_devise.push($(this).val());
        });

        $("input[name='prx[product_price][]']").each(function(key, value) {
            prx_price.push($(this).val());
        });

        $("select[name='prx[tax_rate_id][]']").each(function(key, value) {
            prx_tax.push($(this).val());
        });
        //var ofile = document.getElementById('images').files;
        //   var arrayfile = new Array();
        /*  for (var i = 0; i < ofile.length; i++) {
              arrayfile.push(ofile[i].name + '//' + ofile[i].size + '//' + ofile[i].type);

              //   arrayfile.push(ofile[i].type);
          }*/


        //            prx = JSON.stringify(document.getElementById('prx'));
        $.post("<?php echo site_url('products/ajax/create'); ?>", {
                family_id: $('#family_id').val(),
                product_name: $('#product_name').val(),
                product_description: $('#product_description').val(),
                product_sku: $('#product_sku').val(),
                purchase_price: $('#purchase_price').val(),
                tax_rate_id: $('#tax_rate_id').val(),
                prx_devise: prx_devise,
                prx_price: prx_price,
                prx_tax: prx_tax,
                prod_service: $('#prod_service').val(),
                marge: $('#marge').val(),
                poids: $('#poids').val(),
                quantite: $('#quantite').val(),
                code_barre: $('#code_barre').val(),
                marque: $('#marque').val(),
                stock: $('#stock').val(),
                unite_id: $('#unite_id').val(),
                langue : $('#langue').val(),
                product_description_eng: $('#product_description_eng').val(),
                product_description_ar: $('#product_description_ar').val(),
                product_name_en: $('#product_name_en').val(),
                product_name_ar: $('#product_name_ar').val(),
                // images: arrayfile,
            },
            function(data) {
                //                alert(data);
                var response = JSON.parse(data);
                if (response.success === 1) {
                    $('#create-product').modal('hide');
                    $('#modal-placeholder').load(
                        "<?php echo site_url('products/ajax/modal_product_lookup'); ?>/" + Math
                        .floor(Math.random() * 1000), {
                            devise: $('#devise').val(),
                            type_doc: $('#type_doc').val()
                        },
                        function() {

                            $("#checkbox310_" + response.product_id + "").prop("checked", true);
                            //  myFunction();
                        });
                } else
                    alert(response.validation_errors);

            });
    });

});
$("#prod_service").change(function() {
    if ($("#prod_service").val() == 0) {
        $(".code_barre_div").attr("hidden", false);
        $(".unite_id").attr("hidden", false);
        $(".quantite_div").attr("hidden", false);
        $(".stock_div").attr("hidden", false);
        $(".imgdown").attr("hidden", false);
        $(".poids").attr("hidden", false);
        $(".marque").attr("hidden", false);
    } else {
        $(".code_barre_div").attr("hidden", true);
        $(".unite_id").attr("hidden", true);
        $(".quantite_div").attr("hidden", true);
        $(".stock_div").attr("hidden", true);
        $(".imgdown").attr("hidden", true);
        $(".poids").attr("hidden", true);
        $(".marque").attr("hidden", true);
        $("#code_barre").val('');
        $("#quantite").val('');
        $("#stock").val('');
    }
});
</script>
<input type="hidden" id="type_doc" value="<?php echo $type_doc; ?>">
<input type="hidden" id="gestionstock" value="<?php echo $gestionstock; ?>">
<style>
.min_top {
    margin-top: 35px;
}
</style>

<br><br>
<div id="create-product" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
  
    aria-labelledby="modal-choose-items" aria-hidden="true"
    style="display: block;width: 65%;height: 85%;overflow:hidden !important;z-index: 99999;margin-top: 22px;border-radius: 6px;">
    <input type="hidden" id="lgn" value="<?php echo lang('cldr') ?>">

    <form class="modal-content" style=" width: 100%" enctype="multipart/form-data">
        <div class="modal-header" style="height: 70px">
            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>
            <h3><?php echo lang('add_product'); ?></h3>
        </div>
        <input type="hidden" name="langue" id="langue" >
        <div style="clear:both"></div>
        <div class="modal-body" style="margin-top: 70px;">
            <fieldset style="padding-bottom:10px;margin-bottom:10px">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group form-md-line-input has-info">
                        <select class="form-control" name="family_id" id="family_id">
                            <?php foreach ($families as $family) {?>
                            <option value="<?php echo $family->family_id; ?>"><?php echo $family->family_name; ?>
                            </option>
                            <?php }?>
                        </select>
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"><?php echo lang('select_family'); ?></label>
                    </div>
                </div>
               
                <div class="col-xs-12 col-sm-1">
                    <div class="form-group form-md-line-input has-info">
                    
                    <dl class="dropdown" style="margin-top: auto;">
                    <dt>
                    <a><span style="font-size:12px"><?php echo lang('language') ?></span></a>

                    </dt>
                    <?php
                       $tab =explode(',',$default_language_document); 
                      // var_dump($tab);
                    ?>
                    <dd>
                    <ul class="paylangue" style="display: none; z-index: 9999;">
                    <?php 
                             foreach(array_filter($tab) as $key => $value){
                                                               
                                $img1 = (base_url().'/assets/default/img/' . $value.'.png');  ?>
                    <li onclick="getlicountry('<?php echo $value; ?>')" ><a href="#"> <img class="flag" src="<?php echo $img1; ?>" alt="" /><span class="value"><?php echo $value; ?></span></a></li>
                             <?php  } ?>
                             </ul></dd></dl>
                             </div>
                         
                    
                </div>
                <div class="col-xs-12 col-sm-5">
                    <div class="form-group form-md-line-input has-info">
                        <input type="text" class="form-control" id="product_sku" name="product_sku">
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"><?php echo lang('product_sku'); ?></label>
                    </div>
                </div>

                <div class="lben_dv col-xs-12 col-sm-6">
                    <div class="form-group form-md-line-input has-info">
                        <input type="text" class="form-control" id="product_name_en" name="product_name_en">
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"><?php echo lang('product_name'); ?>
                        <span
                                            style="color: #F60922; margin-left: 5px;"> 
                                            <?php 
                                                               
                                                               $img1 = (base_url().'/assets/default/img/English.png');  ?>
                                                               <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                            </span>
                        
                        </label>
                    </div>
                </div>
                <div class="lbfr_dv col-xs-12 col-sm-6">
                    <div class="form-group form-md-line-input has-info">
                        <input type="text" class="form-control" id="product_name" name="product_name">
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"><?php echo lang('product_name'); ?>
                        <span
                                            style="color: #F60922; margin-left: 5px;"> 
                                            <?php 
                                                               
                                                               $img1 = (base_url().'/assets/default/img/French.png');  ?>
                                                               <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                            </span>
                        </label>
                    </div>
                </div>
                <div class="lbar_dv col-xs-12 col-sm-6">
                    <div class="form-group form-md-line-input has-info">
                        <input type="text" class="form-control" id="product_name_ar" name="product_name_ar">
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"><?php echo lang('product_name'); ?>
                        <span
                                            style="color: #F60922; margin-left: 5px;"> 
                                            <?php 
                                                               
                                                               $img1 = (base_url().'/assets/default/img/Arabic.png');  ?>
                                                               <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                            </span>
                        
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group form-md-line-input has-info">
                        <select class="form-control" name="prod_service" id="prod_service">
                            <option value="0">
                                Produit
                            </option>
                            <option value="1">
                                Service
                            </option>
                        </select>
                        <div class="form-control-focus"></div>
                        <label for="form_control_1">Type</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 poids">
                    <div class="form-group form-md-line-input has-info">
                        <input value="<?php echo $this->mdl_products->form_value('poids'); ?>" type="text"
                            class="form-control" id="poids" name="poids">

                        <div class="form-control-focus"></div>

                        <label for="form_control_1">Poids </label>

                    </div>
                </div>
                <div class="fr_dv col-xs-12 col-sm-6">
                    <div class="form-group form-md-line-input has-info">
                        <textarea name="product_description" rows="1" id="product_description" class="form-control"
                            style="resize:vertical; max-height:90px;"></textarea>
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"><?php echo lang('product_description'); ?>
                        <?php                                                                
                                $img1 = (base_url().'/assets/default/img/French.png');  ?>
                                <img class="flag" src="<?php echo $img1; ?>" alt="" />        
                        </label>
                    </div>
                </div>
                <div class="en_dv col-xs-12 col-sm-6">
                        <div  id='English' class="form-group form-md-line-input has-info" style="margin: 0px 0px 20px;width: 100%;">
                            <textarea name="product_description_eng" rows="2" id="product_description_eng"
                                class="form-control"></textarea>
                            <div class="form-control-focus" style="margin: 0px;"></div>
                            <label for="form_control_1"
                                style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_description'); ?><span
                                    style="color: #F60922; margin-left: 5px;">*</span>
                                    <?php                                                                
                                $img1 = (base_url().'/assets/default/img/English.png');  ?>
                                <img class="flag" src="<?php echo $img1; ?>" alt="" />                                   
                                    </label>
                        </div>
                    </div>
                    <div class="ar_dv col-xs-12 col-sm-6">
                        <div   id='Arabic' class="form-group form-md-line-input has-info" style="margin: 0px 0px 20px;width: 100%;">
                            <textarea name="product_description_ar" rows="2" id="product_description_ar"
                                class="form-control"></textarea>
                            <div class="form-control-focus" style="margin: 0px;"></div>
                            <label for="form_control_1"
                                style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_description'); ?><span
                                    style="color: #F60922; margin-left: 5px;">*</span>
                                    <?php 
                            $img1 = (base_url().'/assets/default/img/Arabic.png');  ?>
                              
                                <img class="flag" src="<?php echo $img1; ?>" alt="" />
                                </span>                      
                                    </label>
                        </div>               
                    </div>

                <?php

if (gestionstock() == true) {?>
                <div class="col-xs-12 col-sm-4 quantite_div">
                    <div class="form-group form-md-line-input has-info">
                        <input value="<?php echo $this->mdl_products->form_value('quantite'); ?>" type="number"
                            class="form-control" id="quantite" name="quantite">

                        <div class="form-control-focus"></div>

                        <label for="form_control_1">Quantité </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 code_barre_div">
                    <div class="form-group form-md-line-input has-info" style="margin: 0px 0px 20px;width: 95%;">
                        <input value="<?php echo $this->mdl_products->form_value('code_barre'); ?>" type="text"
                            class="form-control" id="code_barre" name="code_barre">
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"
                            style="font-size: 13px; color: #899a9a;margin-top: -15px;">Code-barres</label>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 marque">
                    <div class="form-group form-md-line-input has-info" style="margin: 0px 0px 20px;width: 95%;">
                        <input value="<?php echo $this->mdl_products->form_value('marque'); ?>" type="text"
                            class="form-control" id="marque" name="marque">
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"
                            style="font-size: 13px; color: #899a9a;margin-top: -15px;">Marque</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                    <div class="col-xs-12 col-md-6 stock_div">
                        <div class="form-group form-md-line-input has-info" style="margin: 0px 0px 20px;width: 95%;">
                            <input value="<?php echo $this->mdl_products->form_value('stock'); ?>" type="text"
                                class="form-control" id="stock" name="stock">
                            <div class="form-control-focus"></div>
                            <label for="form_control_1" style="font-size: 13px; color: #899a9a;margin-top: -15px;">Stock
                                alerte</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 unite_id">
                        <div class="form-group form-md-line-input has-info">
                            <select class="form-control" name="unite_id" id="unite_id">
                                <!--<option value=""></option>-->
                                <?php foreach ($unite as $unite) {?>
                                <option value="<?php echo $unite->id_unite; ?>"
                                    <?php if ($this->mdl_products->form_value('unite_id') == $unite->id_unite) {?>selected="selected"
                                    <?php } elseif ($unite->id_unite == 3) {?>selected="selected" <?php }?>>
                                    <?php echo $unite->designation; ?>
                                </option>
                                <?php }?>
                            </select>
                            <div class="form-control-focus" style="margin: 0px;"></div>
                            <label for="form_control_1"
                                style="margin-left: -15px;font-size: 13px; color: #899a9a;margin-top: -15px;">Unité<span
                                    style="color: #F60922; margin-left: 5px;">*</span></label>

                        </div>
                    </div>
                </div>
                <?php } else {?>

                <input value="<?php echo $this->mdl_products->form_value('quantite'); ?>" type="hidden"
                    class="form-control" id="quantite" hidden name="quantite">
                <input value="<?php echo $this->mdl_products->form_value('code_barre'); ?>" type="hidden"
                    class="form-control" id="code_barre" name="code_barre">
                <input value="<?php echo $this->mdl_products->form_value('marque'); ?>" type="hidden"
                    class="form-control" id="marque" name="marque">
                <input value="<?php echo $this->mdl_products->form_value('stock'); ?>" type="hidden"
                    class="form-control" id="stock" name="stock">

                <input value="<?php echo $this->mdl_products->form_value('marque'); ?>" type="hidden"
                    class="form-control" id="unite_id" name="unite_id">
                <?php }?>
                <input value="<?php echo $this->mdl_products->form_value('marge'); ?>" type="hidden"
                    class="form-control" id="marge" name="marge">

                <div class="col-xs-4 col-sm-4"> <br>
                    <div class="form-group form-md-line-input has-info">

                        <input type="hidden" name="file" id="images" multiple>

                    </div>
                </div>
                <div class="col-xs-4 col-sm-12">
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="form-group form-md-line-input has-info">
                        <input type="text" class="form-control" name="purchase_price" id="purchase_price">
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"><?php echo lang('purchase_price'); ?></label>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="form-group form-md-line-input has-info">
                        <select class="form-control" name="tax_rate_id" id="tax_rate_id">
                            <?php foreach ($tax_rates as $tax_rate) {?>
                            <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                <?php if ($this->mdl_products->form_value('tax_rate_id') == $tax_rate->tax_rate_id) {?>
                                selected="selected" <?php }?>><?php echo $tax_rate->tax_rate_name; ?></option>
                            <?php }?>
                        </select>
                        <div class="form-control-focus"></div>
                        <label for="form_control_1"><?php echo lang('tax_rate'); ?></label>
                    </div>
                </div>
                <?php foreach ($devises as $value) {?>
                <div class="col-xs-12 col-sm-3 min_top">
                    <?php echo lang('product_price') . '&nbsp;(' . $value->devise_symbole . ')'; ?>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group form-md-line-input has-info">
                        <input type="hidden" name="prx[devise][]" id="prx[devise][]"
                            value="<?php echo $value->devise_id; ?>">
                        <input type="text" class="form-control" name="prx[product_price][]" id="prx[product_price][]">
                        <div class="form-control-focus"></div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-2 min_top">
                    <?php echo lang('tax_rate'); ?>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group form-md-line-input has-info">
                        <select class="form-control" name="prx[tax_rate_id][]" id="prx[tax_rate_id][]">
                            <?php if ($typetaxe == 0) {?>
                            <option value=3>0
                            </option>
                            <?php } else {?>
                            <?php foreach ($tax_rates as $tax_rate) {?>
                            <option value="<?php echo $tax_rate->tax_rate_id; ?>">
                                <?php echo $tax_rate->tax_rate_name; ?></option>
                            <?php }}?>
                        </select>
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <?php }?>

            </fieldset>
        </div>
        <div class="modal-footer" style="border:none">
            <div class="btn-group">
                <button class="btn btn-danger btn-sm default" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo lang('cancel'); ?>
                </button>
                <button class="btn btn-success btn-sm blue" id="product_create_confirm" type="button" name="btn_submit">
                    <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
    </form>
</div>

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
        function getlicountry(id) {    
            var o = new Object();
            //alert(id);  
           /* o[0]="Arabic";
            o[1]="English";
            o[2]="French";*/
         o['Arabic'] = "Arabic";
        o['English'] = 'English';
        o['French'] = 'French';  
          $('#langue').val(id);
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
        }
        $('.fr_dv').hide();
        $('.en_dv').hide(); 
        $('.ar_dv').hide();
        if($('#lgn').val()){
            switch ($('#lgn').val()){
            case 'ar':
            $('.lbar_dv').show(); 
            $('.lbfr_dv').hide();
            $('.lben_dv').hide(); 
            break;
            case 'en':
            $('.lben_dv').show();  
            $('.lbar_dv').hide();
            $('.lbfr_dv').hide();
            break;
            case 'fr':
            $('.lbfr_dv').show();  
            $('.lbar_dv').hide();
            $('.lben_dv').hide();
            break;
        }  
      }
      /*  $("licountry_").click(function(){
 var selectedCountry = $(this).val();

alert("You have selected the country - " + selectedCountry);

});*/

</script>