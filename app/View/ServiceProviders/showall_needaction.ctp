<?php $paginator = $this->Paginator;
echo $this->Html->css(array('cake.generic'));
?>

<div class="page-title">	
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Service Providers Need Your Action</span></h3>	
</div>

<div class="row">
    <div class="col-md-12" style="background-color: white;">
        <h4>Corporate <span class="semi-bold"><?php echo $coorporate_count; ?></span></h4>	
        <h4>Freelance <span class="semi-bold"><?php echo $freelance_count; ?></span></h4>	
        <div class="grid simple ">
            <div class="grid-body no-border">

                <table   class="table table-bordered no-more-tables  table-condensed" id="example">
                    <thead dir="rtl">
                        <tr style="background-color:darkgray;height:40px;">
                            <th  width="5%" style="text-align: center; font-size: large; "><b>ID</th>
                            <th  width="20%" style="text-align: center; font-size: large; "><b>Logo</th>
                            <th  width="20%" style="text-align: center; font-size: large; "><b>Name</th>
                            <th  width="10%" style="text-align: center; font-size: large; "><b> Category </th>
                            <th  width="5%" style="text-align: center; font-size: large; "><b>Service Type</th>
                            <th  width="40%" style="text-align: center; font-size: large; "><b>Status</th>
                            <th  width="5%"style="text-align: center; font-size: large; "><b>Details</th>
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
                                <td><?php echo $Service_Provider['Service_Provider']['papers_status_details']; ?>

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
                    echo $paginator->numbers(array('modulus' => 5));
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