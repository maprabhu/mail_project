<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>
            Profile Manage
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#">Profile Manage</a></li>
        </ol>
    </section>  

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">

                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <div class='box'>
                            <div class='box-header'>
                                <h3 class='box-title'><small></small></h3>

                            </div><!-- /.box-header -->
                            <div class='box-body pad'>
                                <?php
                                $attributes = array('id' => 'add_profile_form', 'name' => 'add_profile_form', 'role' => 'form');
                                echo form_open_multipart('page_manage/edit_profile_view', $attributes);
                                ?>
                                <div class="form-group">
                                    <label>Profile Name</label>
                                    <input type="text" name="person_name" id="person_name" value="<?php echo $get_profile_data_details['result'][0]->person_name; ?>" />
                                </div>
                                <div class="form-group">
                                    <label>Tamil</label>
                                    <textarea name="profile_data_tamil" id="profile_data_tamil" class="textarea profile_data_tamil" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                        
                                        <?php echo $get_profile_data_details['result'][0]->profile_data_tamil; ?>
                                    </textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>English</label>
                                    <textarea name="profile_data_english" id="profile_data_english" class="textarea profile_data_english" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                        
                                        <?php echo $get_profile_data_details['result'][0]->profile_data_english; ?>
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Profile Image : </label>
                                    <?php
                                    if($get_profile_data_details['result'][0]->image_name){
                                        $prof_img = base_url()."assets/uploads/profile/".$get_profile_data_details['result'][0]->image_name;
                                        echo "<img src='$prof_img' style='width:150px;height:150px;'/>";
                                    }else{
                                        echo "No Photo";
                                    }
                                    ?>
                                    <input type="file" name="image_name" id="image_name" />
                                </div>
                                <input type="hidden" name="profile_data_id" id="profile_data_id" value="<?php echo $get_profile_data_details['result'][0]->profile_data_id; ?>" />
                                    <!--<a href="<?php echo base_url(); ?>page_manage/edit_party" class="btn btn-danger">Save</a>-->
                                <input type="submit" class="btn btn-danger" name="btnSaveProfile" id="btnSaveProfile" value="Save" />
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</div>        
<!-- bootstrap wysihtml5 - text editor -->
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script>
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.

        //bootstrap WYSIHTML5 - text editor
        $(".profile_data_tamil").wysihtml5();
        
        $(".profile_data_english").wysihtml5();
    });
</script>
<!-- DATA TABES SCRIPT -->
