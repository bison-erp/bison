<style>
.chaff {
    text-align: center;
    text-transform: uppercase;
    color: #6495ED;
}

body {
    background-color: #666;
}

#barChart {
    background-color: wheat;
    border-radius: 6px;
    /*   Check out the fancy shadow  on this one */
    box-shadow: 0 3rem 5rem -2rem rgba(0, 0, 0, 0.6);
}

[data-tip] {
    position: relative;

}

[data-tip]:before {
    content: '';
    /* hides the tooltip when not hovered */
    display: none;
    content: '';
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-bottom: 5px solid #1a1a1a;
    position: absolute;
    top: 30px;
    left: 35px;
    z-index: 8;
    font-size: 0;
    line-height: 0;
    width: 0;
    height: 0;
}

[data-tip]:after {
    display: none;
    content: attr(data-tip);
    position: absolute;
    top: 35px;
    left: 0px;
    padding: 19px 25px;
    background: #1a1a1a;
    color: #fff;
    z-index: 9;
    font-size: 1em;
    height: 18px;
    line-height: 4px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    white-space: nowrap;
    word-wrap: normal;
}

[data-tip]:hover:before,
[data-tip]:hover:after {
    display: block;
}
</style>
<div id="headerbar_empty">
</div>
<!-- BEGIN ROW -->
<div class="row">
    <div class="colr">

    </div>
    <div class="col-md-12">
        <!-- BEGIN CHART PORTLET-->
        <div class="portlet light top-clt top-cmrcl">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"><?php echo lang('top-cmrcl'); ?> </span>

                </div>
                <div class="tools">
                    <div class="pull-right" style="margin: 0 0 0 10px;">
                        <select class="form-control" id="selected_date">
                            <?php
for ($i = 0; $i < 4; $i++) {
    $date_select = (int) date("Y") - $i;
    ?>
                            <option value="<?php echo $date_select; ?>"><?php echo $date_select; ?></option>
                            <?php }?>

                        </select>

                    </div>
                    <div data-tip="Date fin" class="pull-right" style="margin: 0 0 0 10px;">
                        <input class="form-control" type="date" id="end_date" name="end_date">

                    </div>
                    <div data-tip="Date début" class="pull-right" style="margin: 0 0 0 10px;">
                        <input class="form-control" type="date" id="first_date" name="first_date">

                    </div>
                    <div class="pull-right" style="margin: 0 0 0 10px;">
                        <select class="form-control" id="selected_devise">
                            <?php foreach ($devises as $devise) {?>
                            <option value="<?php echo $devise->devise_id; ?>">
                                <?php echo $devise->devise_label . " (" . $devise->devise_symbole . ")"; ?></option>
                            <?php }?>
                        </select>

                    </div>
                    <div class="pull-right" style="margin: 0 0 0 10px;">
                        <select class="form-control" id="selected_group">
                            <option value="0">Tous</option>
                            <?php foreach ($groupes_users as $group) {?>
                            <option value="<?php echo $group->groupes_user_id; ?>">
                                <?php echo $group->designation; ?>
                            </option>
                            <?php }?>
                        </select>
                    </div>

                </div>
                <div class="portlet-body">
                    <div id="chart_6" class="chart" style="height: 525px;width:100%">
                    </div>
                </div>
                <div style="text-align: center;    font-size: 24px;">
                    <span class="chaff">
					<?php echo lang('chiffre-affaire');?>
                    </span>
                </div>
            </div>
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-green-haze"></i>
                        <span class="caption-subject bold uppercase font-green-haze"> <?php echo lang('taux-conversion');?></span>
                    </div>
                </div>
                <div class="portlet-body table-responsive">
                    <table class="table table-striped  table-hover no-footer">
                        <thead>
                            <tr style="font-weight: bold;">
                                <td style="width:50px;">#</td>
                                <td><?php echo lang('user');?></td>
                                <td><?php echo lang('nb_devis');?></td>
                                <td style="width:15%"><?php echo lang('ca_devis');?></td>
                                <td><?php echo lang('nb_devis_accept');?></td>
                                <td style="width:15%;"><?php echo lang('ca_devis_accept');?></td>
                                <td style="width:15%;"><?php echo lang('mont-encaiss');?></td>
                                <td ><?php echo lang('nb-user');?></td>
                                <td ><?php echo lang('nb-prospects');?></td>
                                <td ><?php echo lang('taux-conversion');?></td>
                            </tr>
                        </thead>
                        <tbody id="stat_table">
                        </tbody>
                        <tfoot id="stat_table_total">

                        </tfoot>

                    </table>
                </div>
            </div>
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-green-haze"></i>
                        <span class="caption-subject bold uppercase font-green-haze"> <?php echo lang('courbe-conversion');?> </span>
                    </div>
                </div>
				<div class="responsive-caption">
                <div class="portlet-body" style="position: relative;  width:90vw" >
                    <!--       Chart.js Canvas Tag -->
					<canvas id="myChart" width="800" height="250"></canvas>
                </div>
				</div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="symbole_devise" value="DT">
