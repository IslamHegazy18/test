<body> 
    <div class="page-title">	
        <i class="icon-custom-settings"></i>
        <h3>Add <span class="semi-bold">New Merchant</span></h3>	
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Merchant', array("url" => array("controller" => "merchants", "action" => "add"), 'type' => 'file')); ?>  
                    <table class="table  no-more-tables">
                        <tbody>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Name</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"> <?php echo $this->Form->input('unit_name', array("label" => false, "class" => "form-control")); ?></td>
                            </tr>
                             <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Approval System ID</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('approvals_id', array("label" => false, "type" => "number", "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Unit Number</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('unit_number', array("label" => false, "class" => "form-control")); ?></td>
                            </tr>
                            
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Building</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('building', array("label" => false, "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Floor</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('floor', array("label" => false, "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Contact</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('contact', array("label" => false, "class" => "form-control")); ?></td>
                            </tr>
                           
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Logo</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"> <?php echo $this->Form->input('logo', array('type' => 'file', "label" => false, "class" => "form-control")); ?></td>
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