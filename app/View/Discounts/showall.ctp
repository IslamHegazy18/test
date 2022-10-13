<div class="page-title">
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Discounts</span></h3>
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <div>
                    <a class="btn-lg pull-right btn btn-primary btn-lg"  href="<?php echo $this->Html->url(array('controller' => 'Discounts', 'action' => 'add')); ?>" style="margin:5px;">ADD</a>
                </div>
                <table class="table table-bordered no-more-tables">
                    <thead>
                        <tr>
                            <th hidden="hidden">Sort</th>
                            <th  style="text-align: center; font-size:130%">ID</th>
                            <th  style="text-align: center; font-size:130%">Key</th>
                            <th  style="text-align: center; font-size:130%">Value</th>
							<th  style="text-align: center; font-size:130%">percentage</th>
							<th  style="text-align: center; font-size:130%">due_date</th>
                            <th  style="text-align: center; font-size:130%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Discounts as $key => $discount) {
                            ?>
                            <tr>
                                <td style="font-size:130%;"><?php echo $discount["Discount"]["id"]; ?></td>
                                <td style="font-size:130%;"><?php echo $discount["Discount"]["key"]; ?></td>
                                <td style="font-size:130%;"><?php echo $discount["Discount"]["value"]; ?></td>
								<td style="font-size:130%;"><?php echo $discount["Discount"]["percentage"]; ?></td>
								<td style="font-size:130%;"><?php echo $discount["Discount"]["due_date"]; ?></td>
                                <td class = "text-center">
                                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Discounts", "action" => "edit", $discount["Discount"]["id"])); ?>">
                                        <i class="fa fa-pencil-square"></i> Edit </a>

										<i class="fa fa-trash-o"></i>
										<?php echo $this->Html->link('Delete',
											array('controller' => 'Discounts', 'action' => 'delete',$discount["Discount"]["id"]), array('confirm' => 'Are you sure you want to delete this record?!'),
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

