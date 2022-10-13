<?php $paginator = $this->Paginator;
echo $this->Html->css(array('cake.generic'));
?>
<div class="page-title">	
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Service Providers</span></h3>	
</div>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <table   class=" no-more-tables  table-condensed" id="example">
                    <tbody>
                        <?php echo $this->Form->create('ServiceProviders', array("url" => array("controller" => "ServiceProviders", "action" => "showall", '1'))); ?>  
                        <tr>
                            <td class=" col-lg-6"> <?php echo $this->Form->input('serviceprovider_name', array("label" => "Name", 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td> 
                            <td class=" col-lg-6"> <?php echo $this->Form->input('service_type_id', array("label" => "Service Provider Type", 'id' => "source", 'options' => array($serviceprovider_types), 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td> 

                            <td> <?php echo $this->Form->submit('Search', array('class' => 'btn btn-primary btn-cons', 'title' => 'Approvals fillter', '$Approval_TypesID')); ?> </td>
                        </tr>

                    </tbody>
                </table>
                <table   class="table table-bordered no-more-tables  table-condensed" id="example">
                    <thead dir="rtl">
                        <tr style="background-color:darkgray;height:40px;">
                            <th style="text-align: center; font-size: large; "><b>ID</th>
                            <th style="text-align: center; font-size: large; "><b>Logo</th>
                            <th style="text-align: center; font-size: large; "><b>Name</th>
                            <th style="text-align: center; font-size: large; "><b> Category </th>
                            <th style="text-align: center; font-size: large; "><b>Service Type</th>
                            <th style="text-align: center; font-size: large; "><b>Register Date</th>
                            <th style="text-align: center; font-size: large; "><b>Address</th>
                            <th style="text-align: center; font-size: large; "><b>Status</th>
                            <th style="text-align: center; font-size: large; "><b>Details</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($Service_Providers as $key => $Service_Provider) :
                            ?>
                            <tr>
                                <td><b><?php echo $Service_Provider["Service_Provider"]["id"] ?></td>
                                <td style="font-size:130%;"><img width="80" height="80" alt="" src="<?php echo Configure::read('img_url') . $Service_Provider["Service_Provider"]["image"] ?>"></td>
                                <td><b><?php echo $Service_Provider["Service_Provider"]["service_name_en"] ?></td>
                                <td><b><?php echo $Service_Provider["Category"]["name_en"] ?></td>
                                <td><b><?php echo $Service_Provider["Service_Type"]["name"] ?></td>
                                 <td><b><?php echo date("Y-m-d",strtotime($Service_Provider["Service_Provider"]["created"])) ?></td>
                                <td><b><?php echo $Service_Provider["Service_Provider"]["address"] ?></td>
                                <td><b>
                                        <?php
                                        if ($Service_Provider["Service_Provider"]["approval_flag"] == '0') {
                                            echo 'Not Active';
                                        } else {
                                            echo 'Active';
                                        }
                                        ?>
                                </td>
                                <td class = "text-center">
                                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "ServiceProviders", "action" => "details", $Service_Provider["Service_Provider"]["id"])); ?>"> 
                                        <i class="fa fa-info-circle"></i> Details </a>
                                </td>
                            </tr>
                        <?php endforeach;
                        ?>
                    </tbody>
                </table>
                <div class='paging'>
                    <?php
                    echo $paginator->first("First");
                    if ($paginator->hasPrev()) {
                        echo $paginator->prev("Prev");
                    }
                    echo $paginator->numbers(array('modulus' => 2));
                    if ($paginator->hasNext()) {
                        echo $paginator->next("Next");
                    }
                    echo $paginator->last("Last");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>