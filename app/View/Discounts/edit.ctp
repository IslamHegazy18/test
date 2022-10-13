<body>
    <div class="page-title">
        <i class="icon-custom-settings"></i>
        <h3>Add <span class="semi-bold">New Discount</span></h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Discount', array("url" => array("controller" => "Discounts", "action" => "edit", $discount_id))); ?>
                    <table class="table  no-more-tables">
                        <tbody>
							<tr class="form-group">
								<td class="control-label col-lg-4"><label>Discount Key</label></td>
								<td class="col-lg-8 form-control">
									<input type="text" name="discount_key" value="<?php echo $dicounts["Discount"]["key"] ?>" readonly>
								</td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4">
									<label>Discount Value</label>
								</td>
                                <td class="col-lg-8 form-control">
									<?php echo $this->Form->input('discount_value', array("label" => false, 'value' => $dicounts["Discount"]["value"],'type' => 'number', "class" => "form-control",'id'=>'value','min' => 1,'step'=>0.01,)); ?>
								</td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4">
									<label>Discount Percentage</label>
								</td>
                                <td class="col-lg-8 form-control">
									<?php echo $this->Form->input('discount_percentage', array("label" => false,'value' => $dicounts["Discount"]["percentage"],'type' => 'number', "class" => "form-control",'id'=>'percentage','min' => 0.00, 'max'=> 100, 'step'=>0.01)); ?>
								</td>
                            </tr>
							<tr class="form-group">
                                <td class="control-label col-lg-4"><label>Due-date</label></td>
                                <td class="col-lg-8 form-control"><?php echo $this->Form->text('due_date', array("type"=>"date","label" => false, 'value' => $dicounts['Discount']['due_date'])); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-6"><a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'Discounts', 'action' => 'showall')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('Save', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Edit', "style" => "margin-left:3px;")); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->

<script type="text/javascript">

var discount_value      = document.getElementById("value")
var discount_percentage = document.getElementById("percentage")

console.log("per is:" + discount_value.value);
if(discount_value.value == null || discount_value.value == 0)
{
	document.getElementById("value").readOnly = true;
}
if (discount_percentage.value == null || discount_percentage.value == 0)
{
	document.getElementById("percentage").readOnly = true;
}
</script>

</body><!-- /.modal-dialog -->
