<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Units</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Units</li>
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
          <div class="col-md-8 col-sm-8 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Unit List</h3>
              </div>

              <div class="card-body">
                <table class="table table-responsive table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Name</th>
                      <!-- <th>Quantity ( KG )</th> -->
                      <th style="width: 10%;">Status</th>
                      <th>Created Date</th>
                      <th style="width: 15%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($unit as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">      
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['unitName']; ?></td>
                      <!-- <td><?php echo $value['uQnt']; ?></td> -->
                      <td><?php echo $value['status']; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['regdate']))?></td>
                      <td>
                        <?php if($_SESSION['edit_unit'] == 1){ ?>
                        <button type="button" class="btn btn-success btn-xs unit_edit" data-toggle="modal" data-target=".bs-example-modal-unit_edit" data-id="<?php echo $value['untid']; ?>" id="<?php echo $value['untid']; ?>" onclick="document.getElementById('unit_edit').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_unit'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Category/delete_units').'/'.$value['untid']; ?>" onclick="return confirm('Are you sure you want to delete this Unit ?');" ><i class="fa fa-trash"></i></a>
                        <?php } ?>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="modal fade bs-example-modal-unit_edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Unit Information</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="<?php echo base_url('Category/update_units'); ?>" method="post">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Unit Name *</label>
                    <input type="text" class="form-control" name="unitName" id="unitName" required >
                  </div>
                  <!-- <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Units Quantity * ( KG )</label>
                    <input type="number" class="form-control" name="uQnt" id="uQnt" required min="1" >
                  </div> -->
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status" >
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                  <input type="hidden" id="untid" name="untid" required >
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php if($_SESSION['new_unit'] == 1){ ?>
          <div class="col-md-4 col-sm-4 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Unit Information</h3>
              </div>
              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Category/save_units">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Units Name *</label>
                    <input type="text" class="form-control" name="unitName" placeholder="Units Name" required >
                  </div>
                  <!-- <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Units Quantity * ( KG )</label>
                    <input type="number" class="form-control" name="uQnt" placeholder="Units Quantity" required min="1" >
                  </div> -->
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <button type="submit" class="form-control btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php }  ?>
        </div>
      </div>
    </section>
  </div>


<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click','.unit_edit',function(){
          var catid = $(this).attr('id');
            //alert(l_id);
          $('input[name="untid"]').val(catid);
          });

        $(document).on('click','.unit_edit',function(){
          var id = $(this).attr('id');
          //alert(id);
          var url = '<?php echo base_url() ?>Category/get_unit_data';
          //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
              //alert(data);
              var HTML = data["unitName"];
              var HTML2 = data["uQnt"];
              var HTML3 = data["status"];
              //alert(HTML);
              $("#unitName").val(HTML);
              $("#uQnt").val(HTML2);
              $("#status").val(HTML3);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>