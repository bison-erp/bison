<div id="headerbar_empty">
</div>
<!-- BEGIN ROW -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN CHART PORTLET-->
        <div class="portlet light top-clt clt1">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"><?php echo lang('top-clt'); ?></span>

                </div>
                <div class="tools">
                    <div class="pull-right" style="margin: 0 0 0 10px;">
                        <select class="form-control" id="selected_date">
                            <?php
                            for ($i = 0; $i < 4; $i++) {
                                $date_select = (int) date("Y") - $i;
                                ?>
                                <option value="<?php echo $date_select; ?>"><?php echo $date_select; ?></option>
                            <?php } ?>

                        </select>

                    </div>
                    <div class="pull-right" style="margin: 0 0 0 10px;">
                        <select class="form-control" id="selected_devise">
                            <?php foreach ($devises as $devise) { ?>
                                <option value="<?php echo $devise->devise_id; ?>"><?php echo $devise->devise_label . " (" . $devise->devise_symbole . ")"; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div id="chart_6" class="chart" style="height: 525px;">
                </div>
            </div>
        </div>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"><?php echo lang('rapport-annuel'); ?></span>

                </div>
            </div>
            <div class="portlet-body table-responsive">
                <table   class="table table-striped  table-hover no-footer" >
                    <thead>
                        <tr style="font-weight: bold;">
                            <td style="width:50px;">#</td>
                            <td><?php echo lang('clt'); ?></td>
                            <td><?php echo lang('nb-factures'); ?></td>
                            <td ><?php echo lang('chiffre-factures'); ?></td>
                        </tr>
                    </thead>
                    <tbody id="stat_table">
                    </tbody>
                    <tfoot id="stat_table_total">

                    </tfoot>

                </table>
            </div>
        </div>

    </div>
</div>
<input type="hidden" id="symbole_devise" value="DT">
<input type="hidden" id="tax_rate_decimal_places" value="3">
<input type="hidden" id="currency_symbol_placement" value="after">
<input type="hidden" id="thousands_separator" value=" ">
<input type="hidden" id="decimal_point" value=".">
<!-- END ROW -->


<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->

<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/charts-amcharts.js"></script>
<script>
    function updateChart() {

        $.post("<?php echo site_url('reports/ajax/update_chart_clients'); ?>", {
            current_year: current_year,
            current_devise: current_devise
        }, function (data) {
            var parsed = JSON.parse(data);
            json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            table_stat = "";

            devise_info = json_response[1];

            $("#symbole_devise").val(devise_info[0]["devise_symbole"]);
            $("#currency_symbol_placement").val(devise_info[0]["symbole_placement"]);
            $("#tax_rate_decimal_places").val(devise_info[0]["number_decimal"]);
            $("#thousands_separator").val(devise_info[0]["thousands_separator"]);

            total_invoices = 0;
            nb_invoices = 0;
            var cnt = 1;
            table_foot_table = "";
            $.each(json_response[0], function (key, value) {
                table_stat += "<tr>";
                table_stat += "<td style='text-align: center;'>" + cnt +"</td>";
                if(value["client_id"] == 0){
                table_stat += "<td style='text-align: center;'>" + value["client"] + "</td>";
            }else{
                table_stat += "<td style='text-align: center;'><a href='<?php echo base_url(); ?>clients/view/"+value["client_id"]+"'>" + value["client"] + "</a></td>";
            }
                table_stat += "<td style='text-align: center;'>" + value["count_invoices"] + "</td>";
                table_stat += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value["invoices"]) + "</td>";
                
                table_stat += "</tr>";
                cnt++;
                total_invoices += parseFloat(value["invoices"]);
                nb_invoices += parseInt(value["count_invoices"]);

            });
            table_foot_table += "<tr style='font-weight: bold;' class='bg-grey'>";
            table_foot_table += "<td style='text-align: center;' colspan='2'>Total</td>";
            table_foot_table += "<td style='text-align: center;'>" + nb_invoices + "</td>";
            table_foot_table += "<td style='text-align: center;'>" + beautifyFormatWithDevice(total_invoices) + "</td>";
            table_foot_table += "</tr>";

            $("#stat_table").html(table_stat);
            $("#stat_table_total").html(table_foot_table);
            initChart();
        });

        var initChart = function () {
            var datachartss = json_response[0];
            var chart = AmCharts.makeChart("chart_6", {
                "type": "pie",
                "theme": "light",
                "fontFamily": 'Open Sans',
                "color": '#888',
                "dataProvider": datachartss,
                "valueField": "invoices",
                "titleField": "client",
                "balloonText": "[[client]] [[value]]<br>([[percents]]%)",
                "balloon": {
                    "drop": true,
                   
                    
                },
                "balloonFunction": function (graphDataItem, graph) {
                            var value = graphDataItem.value;
                            var percents = graphDataItem.percents;
                            var client = graphDataItem.title;
//                            var test="";
//                            for (var x in graphDataItem) {
//                                test += ", "+x+" : "+graphDataItem[x];
//                            }
//                            alert(test);
                            return client+" "+beautifyFormatWithDevice(value)+" ("+beautifyFormat(percents,"float2")+"%)";
                            

                        },
                "exportConfig": {
                    menuItems: [{
                            icon: Metronic.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                            format: 'png'
                        }]
                }
            });

            $('#chart_6').closest('.portlet').find('.fullscreen').click(function () {
                chart.invalidateSize();
            });
        }



    }

    $("#selected_date").change(function () {
        current_year = $(this).val();
        updateChart();
    });
    $("#selected_devise").change(function () {
        current_devise = $(this).val();
        updateChart();
    });

    jQuery(document).ready(function () {
        if (typeof (current_year) == 'undefined')
        {
            current_year = $("#selected_date").val();
        }
        if (typeof (current_devise) == 'undefined')
        {
            current_devise = $("#selected_devise").val();
        }

        updateChart();

    });
</script>