<script type="text/javascript">
var count = parseInt($('#count').val());
var langue =$('#langue').val();
function del(e,f) {
    var currentRow = $(this).closest("tr");
    var trsup = $('#trdel_' + e+'_'+f);
    // console.log(e,f);

    $.post("<?php echo site_url('products/ajax/getProductid/'); ?>", {
        id: e,
        dec_id: f,
    }, function(data) {        
        var json_response = JSON.parse(data);
        var famille = json_response[0].family_name;
        var produit = json_response[0].product_sku;
            //  console.log(data['family_name']);
        var desc = "";
        var ref = "";
        //var ref = json_response[0].product_name;
        if(langue=="Arabic"){
            desc = desc + json_response[0].product_description_ar;
            ref = ref + json_response[0].product_name_ar;
        }else if(langue=="English"){
            desc = desc + json_response[0].product_description_en;
            ref = ref + json_response[0].product_name_en;
        }else{
            desc = desc + json_response[0].product_description;
            ref = ref + json_response[0].product_name;
        }
      //  var desc = json_response[0].product_description;
        var price = json_response[0].product_price;
        // console.log(json_response[0].family_name);
        $('#products_table').append(
            '<tr class="prod_' + e + '" prod_id="' + e +
            '"><td class="text-left"><div class="md-checkbox"><input type="checkbox" name="product_ids[]" id="checkbox310_' +
            e + '_0" value="' + e + '" class="azerty md-check"><label for="checkbox310_' + e +
            '"><span></span><span class="check"></span><span class="box"></span></label></div></td><td>aaaaaaa</td><td>' +
            produit +
            '</td><td>' + famille + '</td><td>' + ref + '</td><td>' + desc +
            '</td><td style=" white-space:nowrap;" align="right">' + price +
            '</td></tr>');

    })

    // $("#products_table tr td")[$("#products_table tr").length].innerHtml = "";
    trsup.remove();
    count = parseInt(count - 1);
    $('#count').val(count);
    if (count > 0) {
        $("#mod_footer").show();
    } else {
        $("#mod_footer").hide();
    }
    products_filter();
}

function products_filter() {
    var filter_family = $('#filter_family').val();
    var filter_product = $('#filter_product').val();
    var lookup_url = "<?php echo site_url('products/ajax/partial_modal_product_lookup'); ?>/";
    lookup_url += Math.floor(Math.random() * 1000) + '/?';

    if (filter_family) {
        lookup_url += "&filter_family=" + filter_family;
    }

    if (filter_product) {
        lookup_url += "&filter_product=" + filter_product;
    }
    if($('#devise').val()){
        lookup_url += "&devise=" + $('#devise').val();
    }   
    lookup_url += "&langue="+langue;
    $("#products_table tbody").load(lookup_url);

}
$(function() {

    // Display the create invoice modal
    $('#modal-choose-items').modal('show');
    $('#products_table tr.prod').each(function() {
        $(this).find('.price_item_modal').html
        price_item = $(this).find('.price_item_modal').html();
        price_item = Number(price_item.replace(/[^0-9\.]+/g, ""));

        $(this).find('.devise').html($('#symbole_devise').val());

    });
    var called = false;
    // Creates the invoice
    $('#select-items-confirmx').click(function() {
      
        if (!called) {
            called = true;
            var product_ids = [];
            var depot = [];
            
            $("#product_select input[name='product_ids[]']").each(function() {                
                product_ids.push($(this).val());
            });
            $("#product_select input[name='depot[]'").each(function() {                
                    depot.push($(this).val());
            });

            // console.log(depot);
            $.post("<?php echo site_url('products/ajax/process_product_selection'); ?>", {
                product_ids: product_ids,
                depot: depot,
                devise_symbole: $('#symbole_devise').val(),
                devise: $('#devise').val()
            }, function(data) {
                items = JSON.parse(data);
             
                for (var key in items) {
                    // Set default tax rate id if empty
                    if (!items[key].tax_rate_id)
                        items[key].tax_rate_id = 0;
                    $('#ids').val(product_ids);  
                 
                //    console.log(items[key][0]);  
                    addRow(items[key]);
                }
                $('#modal-choose-items').modal('hide');
                $(".name_prod").focus();
                $('.name_prod').typeahead();
            });
        }
    });

    $('#filter_product').keyup(function() {
        products_filter();
    });

    // Filter on family dropdown change
    $("#filter_family").change(function() {
        products_filter();
    });

    // Filter products
    function products_filter() {
        var filter_family = $('#filter_family').val();
        var filter_product = $('#filter_product').val();
        var lookup_url = "<?php echo site_url('products/ajax/partial_modal_product_lookup'); ?>/";
        lookup_url += Math.floor(Math.random() * 1000) + '/?';

        if (filter_family) {
            lookup_url += "&filter_family=" + filter_family;
        }

        if (filter_product) {
            lookup_url += "&filter_product=" + filter_product;
        }
        lookup_url += "&devise=" + $('#devise').val();
        lookup_url += "&langue="+langue;
        $("#products_table tbody").load(lookup_url);

    }

    $('#add_product_btn_modal').click(function() {
        $('#modal-choose-items').modal('hide');
        $('#modal-placeholder').load("<?php echo site_url('products/ajax/modal_product_add'); ?>/" +
            Math.floor(Math.random() * 1000), {
                type_doc: $("#type_doc").val()
            });
    });
});
</script>
<input type="hidden" id="type_doc" value="<?php echo $type_doc; ?>">
<input type='hidden' id='addrowid' value='0'>

