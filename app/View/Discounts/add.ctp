<?php

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Gen']))
{
	$discount_key = generateRandomString();
}
function generateRandomString($length = 4)
{
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++)
	{
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

?>
<body>
    <div class="page-title">
        <i class="icon-custom-settings"></i>
        <h3>Add <span class="semi-bold">New Discount</span></h3>
    </div>

	<script type="text/javascript">

		function changeStatus()
		{
			var status = document.getElementById("status");

			if(status.value == 's')
			{
				document.getElementById("value").disabled = true;
				document.getElementById("percentage").disabled = true;
			}
			if(status.value == 'v')
			{
				document.getElementById("percentage").disabled = true;
			}else{
				document.getElementById("percentage").disabled = false;
			}
			if(status.value == 'p')
			{
				document.getElementById("value").disabled = true;
			}else{
				document.getElementById("value").disabled = false;
			}

		}
	</script>
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Discount', array("url" => array("controller" => "Discounts", "action" => "add"))); ?>
                    <table class="table  no-more-tables">
                        <tbody>
                            <tr class="form-group">
								<td class="control-label col-lg-4"><label>Discount Key</label></td>
								<td class="col-lg-8 form-control">
									<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
										<input type="text" name="discount_key" value="<?php echo (@$discount_key); ?>" readonly>
										<input type="submit" class="btn btn-primary btn-cons" value="Generate" name="Gen">
									</form>
								</td>
                            </tr>
							<tr class="form-group">
								<td class="control-label col-lg-4" style="color:red;">
									<label>Choose Value / Percentage</label>
								</td>
								<td class="col-lg-8 form-control">
									<select id="status" name="select" onchange="changeStatus()">
										<option value="s">select</option>
										<option value="v">value</option>
										<option Value="p">percentage</option>
									</select>
								</td>
							</tr>
                            <tr  class="form-group">
                                <td class="control-label col-lg-4"><label>Discount Value</label></td>
                                <td class="col-lg-8 form-control"><?php echo $this->Form->input('discount_value', array("label" => false, "class" => "form-control", 'id'=>'value', 'type' => 'number', 'min' => 1,'step'=>0.01,'disabled' => true)); ?></td>
                            </tr>
							<tr  class="form-group">
                                <td class="control-label col-lg-4"><label>Discount Percentage</label></td>
                                <td class="col-lg-8 form-control"><?php echo $this->Form->input('discount_percentage', array("label" => false, "class" => "form-control",'type' => 'number','id'=>'percentage','min' => 0.00, 'max'=> 100, 'step'=>0.01,'disabled' => true)); ?></td>
                            </tr>
							<tr class="form-group">
                                <td class="control-label col-lg-4"><label>Due-date</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->text('due_date', array('type'=>'date')); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-6">
									<a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'Discounts', 'action' => 'showall')); ?>" style="margin-left:3px;">Cancel</a>

                                    <?php echo $this->Form->submit('Save', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'name'=> 'save', 'title' => 'ADD', "style" => "margin-left:3px;")); ?>
								</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->


</body><!-- /.modal-dialog -->
