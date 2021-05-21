<?php
$sess_product_add = $this->session->userdata['product_add'];
$sess_product_del = $this->session->userdata['product_del'];
$sess_product_index = $this->session->userdata['product_index'];
$j=0;
$this->load->model('products/mdl_stockmvt');
$this->load->model('products/mdl_products');
?>

<?php foreach ($products as $product) {
   
    //print_r($product); ?>
<tr class="odd gradeX">
     
    <td class="details-control sorting_<?php echo $j ?>">
        <input id="plus<?php echo $j ?>" class="btplus" style='font-family: "Glyphicons Halflings";border: hidden;' onclick="showstock(<?php echo $j ?>)" type="button" value="+"/>  
        <input id="plus<?php echo $j ?>" class="btplus" style='font-family: "Glyphicons Halflings";border: hidden;display:none' onclick="showstock(<?php echo $j ?>)" type="button" value="-"/>         
       
        <div class="content-details" id="content-details<?php echo $j ?>" style=";z-index: 11;background-color: antiquewhite;margin-left: 5%;padding: 14px 14px 12px 14px;position: absolute;display:none">           
            <table class="table" width="100%" border="3px" bordercolor="#bababb">
            <?php 
            /*  $res=$this->mdl_stockmvt->select('ip_products_mvtstock.reference_stock,ip_products_mvtstock.*,SUM(ip_products_mvtstock.stock_actuelle) as sumstock_actuelle,SUM(ip_products_mvtstock.stock_virtuelle) as sumstock_virtuelle,');        
              $res=$this->mdl_stockmvt->like('reference_stock', $product->product_sku,'both');    
              $res=$this->mdl_stockmvt->group_by("ip_products_mvtstock.reference_stock");          
              $res=$this->mdl_stockmvt->get()->result();   */
              // $res=$this->mdl_stockmvt->like('reference_stock', $product->product_sku.'/')->mdl_stockmvt->get()->result();               
              /*$query = $this->db->query("SELECT ip_stock.*,ip_products.*,ip_products_mvtstock.*,SUM(ip_products_mvtstock.stock_actuelle) as sumstock_actuelle,SUM(ip_products_mvtstock.stock_virtuelle) as sumstock_virtuelle,ip_products_mvtstock.reference_stock FROM `ip_products_mvtstock`,`ip_products`,`ip_stock` WHERE ip_stock.ref_stock=ip_products_mvtstock.reference_stock and ip_stock.produit_id=ip_products.product_id and `reference_stock` LIKE '%$product->product_sku%' GROUP BY ip_products_mvtstock.reference_stock");
              $res = $query->result();*/
              $res = $this->mdl_products->getSotock($product->product_sku);
             ?>
                <tr>
                    <th>réference produit</th>
                    <th>stock reelle </th>
                    <th>stock virtuelle </th>
                    <th>quantite sous produit </th>
                    <th>Reste </th>
                </tr>
                
                <?php  
                foreach($res as $resid){ 
                    $class="";
                    $reste=$resid->quantite_stock-$resid->sumstock_actuelle; 
                    if($reste<0) {
                        $class="style=background-color:#f64e608a";
                    }  
                    ?>
                <tr  <?php echo $class ?>>        	
                    <td><?php echo $resid->reference_stock ?></td>
                    <td><?php echo $resid->sumstock_actuelle ?></td>
                    <td><?php echo $resid->sumstock_virtuelle ?></td>
                    <td><?php echo $resid->quantite_stock ?></td>
                    <td><?php echo $reste ?></td>
                </tr>   
                <?php } ?>    
            </table>
        </div>
    </td>
    <?php $j++ ?>
    <td style="white-space:nowrap;">
        <a href="<?php echo site_url('families/form/' . $product->family_id); ?>">
            <?php echo $product->family_name; ?>
        </a></td>
    <td style="white-space:nowrap;">
        <a href="<?php echo site_url('products/form/' . $product->product_id); ?>">
            <?php echo $product->product_sku; ?>
      
        <?php
       $resfile= $this->mdl_productfile->getfile($product->product_id);
       if($resfile){
          
        $dir_path = base_url() . 'uploads/' . strtolower($this->session->userdata['licence']) . '/fileproduct/' . $resfile[0]->name_file;
        ?>
        <div class="containerimg">
            <div class="middledesc">
                <img class="textimg"  height="100" width="150" src="<?php echo $dir_path ?> ">
            </div> 
        </div>
        <?php } ?>
      
        </a>
        </td>
    <td style=" white-space:nowrap; width: 300px"><?php
    if($product->langue=="French"){
        $nam = $product->product_name;
    }elseif($product->langue=="Arabic"){
        $nam = $product->product_name_ar;
    }elseif($product->langue=="English"){
        $nam = $product->product_name_en;
    }else{
        $nam = $product->product_name;
    }
    echo substr($nam, 0, 20);
    if (strlen($nam) > 20) {
        echo '<b style="color:#27871e">&nbsp;&nbsp;...</b>';
    }

    ?></td>
    <td style=" white-space:nowrap; width: 300px">
    <div class="containerdesc">
    <?php
    if($product->langue=="French"){
        $nat = $product->product_description;
    }elseif($product->langue=="Arabic"){
        $nat = $product->product_description_ar;
    }elseif($product->langue=="English"){
        $nat = $product->product_description_eng;
    }else{
        $nat = $product->product_description;
    }
//$nat = $product->product_description;
?>
 <div class="middle">
 <?php if($nat){?>
  <div class="textdesc"><?php echo $nat; ?></div>
 <?php }?>


  </div>
  <?php
    echo substr($nat, 0, 25);
    if (strlen($nat) > 25) {
        echo '<b style="color:#27871e">&nbsp;&nbsp;...</b>';
    }

    ?>
    </div>
    </div>
    </td>
    <td style="white-space:nowrap; text-align: left;"><?php echo $product->quantite; ?></td>
    <td style="white-space:nowrap; text-align: left;"><?php echo $product->marge; ?></td>

    <td style="white-space:nowrap; text-align: left;"><?php echo format_devise($product->purchase_price, 1); ?></td>
    <td style="white-space:nowrap;"><?php echo format_devise($product->product_price, 1); ?>

    </td>
    <?php if ($typetaxe == 1) {?>

    <td><?php echo ($product->tax_rate_id) ? $product->tax_rate_name : lang('none'); ?> %</td>
    <?php }?>
    <td>
        <div class="md-checkbox">
            <input type="checkbox" onchange="myfunction(<?php echo $product->product_id ?>)" name="pdf[]" value="<?php echo $product->product_id ?>"
                id="checkbox3_<?php echo $product->product_id; ?>" class="md-check">
            <label for="checkbox3_<?php echo $product->product_id; ?>">
                <span></span>
                <span class="check"
                    style="border-color: -moz-use-text-color #0AC877 #09B07B -moz-use-text-color;"></span>
                <span class="box"></span>
            </label>
        </div>
    </td>
    <td style="white-space:nowrap; text-align:center; width: 50px">
        <table style=" width:100%;">
            <tr>
                <?php if ($sess_product_add == 1) {?>
                <td style="text-align: center;width: 50%"><a class="icon-param edit-icon-th" href="<?php echo site_url('products/form/' . $product->product_id); ?>"
                        title="<?php echo lang('edit'); ?>"><i class="fas fa-edit"></i></a></td><?php }?>
                <?php if ($sess_product_del == 1) {?>
                <td style="text-align: center;width: 50%">
                    <a class="icon-param delete-icon-th" href="<?php echo site_url('products/delete/' . $product->product_id); ?>"
                        title="<?php echo lang('delete'); ?>"
                        onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
                <?php }?>
            </tr>
        </table>
    </td>
</tr>
<?php }?>

