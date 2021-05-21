<?php
$sess_product_add = $this->session->userdata['product_add'];
$sess_product_del = $this->session->userdata['product_del'];
$sess_product_index = $this->session->userdata['product_index'];
?>
<?php foreach ($products as $product) { //print_r($product); ?>
<tr class="odd gradeX">
    <td style="white-space:nowrap;">
        <a href="<?php echo site_url('families/form/' . $product->family_id); ?>">
            <?php echo $product->family_name; ?>
        </a></td>
    <td style="white-space:nowrap;">
        <a href="<?php echo site_url('products/form/' . $product->product_id); ?>">
            <?php echo $product->product_sku; ?>
        </a></td>
    <td style=" white-space:nowrap; width: 300px"><?php
    if($product->langue=="French"){
        $nam = $product->product_name;
    }elseif($product->langue=="Arabic"){
        $nam = $product->product_name_ar;
    }else{
        $nam = $product->product_name_en;
    }
    echo substr($nam, 0, 20);
    if (strlen($nam) > 20) {
        echo '<b style="color:#27871e">&nbsp;&nbsp;...</b>';
    }

    ?></td>
    <td style=" white-space:nowrap; width: 300px"><?php
    if($product->langue=="French"){
        $nat = $product->product_description;
    }elseif($product->langue=="Arabic"){
        $nat = $product->product_description_ar;
    }else{
        $nat = $product->product_description_eng;
    }
//$nat = $product->product_description;
    echo substr($nat, 0, 25);
    if (strlen($nat) > 25) {
        echo '<b style="color:#27871e">&nbsp;&nbsp;...</b>';
    }

    ?></td>
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
        <table style=" width:80;">
            <tr>
                <?php if ($sess_product_add == 1) {?>
                <td width="40" style=" text-align: center">
				<a class="icon-param edit-icon-th" href="<?php echo site_url('products/form/' . $product->product_id); ?>"
                        title="<?php echo lang('edit'); ?>"><i class="fas fa-edit"></i></a></td><?php }?>
                <?php if ($sess_product_del == 1) {?>
                <td  width="40" style="text-align: center">
                    <a class="icon-param delete-icon-th" href="<?php echo site_url('products/delete/' . $product->product_id); ?>"
                        title="<?php echo lang('delete'); ?>"
                        onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                       <i class="fas fa-trash-alt"></i></a>
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