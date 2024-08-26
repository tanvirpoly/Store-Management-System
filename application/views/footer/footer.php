  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y') ?> <a href="https://sunshine.com.bd/" target="_blank">Sunshine IT</a> .</strong> All rights reserved.
  </footer>
</div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <!--<script type="text/javascript"-->
    <!--    src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js">-->
    <!--</script>-->
    <script src="<?php echo base_url(); ?>assets/plugins/new_datatables/v_dt_jszip-2.5.0_dt-1.12.1_b-2.2.3_b-colvis-2.2.3_b-html5-2.2.3_b-print-2.2.3_datatables.min.js"></script>
    <!--<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>-->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- date-picker -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard3.js"></script>
    <!-- page script -->
    
    <script src="<?php echo base_url(); ?>assets/dist/js/canvasjs.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
    
    <script type="text/javascript">
      function googleTranslateElementInit() {
        new google.translate.TranslateElement({
          pageLanguage: 'en',
          includedLanguages: 'en,bn',
          layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
          autoDisplay: false,
          exclude: ['.notranslate'],
          multilanguagePage: true
          }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script type="text/javascript">
      function printDiv(divName){
        $('#header').show();
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        }
    </script>

    <!--<script type="text/javascript">-->
    <!--  $(function(){-->
    <!--    $("#example").DataTable({-->
    <!--      "responsive": true,-->
    <!--      "autoWidth": false,-->
    <!--      });-->
    <!--    });-->
    <!--</script>-->
    
    <script type="text/javascript">
        $(function() {
          $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            // "buttons": ["excel", "pdf", "print"]
            }).container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        
          $("#example").DataTable({
            dom: "Bfrtip",
            // buttons: ["print", "excel"],
            "responsive": true,
            "autoWidth": false,
            "pagingType": "full_numbers",
          });
        });
      </script>
        <script type="text/javascript">
          $(function() {
            $("#example2").DataTable({
              "responsive": true,
              "lengthChange": true,
              "autoWidth": false,
              "pageLength": 50,
              "buttons": ["excel", "pdf", "print"]
            }).container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        
            $("#example3").DataTable({
              "dom": "Bfrtip",
              "buttons": ["print", "excel"],
              "responsive": true,
              "autoWidth": false,
              "pagingType": "full_numbers",
              "pageLength": 50
            });
          });
        </script>

    <script type="text/javascript">
      function isNumberKey(evt)
        {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
        }
    </script>
    
    <script type="text/javascript">
      $(function(){
        $('.datepicker').datepicker({
          autoclose: true,
          todayHighlight: true
          });
        });
    </script>
    
    <script type="text/javascript">
      $(function(){
        $(".select2").select2();
      });
    </script>

  </body>
</html>