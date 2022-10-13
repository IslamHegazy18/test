<body> 
    <div class="page-title">	
        <i class="icon-custom-settings"></i>
        <h3>Add <span class="semi-bold">New Main Category</span></h3>	
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('MainCategory', array("url" => array("controller" => "MainCategories", "action" => "add"), 'type' => 'file')); ?>  
                    <table class="table  no-more-tables">
                        <tbody>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Category Logo</label></td>
                                <td class="col-lg-8"><?php echo $this->Form->input('file', array("id" => "image", "label" => false, "class" => "form-control", "type" => "file")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Category Name EN</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('name_en', array("label" => false, "class" => "validate[required] form-control")); ?></td>
                            </tr>
                             <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Category Name AR</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('name_ar', array("label" => false, "class" => "validate[required] form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-6"><a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'welcome')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('Save', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'ADD', "style" => "margin-left:3px;")); ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->


</body><!-- /.modal-dialog -->