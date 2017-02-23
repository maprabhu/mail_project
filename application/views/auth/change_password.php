<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>
            Change Password Management
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#">Change Password Management</a></li>
        </ol>
    </section>  

    <section class="content">
        <div class="row">
            
            <?php
                        $attributes = array('id' => 'add_company_form', 'name' => 'add_company_form', 'role' => 'form');
                        echo form_open_multipart('auth/change_password', $attributes);
                        ?>
            <div class="col-md-6">

              <div class="box box-danger">
                
                <div class="box-body">
                  

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/change_password");?>

      <p>
            <?php echo lang('change_password_old_password_label', 'old_password');?> <br />
            <?php echo form_input($old_password);?>
      </p>

      <p>
            <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
            <?php echo form_input($new_password);?>
      </p>

      <p>
            <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
            <?php echo form_input($new_password_confirm);?>
      </p>

      <?php echo form_input($user_id);?>
      <p><?php echo form_submit('submit', lang('change_password_submit_btn'));?></p>

<?php echo form_close();?>


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


</script>
