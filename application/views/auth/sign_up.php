<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Trackcentral App | Sign Up</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url('assets/plugins/iCheck/square/blue.css');?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
      


      <div class="login-box" style="margin: auto;">
      <div class="login-logo">
        <a href="login"><b>Trackcentral</b> App</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        
        <div id="infoMessage" style="color: red;"><?php //echo $message;?></div>
        
        
        


        <?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <?php
    
    //echo isset(($this->session->flashdata('auth_message') ? $this->session->flashdata('auth_message') : FALSE);
        if($this->session->flashdata('auth_message')){echo $this->session->flashdata('auth_message');}

    ?>
    <h1>Sign Up</h1>
    <?php
    echo form_open("api/sign_up");
    
    ?>
    <input type="hidden" name="created_from" id="created_from" value="2" />
    
    <?php
    echo form_label('First name:','first_name').'<br />';
    echo form_error('first_name');
    echo form_input('first_name',set_value('first_name')).'<br />';
    
    echo form_label('Company name:','company').'<br />';
    echo form_error('company');
    echo form_input('company',set_value('company')).'<br />';
    
    
    echo form_label('Phone:','phone').'<br />';
    echo form_error('phone');
    echo form_input('phone',set_value('phone')).'<br />';
    
    echo form_label('Email:','email').'<br />';
    echo form_error('email');
    echo form_input('email',set_value('email')).'<br />';
    echo form_label('Password:', 'password').'<br />';
    echo form_error('password');
    echo form_password('password').'<br />';
    echo form_label('Confirm password:', 'confirm_password').'<br />';
    echo form_error('confirm_password');
    echo form_password('confirm_password').'<br />';
    
    echo form_label('Choose Plan:', 'plan_type').'<br />';
    ?>
    <select name="plan_type" id="plan_type" class="col-xs-8 col-lg-2 col-md-4" >
        <option value="0">Silver Plan</option>
        <option value="1">Gold Plan</option>
        <option value="2">Voice Plan</option>
    </select>
    <br /><br /><br />
</div>
          <div class="row">
              <!--
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>                        
            </div>-->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        <?php echo form_close();?>

        <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
        <p><a href="<?php echo base_url();?>auth/login">Click here to sign in</a></p>
        <!--
        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>
        -->
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.3.min.js'); ?>" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js'); ?>" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>



