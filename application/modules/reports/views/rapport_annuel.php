<div id="headerbar_empty">
</div>
<!-- BEGIN ROW -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN CHART PORTLET-->
        <div class="portlet light top-clt">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> <?php echo lang('rapport_annuel_factures'); ?></span>

                </div>
                <div class="tools">
                    <div class="pull-right" style="margin: 0 0 0 10px;">
                        <select class="form-control" id="selected_devise">
                            <?php foreach ($devises as $devise) { ?>
                                <option value="<?php echo $devise->devise_id; ?>"><?php echo $devise->devise_label . " (" . $devise->devise_symbole . ")"; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
            </div>
            <div class="portlet-body annuel">
                <div id="chart_2" class="chart" style="height: 400px;">
                </div>
            </div>
        </div>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> <?php echo lang('rapport_annuel_factures'); ?></span>

                </div>
            </div>
            <div class="portlet-body table-responsive">
                <table   class="table table-striped  table-hover no-footer" >
                    <thead>
                        <tr style="font-weight: bold;">
                            <td ><?php echo lang('month'); ?></td> 
                            <td ><?php echo lang('nb-factures'); ?> (<?php echo date("Y"); ?>)</td>
                            <td ><?php echo lang('chiffre-factures'); ?>(<?php echo date("Y"); ?>)</td>
                            <td ><?php echo lang('nb-factures'); ?> (<?php echo date("Y") - 1; ?>)</td>
                            <td ><?php echo lang('chiffre-factures'); ?>(<?php echo date("Y") - 1; ?>)</td>
                            <td ><?php echo lang('nb-factures'); ?>(<?php echo date("Y") - 2; ?>)</td>
                            <td ><?php echo lang('chiffre-factures'); ?>(<?php echo date("Y") - 2; ?>)</td>

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
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN CHART PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> <?php echo lang('rapport_annuel_devis'); ?></span>

                </div>
            </div>
            <div class="portlet-body annuel">
                <div id="chart_3" class="chart" style="height: 400px;">
                </div>
            </div>
        </div>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> <?php echo lang('rapport_annuel_devis'); ?></span>

                </div>
            </div>
            <div class="portlet-body table-responsive">
                <table   class="table table-striped table-hover no-footer" >
                    <thead>
                        <tr style="font-weight: bold;">
                            <td ><?php echo lang('month'); ?></td>
                            <td ><?php echo lang('nombre_devis'); ?> (<?php echo date("Y"); ?>)</td>
                            <td ><?php echo lang('chiffre_devis'); ?>(<?php echo date("Y"); ?>)</td>
                            <td ><?php echo lang('nombre_devis'); ?> (<?php echo date("Y") - 1; ?>)</td>
                            <td ><?php echo lang('chiffre_devis'); ?>(<?php echo date("Y") - 1; ?>)</td>
                            <td ><?php echo lang('nombre_devis'); ?> (<?php echo date("Y") - 2; ?>)</td>
                            <td ><?php echo lang('chiffre_devis'); ?> (<?php echo date("Y") - 2; ?>)</td>

                        </tr>
                    </thead>
                    <tbody id="stat_table_1">
                    </tbody>
                    <tfoot id="stat_table_total_1">

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
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->

<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/charts-amcharts.js"></script>
<script>

    function updateChart() {

        $.post("<?php echo site_url('reports/ajax/update_chart_annuel'); ?>", {
            current_devise: current_devise
        }, function (data) {
            var parsed = JSON.parse(data);
            json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            table_stat = "";
            table_stat_1 = "";

            devise_info = json_response[1];
            var mois_array = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];

            $("#symbole_devise").val(devise_info[0]["devise_symbole"]);
            $("#currency_symbol_placement").val(devise_info[0]["symbole_placement"]);
            $("#tax_rate_decimal_places").val(devise_info[0]["number_decimal"]);
            $("#thousands_separator").val(devise_info[0]["thousands_separator"]);

            total_invoices = 0;
            total_invoices_1 = 0;
            total_invoices_2 = 0;
            nb_invoices = 0;
            nb_invoices_1 = 0;
            nb_invoices_2 = 0;
            table_foot_table = "";

            $.each(json_response[0], function (key, value) {
                table_stat += "<tr>";
                var d = new Date(value["date"]);
                var m = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
                table_stat += "<td style='text-align: center;font-weight:bold;'>" + mois_array[d.getMonth()] + "</td>";
                table_stat += "<td style='text-align: center;'>" + value["count_factures"] + "</td>";
                table_stat += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value["facture"]) + "</td>";
                table_stat += "<td style='text-align: center;'>" + value["count_factures_1"] + "</td>";
                table_stat += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value["facture_1"]) + "</td>";
                table_stat += "<td style='text-align: center;'>" + value["count_factures_2"] + "</td>";
                table_stat += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value["facture_2"]) + "</td>";

                table_stat += "</tr>";
                total_invoices += parseFloat(value["facture"]);
                total_invoices_1 += parseFloat(value["facture_1"]);
                total_invoices_2 += parseFloat(value["facture_2"]);
                nb_invoices += parseInt(value["count_factures"]);
                nb_invoices_1 += parseInt(value["count_factures_1"]);
                nb_invoices_2 += parseInt(value["count_factures_2"]);

            });

            table_foot_table += "<tr style='font-weight: bold;' class='bg-grey'>";
            table_foot_table += "<td style='text-align: center;'>Total</td>";
            table_foot_table += "<td style='text-align: center;'>" + nb_invoices + "</td>";
            table_foot_table += "<td style='text-align: center;'>" + beautifyFormatWithDevice(total_invoices) + "</td>";
            table_foot_table += "<td style='text-align: center;'>" + nb_invoices_1 + "</td>";
            table_foot_table += "<td style='text-align: center;'>" + beautifyFormatWithDevice(total_invoices_1) + "</td>";
            table_foot_table += "<td style='text-align: center;'>" + nb_invoices_2 + "</td>";
            table_foot_table += "<td style='text-align: center;'>" + beautifyFormatWithDevice(total_invoices_2) + "</td>";

            table_foot_table += "</tr>";

            $("#stat_table").html(table_stat);
            $("#stat_table_total").html(table_foot_table);
            initChart();




            total_quotes = 0;
            total_quotes_1 = 0;
            total_quotes_2 = 0;
            nb_quotes = 0;
            nb_quotes_1 = 0;
            nb_quotes_2 = 0;
            table_foot_table_1 = "";

            $.each(json_response[2], function (key, value) {
                table_stat_1 += "<tr>";
                var d = new Date(value["date"]);
                var m = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
                table_stat_1 += "<td style='text-align: center;font-weight:bold;'>" + mois_array[d.getMonth()] + "</td>";
                table_stat_1 += "<td style='text-align: center;'>" + value["count_devis"] + "</td>";
                table_stat_1 += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value["devis"]) + "</td>";
                table_stat_1 += "<td style='text-align: center;'>" + value["count_devis_1"] + "</td>";
                table_stat_1 += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value["devis_1"]) + "</td>";
                table_stat_1 += "<td style='text-align: center;'>" + value["count_devis_2"] + "</td>";
                table_stat_1 += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value["devis_2"]) + "</td>";

                table_stat_1 += "</tr>";
                total_quotes += parseFloat(value["devis"]);
                total_quotes_1 += parseFloat(value["devis_1"]);
                total_quotes_2 += parseFloat(value["devis_2"]);
                nb_quotes += parseInt(value["count_devis"]);
                nb_quotes_1 += parseInt(value["count_devis_1"]);
                nb_quotes_2 += parseInt(value["count_devis_2"]);

            });

            table_foot_table_1 += "<tr style='font-weight: bold;' class='bg-grey'>";
            table_foot_table_1 += "<td style='text-align: center;'>Total</td>";
            table_foot_table_1 += "<td style='text-align: center;'>" + nb_quotes + "</td>";
            table_foot_table_1 += "<td style='text-align: center;'>" + beautifyFormatWithDevice(total_quotes) + "</td>";
            table_foot_table_1 += "<td style='text-align: center;'>" + nb_quotes_1 + "</td>";
            table_foot_table_1 += "<td style='text-align: center;'>" + beautifyFormatWithDevice(total_quotes_1) + "</td>";
            table_foot_table_1 += "<td style='text-align: center;'>" + nb_quotes_2 + "</td>";
            table_foot_table_1 += "<td style='text-align: center;'>" + beautifyFormatWithDevice(total_quotes_2) + "</td>";

            table_foot_table_1 += "</tr>";

            $("#stat_table_1").html(table_stat_1);
            $("#stat_table_total_1").html(table_foot_table_1);
            initChart1();
        });


        var initChart = function () {

            var datachartss = json_response[0];

            var chart = AmCharts.makeChart("chart_2", {
                "type": "serial",
                "theme": "light",
                "fontFamily": 'Open Sans',
                "color": '#888888',
                "legend": {
                    "equalWidths": false,
                    "useGraphSettings": true,
                    "valueAlign": "left",
                    "valueWidth": 120
                },
                "dataProvider": datachartss,
                "valueAxes": [{
                        "id": "factureAxis",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "title": "",
                        "labelFunction": function (value, valueString, axis) {
                            return beautifyFormatWithDevice(valueString);

                        }
                    }, {
                        "id": "clientsAxis",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "labelsEnabled": false,
                        "position": "right"
                    }],
                "graphs": [
                    {
                        "alphaField": "alpha",
                        "balloonText": "Factures: [[value]]",
                        "dashLengthField": "dashLength",
                        "fillAlphas": 0.7,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_invoices),
                        "legendValueText": "[[value]]",
                        "title": "<?php echo date("Y"); ?>",
                        "type": "column",
                        "valueField": "facture",
                        "valueAxis": "factureAxis",
                        "balloonFunction": function (graphDataItem, graph) {
                            var value = graphDataItem.values.value;
                            return beautifyFormatWithDevice(value);

                        }
                    },
                    {
                        "alphaField": "alpha",
                        "balloonText": "Factures_1: [[value]]",
                        "dashLengthField": "dashLength",
                        "fillAlphas": 0.7,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_invoices),
                        "legendValueText": "[[value]]",
                        "title": "<?php echo date("Y") - 1; ?>",
                        "type": "column",
                        "valueField": "facture_1",
                        "valueAxis": "facture_1Axis",
                        "balloonFunction": function (graphDataItem, graph) {
                            var value = graphDataItem.values.value;
                            return beautifyFormatWithDevice(value);

                        }
                    },
                    {
                        "alphaField": "alpha",
                        "balloonText": "Factures_2: [[value]]",
                        "dashLengthField": "dashLength",
                        "fillAlphas": 0.7,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_invoices),
                        "legendValueText": "[[value]]",
                        "title": "<?php echo date("Y") - 2; ?>",
                        "type": "column",
                        "valueField": "facture_2",
                        "valueAxis": "facture_2Axis",
                        "balloonFunction": function (graphDataItem, graph) {
                            var value = graphDataItem.values.value;
                            return beautifyFormatWithDevice(value);

                        }
                    },
                ],
                "chartCursor": {
                    "categoryBalloonDateFormat": "MMM",
                    "cursorAlpha": 0.1,
                    "cursorColor": "#000000",
                    "fullWidth": true,
                    "valueBalloonsEnabled": true,
                    "zoomable": false
                },
                "dataDateFormat": "YYYY-MM",
                "categoryField": "date",
                "categoryAxis": {
                    "dateFormats": [{
                            "period": "DD",
                            "format": "DD"
                        }, {
                            "period": "MM",
                            "format": "MMM"
                        }, {
                            "period": "YYYY",
                            "format": "YYYY"
                        }],
                    "parseDates": true,
                    "autoGridCount": false,
                    "axisColor": "#555555",
                    "gridAlpha": 0.1,
                    "gridColor": "#FFFFFF",
                    "minPeriod": "MM",
                    "gridCount": 50
                },
                "exportConfig": {
                    "menuBottom": "20px",
                    "menuRight": "22px",
                    "menuItems": [{
                            "icon": Metronic.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                            "format": 'png'
                        }]
                }
            });

            $('#chart_2').closest('.portlet').find('.fullscreen').click(function () {
                chart.invalidateSize();
            });
        }
        var initChart1 = function () {

            var datachartss = json_response[2];

            var chart = AmCharts.makeChart("chart_3", {
                "type": "serial",
                "theme": "light",
                "fontFamily": 'Open Sans',
                "color": '#888888',
                "legend": {
                    "equalWidths": false,
                    "useGraphSettings": true,
                    "valueAlign": "left",
                    "valueWidth": 120
                },
                "dataProvider": datachartss,
                "valueAxes": [{
                        "id": "factureAxis",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "title": "",
                        "labelFunction": function (value, valueString, axis) {
                            return beautifyFormatWithDevice(valueString);

                        }
                    }, {
                        "id": "clientsAxis",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "labelsEnabled": false,
                        "position": "right"
                    }],
                "graphs": [
                    {
                        "alphaField": "alpha",
                        "balloonText": "Devis: [[value]]",
                        "dashLengthField": "dashLength",
                        "fillAlphas": 0.7,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_invoices),
                        "legendValueText": "[[value]]",
                        "title": "<?php echo date("Y"); ?>",
                        "type": "column",
                        "valueField": "devis",
                        "valueAxis": "devisAxis",
                        "balloonFunction": function (graphDataItem, graph) {
                            var value = graphDataItem.values.value;
                            return beautifyFormatWithDevice(value);

                        }
                    },
                    {
                        "alphaField": "alpha",
                        "balloonText": "Devis_1: [[value]]",
                        "dashLengthField": "dashLength",
                        "fillAlphas": 0.7,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_invoices),
                        "legendValueText": "[[value]]",
                        "title": "<?php echo date("Y") - 1; ?>",
                        "type": "column",
                        "valueField": "devis_1",
                        "valueAxis": "devis_1Axis",
                        "balloonFunction": function (graphDataItem, graph) {
                            var value = graphDataItem.values.value;
                            return beautifyFormatWithDevice(value);

                        }
                    },
                    {
                        "alphaField": "alpha",
                        "balloonText": "Devis_2: [[value]]",
                        "dashLengthField": "dashLength",
                        "fillAlphas": 0.7,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_invoices),
                        "legendValueText": "[[value]]",
                        "title": "<?php echo date("Y") - 2; ?>",
                        "type": "column",
                        "valueField": "devis_2",
                        "valueAxis": "devis_2Axis",
                        "balloonFunction": function (graphDataItem, graph) {
                            var value = graphDataItem.values.value;
                            return beautifyFormatWithDevice(value);

                        }
                    },
                ],
                "chartCursor": {
                    "categoryBalloonDateFormat": "MMM",
                    "cursorAlpha": 0.1,
                    "cursorColor": "#000000",
                    "fullWidth": true,
                    "valueBalloonsEnabled": true,
                    "zoomable": false
                },
                "dataDateFormat": "YYYY-MM",
                "categoryField": "date",
                "categoryAxis": {
                    "dateFormats": [{
                            "period": "DD",
                            "format": "DD"
                        }, {
                            "period": "MM",
                            "format": "MMM"
                        }, {
                            "period": "YYYY",
                            "format": "YYYY"
                        }],
                    "parseDates": true,
                    "autoGridCount": false,
                    "axisColor": "#555555",
                    "gridAlpha": 0.1,
                    "gridColor": "#FFFFFF",
                    "minPeriod": "MM",
                    "gridCount": 50
                },
                "exportConfig": {
                    "menuBottom": "20px",
                    "menuRight": "22px",
                    "menuItems": [{
                            "icon": Metronic.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                            "format": 'png'
                        }]
                }
            });

            $('#chart_3').closest('.portlet').find('.fullscreen').click(function () {
                chart.invalidateSize();
            });
        }

    }


    $("#selected_devise").change(function () {
        current_devise = $(this).val();
        updateChart();
    });

    jQuery(document).ready(function () {

        if (typeof (current_devise) == 'undefined')
        {
            current_devise = $("#selected_devise").val();
        }

        updateChart();

    });
</script>