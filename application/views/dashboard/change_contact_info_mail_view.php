<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>
            Email config
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#">Email config</a></li>
        </ol>
    </section>  

    <section class="content">
        <div class="row">

            <?php
            $attributes = array('id' => 'add_siteconfig_form', 'name' => 'add_siteconfig_form', 'role' => 'form');
            echo form_open_multipart('api/change_contact_info_mail', $attributes);
            ?>
            <div class="col-md-6">

                <div class="box box-danger">

                    <div class="box-body">
                        <h4>To receive the Contact form submittion email from apps, change the following email address. </h4>


                        <?php
                        //print_r($change_contact_info_mail);
                        ?>
                        <p>
                            <input type="text" name="contact_email" id="contact_email" value="<?php echo $change_contact_info_mail['result'][0]->contact_email;?>" />
                        </p>

                        <p>
                            <input type="submit" name="" id="" value="Update" class="btn btn-facebook"/>
                        </p>


                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div>
        </form>







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
