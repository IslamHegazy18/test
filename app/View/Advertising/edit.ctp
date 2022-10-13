<body>
    <div class="page-title">
        <i class="icon-custom-settings"></i>
        <h3>Edit <span class="semi-bold">Image</span></h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Images', array("url" => array("controller" => "Advertising", "action" => "edit", $image_id), 'type' => 'file')); ?>
                    <table class="table  no-more-tables">
                        <tbody>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Image</label></td>
                                <td class="col-lg-8" style="background-color: black;">
									<img width="80" height="80" alt="" src="<?php echo Configure::read('img_url') . $images["AdvertisingImages"]["image_path"] ?>"><?php echo $this->Form->input('file', array("id" => "image", "label" => false, "class" => "form-control", "type" => "file")); ?>
								</td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>URL</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control">
									<?php echo $this->Form->input('url', array("label" => false, 'value' => $images["AdvertisingImages"]["url"], "class" => "form-control")); ?>
								</td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Staus</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control">
								<?php echo $this->Form->input('status', array("label" => FALSE, 'id' => "source",  'options' => array(0, 1), 'value' =>$images['AdvertisingImages']['status'] ,'style' => 'width: 250px; margin-bottom:5px;')); ?>
								</td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-6">
									<a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'Advertising', 'action' => 'showall')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('Save', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Edit', "style" => "margin-left:3px;")); ?>
								</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</body><!-- /.modal-dialog -->