<input type="hidden" id="tax_rate_decimal_places" value="3">
<input type="hidden" id="currency_symbol_placement" value="after">
<input type="hidden" id="thousands_separator" value=" ">
<input type="hidden" id="decimal_point" value=".">
<input type="hidden" id="valentre" value="0">


<!-- END ROW -->


<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/js/chart.js" type="text/javascript">
</script>

<!--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
-->
<!-- END PAGE LEVEL PLUGINS -->

<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/charts-amcharts.js"></script>
<script>
var colorArray = ["#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177", "#0d5ac1",
    "#f205e6", "#1c0365", "#14a9ad", "#4ca2f9", "#a4e43f", "#d298e2", "#6119d0",
    "#d2737d", "#c0a43c", "#f2510e", "#651be6", "#79806e", "#61da5e", "#cd2f00",
    "#9348af", "#01ac53", "#c5a4fb", "#996635", "#b11573", "#4bb473", "#75d89e",
    "#2f3f94", "#2f7b99", "#da967d", "#34891f", "#b0d87b", "#ca4751", "#7e50a8",
    "#c4d647", "#e0eeb8", "#11dec1", "#289812", "#566ca0", "#ffdbe1", "#2f1179",
    "#935b6d", "#916988", "#513d98", "#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
    "#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
    "#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
    "#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
    "#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
    "#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
    "#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
    "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
];

