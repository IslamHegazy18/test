
<body> 
    <div class="page-title">	
        <i class="icon-custom-settings"></i>
        <h3>Merchant <span class="semi-bold">Reports</span></h3>	
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Visit', array("url" => array("controller" => "dashboards", "action" => "merchants"))); ?>  

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
                                    <?php echo $this->Form->submit('Show Cahrt', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Add this status to database', "style" => "margin-left:3px;")); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <span hidden="true" id="dataarray"><?php echo $Alldata; ?> </span>
                    
                    <h1 style="font-weight: 900;"><?php echo $TotalVisits . ' Visit' ?></h1>
                    <table width="100%" hight="100%">
                        <tbody>
                            <tr style="border-style: groove;">
                                <td>
                                    <div id="chartContainer" style="height: 360px; max-width: 100%; margin: 0px auto;"></div>
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
            axisY: { maximum: 1000 , title: 'Faiz'},
        axisX:{
            interval: 1,
            labelAngle: 0 
        },
        exportEnabled: true,
            title: {
                text: "Visits Type"
            },
            axisY: {
                title: "Number Of Visits"
            },
            data: [{
                    type: "bar",
                    //color: "#014D65",
                    //click: function (e) {
                    //  var branchID = e.dataPoint.x + 1;
                    //  window.location = "<?php //echo $this->HTML->url(array("controller" => "dashboards", "action" => "achivment_details"));     ?>" + "/" + branchID;

                    //alert(" Branch ID:" + branchID);
                    // },
                    dataPoints: jsonData
                }]
        });
        chart.render();
        chart = {};


    }

</script>