<div id="modal-choose-items" class="modal" role="dialog" aria-labelledby="modal-choose-items" aria-hidden="true">

    <div class="modal-content">
        <div class="modal-body commande">
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
                    <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                        style="width: 22px;height: 20px;color: #FFF !important;background-image: none !important; background-color: rgb(220, 53, 88) !important;text-align: center;text-indent: 0px;opacity: 1;">
                        <i class="fa fa-close"></i></button>
                    <table>
                        <tr>
                            <td width="50%">
                            <input type="hidden" value="<?php echo $langue;?>">

                                <h4 style="margin-bottom: 15px;"><b><?php echo lang('view_selected_product'); ?></b></h4>
                            </td>
                        </tr>
                    </table>
					<div class="table-responsive">
                    <table class="table  col-sm-12 col-lg-12 col-md-12 col-xl-12" id="product_select">
                        <tr>
                            <th width="20%"><?php echo lang('product_sku2'); ?> <?php echo lang('product_name2');?></th>
                            <th width="20%"><?php echo lang('family_name2'); ?></th>
                            <th width="15%"><?php echo lang('product'); ?></th>
                            <th width="25%"><?php echo lang('product_description'); ?></th>
                            <th width="15%"><?php echo lang('product_price'); ?></th>
                            <th width="5%"></th>
                        </tr>
                        <tbody>
                        </tbody>
                    </table>
					</div>
                    <input type='hidden' id='count' value='0'>
                </div>
            </div>
            <div class="row">
                <div class="cols-sm-12 col-lg-12 col-md-12 col-xl-12">
                    <h4 style="margin-bottom: 15px;"><b><?php echo lang('add_product'); ?></b></h4>
                </div>
            </div>
            <div class="row ajout-prod">
                <div class="cols-sm-3  col-md-3 col-xl-3">
                    <input type="text" class="form-control" name="filter_product" id="filter_product"
                        placeholder="<?php echo lang('search_name'); ?>" value="<?php echo $filter_product ?>">
                </div>
                <div class="cols-sm-3 col-lg-3 col-md-3 col-xl-3">
                    <select name="filter_family" id="filter_family" class="form-control">
                        <option value=""><?php echo lang('any_family'); ?></option>
                        <?php foreach ($families as $family) {?>
                        <option value="<?php echo $family->family_id; ?>" <?php if ($family->family_id == $filter_family) {
    echo ' selected="selected"';
}
    ?>><?php echo $family->family_name; ?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="cols-sm-2 col-lg-2 col-md-2 col-xl-2">
                    <button type="button" id="add_product_btn_modal"
                        class="btn btn-default"><?php echo lang('create_product_md'); ?></button>
                </div>
                <div id="mod_footer" class="cols-sm-4 col-lg-4 col-md-4 col-xl-4"
                    style=" white-space: nowrap; display:none">
                        <div class="pull-right btn-group">
                    <button class="btn default" type="button" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        <?php echo lang('cancel'); ?>
                    </button>
                    <button class="btn btn-success" id="select-items-confirmx" type="button">
                        <i class="fa fa-check"></i>
                        <?php echo lang('submit'); ?>
                    </button>
                </div>
                </div>
            </div>
            <div class="row">
                <br>
                <div class="cols-sm-12 col-lg-12 col-md-12 col-xl-12 table-responsive">
                    <table id="products_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="3%" style="border: hidden;">
                                    <!--<div class="md-checkbox">
                                        <input type="checkbox" name="product_ids_tout" id="checkbox310_0" value="0"
                                            class="azerty md-check">
                                        <label for="checkbox310_0">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
                                    </div>-->
                                </th>                               
                                <th><?php echo lang('product_sku2'); ?><?php echo lang('product_name2');?></th>
                                <th>Declinaison</th>
                                <th>Dépot</th>
                                <th><?php echo lang('family_name2'); ?></th>
                                <th><?php echo lang('product_name2'); ?></th>
                                <th><?php echo lang('product_description2'); ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('product_price'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$count = 0;
 foreach ($products as $product) {     
    if(count($this->mdl_products->by_langue($product->product_id,$langue))>0){
        $resullang= $this->mdl_products->by_langue($product->product_id,$langue)[0];
        if(!empty($resullang->product_name)  && !empty($resullang->product_description) ){
    ?>
                            <tr class="prod_<?php echo $product->product_id; ?>"
                                prod_id="<?php echo $product->product_id; ?>">
                                <td class="text-left">
                                    <div class="md-checkbox">
                                        <input type="checkbox" name="product_ids[]"
                                            id="checkbox310_<?php echo $product->product_id; ?>"
                                            value="<?php echo $product->product_id; ?>" class="azerty md-check">
                                        <label for="checkbox310_<?php echo $product->product_id; ?>">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
                                    </div>
                                </td>                              
                                <td nowrap class="ref text-left">
                                    <?php echo $product->product_sku; ?>
                                </td>
                                <td nowrap class="text-left">
                                    <?php if($product->stock_decl){
                                    // var_dump($product->mdl_depot_stock);?>
                                        <select onclick="getdecl(<?php echo $product->product_id ?>)" id="declination_<?php echo $product->product_id ?>" multiple="multiple">
                                     <?php
                                    foreach ($product->stock_decl as $stock_decl) {?>
                                        <option value="<?php echo $product->product_id ?>_<?php echo $stock_decl->stock_id ?>"><?php 
                                         $sp=split('[/]',$stock_decl->ref_stock);
                                         echo  $sp[1]
                                        
                                        ?></option>
                                    <?php } ?>
                                    </select> 
                                    <?php }  ?>
                                  
                                </td>
                                <td>
                                <?php  
                                    //var_dump($product->mdl_depot_stock);?>
                                    <?php foreach ($product->stock_decl as $depot_stock) {
                                        $stock_id = $this->mdl_depot_stock->where('ip_deopt_stock.stock_id', $depot_stock->stock_id)->get()->result(); 
                                       // var_dump($stock_id);
                                      ?> 
                                    <select style="display:none" class="depot<?php echo $product->product_id ?>_<?php echo $depot_stock->stock_id ?> form-control" id="depot_<?php echo $product->product_id ?>">
                                    <?php foreach ($stock_id as $stock_depot) { ?>
                                                <option value="<?php echo $stock_depot->id_depot ?>"><?php echo $stock_depot->libelle ?>
                                                </option> 
                                                
                                            <?php } ?>
                                            </select> 
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php echo $product->family_name; ?>
                                </td>
                                <td>
                                    <?php
$prod_res = $resullang->product_name;
    echo substr($prod_res, 0, 20);
    if (strlen($prod_res) > 20) {
        echo '<b style="color:#27871e">&nbsp;&nbsp;...</b>';
    }

    ?>
                                </td>
                                <td class="description_td<?php echo($product->product_id); ?>">

                                    <?php //  var_dump($product->stock_decl); ?>
                                    <?php  
                                    
//debut declinaison
$i=0;
foreach ($product->stock_decl as $valuestck) {?>
    <?php foreach ($groupe as $key=>$value){?>
      
      
            <?php $res= $this->mdl_option_attribut->getAttribut($value->group_id) ?>
          
            <?php                                                            
            foreach($res as $keyy=>$valuee){
             //   echo $valuee->valeur ;
                //return var_dump($this->mdl_declinaison->trouve($valuestck->stock_id,$valuee->id_option_attribut,$value->group_id));die('h'); 
               if($valuee->id_option_attribut){
                 // var_dump($valuee->id_option_attribut); 
                if($this->mdl_declinaison->trouve($valuestck->stock_id,$valuee->id_option_attribut,$valuee->group_id)>0){
                  
                ?>                                       
                         <span style="display:none" id="<?php echo $valuestck->stock_id ?>"> <?php echo $value->name.': ' ?>   <?php echo $valuee->valeur.'</br>'?>  </span>
                            <?php }}?>
            <?php } ?>
      
    <?php } ?><?php
$i++; 
}


//fin declinaison







$desc_res = $resullang->product_description;
?><span class="description<?php echo($product->product_id); ?>"><?php 
    echo substr($desc_res, 0, 25);
    if (strlen($desc_res) > 25) {
        echo '<b style="color:#27871e">&nbsp;&nbsp;...</b>';
    }

    ?></span>
                                </td>
                                <td style=" white-space:nowrap;" align="right">
                                    <span
                                        class="price_item_modal"><?php echo format_devise($product->product_price_dev, $devise); ?></span>
                                </td>
                            </tr>
                            <?php $count = $count + 1;}}}?>                            
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    <style>
    .modal {
        right: 20%;
        bottom: 0%;
        left: 10%;
    }
    </style>
    <div>
        <script>
        var cnt = 0;

        /*  function myFunction2() {
              return document.querySelectorAll('#products_table input[type=checkbox]:checked');
              console.log(document.querySelectorAll('#products_table input[type=checkbox]:checked'));

          }*/


        /* $(document).ready(function() {
             $(".azerty").on('click', function() {
                 // get the current row
                 var currentRow = $(this).closest("tr");

                 var col1 = currentRow.find("td:eq(0)")
                     .html(); // get current row 1st table cell TD value
                 var col2 = currentRow.find("td:eq(1)")
                     .html(); // get current row 2nd table cell TD value
                 var col3 = currentRow.find("td:eq(2)")
                     .html(); // get current row 3rd table cell  TD value
                 var col4 = currentRow.find("td:eq(3)")
                     .html(); // get current row 2nd table cell TD value
                 var col5 = currentRow.find("td:eq(4)")
                     .html(); // get current row 3rd table cell  TD value
                 var col6 = currentRow.find("td:eq(5)")
                     .html(); // get current row 3rd table cell  TD value

                 $('#product_select').append(
                     '<tr><td>' + col2 +
                     '</td><td>' + col3 + '</td><td>' + col4 + '</td><td>' + col5 + '</td><td>' +
                     col6 +
                     '</td></tr>'
                 );
             });
         });*/

        /* function myFunction(e) {

             $("#products_table input[type=checkbox]").each(function(key, value) {
                 //  alert(cnt);
                 if (e == key) {

                     if (this.checked) {
                         cnt = cnt + 1;


                     } else {
                         cnt = cnt - 1;
                     }
                     return false;
                 }

                 //   alert(cnt);

                 //  alert('hh');
                 if (cnt > 0) {
                     $("#mod_footer").show();
                 } else {
                     $("#mod_footer").hide();
                 }
                 // get the current row
                 //  var currentRow = myFunction2()[e].parentNode.parentNode.parentNode.parentNode;
                 //    console.log(currentRow.innerHTML);
                 console.log('1');
                 $("#products_table input[type=checkbox]").on('click', function() {
                     // get the current row
                     alert('hh');
                     if (this.checked) {
                         var currentRow = $(this).closest("tr");

                         var col1 = currentRow.find("td:eq(0)")
                             .html(); // get current row 1st table cell TD value
                         var col2 = currentRow.find("td:eq(1)")
                             .html(); // get current row 2nd table cell TD value
                         var col3 = currentRow.find("td:eq(2)")
                             .html(); // get current row 3rd table cell  TD value
                         var col4 = currentRow.find("td:eq(3)")
                             .html(); // get current row 2nd table cell TD value
                         var col5 = currentRow.find("td:eq(4)")
                             .html(); // get current row 3rd table cell  TD value
                         var col6 = currentRow.find("td:eq(5)")
                             .html(); // get current row 3rd table cell  TD value

                         $('#product_select').append(
                             '<tr><td>' + col2 +
                             '</td><td>' + col3 + '</td><td>' + col4 + '</td><td>' + col5 +
                             '</td><td>' +
                             col6 +
                             '</td></tr>'
                         );
                     }
                 });
             });

         };*/
         $("#products_table input[type=checkbox]").click(function() {
            
            // get the current row
            var currentRow = $(this).closest("tr");
            var currenttd = $(this).val();
             
            //console.log($("#declination_"+currenttd).val());
            var selected=[];
            var cn=0;
            $('#declination_'+currenttd+' :selected').each(function(){
                const words = $(this).val().split('_');

                selected[words[1]]=$(this).text();
                cn++;
                });
            // console.log(selected);
   
                var col1 = currentRow.find("td:eq(1)").html(); // get current row 1st table cell TD value
              
                // if (typeof col1 != "undefined")
                // for(i=0;i<cn;i++)
                   if(cn==0){
                        // var col2 = currentRow.find("td:eq(2)").html();; // get current row 2nd table cell TD value
                        var col2 = currentRow.find("td:eq(1)").html();
                        var col3 = currentRow.find("td:eq(4)").html();  
                        var col4 = currentRow.find("td:eq(5)").html(); 
                        var col5 = currentRow.find("td:eq(6)").html();  
                        var col6 = currentRow.find("td:eq(7)").html();  
                        
                        var button =
                            '<button onclick="del(' + currenttd +
                            ','+cn+')" class="btn-xs" style=" cursor: pointer; background-color: #c94c4c; border: none;color: white">Supprimer</button>';
                        $('#product_select').append(
                            '<tr id="trdel_' + currenttd + '_0"><td>' + col2 +
                            '<input type="hidden" value="' + currenttd +
                            '_0" name="product_ids[]"><input type="hidden" name="depot[]" value="0"></td><td>' + col3 + '</td><td>' + col4 + '</td><td>' + col5 +
                            '</td><td>' +
                            col6 +
                            '</td><td>' + button + '</td></tr>'
                        );
                        //   currentRow.remove();
                        count = parseInt(count + 1);
                
                        $('#count').val(count);
                        if (count > 0) {
                            $("#mod_footer").show();
                        } else {
                            $("#mod_footer").hide();
                        }
                    }else{ 
                    var col3 = currentRow.find("td:eq(4)").html();  
                    var col4 = currentRow.find("td:eq(5)").html(); 
                  //  var col5 = currentRow.find("td:eq(6)").html();  
                    var col6 = currentRow.find("td:eq(7)").html();  
                    var desc = $('td span.description'+currenttd).html();
                    for (var key in selected) {                  
                    var tddesc = $('tr.prod_'+currenttd+' td span[id="'+key+'"]');
                    var tab='';            
                    tddesc.each(function(){
                        tab+=$(this).css('display','block').html();
                    }) 
                    var col5 = tab+'</br>'+desc;  
                    var col2 =  selected[key];
                    var depot_id = $('.depot'+currenttd+'_'+key).val();
                    //  console.log(depot_id) ;   
                    var button =
                        '<button onclick="del(' + currenttd +
                        ','+key+')" class="btn-xs" style=" cursor: pointer; background-color: #c94c4c; border: none;color: white">Supprimer</button>';
                       
                     $('#product_select').append(
                        '<tr id="trdel_' + currenttd + '_'+key+'"><td>' + col2 +
                        '<input type="hidden" value="' + currenttd +
                        '_'+ key +'" name="product_ids[]"><input type="hidden" name="depot[]" value="'+depot_id+'"></td><td>' + col3 + '</td><td>' + col4 + '</td><td>' + col5 +
                        '</td><td>' +
                        col6 +
                        '</td><td>' + button + '</td></tr>'
                    );
                  //  console.log(tddesc.length);
                  //  console.log(cn);
                  /*  if(cn==tddesc.length){
                       
                    }*/
                  
                    count = parseInt(count + 1);
                
                    $('#count').val(count);
                    if (count > 0) {
                        $("#mod_footer").show();
                    } else {
                        $("#mod_footer").hide();
                    }
                } 
            }
            currentRow.remove(); 
        });

        function getdecl(e){
         //   alert();
         //for (var i = 0; i < items.length; i++) {
        /*    alert(e);
            var res = e.split(","); 
            res.forEach(function(f){
                $('#depot_'+f).css('display','none');
            })*/
            var test = $('#declination_'+e).val()+ '';
            var res = test.split(","); 
            
            $('td #depot_'+e).each(function() {
                $(this).css('display','none');
            })
           
            res.forEach(function(f){
                $('.depot'+f).css('display','block');
            }) 
          //  alert(res);

           //  $('.depot'+$('#declination_'+e).val()).css('display','block');
        }

    
        </script>