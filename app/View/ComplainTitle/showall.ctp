<div class="page-title">
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Complain Titles</span></h3>
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <div>
                    <a class="btn-lg pull-right btn btn-primary btn-lg"  href="<?php echo $this->Html->url(array('controller' => 'ComplainTitle', 'action' => 'add')); ?>" style="margin:5px;">ADD</a>
                </div>
                <table class="table table-bordered no-more-tables">
                    <thead>
                        <tr>
                            <th hidden="hidden">Sort</th>
                            <th  style="text-align: center; font-size:130%">ID</th>
                            <th  style="text-align: center; font-size:130%">En name</th>
							<th  style="text-align: center; font-size:130%">Ar name</th>
                            <th  style="text-align: center; font-size:130%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($complain_title as $key => $complain_title_) {
                            ?>
                            <tr>
                                <td style="font-size:130%;"><?php echo $complain_title_["complain_title"]["id"]; ?></td>
                                <td style="font-size:130%;"><?php echo $complain_title_["complain_title"]["name_en"]; ?></td>
                                <td style="font-size:130%;"><?php echo $complain_title_["complain_title"]["name_ar"]; ?></td>
                                <td class = "text-center">
                                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "ComplainTitle", "action" => "edit", $complain_title_["complain_title"]["id"])); ?>">
                                        <i class="fa fa-pencil-square"></i> Edit </a>

										<i class="fa fa-trash-o"></i>
										<?php echo $this->Html->link('Delete',
											array('controller' => 'ComplainTitle', 'action' => 'delete',$complain_title_["complain_title"]["id"]), array('confirm' => 'Are you sure you want to delete this record?!'),
											array('class' => 'btn')
										);?>
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

