<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <!--<img src="<?php echo base_url();?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />-->
                <img src="<?php echo base_url();?>assets/images/avatar.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $this->session->userdata('first_name');?></p>

              <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
          </div>
          <!-- search form -->
          <!--
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!--<li class="header">MAIN NAVIGATION</li>-->
            
            <li class="<?php echo (($this->uri->segment(1) === 'dashboard')) ? 'active' : '' ;?>" >
              <a href="<?php echo base_url('dashboard/index');?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
              </a>
            </li>            
            
             <li class="<?php echo (($this->uri->segment(1) === 'mail_server_manage')) ? 'active' : '' ;?>">
              <a href="<?php echo base_url('mailserver_manage/manage_other_mail');?>">
                <i class="fa fa-envelope"></i> <span>MailBox</span> 
              </a>
            </li>
            
            <li class="treeview <?php echo (($this->uri->segment(2) === 'profile') || ($this->uri->segment(2) === 'change_password')) ? 'active' : '' ;?>">
              <a href="#">
                <i class="fa fa-wrench"></i>
                <span>Settings</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?php echo (($this->uri->segment(2) === 'profile')) ? 'active' : '' ;?>"><a href="<?php echo base_url('auth/profile');?>"><i class="fa fa-circle-o"></i> Profile</a></li>
                <li class="<?php echo (($this->uri->segment(2) === 'change_password')) ? 'active' : '' ;?>"><a href="<?php echo base_url('auth/change_password');?>"><i class="fa fa-circle-o"></i> Change Password</a></li>
                
              </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>