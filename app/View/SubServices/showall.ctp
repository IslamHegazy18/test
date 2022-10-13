<div class="page-title">	
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Sub Services</span></h3>	
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <div >
                    <a class="btn-lg pull-right btn btn-primary btn-lg"  href="<?php echo $this->Html->url(array('contoller' => 'SubServices', 'action' => 'add')); ?>" data-original-title="" title="" style="margin:5px;">ADD</a>
                </div>
                <table   class="table table-bordered no-more-tables">
                    <thead>
                        <tr >
                            <th hidden="hidden">Sort</th>
                            <th  style="text-align: center; font-size:130%">ID</th>
                             <th  style="text-align: center; font-size:130%">Logo</th>
                            <th  style="text-align: center; font-size:130%">Sub Services</th>
                            <th  style="text-align: center; font-size:130%">Category</th>
                            <th  style="text-align: center; font-size:130%">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Categories as $key => $Category) {
                            ?>
                            <tr>
                                <td style="font-size:130%;"><?php echo $Category["Category"]["id"] ?></td>
                                <td style="font-size:130%;"><img width="80" height="80" alt="" src="<?php echo Configure::read('img_url') . $Category["Category"]["image"] ?>"></td>
                                <td style="font-size:130%;"><?php echo $Category["Category"]["name_en"] ?></td>
                                <td style="font-size:130%;"><?php echo $Category['Parent']["Category"]["name_en"] ?></td>
                                <td class = "text-center">
                                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "SubServices", "action" => "edit", $Category["Category"]["id"])); ?>"> 
                                        <i class="fa fa-info-circle"></i> Details </a>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

