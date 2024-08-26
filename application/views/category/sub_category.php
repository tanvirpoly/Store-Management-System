<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sub Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Sub Category</li>
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
                <h3 class="card-title">Sub Category List</h3>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 5%;">SN</th>
                      <th>Category</th>
                      <th>Sub Category</th>
                      <th style="width: 12%;">STATUS</th>
                      <th style="width: 13%;">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($subcategory as $key => $value) { 
                    $i++;
                    ?>
                    <tr class="gradeX">      
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['catName']; ?></td>
                      <td><?php echo $value['scatName']; ?></td>
                      <td><?php echo $value['status']; ?></td>
                      <td>
                       <?php if($_SESSION['edit_sub_category'] == 1){ ?>
                        <button type="button" class="btn btn-success btn-xs category_edit" data-toggle="modal" data-target=".bs-example-modal-category_edit" data-id="<?php echo $value['scatid']; ?>" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_sub_category'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Category/delete_sub_category').'/'.$value['scatid']; ?>" onclick="return confirm('Are you sure you want to Delete this Category ?');" ><i class="far fa-trash-alt"></i></a>
                       <? }?>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="modal fade bs-example-modal-category_edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Sub Category Information</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="<?php echo base_url('Category/update_sub_category');?>" method="post">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Select Category</label>
                    <select class="form-control" name="category" id="category" required >
                      <?php foreach($category as $value){ ?>
                      <option value="<?= $value['catid'];?>"><?php echo $value['catName']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Sub Category Name *</label>
                    <input type="text" class="form-control" name="scatName" id="scatName" required >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status" >
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                  <input type="hidden" id="scatid" name="scatid" required >
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
       
          <div class="col-md-4 col-sm-4 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sub Category Information</h3>
              </div>
              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Category/save_sub_category" >
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Select Category</label>
                    <select class="form-control select2" name="category" required >
                      <option value="">Select One</option>
                      <?php foreach($category as $value){ ?>
                      <option value="<?php echo $value['catid']; ?>"><?php echo $value['catName']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Sub Category Name *</label>
                    <input type="text" class="form-control" name="scatName" placeholder="Sub Category Name" required >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" >
                    <button type="submit" class="form-control btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>

    
    <script type="text/javascript">
      $(document).ready(function(){
        $(".category_edit").click(function(){
          var scatid = $(this).data('id');
            //alert(l_id);
          $('input[name="scatid"]').val(scatid);
          });

        $('.category_edit').click(function(){
          var id = $(this).data('id');
          alert(id);
          var url = '<?php echo base_url() ?>Category/get_sub_category_data';
            alert(url);
            $.ajax({
              method: 'POST',
              url     : url,
              dataType: 'json',
              data    : {'id' : id},
              success:function(data){ 
              alert(data);
            //   console.log(data);
              var HTML = data["catid"];
              var HTML2 = data["scatName"];
              var HTML3 = data["status"];
              alert(HTML);
              $("#category").val(HTML);
              $("#scatName").val(HTML2);
              $("#status").val(HTML3);
              $("#status").select2();
              $("#category").select2();
              
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>