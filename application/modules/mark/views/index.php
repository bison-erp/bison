<?php
/*$sess_product_add = $this->session->userdata['product_add'];
$sess_product_del = $this->session->userdata['product_del'];
$sess_product_index = $this->session->userdata['product_index'];*/
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_devis_del = $this->session->userdata['devis_del'];
$sess_devis_index = $this->session->userdata['devis_index'];
?>
<style>
.label {
    font-weight: normal;
    padding: .3em .6em;
    display: block;
    width: 100%;
}

.label.label-inline {
    display: inline;
    width: auto
}

.table>tbody>tr>td {
    white-space: nowrap;
    vertical-align: middle;
}
.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    /* Safari */
    animation: spin 2s linear infinite;
    position: relative;
    top: -650px;
    left: 600px;
}

.table>tbody>tr>td {
    white-space: nowrap;
    vertical-align: middle;
}

#fournisseur_all thead tr th {
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
}

#fournisseur_all {
  //  table-layout: fixed;
}

#fournisseur_all tbody tr:hover {
    background: aliceblue;
}
#dropdown-menu {
    position: relative;
}

#dropdown-menu .datepicker {
    position: absolute;
    top: 0;
    right: 300px !important;
}

.datepicker {
    text-align: center;
}

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
    text-align: center;
    color: #FFF;
    font-weight: bold !important;
}
</style>
<div id="headerbar">
   
	  <table style="width:100%; margin-top: 0px;">
         <tr>
             <td align="right" class="form-widh" style="width:25%">
				 <form class="navbar-form navbar-left search_in_list" role="search" style="padding:0;">
                     <div class="form-group">
							<input id="filter_marks" type="text"  class="search-query form-control input-sm" placeholder="<?php echo lang("filtre_marques"); ?>">
                     </div>
                 </form>
            </td>
			
 <?php if ($sess_devis_add == 1) {?>
    <td align="right" class="pull-block" style=" width:70%">
       <div class="pull-right" style="margin: 15px 7px;">
        <a class="btn btn-sm btn-primary btn-light-success" href="<?php echo site_url('mark/form'); ?>">
            <?php echo  lang('ajout_mark'); ?>
		</a>
       </div>
	   </td>
    <?php } ?>
            

        </tr>
    </table>
</div>

    <div class="row">
	  <div class="col-md-12">
         <div class="portlet light">
	<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts');?>
       
                <div class="table-scrollable" style=" width: 100%; border:none!important;">
                    <table class="table table-striped table-hover table-responsive" id="fournisseur_all">
                        <thead>
                            <tr>
                                <th order="ip_mark.id_mark"><?php echo lang('nom_mark'); ?></th>
                                <th style="width: 60px;"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="filter_results">
                            
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

<!--<div class="pag-table-content">	
    <div class="pull-right  visible-lg">
        <?php //echo pager(site_url('mark/index'), 'mdl_mark'); ?>
    </div>
</div>-->
<div class="pag-table-content">
    <div class="pull-right">
        <select class="btn btn-default btn-sm bg-light-primary pagin" style="background:#FFF;" id="mark_par_page">
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
</div>
<div class="loader"></div>
<script>
$('.loader').hide();
	$(function() {
	start_page = 1;
    limit_par_page = 20;
    nb_pages = 1;
    order_by = "ip_mark.id_mark";
    order_method = "desc";
	if (typeof(page) == 'undefined') {
        page = 1;
    }
    if (typeof(filter_mark) == 'undefined') {
        filter_mark = "";
    }
	 $('#filter_marks').keyup(function()
       {
        filter_mark = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterMark();
		});
    $('#filter_fournisseur_input').keyup(function() {
        filter_mark = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterMark();
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
        filterMark();
    });
	$("#mark_par_page").change(function() {
        start_page = 1;
        limit_par_page = $(this).val();
        filterMark();
    });
   
    $("#fournisseur_all thead tr th").click(function() {
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
            filterMark();
        }
    });
    filterMark();
	function filterMark() 
	{
	  $('#filter_results').load("<?php echo site_url('mark/ajax/load_mark_partial_filter'); ?>/" +
            Math
            .floor(Math.random() * 1000), {
            filter_mark: filter_mark,
			  limit_par_page: limit_par_page,
                start_page: start_page,
                order_by: order_by,
                order_method: order_method  
        },
        function(data) {}, 500);
    }
	
 
});
</script>
 <input type="hidden" id="selected_dates" value="" />
 <input type="hidden" id="selected_dates_bool" value="" />
 <div id="download"></div>
