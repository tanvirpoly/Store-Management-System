<?php $this->load->view('header/header'); ?>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

      <script type="text/javascript">
      $(function(){
        $('.datepicker').datepicker({
          autoclose: true,
          todayHighlight: true
          });
        });
    </script>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>" style="height: auto; width: 80%;">
      </div> 
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in Keep Secure your Business</p>
          <?php
          $exception = $this->session->userdata('exception');
          if(isset($exception))
          {
          echo $exception;
          $this->session->unset_userdata('exception');
          } ?>

          <form action="<?php echo base_url('Login/login_process'); ?>" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="username" placeholder="Email or Phone Number" required >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="Password" required >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
            </div>
          </form>

          <p class="mb-1">
            <a href="<?php echo base_url(); ?>forgetPassword">I forgot my password</a>
          </p>
          <p class="mb-1">
              
            <!--<button type="button" class="btn btn-primary add_emp" data-toggle="modal" data-target=".bs-example-modal-aemp" style="float: left" ><i class="fa fa-plus"></i>User Registration</button>-->
            <!--<a href="<?php echo base_url(); ?>register">User Register</a>-->
          </p>
           <p class="mb-0">
            <a style="color: black;"  href="<?php echo base_url(); ?>register" class="text-center">Register now!</a>
          </p>
        </div>
      </div>
    </div>
        <!--<div class="modal fade bs-example-modal-aemp" tabindex="-1" role="dialog" aria-hidden="true">-->
        <!--      <div class="modal-dialog modal-md">-->
        <!--        <div class="modal-content">-->
        <!--          <div class="modal-header">-->
        <!--            <h4 class="modal-title">User Information</h4>-->
        <!--            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>-->
        <!--          </div>-->
        <!--          <form action="<?php echo base_url('register/process'); ?>" method="post" enctype="multipart/form-data" >-->
        <!--            <div class="col-md-12 col-sm-12 col-12">-->
        <!--              <div class="row">-->
        <!--                <div class="form-group col-md-6 col-sm-6 col-12">-->
        <!--                  <label>Employee Name *</label>-->
        <!--                  <input type="text" class="form-control" name="empName" placeholder="Employee Name" required >-->
        <!--                </div>-->
        <!--                <div class="form-group col-md-6 col-sm-6 col-12">-->
        <!--                  <label>Employee Department *</label>-->
        <!--                  <input type="text" class="form-control" name="empDpt" placeholder="Employee Department" required >-->
        <!--                </div>-->
        <!--                <div class="form-group col-md-6 col-sm-6 col-12">-->
        <!--                  <label>Contact Number *</label>-->
        <!--                  <input type="text" class="form-control" name="empMobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >-->
        <!--                </div>-->
        <!--                <div class="form-group col-md-6 col-sm-6 col-12">-->
        <!--                  <label>Address *</label>-->
        <!--                  <input type="text" class="form-control" name="empAddress" placeholder="Address" required >-->
        <!--                </div>-->
        <!--                <div class="form-group col-md-6 col-sm-6 col-12">-->
        <!--                  <label>Email ID</label>-->
        <!--                  <input type="email" class="form-control" name="empEmail" placeholder="example@gmail.com"  >-->
        <!--                </div>-->
                        <!--<div class="form-group col-md-6 col-sm-6 col-12">-->
                        <!--  <label>Employee Salary</label>-->
                        <!--  <input type="text" class="form-control" name="empSalary" placeholder="Salary"  >-->
                        <!--</div>-->
        <!--                <div class="form-group col-md-6 col-sm-6 col-12">-->
        <!--                  <label>Joining Date</label>-->
        <!--                  <input type="text" class="form-control datepicker" name="joinDate" placeholder="Date of Joining"  >-->
        <!--                </div>-->
        <!--                <div class="form-group col-md-6 col-sm-6 col-12">-->
        <!--                  <label>Image</label>-->
        <!--                  <input type="file" name="userfile"  >-->
        <!--                </div>-->
        <!--                <div class="form-group col-md-6 col-sm-6 col-12">-->
        <!--                  <label>Signature</label>-->
        <!--                  <input type="file" name="userfileOne"  >-->
        <!--                </div>-->
        <!--              </div>-->
        <!--            </div>-->
        <!--            <div class="modal-footer">-->
        <!--              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>-->
        <!--              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>-->
        <!--            </div>-->
        <!--          </form>-->
        <!--        </div>-->
        <!--      </div>-->
        <!--    </div>-->

    

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>

  </body>
</html>