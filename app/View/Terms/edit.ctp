<body>
    <div class="page-title">
        <i class="icon-custom-settings"></i>
        <h3>Add <span class="semi-bold">New Terms</span></h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Terms', array("url" => array("controller" => "Terms", "action" => "edit", $terms_id))); ?>
                    <table class="table  no-more-tables">
                        <tbody>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Terms_EN</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->textarea('data_en', array("label" => false, 'value' => $terms["TermsConditions"]["data_en"], "class" => "validate[required] form-control", "style" => "width: 1065px; height: 298px;")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Terms_AR</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->textarea('data_ar', array("label" => false, 'value' => $terms["TermsConditions"]["data_ar"], "class" => "validate[required] form-control", "style" => "width: 1065px; height: 298px;")); ?></td>
                            </tr>
                            <tr class="form-group">
								<td></td>
                                <td class="control-label col-lg-6"><a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'welcome')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('Save', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Edit')); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->


</body><!-- /.modal-dialog -->
