
<body> 
    <div class="page-title">	
        <i class="icon-custom-settings"></i>
        <h3>Visits Grade <span class="semi-bold">Reports</span></h3>	
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Visit', array("url" => array("controller" => "dashboards", "action" => "details"))); ?>  

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
                                <td class=" col-lg-6"> <?php echo $this->Form->input('building_id', array("label" => "Building", 'id' => "source2", 'options' => array($building), 'style' => 'width: 250px; margin-bottom:5px;')); ?>   </td>
                                <td  colspan="2" class="control-label col-lg-6"><a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'welcome')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('Show Cahrt', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Add this status to database', "style" => "margin-left:3px;")); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <span hidden="true" id="dataarray"><?php echo $Alldata; ?> </span>
                    <span hidden="true" id="dataarray_top"><?php echo $Alldata_top; ?> </span>
                    <span hidden="true" id="dataarray_buttom"><?php echo $Alldata_buttom; ?> </span>
                    <span hidden="true" id="dataarray_auditor"><?php echo $Alldata_auditor; ?> </span>

                    <h1 style="font-weight: 900;"><?php echo $TotalVisits.' Visit' ?></h1>
                    <table width="100%">
                        <tbody>
                            <tr style="border-style: groove;">
                                <td colspan="2">
                                    <div id="chartContainer" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
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

                            <tr style="border-style: groove;">
                                <td colspan="2">
                                    <div id="chartContainer_top" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
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

                            <tr style="border-style: groove;">
                                <td colspan="2">
                                    <div id="chartContainer_buttom" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
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
                            <tr style="border-style: groove;">
                                <td colspan="2">
                                    <div id="chartContainer_auditor" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
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
    var jsonData = JSON.parse($('#dataarray').text());
    var jsonData_top = JSON.parse($('#dataarray_top').text());
    var jsonData_buttom = JSON.parse($('#dataarray_buttom').text());
    var jsonData_auditor = JSON.parse($('#dataarray_auditor').text());


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

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            //colorSet:  "customColorSet1",
            title: {
                text: "Visits Grade Percentage"
            },
            axisY: {
                title: "Percentage"
            },
            data: [{
                    type: "column",
                    //color: "#014D65",
                    //click: function (e) {
                    //  var branchID = e.dataPoint.x + 1;
                    //  window.location = "<?php //echo $this->HTML->url(array("controller" => "dashboards", "action" => "achivment_details"));    ?>" + "/" + branchID;

                    //alert(" Branch ID:" + branchID);
                    // },
                    dataPoints: jsonData
                }]
        });
        chart.render();
        chart = {};


        var chart1 = new CanvasJS.Chart("chartContainer_top", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            //colorSet:  "customColorSet1",
            title: {
                text: "Visits Top Ten"
            },
            axisY: {
                title: "Percentage"
            },
            data: [{
                    type: "column",
                    //color: "#014D65",
                    //click: function (e) {
                    //  var branchID = e.dataPoint.x + 1;
                    //  window.location = "<?php //echo $this->HTML->url(array("controller" => "dashboards", "action" => "achivment_details"));    ?>" + "/" + branchID;

                    //alert(" Branch ID:" + branchID);
                    // },
                    dataPoints: jsonData_top
                }]
        });
        chart1.render();
        chart1 = {};


        var chart2 = new CanvasJS.Chart("chartContainer_buttom", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            //colorSet:  "customColorSet1",
            title: {
                text: "Visits Buttom Ten"
            },
            axisY: {
                title: "Percentage"
            },
            data: [{
                    type: "column",
                    //color: "#014D65",
                    //click: function (e) {
                    //  var branchID = e.dataPoint.x + 1;
                    //  window.location = "<?php //echo $this->HTML->url(array("controller" => "dashboards", "action" => "achivment_details"));    ?>" + "/" + branchID;

                    //alert(" Branch ID:" + branchID);
                    // },
                    dataPoints: jsonData_buttom
                }]
        });
        chart2.render();
        chart2 = {};

        var chart3 = new CanvasJS.Chart("chartContainer_auditor", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            //colorSet:  "customColorSet1",
            title: {
                text: "Visits Auditor Grade"
            },
            axisY: {
                title: "Percentage"
            },
            data: [{
                    type: "column",
                    //color: "#014D65",
                    //click: function (e) {
                    //  var branchID = e.dataPoint.x + 1;
                    //  window.location = "<?php //echo $this->HTML->url(array("controller" => "dashboards", "action" => "achivment_details"));    ?>" + "/" + branchID;

                    //alert(" Branch ID:" + branchID);
                    // },
                    dataPoints: jsonData_auditor
                }]
        });
        chart3.render();
        chart3 = {};



    }

</script>