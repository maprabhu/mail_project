<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <!-- <b>Version</b> 2.0 -->
        </div>
        <!-- <strong>Copyright &copy; <?php //echo date('Y');?> <a href=""> Cobrasoftwares</a>.</strong> All rights reserved. -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    
    <!--<script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>-->
    <!-- DATA TABES SCRIPT -->
    <!--
    <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js'); ?>" type="text/javascript"></script>
    -->
    
    
    
<script src="<?php echo base_url('assets/datatable/jquery.dataTables.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/datatable/dataTables.bootstrap.js'); ?>" type="text/javascript"></script>

    <script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>

  </body>
</html>