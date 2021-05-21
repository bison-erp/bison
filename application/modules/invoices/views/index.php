

<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<style>
#myProgress {
  width: 100%;
  background-color: #FFFFFF;
}

#myBar {
  width: 0%;
  height: 30px;
 background-color: #A8E3F3;
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

/* Safari */
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}


/*.label{font-weight:normal;padding:.3em .6em;color:white !important;display:block;width:100%;}*/
.label.label-inline {
    display: inline;
    width: auto
}


.table>tbody>tr>td {
    white-space: nowrap;
    vertical-align: middle;
}

#invoice_all thead tr th {
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
}

#invoice_all {
    table-layout: fixed;
}

#invoice_all tbody tr:hover {
    background: aliceblue;
}

/*#invoice_all{table-layout:fixed;}*/
</style>
<?php
$max = $query_max_dat[0]->invoice_date_created;
$max_yer = explode('-', $max);
$max_y = $max_yer[0];
if (date('Y') > $max_y) {
    $max_y = date('Y');
}
//$min = $query_min_dat[0]->invoice_date_created;
/////$min_yer = explode('-', $min);
//$min_y = $min_yer[0];

?>

<div id="headerbar">
    <?php
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_devis_del = $this->session->userdata['devis_del'];
$sess_devis_index = $this->session->userdata['devis_index'];
//echo '<pre>';
//print_r($this->session->userdata);
//echo '</pre>';
?>

    <table class="fact-tab" style=" width:100%; margin-top: 0px;">
        <tr>
            <td align="left" class="form-widh factures" style=" width:19%">
                <?php if (isset($filter_display) and $filter_display == true) {?>
                <form class="navbar-form navbar-left search_in_list" role="search" style="padding:0;">
                    <div class="form-group">
                        <input id="filter_invoices" type="text"
                            class="search-query form-control input-sm" placeholder="<?php echo $filter_placeholder; ?>">
                    </div>
                </form>
                <?php }?>

            </td>
            <td align="center" style=" width:9%">
                <select class="form-control select_filter" id="select_filter_user">
                    <option value="0"><?php echo lang('filter_user'); ?></option>
                    <?php foreach ($users as $user) {?>
                    <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php }?>
                </select>
            </td>
            <td align="center" style=" width:9%">
                <select class="form-control select_filter" id="select_filter_date"">
                    <option value="all"><?php echo lang('year'); ?></option>
                    <?php
						$min_y = intval($min_y) == 0 ? date("Y") : $min_y;
						$max = intval($max) == 0 ? date("Y") : $max;
						for ($i = $min_y; $i <= $max; $i++) {?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php }
?>
                </select>

            </td>
            <td align="center" style=" width:9%">
                <select class="form-control select_filter" id="select_filter_statuts">
                    <option value="all"><?php echo lang('all_statue'); ?></option>
                    <option value="1"><?php echo lang('draft'); ?></option>
                    <option value="2"><?php echo lang('sent'); ?></option>
                    <option value="3"><?php echo lang('viewed'); ?></option>
                    <option value="4"><?php echo lang('paid'); ?></option>
                    <option value="5"><?php echo lang('rejected'); ?></option>
                    <option value="7"><?php echo lang('unpaid'); ?></option>
                    <option value="8"><?php echo lang('refunded'); ?></option>
                    <option value="6"><?php echo lang('canceled'); ?></option>                   
                </select>

            </td>
            <td align="right" class="pull-block" style=" width:53%">
                <?php if ($sess_devis_add == 1) {?>
                <div class="pull-right factures">
                    <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg" data-toggle="collapse"
                        data-target="#ip-submenu-collapse">
                        <i class="fa fa-bars"></i> <?php echo lang('submenu'); ?>
                    </button>
                    <button type="submit" id="relance_rappel" name="relance_rappel" class=" btn btn-sm btn relance-rappel">
                         <i class="fas fa-check-square"></i><?php echo lang('relance'); ?>
                    </button>
                    <?php if (rightsExportLotPdf()) {?>
                    <button id="download_invoices" name="download_invoices" class=" btn btn-sm btn download-invoices">
                        <i class="fa fa-download"></i> <?php echo lang('export_xl') ?>
                    </button>
                    <?php }?>
                    <?php if (rightsExportExcel()) {?>
                    <button id="export_excel" class="btn btn-sm btn export-excel">
                        <i class="fas fa-file"></i><?php echo lang('exporter') ?>
                    </button>
                    <?php }?>

                    <a class="create-facture btn no-marg btn-sm btn-primary btn-light-success"
                        href="<?php echo base_url(); ?>invoices/form">
                        <?php echo lang('create_invoice'); ?>
                    </a>
                </div>
                <?php }?>
            </td>

        </tr>
        </table>
    <div style="clear:both"></div>
