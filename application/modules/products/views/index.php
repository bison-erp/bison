<?php
$sess_product_add = $this->session->userdata['product_add'];
$sess_product_del = $this->session->userdata['product_del'];
$sess_product_index = $this->session->userdata['product_index'];
?>
<style> 
#product_all thead tr th {
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
}

#product_all {
    table-layout: fixed;
}

#product_all tbody tr:hover {
    background: aliceblue;
}
.page-breadcrumb{
    float: left;
}
 .containerdesc:hover .image {
  opacity: 0.33;
}
.containerdesc {
  position: relative;
  width: 100%;
}
.containerdesc:hover .middle {
  opacity: 1;
}
.containerimg:hover .image {
  opacity: 0.33;
}
.containerimg {
  position: relative;
  width: 100%;
}
.containerimg:hover .middledesc {
  opacity: 1;
}
.textdesc {
    color: black;
    font-size: 16px;
    padding: 16px 32px;
    -webkit-box-shadow: 0 0 7px rgba(0,0,0,0.15);
    -moz-box-shadow: 0 0 7px rgba(0,0,0,0.15);
    -ms-box-shadow: 0 0 7px rgba(0,0,0,0.15);
    -o-box-shadow: 0 0 7px rgba(0,0,0,0.15);
    box-shadow: 0 0 7px rgba(0,0,0,0.15);
    border: solid 1px rgba(0,0,0,0.15);
    background: #fff;
    border-radius: 5px;
    word-wrap:break-word;
    display:block;
 }
 .textimg {
    color: black;
    font-size: 16px;
    padding: 16px 32px;
    -webkit-box-shadow: 0 0 7px rgba(0,0,0,0.15);
    -moz-box-shadow: 0 0 7px rgba(0,0,0,0.15);
    -ms-box-shadow: 0 0 7px rgba(0,0,0,0.15);
    -o-box-shadow: 0 0 7px rgba(0,0,0,0.15);
    box-shadow: 0 0 7px rgba(0,0,0,0.15);
    border: solid 1px rgba(0,0,0,0.15);
    background: #fff;
    border-radius: 5px;
    word-wrap:break-word;
    display:block;
    margin-top:35px;
 }
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
 }
 .middledesc {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
 }
 </style>
<div id="headerbar">
    <table style="width:100%; margin-top: 0;">
        <tr>      
		<td align="right" class="form-widh factures produits" style=" width:20%">
            <?php //$this->layout->load_view('filter/jquery_filter'); ?>
            <form class="navbar-form navbar-left search_in_list" role="search" style="padding:0;">
                <div class="form-group">
                    <input id="filter_product_input" type="text"
                        class="search-query form-control input-sm" placeholder="<?php echo ($filter_placeholder); ?>">
                </div>
            </form>
        </td>
        <td align="left" style=" width:10%">
            <select class="form-control select_filter" id="select_filter_family">
                <option value="all"><?php echo lang('family'); ?></option>
                <?php foreach ($families as $familie) {?>
                <option value="<?php echo $familie->family_id; ?>"><?php echo $familie->family_name; ?></option>
                <?php }?>
            </select>
        </td>
        <td align="right" style=" width:70%">
			<div class="pull-right factures produits" style="margin:2px 0;">
				<button id="export_excel" class="btn btn-sm btn export-excel">
						<i class="fas fa-file"></i><?php echo lang('exporter') ?> 
				</button>	
					<a class="btn btn-md-size btn-primary btn-success" href="<?php echo site_url('/families/form'); ?>">
						<?php echo lang('create_family'); ?>
					</a>
				<?php if ($sess_product_add == 1) {?>
						<a class="create-product btn btn-sm btn-primary no-marg btn-light-success" href="<?php echo site_url('products/form'); ?>">
						<?php echo lang('create_product'); ?></a>
				<?php }?>
            </div>
        </td>
        </tr>
    </table>
     <div style="clear:both"></div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div id="content" class="table-content">
                <div class="table-responsive">
                    <table class="table table-striped" id="product_all">
                        <?php $this->load->model('settings/mdl_settings');
$typetaxe = $this->mdl_settings->gettypetaxeinvoice();
if ($typetaxe == 1) {
    ?>
                        <thead>
                            <tr>
                                <th  style="width: 25px"></th>
                                <th order="ip_families.family_name" style="width: 110px"><?php echo lang('family'); ?>
                                </th>
                                <th order="product_sku" style="width: 110px"><?php echo lang('product_sku'); ?></th>
                                <th order="product_name" style="width: 130px"><?php echo lang('product_name_1'); ?></th>
                                <th order="product_description" style="width: 140px">
                                    <?php echo lang('product_description'); ?></th>
                                <th order="quantite" style="width: 60px">
                                    <?php echo lang('quantity_product'); ?></th>    
                                <th order="marge" style="width: 70px">
                                    <?php echo lang('marge'); ?></th>         
                                <th order="purchase_price" style="width: 100px"><?php echo lang('purchase_price'); ?>
                                </th>
                                <th order="product_price" style="width: 100px"><?php echo lang('product_price'); ?></th>
                                <th order="ip_tax_rates.tax_rate_name" style="width: 70px;">
                                    <?php echo lang('tax_rate'); ?></th>
                                <th width="50">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="check_all" class="md-check">
                                        <label for="check_all">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
                                    </div>
                                </th>
                                <th style="width: 70px; "><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <?php } else {

    ?>
                        <thead>
                            <tr>
                                <th order="ip_families.family_name" style="width: 110px"><?php echo lang('family'); ?>
                                </th>
                                <th order="product_sku" style="width: 110px"><?php echo lang('product_sku'); ?></th>
                                <th order="product_name" style="width: 130px"><?php echo lang('product_name_1'); ?></th>
                                <th order="product_description" style="width: 140px">
                                    <?php echo lang('product_description'); ?></th>
                                <th order="quantite" style="width: 60px">
                                    <?php echo lang('quantity_product'); ?></th>    
                                <th order="marge" style="width: 70px">
                                    <?php echo lang('marge'); ?></th>     
                                <th order="purchase_price" style="width: 100px"><?php echo lang('purchase_price'); ?>
                                </th>
                                <th order="product_price" style="width: 100px"><?php echo lang('product_price'); ?></th>
                                <th width="50">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="check_all" class="md-check">
                                        <label for="check_all">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
                                    </div>
                                </th>
                                <th style="width: 70px; "><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <?php } ?>
                        <tbody id="filter_results">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
		 
