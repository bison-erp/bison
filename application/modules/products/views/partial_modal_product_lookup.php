
<?php $count = 0;
foreach ($products as $product) {
    if(count($this->mdl_products->by_langue($product->product_id,$langue))>0){
        $resullang= $this->mdl_products->by_langue($product->product_id,$langue)[0];
        if(!empty($resullang->product_name)  && !empty($resullang->product_description) ){
    ?>
<tr class="prod_<?php echo $product->product_id; ?>" prod_id="<?php echo $product->product_id; ?>">
    <td class="text-left">
        <div class="md-checkbox">
            <input type="checkbox" name="product_ids[]" id="checkbox310_<?php echo $product->product_id; ?>"
                value="<?php echo $product->product_id; ?>" class="azerty md-check">
            <label for="checkbox310_<?php echo $product->product_id; ?>">
                <span></span>
                <span class="check"></span>
                <span class="box"></span>
            </label>
        </div>
    </td>
   
    <td nowrap class="text-left">
        <?php echo $product->product_sku; ?>
    </td>
    <td nowrap class="ref text-left">
          <?php if($product->stock_decl){
                                     //   var_dump($product);?>
                 <select onclick="getdecl(<?php echo $product->product_id ?>)" id="declination_<?php echo $product->product_id ?>" multiple="multiple">
                    <?php
                       foreach ($product->stock_decl as $stock_decl) {?>
                         <option value="<?php echo $product->product_id ?>_<?php echo $stock_decl->stock_id ?>"><?php 
                            $sp=split('[/]',$stock_decl->ref_stock);
                            echo  $sp[1]
                            //echo  $stock_decl->ref_stock
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
        <?php // echo $product->product_name; ?>
        <?php
$prod_res = $resullang->product_name;
    echo substr($prod_res, 0, 20);
    if (strlen($prod_res) > 20) {
        echo '<b style="color:#27871e">&nbsp;&nbsp;...</b>';
    }

    ?>
    </td>
    <td class="description_td<?php echo $product->product_id ?>">
            <?php // echo $product->product_description; ?>

            <?php   $i=0;
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

?>
        <span class="description<?php echo $product->product_id ?>">
            <?php
            
                $desc_res = $resullang->product_description;
            
    //$desc_res = $product->product_description;
        echo substr($desc_res, 0, 25);
        if (strlen($desc_res) > 25) {
            echo '<b style="color:#27871e">&nbsp;&nbsp;...</b>';
        }

        ?>
        </span>
    </td>
    <td style=" white-space:nowrap;" align="right">
        <span class="price_item_modal"><?php echo format_devise($product->product_price_dev, $devise); ?></span>
    </td>
</tr>
<?php $count = $count + 1;}}}?>
<script>
var count = parseInt($('#count').val());
/*$("#products_table input[type=checkbox]").click(function() {
    // get the current row
    var currentRow = $(this).closest("tr");
    var currenttd = $(this).val();
    var col1 = currentRow.find("td:eq(0)").html();
    var col2 = currentRow.find("td:eq(1)").html();
    var col3 = currentRow.find("td:eq(2)").html();
    var col4 = currentRow.find("td:eq(3)").html();
    var col5 = currentRow.find("td:eq(4)").html();
    var col6 = currentRow.find("td:eq(5)").html();
    var button =
        '<button class="btn-xs" onclick="del(' + currenttd +
        ')" style=" cursor: pointer; background-color: #c94c4c; border: none;color: white">Supprimer</button>';

    $('#product_select').append(
        '<tr id="trdel_' + currenttd + '"><td id="td2_"' + currenttd +
        '>' + col2 +
        '<input type="hidden" value="' + currenttd +
        '" name="product_ids[]"></td><td>' + col3 + '</td><td>' + col4 + '</td><td>' + col5 + '</td><td>' +
        col6 +
        '</td><td>' + button + '</td></tr>'
    );
    currentRow.remove();
    count = parseInt(count + 1);
    $('#count').val(count);
    if (count > 0) {
        $("#mod_footer").show();
    } else {
        $("#mod_footer").hide();
    }
});*/ 

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
                        '_0" name="product_ids[]"></td><td>' + col3 + '</td><td>' + col4 + '</td><td>' + col5 +
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
                    var depot_id = $('.depot'+currenttd+'_'+key).val();
                    var col5 = tab+'</br>'+desc;  
                    var col2 =  selected[key];
                    var button =
                        '<button onclick="del(' + currenttd +
                        ','+key+')" class="btn-xs" style=" cursor: pointer; background-color: #c94c4c; border: none;color: white">Supprimer</button>';
                       
                     $('#product_select').append(
                        '<tr id="trdel_' + currenttd + '_'+key+'"><td>' + col2 +
                        '<input type="hidden" value="' + currenttd +
                        '_'+ key +'" name="product_ids[]"><input type="hidden" name="depot[]" value="'+key+'_'+depot_id+'"></td><td>' + col3 + '</td><td>' + col4 + '</td><td>' + col5 +
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
    lookup_url += "&langue=" + $('#langue').val();
   
    $("#products_table tbody").load(lookup_url);

}

function del(e,f) {
    var currentRow = $(this).closest("tr");
    var trsup = $('#trdel_' + e+'_'+f);
   // var trsup1 = $('#td2_' + e);
 
    // console.log(currentRow);

    $.post("<?php echo site_url('products/ajax/getProductid'); ?>", {
        id: e,
        dec_id: f,
    }, function(data) {
        //  console.log(data['family_name']);
        var json_response = JSON.parse(data);
        var famille = json_response[0].family_name;
        var produit = json_response[0].product_sku;
        var ref = json_response[0].product_name;
        if(json_response[0].langue=="French"){
            var desc =json_response[0].product_description;
        }
        if(json_response[0].langue=="Arabic"){
            var desc =json_response[0].product_description_ar;
        }
        if(json_response[0].langue=="English"){
            var desc =json_response[0].product_description_eng;
        }
      //  var desc = json_response[0].product_description;
        var price = json_response[0].product_price;
        // console.log(json_response[0].family_name);
        $('#products_table').append(
            '<tr class="prod_' + e + '" prod_id="' + e +
            '"><td class="text-left"><div class="md-checkbox"><input type="checkbox" name="product_ids[]" id="checkbox310_' +
            e + '" value="' + e + '" class="azerty md-check"><label for="checkbox310_' + e +
            '"><span></span><span class="check"></span><span class="box"></span>  </label></div></td><td>' +
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