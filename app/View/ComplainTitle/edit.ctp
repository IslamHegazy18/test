<body>
    <div class="page-title">
        <i class="icon-custom-settings"></i>
        <h3>Edit <span class="semi-bold">complain title</span></h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('complain_title', array("url" => array("controller" => "ComplainTitle", "action" => "edit", $complain_title_id))); ?>
                    <table class="table  no-more-tables">
                        <tbody>
                        <tr class="form-group">
								<td class="control-label col-lg-4"><label>ID</label></td>
								<td class="col-lg-8 form-control">
									<input type="text" name="ID" value="<?php echo $complain_titles["complain_title"]["id"] ?>" readonly>
								</td>
                            </tr>
                        <tr  class="form-group">
                                <td class="control-label col-lg-4"><label>En name</label></td>
                                <td class="col-lg-8 form-control"><?php echo $this->Form->input('name_en', array("label" => false, "class" => "form-control", 'id'=>'name_en', 'type' => 'text','value' => $complain_titles["complain_title"]["name_en"])); ?></td>
                            </tr>
							<tr  class="form-group">
                                <td class="control-label col-lg-4"><label>Ar name</label></td>
                                <td class="col-lg-8 form-control"><?php echo $this->Form->input('name_ar', array("label" => false, "class" => "form-control", 'id'=>'name_ar', 'type' => 'text','value' => $complain_titles["complain_title"]["name_ar"])); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-6"><a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'ComplainTitle', 'action' => 'showall')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('Save', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Edit', "style" => "margin-left:3px;")); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->

<!-- <script type="text/javascript">

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
</script> -->

</body><!-- /.modal-dialog -->
