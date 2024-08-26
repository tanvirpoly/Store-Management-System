<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products Opening Stock</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Products Opening Stock</li>
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
                <h3 class="card-title">Products Opening Stock Information</h3>
                <button type="button" class="btn btn-success template" data-toggle="modal" data-target=".bs-example-modal-template" style="float: right; margin-right: 10px;" ><i class="fa fa-plus"></i> Import</button>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Product/save_store_product"); ?>">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Select Products *</label>
                        <select class="form-control select2" id="products" >
                          <option value="">Select One</option>
                          <option value="all">All</option>
                          <?php foreach($product as $value){ ?>
                          <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                        
                    <div class="col-md-12 col-sm-12 col-12">
                      <table id="" class="table table-bordered table-striped">
                        <thead class="btn-default">
                          <tr>
                            <th>Products</th>
                            <th>Quantity</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="mtable">
                        </tbody>
                      </table>
                    </div>

                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Note</label>
                        <input type="text" class="form-control" name="notes" placeholder="If have any note">
                      </div>
                    </div>             
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;SUBMIT</button>
                      <a href="<?php echo site_url('storeProduct'); ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;BACK</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
  <div id="templete" class="modal fade bs-example-modal-template" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title">Import Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <div class="row">
              <div class="form-group col-md-12 col-sm-12 col-12">
                <div style="width: 100%;height: 100px;background: #fff4f4;text-align: center;">
                  <a href="<?php echo base_url('assets/templates/openingstock.xlsx') ?>" style="padding:1em;text-align: center;display:inline-block;text-decoration: none !important;margin:0 auto;">Blank format</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <form method="post" id="import_form" enctype="multipart/form-data" >
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Import Product<span style="color: red">  *</span><br>(Excel file Upload)</label>
                <input type="file" name="file" id="file" required accept=".xls, .xlsx" >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top: 20px; text-align: center;">
                <input type="submit" name="import" value="Import" class="btn btn-info" >
              </div>
            </form>
            <div class="progress">
              <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
        $(document).ready(function(){
          $('#import_form').on('submit',function(event){
            event.preventDefault();
            $.ajax({
              url:"<?php echo base_url(); ?>Product/opening_stock_import",
              method:"POST",
              data:new FormData(this),
              contentType:false,
              cache:false,
              processData:false,
              xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                  if (e.lengthComputable) {
                    var percent = Math.round((e.loaded / e.total) * 100);
                    $('#progressBar').css('width', percent + '%').html(percent + '%');
                  }
                });
                return xhr;
              },
              success:function(data){
                $('#file').val('');
                // load_data();
                // alert(data);
                console.log(data);
                $('#templete').remove();
                $('.modal-backdrop').remove();
                // window.location.reload();
              },
               error:function(){
                    alert('Not Imported');
                }
            });
          });
        });
      </script> 

    <script type="text/javascript">
      $(document).ready(function(){
        $('#products').change(function(){    
          var id = $('#products').val();
          var url = '<?php echo base_url() ?>'+'Product/get_product/'+id;
                // alert(base_url);
          $.ajax({
            type: 'GET',
            url: url,
            dataType: 'text',
            success: function(data){
              var jsondata = JSON.parse(data);                
              $('#mtable').append(jsondata);
              }
            });
          });
        });
    </script>
