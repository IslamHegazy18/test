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
                                        <img width="100" height="100" alt="" src="<?php echo Configure::read('img_url') . $User["User"]["profile_pic"]; ?>">
                                    </div>
                                </td>
                                <td style="padding: 5px;"width="60%">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 25px; font-weight: bolder;">
                                                    <?php echo $User["User"]["fname"] . $User["User"]["lname"]; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 20px;">
                                                    <?php echo $User["Permission"]["name"]; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 20px;">
                                                    <?php echo $User["Service_Type"]["name"]; ?>
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
                                <li class="active"><a href="#tab4Provider">User</a></li>
                                <li><a href="#tab4Account">Account</a></li>
                                <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                    <li><a href="#tab4Reservations">Reservations</a></li>
                                    <li><a href="#tab4Notifications">Notifications</a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content" style="border-width: 2px; border-color: #C1C1C1; border-radius: 10px;border-style: solid;">
                                <div class="tab-pane active" id="tab4Provider">
                                    <div class="row column-seperation">
                                        <table class="table table-bordered no-more-tables  table-condensed">
                                            <tbody>
                                                <?php echo $this->Form->input('User_', array("type" => "hidden", 'value' => $User["User"]["id"])); ?>

                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Profile Pic</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('file', array("id" => "image", "label" => false, "class" => "form-control", "type" => "file")); ?></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>First Name</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('fname', array("label" => false, 'value' => $User["User"]["fname"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>
                                                </tr>
												<tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Last Name</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('lname', array("label" => false, 'value' => $User["User"]["lname"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>
                                                </tr>
												<tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Email</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('email', array("label" => false, 'value' => $User["User"]["email"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>
                                                </tr>
												<tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Mobile</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('phone', array("label" => false, 'value' => $User["User"]["phone"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>
                                                </tr>
												<tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Birthday</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('birthday', array("label" => false, 'value' => $User["User"]["birthday"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>
                                                </tr>
												<tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>ID Number</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('idnumber', array("label" => false, 'value' => $User["User"]["idnumber"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Type</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('service_type_id', array("label" => FALSE, 'id' => "source", "default" => $User["Service_Type"]["id"], 'options' => array($Service_Type_names), 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td>
                                                </tr>
												<tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Permission</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('permission_id', array("label" => FALSE, 'id' => "source", "default" => $User["Permission"]["id"], 'options' => array($User_Permissions), 'style' => 'width: 250px; margin-bottom:5px;')); ?> </td>
                                                </tr>
                                                <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
                                                    <tr>
                                                        <td colspan="2">
                                                            <?php echo $this->Form->submit('Update User', array('name' => 'btn', 'class' => 'btn btn-success btn-cons')); ?>
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
                                                <?php echo $this->Form->input('User_id', array("type" => "hidden", 'value' => $User["User"]["id"])); ?>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>First Name</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('fname', array("label" => false, 'value' => $User["User"]["fname"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Last Name</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('lname', array("label" => false, 'value' => $User["User"]["lname"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Email</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('email', array("label" => false, 'value' => $User["User"]["email"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Phone</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('phone', array("label" => false, 'value' => $User["User"]["phone"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Birthday</label></td>
                                                    <td class="col-lg-4"><div class="input-append success date col-md-10 col-lg-6 no-padding">
                                                            <?php echo $this->Form->input('birthday', array("id" => "id_date", "label" => false, 'class' => "form-control", "type" => "text", 'value' => $User["User"]["birthday"])); ?>
                                                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span> </div></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Gender</label></td>
                                                    <td class="col-lg-8">
                                                        <?php
                                                        if ($User["User"]["gender"] == '1') {
                                                            echo 'Male';
                                                        } else if ($User["User"]["gender"] == '2') {
                                                            echo 'Female';
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>ID Number</label></td>
                                                    <td class="col-lg-8"><?php echo $this->Form->input('idnumber', array("label" => false, 'value' => $User["User"]["idnumber"], "class" => "form-control", "type" => "text", 'style' => 'width: 250px;')); ?></td>

                                                </tr>
                                                <tr class="form-group">
                                                    <td class="control-label col-lg-6"><label>Activation Date</label></td>
                                                    <td class="col-lg-8"><?php echo $User["User"]["activation_date"]; ?></td>
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
                                <?php if ($this->Session->read('User.User.permission_id') == '888') { ?>
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
                                                    <tr service_provider ="<?php echo $User["User"]["id"]; ?> ">
                                                        <td class ="<?php echo $User["User"]["id"]; ?>" >
                                                            <textarea id="message" class="admin_notes" type="text"  service_provider ="<?php echo $User["User"]["id"]; ?> "  class="form-control" rows ="5"></textarea>
                                                        </td>
                                                        <td class ="<?php echo 'btnSend' . $User["User"]["id"] ?>" style=" font-size: 15px; font-weight: bold; "COLSPAN=3>
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
