<div class="content-wrapper">
    <section class="content-header">

        <h1>Delete User</h1>
<p><?php echo "Do you want to delete this user : <b>".$user->first_name." ".$user->last_name;?></b></p>

<?php echo form_open("auth/delete_user/".$user->id);?>

  <p>
  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    <input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    <input type="radio" name="confirm" value="no" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p><?php echo form_submit('submit', lang('deactivate_submit_btn'));?></p>

<?php echo form_close();?>
</section>
    
</div>