<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Customer</li>
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
              <div class="card-header" >
                <h3 class="card-title">Customer List</h3>
                <?php if($_SESSION['new_customer'] == 1){ ?>
                <button type="button" class="btn btn-primary add_customer" data-toggle="modal" data-target=".bs-example-modal-add_customer" style="float: right;" ><i class="fa fa-plus"></i> New Customer</button>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($customer as $value){
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['custCode']; ?></td>
                      <td><?php echo $value['custName']; ?></td>
                      <td><?php echo $value['custMobile']; ?></td>
                      <td><?php echo $value['custEmail']; ?></td>
                      <td><?php echo $value['custAddress']; ?></td>
                      <td>
                        <?php if($_SESSION['edit_customer'] == 1){ ?>
                        <button type="button" class="btn btn-primary btn-sm customer_edit" data-toggle="modal" data-target=".bs-example-modal-customer_edit" data-id="<?php echo $value['custid']; ?>" id="<?php echo $value['custid']; ?>" onclick="document.getElementById('customer_edit').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_customer'] == 1){ ?>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url('Customer/delete_customer').'/'.$value['custid']; ?>" onclick="return confirm('Are you sure you want to delete this Customer ?');" ><i class="fa fa-trash"></i></a>
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

    <div class="modal fade bs-example-modal-add_customer" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title">Customer Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Customer/save_customer');?>" method="post" enctype="multipart/form-data" >
            <div class="col-md-12 col-sm-12 col-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Customer Name *</label>
                  <input type="text" class="form-control" name="custName" placeholder="Customer Name" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Address *</label>
                  <input type="text" class="form-control" name="address" placeholder="Address *" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Email" >
                </div>
                <!--<div class="form-group col-md-6 col-sm-6 col-12">-->
                <!--  <label>Opening Balance</label>-->
                <!--  <input type="text" class="form-control" name="balance" placeholder="Opening Balance" >-->
                <!--</div>-->
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

    <div class="modal fade bs-example-modal-customer_edit" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title">Customer Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Customer/update_customer');?>" method="post" enctype="multipart/form-data" >
            <div class="col-md-12 col-sm-12 col-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Customer Name *</label>
                  <input type="text" class="form-control" name="custName" id="custName" placeholder="Customer Name" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" class="form-control" name="mobile" id="mobile" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required placeholder="Customer Mobile" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label>Email ID</label>
                  <input type="email" class="form-control" name="email" id="email" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label>Address</label>
                  <input type="text" class="form-control" name="address" id="address" >
                </div>
                <!--<div class="form-group col-md-6 col-sm-6 col-xs-12">-->
                <!--  <label>Opening Balance</label>-->
                <!--  <input type="text" class="form-control" name="balance" id="balance" >-->
                <!--</div>-->
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label>Status</label>
                  <select class="form-control" name="status" id="status" >
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                </div>
              </div>
              <input type="hidden" id="custid" name="custid" required >
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click','.customer_edit',function(){
          var catid = $(this).attr('id');
          $('input[name="custid"]').val(catid);
          });

        $(document).on('click','.customer_edit',function(){
          var id = $(this).attr('id');

          var url = '<?php echo base_url() ?>Customer/get_customer_data';
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
              var HTML = data["custName"];
              var HTML3 = data["custMobile"];
              var HTML4 = data["custEmail"];
              var HTML5 = data["custAddress"];
            //   var HTML6 = data["custBalance"];
              var HTML7 = data["status"];

              $("#custName").val(HTML);
              $("#mobile").val(HTML3);
              $("#email").val(HTML4);
              $("#address").val(HTML5);
            //   $("#balance").val(HTML6);
              $("#status").val(HTML7);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>