</div>


	 <div id="myProgress">
      
		 <div id="myBar"></div> 
		 </div> 		

<form action="<?php echo site_url('mailer/relance'); ?>" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div id="content" class="table-content">
                    <?php // $this->layout->load_view('layout/alerts');  ?>

                    <div class="table-scrollable" style=" width: 100%; border:none!important;">
                        <table class="table table-striped table-hover table-responsive" id="invoice_all">
                            <thead>
                                <tr>
                                    <th width="50" order="ip_invoices.invoice_number"><?php echo lang('num_devis'); ?>
                                    </th>
                                    <th width="50" order="ip_invoices.invoice_status_id" style="text-align:center;">
                                        <?php echo lang('status_tab'); ?></th>
                                    <th width="100" order="ip_invoices.invoice_date_created">
                                        <?php echo lang('created'); ?></th>
                                    <th width="100" order="ip_invoices.invoice_date_due"><?php echo lang('due_date'); ?>
                                    </th>
                                    <th width="150" order="client_societe2"><?php echo lang('client_filter'); ?></th>
                                    <th width="50" order="client_country"><?php echo lang('client_pays'); ?></th>
                                    <th width="150" order="ip_invoices.nature"><?php echo lang('quote_nature'); ?></th>
                                    <th width="100" order="invoice_item_subtotal_final"><?php echo lang('amount_ht'); ?>
                                    </th>
                                    <th width="100" order="invoice_total"><?php echo lang('amount_ttc'); ?></th>
                                    <th width="50" order="ABS(delai_paiement_label)"><?php echo lang('mode_pmt'); ?>
                                    </th>
                                    <th width="120" order="user_name"><?php echo lang('suivi'); ?></th>
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
                                    <th width="50" style="white-space:nowrap;" align="right">
                                        <div class="options btn-group">
                                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                href="#">
                                                <i class="fa fa-cog"></i> <?php // echo lang('options');     ?>
                                            </a>
                                            <ul class="dropdown-menu dropdown-btngroup-menu">
                                                <!--<li style="display:none" id="select_all">-->
                                                <li>
                                                    <a href="#">
                                                        <div id="select_all" class="md-checkbox">
                                                            <input type="checkbox" id="aa">
                                                            <label for="aa">
                                                                <?php echo lang('select_all'); ?>
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </a>
                                                    <div class='selectinput'>

                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="filter_results">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</form>

<!-- pagination -->
<div class="pag-table-content">
    <div class="pull-right">
        <select class="btn btn-default btn-sm bg-light-primary pagin" style="background:#FFF;" id="invoices_par_page">
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

<div class="loader"></div>

<input type='hidden' value='0' id='etatselect'>

<script type="text/javascript">
 $(document).ready(function() {
    var myInteger = 0;
    $('#relance_rappel').prop("disabled", true);
    $('#export_excel').prop("disabled", true);
    $('#check_all').prop('checked', false);
    $('#aa').prop('checked', false);
})
$('.loader').hide();

function createfilesPDF(folder) {
    $('input:checked[name="Choix[]"]').each(function() {
        var invoice_id = parseInt($(this).val());
        $.post("<?php echo site_url('invoices/ajax/downloadInvoices'); ?>", {
            invoice_id: invoice_id,
            folder: folder
        });

    });
}

