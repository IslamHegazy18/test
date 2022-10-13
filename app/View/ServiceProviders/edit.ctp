<body> 
    <div class="page-title">	
        <i class="icon-custom-settings"></i>
        <h3>Edit <span class="semi-bold">Merchant</span></h3>	
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <?php echo $this->Form->create('Merchant', array("url" => array("controller" => "merchants", "action" => "edit", $merchant_id), 'type' => 'file')); ?>  
                    <table class="table  no-more-tables">
                        <tbody>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Logo</label></td>
                                <td  class="col-lg-8"><img width="110" height="110" alt="" src="<?php echo $Merchant["Merchant"]["logo"] ?>" ></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Change Logo</label></td>
                                <td  class="col-lg-8"><?php echo $this->Form->input('logo', array('type' => 'file', "label" => false, "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Name - اسم الوحدة</label></td>
                                <td  class="col-lg-8 form-control"><?php echo $this->Form->input('unit_name', array("label" => false, 'value' => $Merchant["Merchant"]["unit_name"], "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Unit Number - رقم الوحدة</label></td>
                                <td  class="col-lg-8 form-control"><?php echo $this->Form->input('unit_number', array("label" => false, 'value' => $Merchant["Merchant"]["unit_number"], "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Building - المبنى</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('building', array("id" => "building_id", "label" => false, "class" => "form-control", 'options' => array($Buildings), 'default' => $Merchant["Merchant"]["building"])); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Floor - الدور</label></td>
                                <td  class="col-lg-8 form-control"><?php echo $this->Form->input('floor', array("label" => false, 'value' => $Merchant["Merchant"]["floor"], "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group" id="drop_permission">
                                <td class="control-label col-lg-4"><label>Merchant Type - نوع العميل</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('merchant_type_id', array("id" => "merchant_type_id", "label" => false, "class" => "form-control", 'options' => array($merchant_type), 'default' => $Merchant["Merchant"]["merchant_type_id"])); ?></td>
                            </tr>
                           <!-- <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Contact</label></td>
                                <td  class="col-lg-8 form-control"><?php echo $this->Form->input('contact', array("label" => false, 'value' => $Merchant["Merchant"]["contact"], "class" => "form-control")); ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Email Citystars</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php //echo $this->Form->input('citystars_email', array("label" => false, 'value' => $User["User"]["citystars_email"], "class" => "form-control"));  ?></td>
                            </tr> -->
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Email Branch Manager</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('branch_email', array("label" => false, 'value' => $User["User"]["branch_email"], "class" => "form-control"));  ?></td>
                            </tr>
                            <!--  <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Email Area Manager</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"><?php //echo $this->Form->input('area_email', array("label" => false, 'value' => $User["User"]["area_email"], "class" => "form-control"));  ?></td>
                            </tr>
                            <tr class="form-group">
                                <td class="control-label col-lg-4"><label>Email Operation Manager</label></td>
                                <td id="sub_ite_id" class="col-lg-8 form-control"> <?php //echo $this->Form->input('operation_email', array("label" => false, 'value' => $User["User"]["operation_email"], "class" => "form-control"));  ?></td>
                            </tr>-->

                            <tr class="form-group">
                                <td class="control-label col-lg-6"><a id="clearData" class="btn-lg pull-right btn btn-danger btn-lg" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'welcome')); ?>" data-original-title="" title="" style="margin-left:3px;">Cancel</a>
                                    <?php echo $this->Form->submit('تسجيل', array('class' => 'btn-lg pull-right btn btn-success btn-lg', 'title' => 'Edit', "style" => "margin-left:3px;")); ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
    <script>
        $(document).ready(function () {
            if (<?php echo $Users["User"]["permission_id"]; ?> == 3) {
                $('#drop_merchants').show();
            } else {
                $('#drop_merchants').hide();
            }
            $("#drop_permission").change(function () {
                if ($('#permission_id').val() == 3) {
                    $('#drop_merchants').show();
                } else {
                    $('#drop_merchants').hide();
                }

            });
        });
        $(function () {
            formGeneral();
            // formValidation();
        });

    </script>

</body><!-- /.modal-dialog -->