<tr style="display:none">
    <script>
    <?php
$nb_pages = isset($nb_pages) ? $nb_pages : 1;
$start_page = isset($start_page) ? $start_page : 1;
$nb_all_lines = isset($nb_all_lines) ? $nb_all_lines : 1;
$start_line = isset($start_line) ? $start_line : 1;
?>
    nb_pages = <?php echo $nb_pages; ?>;
    start_page = <?php echo $start_page; ?>;
    nb_all_lines = <?php echo $nb_all_lines; ?>;
    start_line = <?php echo $start_line; ?>;
    if (nb_pages == 0)
        nb_pages = 1;
    $("#number_current_page").text(start_page + '/' + nb_pages);
    if (start_page == 1 || start_page == 0) {
        $("#btn_fast_backward").addClass("disabled");
        $("#btn_fa_backward").addClass("disabled");
    } else {
        $("#btn_fast_backward").removeClass("disabled");
        $("#btn_fa_backward").removeClass("disabled");
    }
    if (start_page == nb_pages) {
        $("#btn_fast_forward").addClass("disabled");
        $("#btn_fa_forward").addClass("disabled");
    } else {
        $("#btn_fast_forward").removeClass("disabled");
        $("#btn_fa_forward").removeClass("disabled");
    }
    </script>
</tr>