function getRandomIntInclusive(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

let constvat = 0;
let constvat1 = 0;
$('#relance_rappel').click(function() {
    long = $('input:checked[name="Choix[]"]');
    long1 = $('input:checked[name="Choixtou[]"]');

    if (long1.length > 0) {
        $('input:checked[name="Choixtou[]"]').each(function() {
            $('.loader').show();
            var id_invoice = $(this).val();
            $.post("<?php echo site_url('mailer/relance'); ?>", {
                id_invoice: id_invoice,
                type: 'invoice'
            }, function(data) {
                constvat1 = constvat1 + 1;
                //  console.log('h1' + constvat1);

                if (constvat1 == long1.length) {
                    //  alert('fini0');

                    // window.location.reload(true);
                }
            });
        });
        // window.location.reload(true);
        $('input:checked[name="Choix[]"]').prop('checked', false);
        $('#aa').prop('checked', false);
        $('#check_all').prop('checked', false);
        $('#relance_rappel').prop("disabled", true);
        $('#export_excel').prop("disabled", true);
    } else if (long.length > 0) {
        $('input:checked[name="Choix[]"]').each(function() {
            $('.loader').show();

            var id_invoice = $(this).val();
            $.post("<?php echo site_url('mailer/relance'); ?>", {
                id_invoice: id_invoice,
                type: 'invoice'
            }, function(data) {
                //  window.location.reload(true);
                constvat = constvat + 1;
                //  console.log('h1' + constvat1);
                if (constvat == long.length) {

                    window.location.reload(true);
                }
            });
        });
        $('input:checked[name="Choix[]"]').prop('checked', false);
        $('#aa').prop('checked', false);
        $('#check_all').prop('checked', false);
        $('#relance_rappel').prop("disabled", true);
        $('#export_excel').prop("disabled", true);
    }
});

$("#download_invoices").click(function() {
    // if (confirm('Voulez vous Télécharger ces factures ?')) {
    $('#download_invoices').addClass('disabled');
    var folder = "Factures_" + getRandomIntInclusive(1000, 9999);
    $.when(createfilesPDF(folder)).done().then(function(v) {
        $.post("<?php echo site_url('invoices/ajax/createZip'); ?>", {
            folder: folder
        }, function(data) {
            //               alert(data);
            $('#download_invoices').removeClass('disabled');
            window.open("<?php echo site_url('invoices/download_zip'); ?>" + '/' + data,
                '_blank');
        });
        $('#check_all').prop('checked', false);
        $('#aa').prop('checked', false);
        $('input[name="Choix[]"]').each(function() {
            $(this).prop('checked', false);
        });
        $('input[name="Choixtou[]"]').each(function() {
            $(this).prop('checked', false);
        });
    });
    //  }
});
document.getElementById("myBar").style.display = "none";
function move(t) {
		 
	var i = 0;
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 1;
    var id = setInterval(frame, t);
    function frame() {
      if (width == 100) {
       clearInterval(id);
	  elem.style.display = "none";
	  //window.location.reload(true);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
		
      }
    }
	
  }
 
}

