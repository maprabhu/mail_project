<!-- Start of Add event modal popup -->
<div class="modal"  id="editOtherUsersModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Other Users</h4>
            </div>
            <?php
            $attributes = array('id' => 'add_other_users_form', 'name' => 'add_other_users_form', 'role' => 'form');
            echo form_open_multipart('api/accountapi', $attributes);
            ?>
            <div class="modal-body">

                <span class="errMessage" id="event_response" ></span>
                <input type="hidden" name="created_from" id="created_from" value="2"/>
                <!--                <div class="form-group">
                                    <label >UserName</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Username" >
                                    <label class="no-padding-left error" id="error_email"></label> 
                                </div>-->

                <div class="form-group" id="group_id_div">
                    <label >Choose User Type</label> 
                    <select name="group_id" id="group_id" class="form-control"  >
                        <option value="">Select User Type</option>
                        <?php
                        foreach ($grouplist as $group_id => $group_name) {
                            echo "<option value='$group_id'>".$group_name."</option>";
                        }
                        ?>
                    </select>
                    <label class="no-padding-left error" id="error_group_id"></label> 
                </div>

                <div class="form-group">
                    <label >Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" >
                    <label class="no-padding-left error" id="error_username"></label> 
                </div>
                <!-- <div class="form-group" id="usernamedispdiv">
                    <label >Username</label>
                    <div id="dispusername"></div>
                </div> -->
                <!-- <div class="form-group">
                    <label >Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Name" >
                    <label class="no-padding-left error" id="error_first_name"></label> 
                </div> -->
                <!-- <div class="form-group">
                    <label >Company Name</label>
                    <input type="text" name="company" id="company" class="form-control" placeholder="Company" >
                    <label class="no-padding-left error" id="error_company"></label> 
                </div> -->
                <div class="form-group">
                    <label >Email</label> 
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" >
                    <label class="no-padding-left error" id="error_email"></label> 
                </div>
                <div class="form-group">
                    <label >Password</label> 
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" >
                    <label class="no-padding-left error" id="error_password"></label> 
                </div>
                <div class="form-group">
                    <label >Mobile</label> 
                    <input type="text" maxlength="10" name="phone" id="phone" class="form-control" placeholder="Mobile" >
                    <label class="no-padding-left error" id="error_phone"></label> 
                </div>
                <div class="form-group">
                    <label >Description</label> 
                    <input type="text" name="description" id="description" class="form-control" placeholder="Description" >
                    <label class="no-padding-left error" id="error_description"></label>
                </div>
                
                <!-- <div class="form-group">
                    <label >Photo </label> 
                    <input type="file" name="photo_name" id="photo_name" class="form-control"/>
                </div> -->
                
                
            </div>
            <div class="modal-footer">
                <input type="hidden" name="api" id="api" value="insert" />
                <input type="hidden" name="hide_other_user_btn_value" id="hide_other_user_btn_value" value="" />
                <input type="hidden" name="update_other_user_id" id="update_other_user_id" value="" />
                <input type="hidden" name="mobile_auth_key_post" id="mobile_auth_key_post" value="123" />
                <button class="btn btn-primary" id="btn_OtherUserSave" name="btn_OtherUserSave" type="submit" >Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                <!--<button type="submit" class="btn btn-primary">Save changes</button>-->
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- End of add event modal popup-->	

<!-- Start of Delete Modal -->
<div class="modal fade" id="deleteOtherUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3>Are you sure want to delete the user ?</h3>
                <div id="spnDelEventMessage" class="error"></div>
            </div>
            <input type="hidden" name="delete_other_user_id" id="delete_other_user_id" />
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo DELETE_CANCEL_LABEL; ?></button>
                <button type="button" class="btn btn-danger btn_delEvent" name="btn_delEvent" id="btn_delEvent" ><?php echo DELETE_CONFIRM_LABEL; ?></button>
            </div>
        </div>
    </div>
</div>
<!--End of Delete modal -->

