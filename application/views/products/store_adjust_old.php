<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products Physical Count</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Products Physical Count</li>
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
                <h3 class="card-title">Products Physical Count List</h3>
                <button type="button" class="btn btn-primary newStore" data-toggle="modal" data-target=".bs-example-modal-newStore" style="float: right;" ><i class="fa fa-plus"></i> New Count</button>
                <!-- <a href="<?php echo site_url('newAProduct'); ?>" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Count</a> -->

              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Quantity</th>
                      <th>Notes</th>
                      <th style="width: 10%;">Action</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach($store as $value){
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['pCode']; ?></td>
                      <td><?php echo $value['pName']; ?></td>
                      <td><?php echo $value['quantity']; ?></td>
                      <td><?php echo $value['notes']; ?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs editStore" data-toggle="modal" data-target=".bs-example-modal-editStore" data-id="<?php echo $value['said']; ?>" id="<?php echo $value['said']; ?>" onclick="document.getElementById('editStore').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Product/delete_products_adjustment').'/'.$value['said']; ?>" onclick="return confirm('Are you sure you want to delete this Product Adjustment ?');"><i class="fa fa-trash"></i></a>
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


    <div class="modal fade bs-example-modal-newStore" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Adjust Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form method="POST" action="<?php echo base_url('Product/save_store_adjustment'); ?>" enctype="multipart/form-data" >
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Select Product *</label>
              <div>
              <select class="form-control select2" name="product" required style="width: 100%;">
                <option value="">Select One</option>
                <?php foreach($product as $value) { ?>
                <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName']; ?></option>
                <?php } ?>
              </select>
              </div>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Store Quantity</label>
              <input type="text" class="form-control" name="store" placeholder="Quantity" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Notes</label>
              <input type="text" class="form-control" name="notes" placeholder="If have any notes" >
            </div>
            <div class="modal-footer form-group">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-editStore" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Adjust Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Product/update_product_adjustment'); ?>" method="post">
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Select Product *</label>
              <div>
              <select class="form-control" name="product" id="product" required style="width: 100%;">
                <option value="">Select One</option>
                <?php foreach($product as $value) { ?>
                <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName']; ?></option>
                <?php } ?>
              </select>
              </div>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Quantity *</label>
              <input type="text" class="form-control" name="quantity" id="quantity" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Notes</label>
              <input type="text" class="form-control" name="notes" id="notes" placeholder="If have any notes"  >
            </div>
            <input type="hidden" id="said" name="said" required >
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
        $(document).on('click','.editStore',function(){
          var said = $(this).attr('id');
            //alert(l_id);
          $('input[name="said"]').val(said);
          });

        $(document).on('click','.editStore',function(){
          var id = $(this).attr('id');
          var url = '<?php echo base_url() ?>Product/get_adjust_product_data';
            //alert(id);
            $.ajax({
              method: 'POST',
              url     : url,
              dataType: 'json',
              data    : {'id' : id},
              success:function(data){ 
              //alert(data);
              var HTML = data["pid"];
              var HTML2 = data["quantity"];
              var HTML3 = data["notes"];
              //alert(HTML);
              $("#product").val(HTML);
              $("#quantity").val(HTML2);
              $("#notes").val(HTML3);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>