<body> 
    <div class="page-title">	
        <i class="icon-custom-settings"></i>
        <h3>Edit <span class="semi-bold">Sub Services</span></h3>	
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Category', array("url" => array("controller" => "SubServices", "action" => "edit", $category_id), 'type' => 'file')); ?>  
                    <table class="table  no-more-tables">
                        <tbody>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Sub Services Logo</label></td>
                                <td class="col-lg-8"><img width="80" height="80" alt="" src="<?php echo Configure::read('img_url') . $Categories["Category"]["image"] ?>"><?php echo $this->Form->input('file', array("id" => "image", "label" => false, "class" => "form-control", "type" => "file")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Sub Services Name EN</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('name_en', array("label" => false, 'value' => $Categories["Category"]["name_en"], "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Sub Services Name AR</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('name_ar', array("label" => false, 'value' => $Categories["Category"]["name_ar"], "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-6"><a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'categories', 'action' => 'showall')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('Save', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Edit', "style" => "margin-left:3px;")); ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</body><!-- /.modal-dialog -->