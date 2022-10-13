<?php $paginator = $this->Paginator;
echo $this->Html->css(array('cake.generic'));
?>
<div class="page-title">
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Users</span></h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <table class=" no-more-tables  table-condensed" id="example">
                    <tbody>
                        <?php echo $this->Form->create('Users', array("url" => array("controller" => "Users", "action" => "showall", '1'))); ?>
                        <tr>
                            <td class=" col-lg-6"> <?php echo $this->Form->input('user_name', array("label" => "Name", 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td>
                            <td class=" col-lg-6"> <?php echo $this->Form->input('service_type_id', array("label" => "User Type", 'id' => "source", 'options' => array($user_types), 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td>
                            <td> <?php echo $this->Form->submit('Search', array('class' => 'btn btn-primary btn-cons', 'title' => 'Approvals fillter', '$Approval_TypesID')); ?> </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered no-more-tables  table-condensed" id="example">
                    <thead dir="rtl">
                        <tr style="background-color:darkgray;height:40px;">
                            <th style="text-align: center; font-size: large; "><b>ID</th>
                            <th style="text-align: center; font-size: large; "><b>FNAME</th>
                            <th style="text-align: center; font-size: large; "><b>LNAME</th>
                            <th style="text-align: center; font-size: large; "><b>PHONE</th>
                            <th style="text-align: center; font-size: large; "><b>Service Type</th>
                            <th style="text-align: center; font-size: large; "><b>Permission Id</th>
                            <th style="text-align: center; font-size: large; "><b>Register Date</th>
                            <th style="text-align: center; font-size: large; "><b>Status</th>
                            <th style="text-align: center; font-size: large; "><b>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $key => $user) :
                            ?>
                            <tr>
                                <td><b><?php echo $user["User"]["id"]; ?></td>
                                <td><b><?php echo $user["User"]["fname"]; ?></td>
                                <td><b><?php echo $user["User"]["lname"]; ?></td>
                                <td><b><?php echo $user["User"]["phone"]; ?></td>
                                <td><b><?php echo $user["Service_Type"]["name"]; ?></td>
                                <td><b><?php echo $user["Permission"]["name"]; ?></td>
                                <td><b><?php echo date("Y-m-d",strtotime($user["User"]["created"])); ?></td>
                                <td><b>
                                        <?php
                                        if ($user["User"]["status"] == '0') {
                                            echo 'Not Active';
                                        } else {
                                            echo 'Active';
                                        }
                                        ?>
                                </td>
                                <td class = "text-center">
                                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Users", "action" => "details", $user["User"]["id"])); ?>">
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
                    if ($paginator->hasPrev())
                    {
                        echo $paginator->prev("Prev");
                    }
                    echo $paginator->numbers(array('modulus' => 2));
                    if ($paginator->hasNext())
                    {
                        echo $paginator->next("Next");
                    }
                    echo $paginator->last("Last");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