<!-- Start of activate deactivate Modal -->
<div class="modal fade" id="actDecUsersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3>Activate / Deactivate User</h3>
                <div id="activate_deactivate_response" class="error"></div>
            </div>
            <input type="hidden" name="activate_deactivate_user_sms_users_id" id="activate_deactivate_user_sms_users_id" />
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo DELETE_CANCEL_LABEL; ?></button>
                <button type="button" class="btn btn-warning btnActivateUser" name="btnActivateUser" id="btnActivateUser" >Activate</button>
                <button type="button" class="btn btn-danger btnDeactivateUser" name="btnDeactivateUser" id="btnDeactivateUser" >Deactivate</button>
            </div>
        </div>
    </div>
</div>
<!--End of activate deactivate modal -->


<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">

    $(function () {
        $('#datetimepicker5').datetimepicker({
            defaultDate: new Date(),
            format: 'DD-MM-YYYY HH:mm:ss'

        });
    });
    /*
     * disabledDates: [
     moment("12/25/2013"),
     new Date(2013, 11 - 1, 21),
     "11/22/2013 00:53"
     ]
     */
    
    //, startDate: new Date()
    $('#created_date').datepicker({format: 'yyyy-mm-dd', autoclose: true});

        ////new validation start
    chkEventValidateStatus = "";
    chkEventValidateStatus = $("#add_other_users_form").validate({
        errorElement: "span",
        invalidHandler: function (form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                validator.errorList[0].element.focus();
            }
        },
        rules: {

            username: {
                required: true,
                maxlength: 100
            },
            email: {
                required: true,
                email:true,
                maxlength: 150
            },
            password: {
                required: false,
                maxlength: 25
            },group_id: {
                required: true
            }
        },
        messages: {
            username: {required: "Please enter username"
            },
            email: {required: "Please enter email"
            },
            password: {required: "Please enter password"
            },
            group_id: {required: "Please select user type"
            }
        },
        errorPlacement: function (error, element) {
            //for the rest of errors.
            $("#error_" + element.attr("id")).show();
            //error.css("#error_"+element.attr("id"));	
            error.css("margin", "0px");
            error.appendTo("#error_" + element.attr("id"));
            //error.insertAfter(element.parent());
            error.css("");
            error.css("color", "red");
        }


    });
     
    //new validation end



    $("#add_other_users_form").on('submit', (function (event) {
        //var mun_pan = $("#mun_pan").val();alert(mun_pan);
        event.preventDefault();
        if ($("#add_other_users_form").valid() == false) {
            return false;
        } else {
            var url = $(this).attr("action");
            $("#event_response").html('<img src="<?php echo base_url(); ?>assets/images/loader.gif">').fadeIn("fast");
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                async: true,
                success: function (response)
                {
                    $("#event_response").html(response.message).fadeIn("slow", function () {
                        $(this).delay(1500).fadeOut("slow");
                    });
                    if (response.result == 1) {

                        hide_popup('#editOtherUsersModal');
                        list_all_other_users();
                    } else {
                        alert(response.message);
                        return false;
                    }

                },
                error: function (xhr, desc, err)
                {


                }
            });
        }
    }));

    //add eventanization popup
    function add_other_users()
    {
        $("#api").val("insert");
        $('#group_id').prop('disabled', false);
        $("#add_other_users_form").trigger('reset');
        $("#username").val();
        $("#email").val();
        $("#description").val('');
        $("#created_date").val('');
        $("#phone").val('');
        $(".error").html('');

    }


    //add event end

    //edit visitor popup
    function edit_other_user(other_user_id)
    {

        $(".error").html('');
        $("#add_other_users_form").trigger('reset');
        $("#api").val('');
        var csrf_value = $('input[name="csrf_token_name"]').val();

        //$('#tal_id').val('');
        //$('#phc_id').val('');
        var dataStringChk = 'other_user_id=' + other_user_id + '&csrf_token_name=' + csrf_value;

        $.ajax({
            url: '<?php echo base_url(); ?>manage_users/get_other_user_details',
            async: true,
            type: "POST", //The type which you want to use: GET/POST
            data: dataStringChk,
            dataType: "json", //Return data type (what we expect).
            //This is the function which will be called if ajax call is successful.
            success: function (datains) {
                //alert("sad");
                // $("#usernamediv").hide();
                // $("#usernamedispdiv").show();
                $("#username").val(datains.username);
                $("#password").val('');
                $("#phone").val(datains.phone);
                $("#created_on_date").val(datains.created_on_date); 
                $("#description").val(datains.description);
                $("#email").val(datains.email);
                //alert(datains.mobile_auth_key);
                $("#group_id").val(datains.group_id);

                $('#group_id').prop('disabled', true);

                $("#update_other_user_id").val(datains.id);
                $("#api").val("web_update");
            }
        });

    }

    function del_other_user(id) {
        $("#delete_other_user_id").val(id);
    }

    //Delete event
    $(".btn_delEvent").click(function () {
        var csrf_value = $('input[name="csrf_token_name"]').val();
        var delete_other_user_id = $("#delete_other_user_id").val();

        $.ajax({
            url: "<?php echo base_url(); ?>manage_users/del_other_user",
            cache: false,
            type: 'POST',
            data: {
                "csrf_token_name": csrf_value,
                "delete_other_user_id": delete_other_user_id
            },
            success: function (response) {
                response = $.parseJSON(response);

                if (response.error_no == 1451) {
                    $("#spnDelEventMessage").html(response.status).fadeIn("slow", function () {
                        $(this).delay(2000).fadeOut("slow");
                    });
                } else if (typeof response.eventlist !== 'undefined') {
                    hide_popup('#deleteOtherUserModal');
                    list_all_other_users();
                    $("#delete_other_user_id").val('');
                    $("#spnDelEventMessage").html(response.status).fadeIn("slow", function () {
                        $(this).delay(1500).fadeOut("slow");
                    });
                } else if (typeof response.error !== 'undefined') {
                    $("#spnDelEventMessage").html(response.error).fadeIn("fast");
                }
            }
        });
    });

     
    
    //activate deactivate modal actDecUsersModal
    function activate_deactivate_user(id) {
        $(".error").html('');
        $("#activate_deactivate_user_form").trigger('reset');
        $("#activate_deactivate_user_sms_users_id").val(id);
    }
     
    
    //Activate user
    $(".btnActivateUser").click(function () {
        var csrf_value = $('input[name="csrf_token_name"]').val();
        var activate_deactivate_user_sms_users_id = $("#activate_deactivate_user_sms_users_id").val();
        var active = '1';
        
        $.ajax({
            url: "<?php echo base_url(); ?>api/activate_deactivate_user",
            cache: false,
            type: 'POST',
            data: {
                "csrf_token_name": csrf_value,
                "active":active,
                "activate_deactivate_user_sms_users_id": activate_deactivate_user_sms_users_id
            },
            success: function (response) {
                
                hide_popup('#actDecUsersModal');
                list_all_other_users();
            }
        });
    });
    
    //Deactivate event
    $(".btnDeactivateUser").click(function () {
    
        var csrf_value = $('input[name="csrf_token_name"]').val();
        var activate_deactivate_user_sms_users_id = $("#activate_deactivate_user_sms_users_id").val();
        var active = '0';
        
        $.ajax({
            url: "<?php echo base_url(); ?>api/activate_deactivate_user",
            cache: false,
            type: 'POST',
            data: {
                "csrf_token_name": csrf_value,
                "active":active,
                "activate_deactivate_user_sms_users_id": activate_deactivate_user_sms_users_id
            },
            success: function (response) {
                
                hide_popup('#actDecUsersModal');
                list_all_other_users();
            }
        });
    });
    
    function hide_popup(divId) {
        $(divId).modal('hide');
    }

    function show_popup(divId) {
        $(divId).modal('show');
    }
</script>