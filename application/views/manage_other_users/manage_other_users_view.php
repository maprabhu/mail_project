<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
            Users Management
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#">Users Management</a></li>
          </ol>
        </section>  
        
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                  <a href="model_load_event_view.php"></a>
                <div class="box-header">
                    <div>
                        <div style="float: left;">
                             
                  <h3 class="box-title">
                  <button  type="button" class="btn btn-block btn-success btn-sm" 
                         onclick="javascript:add_other_users();" data-toggle="modal" data-target="#editOtherUsersModal">
                         <span class="glyphicon glyphicon-plus"></span> Add Users</button>
                  </h3>
                             
                        </div>
                        
                        
                        
                         
                    </div>
                    
                </div><!-- /.box-header -->
                <div class="box-body">
    <input type="hidden" name="search_first_name" id="search_first_name" />
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    <?php
    
    ?>
    
        
        <table id="visitorstable" class="table table-striped table-bordered bootstrap-datatable datatable responsive visitorstable">
        <thead>
	<tr>
		        <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Created Date</th>
                <th style="width:15%;">Action</th>
	</tr>
        </thead>
	
		<tbody> 

                      </tbody>

	
</table>
                    
                </div>
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
    
        
    $(function () {
        list_all_other_users();
        $('.error').hide();
    });
    
    
    
    function list_all_other_users(){  //alert("csrf_value==");
    var csrf_value = $('input[name="csrf_token_name"]').val();
        //alert(csrf_value);

        var search_first_name = $("#search_first_name").val();
        //alert(event_name_select);
        $('#visitorstable').dataTable().fnDestroy();
        $('#visitorstable').dataTable({
            "processing": true,
            "serverSide": true,
            "language":{
                "emptyTable":"No matching records found"
            },
            "ajax": {
                "url": "<?php echo base_url(); ?>manage_users/list_all_other_users",
                "type": "POST",
                "data" : {
                    "csrf_token_name" : csrf_value,
                    "search_first_name" : search_first_name
                }

            },
            "columns": [
            { "data": "username" },
            { "data": "phone" },
            { "data": "email" },
            { "data": "created_on_date" },
            { "data": "action" }			
            ],
            "aLengthMenu": [[5, 10, 15, 25, 50, 100], ["5", "10", "15", "25", "50", "100"]],
            "pageLength": 5,
            "columnDefs": [ { "targets": 3, "orderable": false }],
            "aaSorting": [[ 0, "desc" ]]
        });
        //{ "data": "plan_type_text" },            
        //$('#visitorstable').dataTable().fnSetColumnVis(0, false);//hide second column
        
    }


    /*
        function hide_popup(divId){         
        $(divId).modal('hide');        
    }
	
        function show_popup(divId){         
        $(divId).modal('show');        
    }
    */

</script>
<?php $this->load->view('manage_other_users/model_load_manage_other_users_view'); ?>