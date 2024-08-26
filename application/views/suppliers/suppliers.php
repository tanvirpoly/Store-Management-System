<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Supplier</li>
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
                <h3 class="card-title">Supplier List</h3>
                <?php if($_SESSION['new_supplier'] == 1){ ?>
                <button type="button" class="btn btn-primary add_supplier" data-toggle="modal" data-target=".bs-example-modal-add_supplier" style="float: right;" ><i class="fa fa-plus"></i> New Supplier</button>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Company</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($supplier as $value){
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['supCode']; ?></td>
                      <td><?php echo $value['supName']; ?></td>
                      <td><?php echo $value['supCName']; ?></td>
                      <td><?php echo $value['supMobile']; ?></td>
                      <td><?php echo $value['supEmail']; ?></td>
                      <td><?php echo $value['supAddress']; ?></td>
                      <td>
                        <?php if($_SESSION['edit_supplier'] == 1){ ?>
                        <button type="button" class="btn btn-success btn-sm supplier_edit" data-toggle="modal" data-target=".bs-example-modal-supplier_edit" data-id="<?php echo $value['supid'];?>" id="<?php echo $value['supid']; ?>" onclick="document.getElementById('supplier_edit').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_supplier'] == 1){ ?>
                        <a class=" btn btn-danger btn-sm" href="<?php echo site_url('Supplier/delete_supplier').'/'.$value['supid']; ?>" onclick="return confirm('Are you sure you want to delete this Supplier ?');" ><i class="fa fa-trash"></i></a>
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

    <div class="modal fade bs-example-modal-add_supplier" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title">Supplier Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Supplier/save_supplier'); ?>" method="post" enctype="multipart/form-data" >
            <div class="col-md-12 col-sm-12 col-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Supplier Name *</label>
                  <input type="text" class="form-control" name="supName" placeholder="Supplier Name" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Supplier Company *</label>
                  <input type="text" class="form-control" name="supCName" placeholder="Supplier Company" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" class="form-control" name="supMobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" required minlength="11" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Supplier Address *</label>
                  <input type="text" class="form-control" name="supAddress" placeholder="Address *" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Supplier Email</label>
                  <input type="email" class="form-control" name="supEmail" placeholder="Email" >
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

    <div class="modal fade bs-example-modal-supplier_edit" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title">Update Supplier Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Supplier/update_supplier');?>" method="post" enctype="multipart/form-data" >
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Supplier Name *</label>
                  <input type="text" class="form-control" name="supName" id="supName" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Supplier Company *</label>
                  <input type="text" class="form-control" name="supCName" id="supCName" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" class="form-control" name="supMobile" id="supMobile" onkeypress="return isNumberKey(event)" maxlength="11" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Address *</label>
                  <input type="text" class="form-control" name="supAddress" id="supAddress" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Email</label>
                  <input type="email" class="form-control" name="supEmail" id="supEmail" >
                </div>
                <!--<div class="form-group col-md-6 col-sm-6 col-12">-->
                <!--  <label>Opening Balance</label>-->
                <!--  <input type="text" class="form-control" name="balance" id="balance" >-->
                <!--</div>-->
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Status</label>
                  <select class="form-control" name="status" id="status" >
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                </div>
              </div>
              <input type="hidden" id="supid" name="supid" required >
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
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
        $(document).on('click','.supplier_edit',function(){
          var catid = $(this).attr('id');
          //alert(l_id);
          $('input[name="supid"]').val(catid);
          });

        $(document).on('click','.supplier_edit',function(){
          var id = $(this).attr('id');
          //alert(id);
          var url = '<?php echo base_url() ?>Supplier/get_supplier_data';
          //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
            //alert(data);
              var HTML = data["supName"];
              var HTML2 = data["supCName"];
              var HTML3 = data["supMobile"];
              var HTML4 = data["supEmail"];
              var HTML5 = data["supAddress"];
              var HTML6 = data["balance"];
              var HTML7 = data["status"];
              //alert(HTML);
              $("#supName").val(HTML);
              $("#supCName").val(HTML2);
              $("#supMobile").val(HTML3);
              $("#supEmail").val(HTML4);
              $("#supAddress").val(HTML5);
              $("#balance").val(HTML6);
              $("#status").val(HTML7);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>