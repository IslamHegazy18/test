
<body> 
    <div class="page-title">	
        <i class="icon-custom-settings"></i>
        <h3>Visits Count <span class="semi-bold">Reports</span></h3>	
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Service_Provider', array("url" => array("controller" => "dashboards", "action" => "totals"))); ?>  

                    <table class="table  no-more-tables">
                        <tbody>
                            <tr class="form-group">
                                <td class="control-label"><label>Date:</label></td>
                                <td>
                                    <div class="input-append success date col-md-5 col-lg-5 no-padding">
                                        <?php echo $this->Form->input('VisitDate_from', array("id" => "offer_validity_start_date_txt", "label" => false, 'class' => "form-control", "type" => "text", "style" => "width:100%;", "placeholder" => "Date From")); ?>
                                        <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
                                    </div>
                                    <div class="input-append success date col-md-5 col-lg-5 no-padding">
                                        <?php echo $this->Form->input('VisitDate_to', array("id" => "offer_validity_end_date_txt", "label" => false, 'class' => "form-control", "type" => "text", "style" => "width:100%;", "placeholder" => "Date To")); ?>
                                        <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
                                    </div>
                                </td>
                            </tr>

                            <tr class="form-group">
                                <td  colspan="2" class="control-label col-lg-6"><a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'welcome')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('Show Chart', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Add this status to database', "style" => "margin-left:3px;")); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <span hidden="true" id="Alldata_Service_Providers"><?php echo $Alldata_Service_Providers; ?> </span>
                    <span hidden="true" id="Alldata_User"><?php echo $Alldata_User; ?> </span>
                    <span hidden="true" id="Alldata_Service_Providers_day"><?php echo $Alldata_Service_Providers_day; ?> </span>

                    <h1 style="font-weight: 900;"><?php echo $TotalServiceProvider . ' Service Provider' ?></h1>
                    <table width="100%">
                        <tbody>
                            <tr style="border-style: groove;">
                                <td colspan="2">
                                    <div id="chartContainer_top" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
                                    <br>
                                    <br>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                </td>
                                <td>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            <tr style="border-style: groove;" >
                                <td colspan="2">
                                    <div id="chartContainer_day" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
                                    <br>
                                    <br>
                                </td>

                            </tr>

                            <tr>
                                <td>
                                    <br>
                                    <br>
                                </td>
                                <td>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            <tr style="border-style: groove;" >
                                <td colspan="2">
                                    <div id="chartContainer_buttom" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
                                    <br>
                                    <br>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</body><!-- /.modal-dialog -->



<script>
    var jsonData_Service_Providers = JSON.parse($('#Alldata_Service_Providers').text());
    var Alldata_Service_Providers_day = JSON.parse($('#Alldata_Service_Providers_day').text());
    var jsonData_User = JSON.parse($('#Alldata_User').text());

    CanvasJS.addColorSet("customColorSet1",
            [//colorSet Array
                "#4661EE",
                "#EC5657",
                "#1BCDD1",
                "#8FAABB",
                "#B08BEB",
                "#3EA0DD",
                "#F5A52A",
                "#23BFAA",
                "#FAA586",
                "#EB8CC6",
            ]);
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer_top", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            //colorSet:  "customColorSet1",
            exportEnabled: true,
            title: {
                text: "Users Type"
            },
            axisX: {
                interval: 1,
                labelAngle: 0
            },
            axisY: {
                title: "Number Of Users"
            },
            data: [{
                    type: "pie",
                    dataPoints: jsonData_User
                }]
        });
        chart.render();
        chart = {};

        var chart2 = new CanvasJS.Chart("chartContainer_buttom", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            //colorSet:  "customColorSet1",
            exportEnabled: true,
            title: {
                text: "Service Provider Category"
            },
            axisY: {
                title: "Number Of Service Provider"
            },
            data: [{
                    type: "bar",
                    dataPoints: jsonData_Service_Providers
                }]
        });
        chart2.render();
        chart2 = {};

        var chart3 = new CanvasJS.Chart("chartContainer_day", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            //colorSet:  "customColorSet1",
            exportEnabled: true,
            title: {
                text: "Service Provider Dates"
            },
            axisY: {
                title: "Number Of Service Provider"
            },
            data: [{
                    type: "line",
                    dataPoints: Alldata_Service_Providers_day
                }]
        });
        chart3.render();
        chart3 = {};

    }

</script>