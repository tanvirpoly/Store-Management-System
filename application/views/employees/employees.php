<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Staff / Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Staff / Employee</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Employee List</h3>
                <?php if($_SESSION['new_employee'] == 1){ ?>
                <button type="button" class="btn btn-primary add_emp" data-toggle="modal" data-target=".bs-example-modal-aemp" style="float: right" ><i class="fa fa-plus"></i> New Employee</button>
                <?php } ?>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-responsive table-bordered table-hover">
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Image</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Join</th>
                      <th>Signature</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($employee as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td>
                        <?php if($value['image'] == null) { ?>
                        <i class="fa fa-user fa-3x" ></i>
                        <?php } else{ ?> 
                        <img src="<?php echo base_url().'/upload/'.$value['image']; ?>" style="width: 40px; height: 40px;">
                        <?php } ?> 
                      </td>
                      <td><?php echo $value['empCode']; ?></td>
                      <td><?php echo $value['empName']; ?></td>
                      <td><?php echo $value['empMobile']; ?></td>
                      <td><?php echo $value['empEmail']; ?></td>
                      <td><?php echo $value['empAddress']; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['joinDate'])); ?></td>    
                      <td>
                        <?php if($value['imageOne'] == null) { ?>
                        <i class="fa fa-user fa-3x" ></i>
                        <?php } else{ ?> 
                        <img src="<?php echo base_url().'/upload/'.$value['imageOne']; ?>" style="width: 40px; height: 40px;">
                        <?php } ?> 
                      </td>
                      <td>
                        <?php if($_SESSION['edit_employee'] == 1){ ?>
                        <button type="button" class="btn btn-success btn-xs emp_edit" data-toggle="modal" data-target=".bs-example-modal-eemp" data-id="<?php echo $value['empid']; ?>" id="<?php echo $value['empid']; ?>" onclick="document.getElementById('emp_edit').style.display='block'"  ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_employee'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Employee/delete_employee').'/'.$value['empid'] ?>" onclick="return confirm('Are you sure you want to delete this Employee ?');" ><i class="fa fa-trash"></i></a>
                        <?php } ?>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    <div class="modal fade bs-example-modal-aemp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Employee Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Employee/save_employee'); ?>" method="post" enctype="multipart/form-data" >
            <div class="col-md-12 col-sm-12 col-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Name *</label>
                  <input type="text" class="form-control" name="empName" placeholder="Employee Name" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Department *</label>
                  <input type="text" class="form-control" name="empDpt" placeholder="Employee Department" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" class="form-control" name="empMobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Address *</label>
                  <input type="text" class="form-control" name="empAddress" placeholder="Address" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Email ID</label>
                  <input type="email" class="form-control" name="empEmail" placeholder="example@gmail.com"  >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Salary</label>
                  <input type="text" class="form-control" name="empSalary" placeholder="Salary"  >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Joining Date</label>
                  <input type="text" class="form-control datepicker" name="joinDate" placeholder="Date of Joining"  >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Image</label>
                  <input type="file" name="userfile"  >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Signature</label>
                  <input type="file" name="userfileOne"  >
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-eemp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title" >Update Staff Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Employee/update_Employee');?>" method="post">
            <div class="col-md-12 col-sm-12 col-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Name *</label>
                  <input type="text" class="form-control" name="empName" id="empName" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Department *</label>
                  <input type="text" class="form-control" name="empDpt" id="empDpt" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" class="form-control" name="empMobile" id="empMobile" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Address *</label>
                  <input type="text" class="form-control" name="empAddress" id="empAddress" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Email ID</label>
                  <input type="email" class="form-control" name="empEmail" id="empEmail"  >
                </div>
                <!--<div class="form-group col-md-6 col-sm-6 col-12">-->
                <!--  <label>Employee Salary</label>-->
                <!--  <input type="text" class="form-control" name="empSalary" id="empSalary"  >-->
                <!--</div>-->
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Joining Date</label>
                  <input type="text" class="form-control datepicker" name="joinDate" id="joinDate"  >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Image</label>
                  <input type="file" name="userfile"  >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Status</label>
                  <select class="form-control" name="status" id="status" >
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            <input type="hidden" name="empid" id="empid" required >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click','.emp_edit',function(){
          var catid = $(this).attr('id');
          //alert(l_id);
          $('input[name="empid"]').val(catid);
          });

        $(document).on('click','.emp_edit',function(){
          var id = $(this).attr('id');
            //alert(id);
          var url = '<?php echo base_url() ?>Employee/get_emp_data';
            //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
              //alert(data);
              var HTML = data["empName"];
              var HTML2 = data["empDpt"];
              var HTML3 = data["empMobile"];
              var HTML4 = data["empAddress"];
              var HTML5 = data["empEmail"];
              var HTML6 = data["empSalary"];
              var HTML7 = data["joinDate"];
              var HTML8 = data["status"];
              //alert(HTML);
              $("#empName").val(HTML);
              $("#empDpt").val(HTML2);
              $("#empMobile").val(HTML3);
              $("#empAddress").val(HTML4);
              $("#empEmail").val(HTML5);
              $("#empSalary").val(HTML6);
              $("#joinDate").val(HTML7);
              $("#status").val(HTML8);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>

    