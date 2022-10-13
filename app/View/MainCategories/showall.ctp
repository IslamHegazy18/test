<div class="page-title">	
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Main Categories</span></h3>	
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <div >
                    <a class="btn-lg pull-right btn btn-primary btn-lg"  href="<?php echo $this->Html->url(array('contoller' => 'MainCategories', 'action' => 'add')); ?>" data-original-title="" title="" style="margin:5px;">ADD</a>
                </div>
                <table   class="table table-bordered no-more-tables">
                    <thead>
                        <tr >
                            <th hidden="hidden">Sort</th>
                            <th  style="text-align: center; font-size:130%">ID</th>
                            <th  style="text-align: center; font-size:130%">Logo</th>
                            <th  style="text-align: center; font-size:130%">Main Category</th>
                            <th  style="text-align: center; font-size:130%">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Categories as $key => $Category) {
                            ?>
                            <tr>
                                <td style="font-size:130%;"><?php echo $Category["MainCategory"]["id"] ?></td>
                                <td style="font-size:130%;"><img width="80" height="80" alt="" src="<?php echo Configure::read('img_url') . $Category["MainCategory"]["image"] ?>"></td>
                                <td style="font-size:130%;"><?php echo $Category["MainCategory"]["name_en"] ?></td>
                                <td class = "text-center">
                                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "MainCategories", "action" => "edit", $Category["MainCategory"]["id"])); ?>"> 
                                        <i class="fa fa-info-circle"></i> Details </a>
                                    <?php //if ($Category["Category"]["status"] == '0') { ?>
                                        <!--<a class="btn" href="<?php //echo $this->Html->url(array("controller" => "Categories", "action" => "diable", $Category["Category"]["id"])); ?>"> 
                                            <i class="fa fa-lock"></i> Disable </a>
                                    <?php //} else if ($Category["Category"]["status"] == '1') { ?>
                                        <a class="btn" href="<?php //echo $this->Html->url(array("controller" => "merchants", "action" => "diable", $Category["Category"]["id"])); ?>"> 
                                            <i class="fa fa-unlock"></i> Enable </a>-->
                                        <?php //} ?>
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

