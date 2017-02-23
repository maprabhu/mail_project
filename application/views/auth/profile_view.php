<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
            Profile Management
            <small></small>
        </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="#">Profile Management</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title"><?php echo form_label('Email','email');?> : <?php echo $user->email;?></h3>
          </div>
          <div class="box-header">
            <h3 class="box-title"><?php echo form_label('Username','username');?> : <?php echo $user->username;?></h3>
          </div>
          <!-- form start -->
          <?php echo form_open('',array('role'=>'form'));?>
          <!-- <form role="form"> -->
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <?php
                      echo form_input('first_name',set_value('first_name',$user->first_name),'class="form-control"');
                      ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Company</label>
              <?php
                      echo form_input('company',set_value('company',$user->company),'class="form-control"');
                      ?>
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Phone</label>
              <?php
                      echo form_input('phone',set_value('phone',$user->phone),'class="form-control"');
                      ?>
            </div>
            
            
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <?php echo form_submit('submit', 'Update profile', 'class="btn btn-primary"');?>
          </div>
          <?php echo form_close();?>
        </div>
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
