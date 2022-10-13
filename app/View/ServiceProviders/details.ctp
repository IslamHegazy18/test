<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>
<body> 
    <div class="page-title">	
        <i class="icon-custom-settings"></i>
        <h3>Visit <span class="semi-bold">Details</span></h3>	
    </div>  



    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-body no-border" id="popup-validation">
                    <table class="pull-left" >
                        <tbody >
                            <tr >
                                <td style="padding: 5px;" width="10%">
                                    <div class="icons">
                                        <img width="100" height="100" alt="" src="<?php echo Configure::read('img_url') . $Service_Provider["Service_Provider"]["image"]; ?>">
                                    </div> 
                                </td>
                                <td style="padding: 5px;"width="60%">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 25px; font-weight: bolder;">
                                                    <?php echo $Service_Provider["Service_Provider"]["service_name_en"] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 20px;">
                                                    <?php echo $Service_Provider["Category"]["name_en"] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 20px;">
                                                    <?php echo $Service_Provider["Service_Type"]["name"] ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="padding: 5px;"width="30%">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php if ($action_flag) { ?>
                                                        <label style="font-size: 15px; font-weight: bolder; color: red;">Paper Need Your Action</label>
                                                    <?php } else if ($missing_flag) { ?>
                                                        <label style="font-size: 15px; font-weight: bolder; color: gold;">Still Missing Papers</label>
                                                    <?php } else { ?>
                                                        <label style="font-size: 15px; font-weight: bolder; color: green;">All Papers Accepted</label>
                                                        <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                                            <?php echo $this->Form->create('Paper_Transaction', array("url" => array("controller" => "ServiceProviders", "action" => "details"), 'type' => 'file')); ?>  
                                                            <?php echo $this->Form->input('Service_Provider_id', array("type" => "hidden", 'value' => $Service_Provider["Service_Provider"]["id"])); ?>
                                                            <?php if ($Service_Provider["Service_Provider"]["approval_flag"] == '0') { ?>
                                                                <?php echo $this->Form->submit('Activate Account', array('name' => 'btn', 'class' => 'btn btn-success btn-cons')); ?>
                                                            <?php } else { ?>
                                                                <?php echo $this->Form->submit('De-activate Account', array('name' => 'btn', 'class' => 'btn btn-danger btn-cons')); ?>
                                                            <?php } ?>
                                                        <?php } ?>     
                                                    <?php } ?> 
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="row" >
                        <div class="col-md-12" style="padding-top: 20px;">
                            <ul class="nav nav-pills" id="tab-4" >
                                <li class="active"><a href="#tab4Provider">Provider</a></li>
                                <?php if (!empty($Company)) { ?>
                                    <li><a href="#tab4Company">Company</a></li>
                                <?php } ?>
                                <li><a href="#tab4Account">Account</a></li>
                                <li><a href="#tab4Papers">Papers</a></li>
                                <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                    <li ><a href="#tab4SubServices">Sub-Services</a></li>
                                    <li ><a href="#tab4Branches">Branches</a></li>
                                    <li><a href="#tab4Reviews">Reviews</a></li>
                                    <li><a href="#tab4Reservations">Reservations</a></li>
                                    <li><a href="#tab4Notifications">Notifications</a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content" style="border-width: 2px; border-color: #C1C1C1; border-radius: 10px;border-style: solid;">
                                <div class="tab-pane active" id="tab4Provider">
                                    <div class="row column-seperation">
                                        <table class="table table-bordered no-more-tables  table-condensed">
                                            <tbody>
                                                <?php echo $this->Form->create('Paper_Transaction', array("url" => array("controller" => "ServiceProviders", "action" => "details"), 'type' => 'file')); ?>  
                                                <?php echo $this->Form->input('Service_Provider_id', array("type" => "hidden", 'value' => $Service_Provider["Service_Provider"]["id"])); ?>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Service Logo</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('file', array("id" => "image", "label" => false, "class" => "form-control", "type" => "file")); ?></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Service Name</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('service_name_en', array("label" => false, 'value' => $Service_Provider["Service_Provider"]["service_name_en"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Type</label></td>
                                                    <td class="col-lg-8"> <?php echo $this->Form->input('service_type_id', array("label" => FALSE, 'id' => "source", "default" => $Service_Provider["Service_Type"]["id"], 'options' => array($Service_Type_names), 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td> 

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Job</label></td>
                                                    <td class="col-lg-8"> <?php echo $this->Form->input('category_id', array("label" => FALSE, 'id' => "source1", "default" => $Service_Provider["Category"]["id"], 'options' => array($Category_names), 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td> 
                                                </tr>

                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Phone</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('phone', array("label" => false, 'value' => $Service_Provider["Service_Provider"]["phone"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Delivery</label></td>
                                                    <td class="col-lg-8">
                                                        <?php
                                                        if ($Service_Provider["Service_Provider"]["delivery_flag"] == '0') {
                                                            echo 'Disabled';
                                                        } else {
                                                            echo 'Activatted';
                                                        }
                                                        ?>

                                                    </td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Covarage KM</label></td>
                                                    <td class="col-lg-8"><?php echo $Service_Provider["Service_Provider"]["covarage_km"] . ' KM'; ?></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Traking</label></td>
                                                    <td class="col-lg-8">
                                                        <?php
                                                        if ($Service_Provider["Service_Provider"]["traking_flag"] == '0') {
                                                            echo 'Disabled';
                                                        } else {
                                                            echo 'Activatted';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Government </label></td>
                                                    <td class="col-lg-8"> <?php echo $this->Form->input('government_id', array("label" => FALSE, 'id' => "source3", "default" => $Service_Provider["Service_Provider"]["government_id"], 'options' => array($Areas), 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td> 
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Address</label></td>
                                                    <td class="col-lg-8">
                                                        <?php echo $this->Form->input('address', array("label" => false, 'value' => $Service_Provider["Service_Provider"]["address"], "class" => "form-control", "type" => "text", 'rows' => '5', 'style' => 'width: 100%;')); ?></td>
                                                </tr>

                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Service Description</label></td>
                                                    <td class="col-lg-4">
                                                        <div  class="radio radio-success">
                                                            <?php echo $this->Form->input('service_description_en', array("id" => "service_description_en", "label" => false, "type" => "text", "value" => $Service_Provider["Service_Provider"]["service_description_en"], "class" => "form-control", 'rows' => '5', 'style' => 'width: 100%;')); ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                                    <tr>
                                                        <td colspan="2">
                                                            <?php echo $this->Form->submit('Update Provider', array('name' => 'btn', 'class' => 'btn btn-success btn-cons')); ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab4Account">
                                    <div class="row column-seperation">
                                        <table class="table table-bordered no-more-tables  table-condensed">
                                            <tbody>
                                                <?php echo $this->Form->create('Paper_Transaction', array("url" => array("controller" => "ServiceProviders", "action" => "details"), 'type' => 'file')); ?>  
                                                <?php echo $this->Form->input('User_id', array("type" => "hidden", 'value' => $Service_Provider["Service_Provider"]["user_id"])); ?>

                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>First Name</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('fname', array("label" => false, 'value' => $Service_Provider["User"]["fname"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Last Name</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('lname', array("label" => false, 'value' => $Service_Provider["User"]["lname"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Email</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('email', array("label" => false, 'value' => $Service_Provider["User"]["email"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Phone</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('phone', array("label" => false, 'value' => $Service_Provider["User"]["phone"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Birthday</label></td>
                                                    <td class="col-lg-4"><div class="input-append success date col-md-10 col-lg-6 no-padding">
                                                            <?php echo $this->Form->input('birthday', array("id" => "id_date", "label" => false, 'class' => "form-control", "type" => "text", 'value' => $Service_Provider["User"]["birthday"])); ?>
                                                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span> </div></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Gender</label></td>
                                                    <td class="col-lg-8">
                                                        <?php
                                                        if ($Service_Provider["User"]["gender"] == '1') {
                                                            echo 'Male';
                                                        } else if ($Service_Provider["User"]["gender"] == '2') {
                                                            echo 'Female';
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>ID Number</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('idnumber', array("label" => false, 'value' => $Service_Provider["User"]["idnumber"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Activation Date</label></td>
                                                    <td class="col-lg-8"><?php echo $Service_Provider["User"]["activation_date"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <?php echo $this->Form->submit('Update Account', array('name' => 'btn', 'class' => 'btn btn-success btn-cons')); ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab4Company">
                                    <div class="row column-seperation">
                                        <table class="table table-bordered no-more-tables  table-condensed">
                                            <tbody>
                                                <?php echo $this->Form->create('Company', array("url" => array("controller" => "ServiceProviders", "action" => "details"), 'type' => 'file')); ?>  
                                                <?php echo $this->Form->input('User_id', array("type" => "hidden", 'value' => $Service_Provider["Service_Provider"]["user_id"])); ?>

                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Name</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('name', array("label" => false, 'value' => $Company["Company"]["name"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Phone</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('phone', array("label" => false, 'value' => $Company["Company"]["phone"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Address</label></td>
                                                    <td class="col-lg-8">
                                                        <?php echo $this->Form->input('address', array("label" => false, 'value' => $Company["Company"]["address"], "class" => "form-control", "type" => "text", 'rows' => '5', 'style' => 'width: 100%;', 'rows' => '5')); ?></td>
                                                </tr>

                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Info.</label></td>
                                                    <td class="col-lg-4">
                                                        <div  class="radio radio-success">
                                                            <?php echo $this->Form->input('info', array("info" => "service_description_en", "label" => false, "type" => "text", "value" => $Company["Company"]["info"], "class" => "form-control", 'rows' => '5', 'style' => 'width: 100%;')); ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <?php echo $this->Form->submit('Update Company', array('name' => 'btn', 'class' => 'btn btn-success btn-cons')); ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <div class="tab-pane " id="tab4Papers">
                                    <div class="row column-seperation">
                                        <table class="table table-bordered no-more-tables  table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <label style="font-size: 15px; font-weight: bolder;">Paper</label>
                                                    </th>
                                                    <th>
                                                        <label style="font-size: 15px; font-weight: bolder;">Attach</label>
                                                    </th>
                                                    <th>
                                                        <label style="font-size: 15px; font-weight: bolder;">Status</label>
                                                    </th>
                                                    <th>
                                                        <label style="font-size: 15px; font-weight: bolder;">Action</label>
                                                    </th>
                                                    <th>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($Required_Paper_arr as $key => $value) { ?>
                                                    <tr class="form-group">
                                                        <td class="control-label col-lg-3" ><label style="font-size: 15px; font-weight: bolder;"><?php echo $value["paper_name_en"]; ?></label></td>
                                                        <td class="control-label col-lg-3"> <a target="_blank" href="<?php echo Configure::read('img_url') . $value["attachment"]; ?>"><img width="200" height="200" alt="" src="<?php echo Configure::read('img_url') . $value["attachment"]; ?>"></a></td>

                                                        <?php $button_flag = FALSE; ?>
                                                        <?php if ($value["approval_flag"] == '1') { ?>
                                                            <td class="col-lg-2" style="color: green; font-size: 15px; font-weight: bolder;">Approved</td>
                                                            <td  class="col-lg-8"><label><?php ?></label>  <?php echo $this->Form->input('admin_notes', array("label" => false, 'value' => $value["admin_notes"], "class" => "form-control", "rows" => "5", "readonly" => "readonly")); ?></td>

                                                        <?php } else if ($value["approval_flag"] == '2') { ?>
                                                            <td class="col-lg-2" style="color: gold;font-size: 15px; font-weight: bolder;">Pending</td>
                                                            <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                                                <td class="control-label col-lg-3" colspan="2">
                                                                    <table>
                                                                        <tbody>
                                                                            <tr transaction_id ="<?php echo $value["Paper_Transaction_id"]; ?> " service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?> ">
                                                                                <td class ="<?php echo $value["Paper_Transaction_id"] . '-' . $Service_Provider["Service_Provider"]["id"]; ?>" >
                                                                                    <textarea id="message" class="admin_notes" type="text" transaction_id ="<?php echo $value["Paper_Transaction_id"]; ?> " service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?> "  class="form-control" rows ="5"><?php echo $value["admin_notes"]; ?></textarea> 
                                                                                </td>
                                                                                <td class ="<?php echo 'btnReject' . $value["Paper_Transaction_id"] ?>" style=" font-size: 15px; font-weight: bold; "COLSPAN=3>
                                                                                    <button  class="btnSubmitReject btn-lg pull-right btn btn-danger btn-lg" >Reject</button>
                                                                                    <img id = "loading_img" src="<?php echo Configure::read('img_url') ?>/img/loader.gif"style="height: 40px; width: 40px; visibility: hidden;">
                                                                                </td>
                                                                                <td class ="<?php echo 'btnAccept' . $value["Paper_Transaction_id"] ?>" style=" font-size: 15px; font-weight: bold; "COLSPAN=3>
                                                                                    <button  class="btnSubmitAccept btn-lg pull-right btn btn-success btn-lg" >Accept</button>
                                                                                    <img id = "loading_img" src="<?php echo Configure::read('img_url') ?>/img/loader.gif"style="height: 40px; width: 40px; visibility: hidden;">
                                                                                </td>
                                                                            </tr>
                                                                            <tr required_paper_id ="<?php echo $value["paper_id"]; ?>" transaction_id ="<?php echo $value["Paper_Transaction_id"]; ?>" service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?>">

                                                                                <td class="col-lg-6">
                                                                                    <input type="file" id="myFile" name="filename">

                                                                                </td>
                                                                                <td colspan="3" class ="<?php echo 'btnUpload' . $value["Paper_Transaction_id"] ?>" style=" font-size: 15px; font-weight: bold; ">
                                                                                    <button  class="btnUploadFile btn-lg pull-right btn btn-success btn-lg" >Upload</button>
                                                                                    <img id = "loading_img" src="<?php echo Configure::read('img_url') ?>/img/loader.gif"style="height: 40px; width: 40px; visibility: hidden;">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>

                                                            <?php } ?>
                                                        <?php } else if ($value["approval_flag"] == '3') { ?>
                                                            <td class="col-lg-2" style="color: red;font-size: 15px; font-weight: bolder;">Rejected</td>
                                                            <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                                                <td class="control-label col-lg-3" colspan="2">
                                                                    <table>
                                                                        <tbody>
                                                                            <tr transaction_id ="<?php echo $value["Paper_Transaction_id"]; ?> " service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?> ">
                                                                                <td class ="<?php echo $value["Paper_Transaction_id"] . '-' . $Service_Provider["Service_Provider"]["id"]; ?>" >
                                                                                    <textarea id="message" class="admin_notes" type="text" transaction_id ="<?php echo $value["Paper_Transaction_id"]; ?>" service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?> "  class="form-control" rows ="5"><?php echo $value["admin_notes"]; ?></textarea> 
                                                                                </td>
                                                                                <td class ="<?php echo 'btnReject' . $value["Paper_Transaction_id"] ?>" style=" font-size: 15px; font-weight: bold; "COLSPAN=3>
                                                                                    <button  class="btnSubmitReject btn-lg pull-right btn btn-danger btn-lg" >Reject</button>
                                                                                    <img id = "loading_img" src="<?php echo Configure::read('img_url') ?>/img/loader.gif"style="height: 40px; width: 40px; visibility: hidden;">
                                                                                </td>
                                                                                <td class ="<?php echo 'btnAccept' . $value["Paper_Transaction_id"] ?>" style=" font-size: 15px; font-weight: bold; "COLSPAN=3>
                                                                                    <button  class="btnSubmitAccept btn-lg pull-right btn btn-success btn-lg" >Accept</button>
                                                                                    <img id = "loading_img" src="<?php echo Configure::read('img_url') ?>/img/loader.gif"style="height: 40px; width: 40px; visibility: hidden;">
                                                                                </td>
                                                                            </tr>
                                                                            <tr required_paper_id ="<?php echo $value["paper_id"]; ?>" transaction_id ="<?php echo $value["Paper_Transaction_id"]; ?>" service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?>">

                                                                                <td class="col-lg-6">
                                                                                    <input type="file" id="myFile" name="filename">

                                                                                </td>
                                                                                <td  rowspan="3"class ="<?php echo 'btnUpload' . $value["Paper_Transaction_id"] ?>" style=" font-size: 15px; font-weight: bold; ">

                                                                                    <button  class="btnUploadFile btn-lg pull-right btn btn-success btn-lg" >Upload</button>
                                                                                    <img id = "loading_img" src="<?php echo Configure::read('img_url') ?>/img/loader.gif"style="height: 40px; width: 40px; visibility: hidden;">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } else if ($value["approval_flag"] == '4') { ?>
                                                            <td class="col-lg-2" style="color: red;font-size: 15px; font-weight: bolder;">Missing</td>

                                                            <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                                                <td  class="control-label col-lg-3" colspan="3">
                                                                    <table>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="col-lg-8"><label><?php ?></label>  <?php echo $this->Form->input('admin_notes', array("label" => false, 'value' => $value["admin_notes"], "class" => "form-control", "rows" => "5", "readonly" => "readonly")); ?></td>


                                                                            </tr>
                                                                            <tr required_paper_id ="<?php echo $value["paper_id"]; ?>" transaction_id ="<?php echo $value["Paper_Transaction_id"]; ?>" service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?>">
                                                                                <td class="col-lg-6">
                                                                                    <input type="file" id="myFile" name="filename">

                                                                                </td>
                                                                                <td  colspan="2"class ="<?php echo 'btnUpload' . $value["Paper_Transaction_id"] ?>" style=" font-size: 15px; font-weight: bold; ">

                                                                                    <button  class="btnUploadFile btn-lg pull-right btn btn-success btn-lg" >Upload</button>
                                                                                    <img id = "loading_img" src="<?php echo Configure::read('img_url') ?>/img/loader.gif"style="height: 40px; width: 40px; visibility: hidden;">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>    
                                                                </td>
                                                            <?php } ?>
                                                        <?php } ?>

                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                    <div class="tab-pane " id="tab4Branches">
                                        <div class="row column-seperation">
                                            <table class="table table-bordered no-more-tables  table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Branch</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Address</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Google Address</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Area</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Status</label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($Service_Provider['Branch'] as $key => $value) { ?>
                                                        <tr class="form-group">
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px; font-weight: bolder;"><?php echo $value["name"]; ?></label></td>
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px;"><?php echo $value["address"]; ?></label></td>
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px; "><?php echo $value["googleaddress"]; ?></label></td>
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px;"><?php echo $value["area"]; ?></label></td>
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px;">

                                                                    <?php
                                                                    if ($value["status"] == '1') {
                                                                        echo 'Closed';
                                                                    } else {
                                                                        echo 'Activatted';
                                                                    }
                                                                    ?>
                                                                </label></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab4SubServices">
                                        <div class="row column-seperation">
                                            <table class="table table-bordered no-more-tables  table-condensed">
                                                <?php echo $this->Form->create('SubService', array("url" => array("controller" => "ServiceProviders", "action" => "details"), 'type' => 'file')); ?>  
                                                <?php echo $this->Form->input('service_provider_id', array("type" => "hidden", 'value' => $Service_Provider["Service_Provider"]["id"])); ?>

                                                <tbody>
                                                    <tr class="form-group">
                                                        <td class="control-label col-lg-6"><label>Service</label></td>
                                                        <td class="col-lg-8"> <?php echo $this->Form->input('subservice_category_id', array("label" => FALSE, 'id' => "source5", 'options' => array($SubCategory_names), 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td> 
                                                    </tr>
                                                    <tr class="form-group">
                                                        <td class="control-label col-lg-6"><label>Service Panner</label></td>
                                                        <td class="col-lg-8"><?php echo $this->Form->input('file_panner', array("id" => "image", "label" => false, "class" => "form-control", "type" => "file")); ?></td>
                                                    </tr>
                                                    <tr class="form-group">
                                                        <td class="control-label col-lg-6"><label>Description</label></td>
                                                        <td class="col-lg-4">
                                                            <div  class="radio radio-success">
                                                                <?php echo $this->Form->input('details_en', array("info" => "service_description_en", "label" => false, "type" => "text", "class" => "form-control", 'rows' => '5', 'style' => 'width: 100%;')); ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="form-group">
                                                        <td class="control-label col-lg-6"><label>Price</label></td>
                                                        <td class="col-lg-8"><?php echo $this->Form->input('price', array("label" => false, "class" => "form-control", "type" => "number", 'style' => 'width: 250px;')); ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <?php echo $this->Form->submit('Add Service', array('name' => 'btn', 'class' => 'btn btn-success btn-cons')); ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered no-more-tables  table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Name</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Image</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Price</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Details</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Status</label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($Service_Provider_Category as $key => $value) { ?>
                                                        <tr class="form-group">
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px; font-weight: bolder;"><?php echo $value["Category"]["name_en"]; ?></label></td>
                                                            <td class="control-label col-lg-3"> <a target="_blank" href="<?php echo Configure::read('img_url') . $value["Service_Provider_Category"]['image']; ?>"><img width="100" height="100" alt="" src="<?php echo Configure::read('img_url') . $value["Service_Provider_Category"]['image']; ?>"></a></td>
                                                            <td class="control-label col-lg-1" ><label style="font-size: 15px; font-weight: bolder;"><?php echo $value["Service_Provider_Category"]["price"] . ' EGP'; ?></label></td>
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px; "><?php echo $value["Service_Provider_Category"]["details_en"]; ?></label></td>
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px; font-weight: bolder;">
                                                                    <?php
                                                                    if ($value["Service_Provider_Category"]["status"] == '1') {
                                                                        echo 'Disabled';
                                                                    } else {
                                                                        echo 'Activatted';
                                                                    }
                                                                    ?>
                                                                </label></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab4Reviews">
                                        <div class="row column-seperation">
                                            <table class="table table-bordered no-more-tables  table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">User Name</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Review</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Rate</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Submit date</label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($User_Review as $key => $value) { ?>
                                                        <tr class="form-group">
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px;"><?php echo $value["User"]["fname"] . ' ' . $value["User"]["lname"]; ?></label></td>
                                                            <td class="control-label col-lg-6" ><label style="font-size: 15px;"><?php echo $value["User_Review"]["review"]; ?></label></td>
                                                            <td class="control-label col-lg-1" ><label style="font-size: 15px; "><?php if (!empty($value["User_Review"]["rate"])) echo $value["User_Review"]["rate"] . '/5'; ?></label></td>
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px;"><?php echo $value["User_Review"]["created"]; ?></label></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab4Reservations">
                                        <div class="row column-seperation">
                                            <table class="table table-bordered no-more-tables  table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">User Name</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Phone</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Date</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Amount</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Status</label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($Reservation as $key => $value) { ?>
                                                        <tr class="form-group">
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px;"><?php echo $value["User"]["fname"] . ' ' . $value["User"]["lname"]; ?></label></td>
                                                            <td class="control-label col-lg-2" ><label style="font-size: 15px;"><?php echo $value["User"]["phone"]; ?></label></td>
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px; "><?php echo $value["Reservation"]["date_user"]; ?></label></td>
                                                            <td class="control-label col-lg-2" ><label style="font-size: 15px;"><?php echo $value["Reservation"]["amount"] . ' EGP'; ?></label></td>
                                                            <td class="control-label col-lg-6" ><label style="font-size: 15px; color: <?php echo $value["Reservation_Status"]["color"]; ?>"><?php echo $value["Reservation_Status"]["name_en"]; ?></label></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab4Notifications">
                                        <div class="row column-seperation">

                                            <table class="table table-bordered no-more-tables  table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">Message</label>
                                                        </th>
                                                        <th>
                                                            <label style="font-size: 15px; font-weight: bolder;">DateTime</label>
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($Notifications as $key => $value) { ?>
                                                        <tr class="form-group">
                                                            <td class="control-label col-lg-3" ><label style="font-size: 15px;"><?php echo $value["Notification"]["message"]; ?></label></td>
                                                            <td class="control-label col-lg-2" ><label style="font-size: 15px;"><?php echo $value["Notification"]["created"]; ?></label></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?> ">
                                                        <td class ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?>" >
                                                            <textarea id="message" class="admin_notes" type="text"  service_provider ="<?php echo $Service_Provider["Service_Provider"]["id"]; ?> "  class="form-control" rows ="5"></textarea> 
                                                        </td>
                                                        <td class ="<?php echo 'btnSend' . $Service_Provider["Service_Provider"]["id"] ?>" style=" font-size: 15px; font-weight: bold; "COLSPAN=3>
                                                            <button  class="btnSubmitSend btn-lg pull-right btn btn-success btn-lg" >Send</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div><!-- /.col-lg-12 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <i class="fa fa-info-circle fa-5x"></i>
                    <h4 class="semi-bold">البيانات التفصيلية</h4>
                </div>

                <table class="table  no-more-tables">
                    <tbody>
                        <tr class="form-group">

                            <td class="control-label col-lg-4"><label>Item Name</label></td>
                            <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('sub_item', array("label" => false, "class" => "form-control")); ?></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-lg-4"><label>Description</label></td>
                            <td id="desc_id" class="col-lg-8 form-control"><?php echo $this->Form->input('desc', array("label" => false, "class" => "form-control", "rows" => "2")); ?></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-lg-4"><label>Grade</label></td>
                            <td id="grade_id" class="col-lg-8 form-control"><?php echo $this->Form->input('grade', array("label" => false, "class" => "form-control")); ?></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-lg-4"><label>Comment</label></td>
                            <td id="comment_id" class="col-lg-8 form-control"><?php echo $this->Form->input('comment', array("label" => false, "class" => "form-control")); ?></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-lg-4"><label>Image</label></td>
                            <td class="col-lg-8 form-control"><img  id="image_id"  width="100" height="100" alt="" src="aa">
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إخفاء</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <i class="fa fa-info-circle fa-5x"></i>
                    <h4 class="semi-bold">البيانات التفصيلية</h4>
                </div>

                <table class="table  no-more-tables">
                    <tbody>
                        <tr class="form-group">

                            <td class="control-label col-lg-4"><label>Item Name</label></td>
                            <td id="sub_ite_id" class="col-lg-8 form-control"><?php echo $this->Form->input('sub_item', array("label" => false, "class" => "form-control")); ?></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-lg-4"><label>Description</label></td>
                            <td id="desc_id" class="col-lg-8 form-control"><?php echo $this->Form->input('desc', array("label" => false, "class" => "form-control", "rows" => "2")); ?></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-lg-4"><label>Grade</label></td>
                            <td id="grade_id" class="col-lg-8 form-control"><?php echo $this->Form->input('grade', array("label" => false, "class" => "form-control")); ?></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-lg-4"><label>Comment</label></td>
                            <td id="comment_id" class="col-lg-8 form-control"><?php echo $this->Form->input('comment', array("label" => false, "class" => "form-control")); ?></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-lg-4"><label>Image</label></td>
                            <td class="col-lg-8 form-control"><img  id="image_id"  width="100" height="100" alt="" src="aa">
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إخفاء</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>


        $('.btnSubmitSend').click(function () {

            var service_provider = $(this).closest('tr').attr("service_provider");
            var text_notification = $(this).closest('tr').find('textarea').val();

            console.log(text_notification);
            var data = {
                service_provider: service_provider,
                text_notification: text_notification
            };

            $(".btnSend" + service_provider).children("button").prop('disabled', true);
            $(".btn" + service_provider).children("img").css("visibility", "visible");
            $.ajax({
                type: "POST",
                data: {result: JSON.stringify(data)},
                url: "<?php echo $this->HTML->url(array("controller" => "ServiceProviders", "action" => "sendNotification_fun")); ?>",
                dataType: "json",
                success: function (data) {
                    console.log(JSON.stringify(data));
                    var result = JSON.parse(JSON.stringify(data).toString());
                    if (result == "success") {
                        alert("Sent Successfully");
                        $(".btnSend" + service_provider).children("button").hide();
                        $(".btn" + service_provider).children("img").css("visibility", "hidden");
                    } else {
                        alert("error in sending,this user has an old version of the mobile application");
                        $(".btn" + service_provider).children("img").css("visibility", "hidden");
                    }
                }, error: function (data) {
                    console.log(data);
                    alert("error in sending,please try again");
                    $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                }
            });

            return false;
        });

        $('.btnUploadFile').click(function () {

            var required_paper_id = $(this).closest('tr').attr("required_paper_id");
            var service_provider = $(this).closest('tr').attr("service_provider");
            var transaction_id = $(this).closest('tr').attr("transaction_id");
            var fup = $(this).closest('tr').find("input[type='file']");
            //var file = document.getElementById("myFile").files[0];  // file from input
            var file = fup[0].files[0];

            var formData = new FormData();
            formData.append('file', file);
            formData.append('service_provider', service_provider);
            formData.append('transaction_id', transaction_id);
            formData.append('required_paper_id', required_paper_id);

            console.log(fup);
            var data = {
                service_provider: service_provider,
                transaction_id: transaction_id,
                file: file
            };

            $(".btnUpload" + transaction_id).children("button").prop('disabled', true);
            $(".btn" + transaction_id).children("img").css("visibility", "visible");
            $.ajax({
                type: "POST",
                // data: {result: JSON.stringify(data)},
                url: "<?php echo $this->HTML->url(array("controller" => "ServiceProviders", "action" => "upload_fun")); ?>",
                data: formData,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(JSON.stringify(data));
                    var result = JSON.parse(JSON.stringify(data).toString());
                    if (result == "success") {
                        alert("Saved Successfully");
                        $(".btnUpload" + transaction_id).children("button").hide();
                        $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                    } else {
                        alert("error in saving,please try again");
                        $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                    }
                }, error: function (data) {
                    console.log(data);
                    alert("error in saving,please try again");
                    $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                }
            });

            return false;
        });
        $('.btnSubmitReject').click(function () {

            var service_provider = $(this).closest('tr').attr("service_provider");
            var transaction_id = $(this).closest('tr').attr("transaction_id");
            var admin_notes = $(this).closest('tr').find('textarea').val();

            console.log(admin_notes);
            var data = {
                service_provider: service_provider,
                transaction_id: transaction_id,
                admin_notes: admin_notes
            };

            $(".btnReject" + transaction_id).children("button").prop('disabled', true);
            $(".btnAccept" + transaction_id).children("button").prop('disabled', true);
            $(".btn" + transaction_id).children("img").css("visibility", "visible");
            $.ajax({
                type: "POST",
                data: {result: JSON.stringify(data)},
                url: "<?php echo $this->HTML->url(array("controller" => "ServiceProviders", "action" => "reject_fun")); ?>",
                dataType: "json",
                success: function (data) {
                    console.log(JSON.stringify(data));
                    var result = JSON.parse(JSON.stringify(data).toString());
                    if (result == "success") {
                        alert("Saved Successfully");
                        $(".btnReject" + transaction_id).children("button").hide();
                        $(".btnAccept" + transaction_id).children("button").hide();
                        $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                    } else {
                        alert("error in saving,please try again");
                        $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                    }
                }, error: function (data) {
                    console.log(data);
                    alert("error in saving,please try again");
                    $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                }
            });

            return false;
        });

        $('.btnSubmitAccept').click(function () {

            var service_provider = $(this).closest('tr').attr("service_provider");
            var transaction_id = $(this).closest('tr').attr("transaction_id");
            var admin_notes = $(this).closest('tr').find('textarea').val();

            console.log(admin_notes);
            var data = {
                service_provider: service_provider,
                transaction_id: transaction_id,
                admin_notes: admin_notes
            };

            $(".btnReject" + transaction_id).children("button").prop('disabled', true);
            $(".btnAccept" + transaction_id).children("button").prop('disabled', true);
            $(".btn" + transaction_id).children("img").css("visibility", "visible");
            $.ajax({
                type: "POST",
                data: {result: JSON.stringify(data)},
                url: "<?php echo $this->HTML->url(array("controller" => "ServiceProviders", "action" => "accept_fun")); ?>",
                dataType: "json",
                success: function (data) {
                    console.log(JSON.stringify(data));
                    var result = JSON.parse(JSON.stringify(data).toString());
                    if (result == "success") {
                        alert("Saved Successfully");
                        $(".btnReject" + transaction_id).children("button").hide();
                        $(".btnAccept" + transaction_id).children("button").hide();
                        $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                    } else {
                        alert("error in saving,please try again");
                        $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                    }
                }, error: function (data) {
                    console.log(data);
                    alert("error in saving,please try again");
                    $(".btn" + transaction_id).children("img").css("visibility", "hidden");
                }
            });

            return false;
        });



        function item_id(sub_ite, desc, grade, comment, attachment_image) {
            document.getElementById("sub_ite_id").innerHTML = sub_ite;
            document.getElementById("desc_id").innerHTML = desc;
            document.getElementById("grade_id").innerHTML = grade;
            document.getElementById("comment_id").innerHTML = comment;
            document.getElementById("image_id").src = attachment_image;
        }

        $(document).ready(function () {


            $('#tab-01 a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('#tab-2 a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('#tab-2 li:eq(1) a').tab('show');

            $('#tab-3 a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('#tab-3 li:eq(2) a').tab('show');

            $('#tab-4 a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('#tab-5 a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('#printMe').click(function () {
                $('#div_to_print').printThis({
                });
            });
            $(function () {
                $("#div_to_print").find('.print').on('click', function () {
                    $("#printable").print({
                        globalStyles: true,
                        mediaPrint: true,
                        iframe: true,
                        prepend: "<br/><div style='float: left;'id='qrcode'></div>",
                        manuallyCopyFormValues: true,
                        deferred: $.Deferred(),
                    });
                });
            });


        });
        function printContent(el) {
            var restorepage = $('html').html();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);

            window.print();
            location.reload();
        }
    </script>
</body><!-- /.modal-dialog -->