function updateChart() {
    var monthfirst = $("#first_date").val().split('-');
    var monthend = $("#end_date").val().split('-');
    // console.log(res[1]);
    $.post("<?php echo site_url('reports/ajax/update_chart_commercials'); ?>", {
        current_year: current_year,
        current_devise: current_devise,
        current_group: current_group,
        first_date: $("#first_date").val(),
        end_date: $("#end_date").val(),
        monthfirst: monthfirst[1],
        monthend: monthend[1],
    }, function(data) {
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
        total_quotes = 0;
        nb_quotes = 0;
        nb_clients = 0;
        nb_prospects = 0;
        var cnt = 1;
        table_foot_table = "";
        countmontantencaissetotal = 0;
        sommeqoutevalidetotal = 0;
        montantencaisser = 0;
        countvalide = 0;
        taux_final = 0;
        $.each(json_response[0], function(key, value) {
            sommeqoutevalidetotal = sommeqoutevalidetotal + value["quotes_sum_total"];
            montantencaisser = montantencaisser + value["montantencaisser"];

            countvalide += value["count_devis_valide"];
            countmontantencaissetotal += parseInt(value["countmontantencaissetotal"]);
            table_stat += "<tr>";
            table_stat += "<td style='text-align: center;'>" + cnt + "</td>";
            table_stat += "<td style='text-align: left;'>" + value["username"] + "</td>";
            table_stat += "<td style='text-align: center;'>" + value["count_devis"] + "</td>";
            table_stat += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value[
                "devis"]) + "</td>";
            table_stat += "<td style='text-align: center;'>" + value["count_devis_valide"] +
                "</td>";
            table_stat += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value[
                "quotes_sum_total"]) + "</td>";

            table_stat += "<td style='text-align: center;'>" + beautifyFormatWithDevice(value[
                "montantencaisser"]) + "</td>";
            table_stat += "<td style='text-align: center;'>" + value["count_clients"] + "</td>";
            table_stat += "<td style='text-align: center;'>" + value["count_prospect"] +
                "</td>";
            table_stat += "<td>" +
                ((value["count_devis_valide"] * 100) / value["count_devis"]).toFixed(2) +
                " % </td>";
            table_stat += "</tr>";
            cnt++;
            total_quotes += parseFloat(value["devis"]);
            nb_quotes += parseInt(
                value["count_devis"]);
            nb_clients += parseInt(value["count_clients"]);
            nb_prospects += parseInt(value["count_prospect"]);
            taux_final += (((value["count_devis_valide"] * 100) / (value[
                "count_devis"]) / json_response[4]));
        });
        table_foot_table += "<tr style='font-weight: bold;' class='bg-grey'>";
        table_foot_table +=
            "<td style='text-align: center;' colspan='2'>Total</td>";
        table_foot_table +=
            "<td style='text-align: center;'>" + nb_quotes + "</td>";
        table_foot_table +=
            "<td style='text-align: center;'>" + beautifyFormatWithDevice(total_quotes) +
            "</td>";

        table_foot_table += "<td style='text-align: center;'>" + countvalide + "</td>";

        table_foot_table +=
            "<td style='text-align: center;'>" + beautifyFormatWithDevice(sommeqoutevalidetotal) +
            "</td>";
        table_foot_table += "<td style='text-align: center;'>" + beautifyFormatWithDevice(
            montantencaisser) + "</td>";

        table_foot_table += "<td style='text-align: center;'>" + nb_clients + "</td>";

        table_foot_table += "<td style='text-align: center;' >" + nb_prospects + "</td>";
        table_foot_table +=
            "<td >" + taux_final.toFixed(2) + " %</td>";

        table_foot_table +=
            "</tr>";

        $("#stat_table").html(table_stat);
        $("#stat_table_total").html(table_foot_table);

        initChart();
        var usercourbe = json_response[6];
        var dataval = json_response[5];
        var datediff = json_response[7];
        // console.log(datediff);
        //  var datchart = json_response[8];
        //  multilinechart(dat);
        //   multiline(dataval, usercourbe);
        // console.log(usercourbe);

        // courbe pour chaque utilisateur

        /*    if ($('#valentre').val() == 0) {
                for (var i = 0; i < dataval.length; i++) {
                    $('.chartgroup').append('<canvas   id="line-chart' + i +
                        '" width="800" height="450"></canvas>');

                }

            } else {
                $("canvas").remove();

                for (var i = 0; i < dataval.length; i++) {
                    $('.chartgroup').append('<canvas   id="line-chart' + i +
                        '" width="800" height="450"></canvas>');

                }

            }
            $('#valentre').val(1);


            for (var i = 0; i < dataval.length; i++) {

                new Chart($('#line-chart' + i), {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June",
                            "Juillet",
                            "Août", "Septembre", "Octobre",
                            "Novembre", "Décembre"
                        ],
                        datasets: [

                            {
                                data: dataval[i],
                                label: usercourbe[i],
                                borderColor: colorArray[i],
                                fill: false
                            },
                        ]
                    },
                    options: {
                        title: {
                            display: true,
                            //  text: 'World population per region (in millions)'
                        }
                    }
                });
            }
*/
        // fin courbe pour chaque utilisateur
        // console.log(dataval[0]);


        //var years = [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050];




        var years1 = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet",
        "Août", "Septembre", "Octobre",
        "Novembre", "Décembre" ];
      /*  var years1 = ["January", "February", "March", "April", "May", "June",
            "Juillet",
            "Août", "Septembre", "Octobre",
            "Novembre", "Décembre"
        ];*/


        var datasets = [];
        var labels = [];
        var labels1 = [];
        /* label.push( {

         })*/
        //    console.log(monthend[1] - monthfirst[1]);
        var years = {
            01: "Janvier",
            02: "Février",
            03: "Mars",
            04: "Avril",
            05: "Mai",
            06: "Juin",
            07: "Juillet",
            08: "Août",
            09: "Septembre",
            10: "Octobre",
            11: "Novembre",
            12: "Décembre",
        };
        /*for (let elem in years) {
            if (monthfirst[1] < 10) {
                if (monthend[1] < 10) {
                    for (var i = monthfirst[1][1]; i < monthend[1][1]; i++) {

                        if (elem == 0 + i) {
                            labels1[i] = years[elem];

                        }
                        //  console.log(ze + i);
                    }
                }

                if (monthend[1] > 10) {
                    for (var i = parseInt(monthfirst[1][1]); i < parseInt(monthend[1]); i++) {
                        //   console.log(i);


                        if (elem == i) {
                            labels1[i] = years[i];
                        }
                    }
                }

            } else {
                for (var i = parseInt(monthfirst[1]); i < parseInt(monthend[1]); i++) {
                    if (elem == i) {
                        labels1[i] = years[elem];
                    }
                }
            }
        }*/
        //  console.log(labels1);
        /*   for (var i = 1; i < years.length; i++) {
               console.log(years[i]);

               // labels1[]
           }*/
        /*  $.each(years, function(key, value) {
              if(key==monthfirst ){

              }
              alert(key + ": " + value);
          });*/
        labels = years1.slice();
        if (labels1.length > 0) {
            labels1 = years1.slice();
        }
        //   console.log(labels1.length);
        var ctx = document.getElementById("myChart");
      
        if (dataval.length == 0) {
           
            //     $('#myChart').empty();
            datasets.push({
                // data: [],
                //label: [],
                // borderColor: [],
                fill: false
            })
            // $('.chartmulti').append('');
         
        } 
         if (dataval.length > 0) { 
            for (var i = 0; i < dataval.length; i++) {
                datasets.push({
                    data: dataval[i],

                    borderColor: colorArray[i],
                    label: usercourbe[i],
                    fill: true
                })
            }
         
        }
        if (dataval.length > 0) {
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: datasets,
                    labels: datediff,

                },
                options: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                }
            });
           /* $('#ctx').closest('.portlet').find('.fullscreen').click(function () {
                myChart.invalidateSize();
            })*/
        } else {
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: datasets,
                    labels: datediff,

                },
                options: {
                    legend: {
                        display: false,
                        position: 'bottom'
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    }
                }
            });
         /*   $('#ctx').closest('.portlet').find('.fullscreen').click(function () {
                myChart.invalidateSize();
            })*/
        }
        //  Chartcourbe(datacourbe, usercourbe);

    });


    var initChart = function() {
        var datachartss = json_response[0];
        var chart = AmCharts.makeChart("chart_6", {
            "type": "pie",
            "theme": "light",
            "fontFamily": 'Open Sans',
            "color": '#888',
            "dataProvider": datachartss,
            "valueField": "devis",
			
            "titleField": "username",
            "balloonText": "[[username]] [[value]]<br>([[percents]]%)",
            "balloon": {
                "drop": true,
            },
            "balloonFunction": function(graphDataItem, graph) {
                var value = graphDataItem.value;
                var percents = graphDataItem.percents;
                var username = graphDataItem.title;
                //                            var test="";
                //                            for (var x in graphDataItem) {
                //                                test += ", "+x+" : "+graphDataItem[x];
                //                            }
                //                            alert(test);
                return username + " " + beautifyFormatWithDevice(value) + " (" +
                    beautifyFormat(
                        percents, "float2") + "%)";


            },
            "exportConfig": {
                menuItems: [{
                    icon: Metronic.getGlobalPluginsPath() +
                        "amcharts/amcharts/images/export.png",
                    format: 'png'
                }]
            }
        });

        $('#chart_6').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    }
}
$("#selected_date").change(function() {
    current_year = $(this).val();
    $("#first_date").val('');
    $("#end_date").val('');
    //Chartcourbe();
    $('#myChart').html('');
    // alert('hh');
    updateChart();
});
$("#first_date").change(function() {
    first_date = $(this).val();
    $('#myChart').html('');
    updateChart();
});
$("#end_date").change(function() {
    end_date = $(this).val();
    $('#myChart').html('');
    updateChart();
})
$("#selected_devise").change(function() {
    current_devise = $(this).val();
    updateChart();
});
$("#selected_group").change(function() {
    current_group = $(this).val();
    updateChart();
});

jQuery(document).ready(function() {

    if (typeof(current_year) == 'undefined') {
        current_year = $("#selected_date").val();
    }
    if (typeof(current_devise) == 'undefined') {
        current_devise = $("#selected_devise").val();
    }
    if (typeof(current_group) == 'undefined') {
        current_group = $("#selected_group").val();
    }

    if (typeof(current_group) == 'undefined') {
        current_group = $("#selected_group").val();
    }

    updateChart();

});



/*
    for (var i = 0; i < dataval.length; i++) {

        new Chart($('#line-chart-test'), {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June",
                    "Juillet",
                    "Août", "Septembre", "Octobre",
                    "Novembre", "Décembre"
                ],
                datasets: [

                    {
                        data: dataval[i],
                        label: usercourbe[i],
                        borderColor: colorArray[i],
                        fill: false
                    },
                ]
            },
            options: {
                title: {
                    display: true,
                    //  text: 'World population per region (in millions)'
                }

            }
        });
    }
    */
</script>