$('#export_excel').click(function() {
    document.getElementById("myBar").style.display = "block";
    if (confirm('Voulez vous Télécharger ces factures ?')) {
    var ids_invoice = [];
    var ids_invoice_sep = "";
    var cnt = 0;
    long = $('input:checked[name="Choix[]"]');
    long1 = $('input:checked[name="Choixtou[]"]');

    if (long1.length > 0) {
        $('input:checked[name="Choixtou[]"]').each(function() {
            if (cnt != 0) {
                ids_invoice_sep += "_";
            }
            ids_invoice_sep += $(this).val();
            ids_invoice.push(parseInt($(this).val()));
            cnt++;
        });
        window.location.href="<?php echo site_url('invoices/export_excelall'); ?>";
           move(20);
        $('input:checked[name="Choix[]"]').prop('checked', false);
        $('#aa').prop('checked', false);
        $('#check_all').prop('checked', false);
        $('#relance_rappel').prop("disabled", true);
        $('#export_excel').prop("disabled", true);

    } else if (long.length > 0) {
        $('input:checked[name="Choix[]"]').each(function() {
            if (cnt != 0) {
                ids_invoice_sep += "_";
            }
            ids_invoice_sep += $(this).val();
            ids_invoice.push(parseInt($(this).val()));
            cnt++;
        });
        window.location.href="<?php echo site_url('invoices/export_excel'); ?>/"+ ids_invoice_sep;
          
        $('input:checked[name="Choix[]"]').prop('checked', false);
        $('#aa').prop('checked', false);
        $('#check_all').prop('checked', false);
        $('#relance_rappel').prop("disabled", true);
        $('#export_excel').prop("disabled", true);
    }
    }
});
$(function() {
    start_page = 1;
    limit_par_page = 20;
    nb_pages = 1;
    order_by = "ip_invoices.invoice_number";
    order_method = "desc";
    if (typeof(page) == 'undefined') {
        page = 1;
    }
    if (typeof(filter_user_id) == 'undefined') {
        filter_user_id = "0";
    }
    if (typeof(filter_date) == 'undefined') {
        filter_date = "all";
    }
    if (typeof(filter_statuts) == 'undefined') {
        filter_statuts = "all";
    }
    if (typeof(filter_invoice) == 'undefined') {
        filter_invoice = "";
    }

    $("#select_all").change(function() {
        if ($('#aa').prop("checked")) {
            $('input[name="Choix[]"]').each(function() {
                $(this).prop('checked', 'checked');
            });
            $('#relance_rappel').prop("disabled", false);
            $('#export_excel').prop("disabled", false);
			$('#download_invoices').prop("disabled", false);
            $.post("<?php echo site_url('invoices/ajax/getInvoice'); ?>", function(data) {
                var invoice_all = JSON.parse(data);
                //   $('#check_all').prop('checked', 'checked');
                $('input[type="checkbox"]').prop('checked', 'checked');

                if ($('input[name="Choixtou[]"]').is(':checked')) {

                } else {
                    for (i = 0; i < invoice_all.length; i++) {
                        $(".selectinput").append(
                            '<input type = "checkbox" name = "Choixtou[]" value = "' +
                            invoice_all[i]['invoice_id'] +
                            ' "  class = "md-check" checked hidden>'
                        );
                    }
                }
            })
        } else {
            $('#relance_rappel').prop("disabled", true);
            $('#export_excel').prop("disabled", true);
			 $('#download_invoices').prop("disabled", true);
            $('input[type="checkbox"]').prop('checked', false);
        }

    })
    $("#check_all").click(function() {
        if ($(this).is(':checked')) {
            $('#relance_rappel').prop("disabled", false);
            $('#export_excel').prop("disabled", false);
			$('#download_invoices').prop("disabled", false);
            $("#filter_results tr td .md-check").each(function() {
                this.checked = true;
            });
        } else {
            $('#relance_rappel').prop("disabled", true);
            $('#export_excel').prop("disabled", true);
			 $('#download_invoices').prop("disabled", true);
            $("#filter_results tr td .md-check").each(function() {
                this.checked = false;
            });
        }
    });


    $('#filter_invoices').keyup(function() {
        filter_invoice = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterInvoices();

    });
    $('#select_filter_user').change(function() {
        filter_user_id = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterInvoices();

    });
    $('#select_filter_date').change(function() {
        filter_date = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterInvoices();
    });
    $('#select_filter_statuts').change(function() {
        filter_statuts = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterInvoices();
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
        filterInvoices();
    });
    $("#invoices_par_page").change(function() {
        start_page = 1;
        limit_par_page = $(this).val();
        filterInvoices();
    });

    $("#invoice_all thead tr th").click(function() {
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
            filterInvoices();
        }

    });

    filterInvoices();

    function filterInvoices() {
        //            $('#filter_results').html("<tr><td colspan='13'> Loading...</td></tr>");
        $('#filter_results').load("<?php echo site_url('invoices/ajax/load_invoices_partial_filter'); ?>/" +
            Math.floor(Math.random() * 1000), {
                filter_user_id: filter_user_id,
                filter_invoice: filter_invoice,
                filter_date: filter_date,
                filter_statuts: filter_statuts,
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
</body>