<!-- pagination -->
<div class="pag-table-content">
    <div class="pull-right">
        <select class="btn btn-default btn-sm bg-light-primary pagin" id="products_par_page">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="200">200</option>
        </select>
    </div>
    <div class="pull-right" style="margin:0 7px;">
        <div class="btn-group">
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fast_backward" href="javascript:;"><i class="fas fa-angle-double-left"></i></a>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fa_backward" href="javascript:;"><i class="fas fa-angle-left"></i></a>
            <span class="btn btn-sm btn-default btn-hover-primary pagin active" style="background:none;" id="number_current_page">1/1</span>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fa_forward" href="javascript:;"><i class="fas fa-angle-right"></i></a>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fast_forward" href="javascript:;"><i class="fas fa-angle-double-right"></i></a>
        </div>
    </div>
</div>
	<!-- end pagination -->
</div>


<script type="text/javascript">
$(function() {

    start_page = 1;
    limit_par_page = 20;
    nb_pages = 1;
    order_by = "ip_products.product_id";
    order_method = "desc";
    if (typeof(page) == 'undefined') {
        page = 1;
    }
    if (typeof(filter_family) == 'undefined') {
        filter_family = "all";
    }
    if (typeof(filter_products) == 'undefined') {
        filter_products = "";
    }


    $("#check_all").click(function() {
        if ($(this).is(':checked')) {
            $("#filter_results tr td .md-check").each(function() {
                this.checked = true;
            });
            $('#export_excel').prop("disabled", false);
        } else {
            $("#filter_results tr td .md-check").each(function() {
                this.checked = false;
            });
            $('#export_excel').prop("disabled", true);
        }
    });


    $('#filter_product_input').keyup(function() {
        filter_products = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterProducts();

    });
    $('#select_filter_family').change(function() {
        filter_family = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterProducts();

    });

    $(".paginate").click(function() {
        var btn = $(this).attr("id");
        if (btn == "btn_fast_backward") {
            start_page = 1;
        }
        if (btn == "btn_fa_backward") {
            start_page = start_page == 1 ? 1 : start_page - 1;
        }
        if (btn == "btn_fast_forward") {
            start_page = nb_pages;
        }
        if (btn == "btn_fa_forward") {
            start_page = start_page == nb_pages ? nb_pages : start_page + 1;
        }
        filterProducts();
    });
    $("#products_par_page").change(function() {
        start_page = 1;
        limit_par_page = $(this).val();
        filterProducts();
    });

    $("#product_all thead tr th").click(function() {
        var order = $(this).attr("order");
        if (order) {
            if (order_by != order) {
                order_by = order;
                order_method = "asc";
            } else {
                if (order_method == "asc") {
                    order_method = "desc";
                } else
                if (order_method == "desc") {
                    order_method = "asc";
                }
            }
            start_page = 1;
            filterProducts();
        }

    });

    filterProducts();

    function filterProducts() {

        //            $('#filter_results').html("<tr><td colspan='13'> Loading...</td></tr>");
        $('#filter_results').load("<?php echo site_url('products/ajax/load_products_partial_filter'); ?>/" +
            Math.floor(Math.random() * 1000), {
                filter_products: filter_products,
                filter_family: filter_family,
                limit_par_page: limit_par_page,
                start_page: start_page,
                order_by: order_by,
                order_method: order_method
            },
            function(data) {}, 500);
    }
});
$('#export_excel').prop('disabled', true);
$('#export_excel').click(function() {
    var ids_client = [];
    var ids_client_sep = "";
    var cnt = 0;
         $('input:checked[name="pdf[]"]').each(function() {           
            if (cnt != 0) {
                ids_client_sep += "_";
            }
            ids_client_sep += $(this).val();
            ids_client.push(parseInt($(this).val()));
            cnt++;            
        });
        
        //alert(ids_client_sep);
     window.open("<?php echo site_url('products/export_excel'); ?>/" + ids_client_sep,
            "_blank"); 
            $('input[name="pdf[]"]').prop("checked", false);
            $('#export_excel').prop('disabled', true);
            $('#check_all').prop("checked", false);
             // Opens a new window     
 })
 var totcheck=0;
function myfunction(i){
    if ($("#checkbox3_" + i).is(':checked')) {
        totcheck = totcheck + 1;
    }else{
        totcheck = totcheck - 1;
    }   
    if(totcheck==0){
        $('#export_excel').prop("disabled", true);
    }else{
        $('#export_excel').prop("disabled", false);
    }
}  

function showstock(i){
   // $('.btplus').val('+');
  //  $('#plus'+i).val('-');
    $('.content-details').css('display','none');
    $('#content-details'+i).css('display','block');
}
  
 </script>