
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>
            Update notification settings
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#">Update notification settings</a></li>
        </ol>
    </section>  

    <section class="content">
        <div class="row">
             
            <div class="col-md-6">

              <div class="box box-danger">
                
                <div class="box-body">
                  <?php
if($get_user_details_by_id['result'][0]->plan_type == 0){
    ?>
<h3>You are not authorized person to view this page!</h3>
    <?php
}else{
?>



<?php
            $attributes = array('id' => 'notification_update_form', 'name' => 'notification_update_form', 'role' => 'form');
            echo form_open_multipart('profile/notification_update', $attributes);
            if($get_user_details_by_id['result'][0]->plan_type == 1 || $get_user_details_by_id['result'][0]->plan_type == 2){
            ?>

<div class="form-group">
    <h3>SMS Pack</h3><br/>
                    <label class="">
                        <input type="radio" name="enable_sms" id="enable_sms" value="1" <?php echo ($get_user_details_by_id['result'][0]->enable_sms == 1 ? 'checked' : '');?>/> Enable
                    </label>
                    <label class="">
                        <input type="radio" name="enable_sms" id="enable_sms" value="0" <?php echo ($get_user_details_by_id['result'][0]->enable_sms == 0 ? 'checked' : '');?>/> Disable
                    </label>
                    
                  </div>      
<?php
            }
            if($get_user_details_by_id['result'][0]->plan_type == 2){
?>
<div class="form-group">
    <h3>Voice SMS Pack</h3><br/>
                    <label class="">
                        <input type="radio" name="enable_voice" id="enable_voice" value="1" <?php echo ($get_user_details_by_id['result'][0]->enable_voice == 1 ? 'checked' : '');?>/> Enable
                    </label>
                    <label class="">
                        <input type="radio" name="enable_voice" id="enable_voice" value="0" <?php echo ($get_user_details_by_id['result'][0]->enable_voice == 0 ? 'checked' : '');?>/> Disable
                    </label>
                    
                  </div>
<?php
            }
            ?>
                    
                    <div class="form-group">
                        <input type="submit" name="" id="" value="Update" class="btn btn-success"/>
                    </div>                    
<?php echo form_close();?>
<?php
}
?>

                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div>
            <!--<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />-->
        
            
            
            
            
            
            
            </div>
        </div>
    </section>

</div>        
<!-- DATA TABES SCRIPT -->

<!-- page script -->
<style>
    /*th.hide_me, td.hide_me {display: none;}*/
</style>
<script type="text/javascript">
$("#notification_update_form").on('submit', (function (event) {

        var enable_sms = $('input[name=enable_sms]:checked').val();
        var enable_voice = $('input[name=enable_voice]:checked').val();

        if(enable_sms == 0 && enable_voice == 0){
            alert("Please select any one option as enabled.");return false;
        }

        event.preventDefault();
        
            var url = $(this).attr("action");
            //$("#company_response").html('<img src="<?php echo base_url(); ?>assets/images/loader.gif">').fadeIn("fast");		
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false,
                async: true,
                success: function (datains)
                {
                    //alert(datains.code);

                    if (datains.result == 1) {
                        alert("Updated");
                        return false;
                    }

                },
                error: function (xhr, desc, err)
                {
                    alert("Error");
                }
            });
        
    }));


</script>
