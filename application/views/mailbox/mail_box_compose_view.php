     <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Mailbox
<!--             <small>13 new messages</small> -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Mailbox</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
              <a href="<?php echo base_url();?>mailserver_manage/manage_other_mail" class="btn btn-success btn-block margin-bottom">Back to Inbox</a>
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Folders</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?php echo base_url();?>mailserver_manage/manage_other_mail"><i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right">12</span></a></li>
                    <li><a href="<?php echo base_url();?>mailserver_manage/mail_sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
                    <!-- <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li> -->
                    <li><a href="<?php echo base_url();?>mailserver_manage/trash_view"><i class="fa fa-trash-o"></i> Trash</a></li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
             </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Compose New Message</h3>
                </div><!-- /.box-header -->
                <?php
            $attributes = array('id' => 'add_other_mail_form', 'name' => 'add_other_mail_form', 'method' => 'post', 'role' => 'form');
            echo form_open_multipart('mailserver_manage/insert_mail', $attributes);
            ?>

                <div class="box-body">
                <span class="errMessage" id="photo_response"></span>
                    <div class="form-group">
                      <label>To:</label>
                      <select class="form-control" id="sender" name="sender">
                       <option value="">--Select Sender--</option>
                      <?php foreach ($get_users_info['result'] as $value) { ?>
                         <option value="<?php echo $value->id;?>"><?php echo $value->username;?></option>
                           
                       <?php } ?>
                        </select>

                  </div>
                   
                  <div class="form-group">
                  <label>Subject: </label>
                    <input class="form-control" type="text" id="subject" name="subject" placeholder="Subject:"/>
                  </div>
                  <div class="form-group">
                  <label>Message: </label>
                    <textarea  id="compose" name ="compose" class="form-control" style="height: 300px">
                      
                    </textarea>
                  </div>
                 
                    <div class="form-group">
                        <label>Attachment:</label>
                        <input type="file" name="attach_file" id="attach_file" class="form-control" style="width:150px;" />
                    </div>
                    <!-- <p class="help-block">Max. 32MB</p> -->
                  
                  <div class="box-footer">
                  <div class="pull-right">
                    <!-- <button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button> -->
                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                  </div>
                  <br>

                  <!-- <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button> -->
                </div><!-- /.box-footer -->  
                  </form>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     

    <!-- iCheck -->
     <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
    
    <!-- Bootstrap WYSIHTML5 -->
     <script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
    
    
    <!-- Page Script -->
    <script>
      $(function () {
        //Add text editor
        $("#compose").wysihtml5();
        $("#add_other_mail_form").trigger('reset');
        $(".error").html('');

      });

      ////new validation start
chkPhotoValidateStatus = "";
chkPhotoValidateStatus = $("#add_other_mail_form").validate({

    errorElement: "span",
    invalidHandler: function(form, validator) {
        var errors = validator.numberOfInvalids();
        if (errors) {
            validator.errorList[0].element.focus();
        }
    },
    rules: {

        sender: {
            required: true,
            maxlength: 1000
        }
    },

    messages: {
        sender: {
            required: "Please select Sender",
            maxlength: "Photo name should be less than 1000 character."
        }
    },

    errorPlacement: function(error, element) {
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

// $("#add_other_mail_form").on('submit', (function(event) {

//     event.preventDefault();
//     if ($("#add_other_mail_form").valid() == false) {
//         return false;
//     } else {
//         var url = $(this).attr("action");
//         $("#photo_response").html('<img src="<?php //echo base_url(); ?>assets/images/loader.gif">').fadeIn("fast");
//         $.ajax({
//             url: url,
//             type: 'POST',
//             dataType: "JSON",
//             data: new FormData(this),
//             processData: false,
//             contentType: false,
//             async: true,
//             success: function(response) {
//                 if (typeof response.success !== 'undefined') {

//                     $("#photo_response").empty();
//                     $("#photo_response").html(response.success).fadeIn("slow", function() {
//                         // $(this).delay(1500).fadeOut("slow");
                        
//                     });
//                     // $("#photo_response").scrollTop();

                    
                    
//                     //listUsers();
//                 } else if (typeof response.error !== 'undefined') {
//                     $("#photo_response").html(response.error).fadeIn("fast");
//                     $('#add_other_mail_form').each(function() {
//                         //this.reset();
//                     });
//                 }

//             },
//             error: function(xhr, desc, err) {


//             }
//         });
//     }
// }));




    </script>
