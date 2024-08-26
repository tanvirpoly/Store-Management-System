<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Products</li>
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
<?php
    $query = $this->db->select('pid')
                  ->from('products')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('pid','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = $query->pid+1;
        }
    else
        {
        $sn = 1;
        }

    $cn = strtoupper(substr($_SESSION['company'],0,3));
    $pc = sprintf("%'05d",$sn);

    $cusid = 'P-'.$cn.$pc;
    // var_dump($cusid); exit();
?>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header" >
                <h3 class="card-title">Products List</h3>
                <?php if($_SESSION['new_product'] == 1){ ?>
                <button type="button" class="btn btn-primary product_add" data-toggle="modal" data-target=".bs-example-modal-product_add" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Product</button>
                <?php } ?>
                <button type="button" class="btn btn-success template" data-toggle="modal" data-target=".bs-example-modal-template" style="float: right; margin-right: 10px;" ><i class="fa fa-plus"></i> Import</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-dpStore" style="float: right; margin-right: 10px;" ><i class="fa fa-plus"></i> Damage Product</button>
              </div>

              <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <form action="<?php echo base_url(); ?>Product" method="get">
                        <div class="row">
                          <!--<input type="hidden" class="form-control" name="sType" value="2" required >-->
                          <div class="form-group col-md-8 col-sm-8 col-xs-12">
                            <label> Product Type *</label>
                            <select class="form-control" name="ptype" required >
                              <option value="all">All</option>
                              <option value="1">Refundable</option>
                              <option value="0">Non-refundable</option>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-xs-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </form>
                      </div>
                </div>
                <table id="example2" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Category</th>
                      <th>Sub-Category</th>
                      <th>Unit</th>
                      <th>Refundable</th>
                      <th>Rack</th>
                      <!-- <th>P-Price</th>
                      <th>S-Price</th> -->
                      <th>P-Stock</th>
                      <th>Stock</th>
                      <th style="width: 10%;">Action</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($product as $value){
                    $i++;
                    
                    $stock = $this->db->select('*')
                                    ->from('stock')
                                    ->where('pid',$value['pid'])
                                    ->get()
                                    ->row();

                    if($stock)
                      {
                      $st = $stock->tquantity;
                      $sdt = $stock->tdquantity;
                      }
                    else
                      {
                      $st = 0;
                      $sdt = 0;
                      }
                    
                    $pspp = $this->db->select("SUM(quantity) as tsq")
                                      ->from('store_pdetails')
                                      ->where('pid',$value['pid'])
                                      ->get()
                                      ->row();
                                      
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['pCode']; ?></td>
                      <td><?php echo $value['pName']; ?></td>
                      <td><?php echo $value['catName']; ?></td>
                      <td><?php echo $value['scatName']; ?></td>
                      <td><?php echo $value['unitName']; ?></td>
                      <td><?php if( $value['refundable'] == 1){ echo 'Yes';}else{ echo 'No'; } ?></td>
                      <td><?php echo $value['rNumber']; ?></td>
                      <!-- <td><?php echo number_format($value['uprice'], 2); ?></td>
                      <td><?php echo number_format($value['sprice'], 2); ?></td> -->
                      <td>
                        <?php if($pspp){ ?>
                        <?php echo $pspp->tsq; ?>
                        <?php } else{ ?>
                        <?php echo '00'; ?>
                        <?php } ?>
                      </td>
                      <td><?php echo $st.' / '.$sdt; ?></td>
                      <td>
                        <?php if($_SESSION['edit_product'] == 1){ ?>
                        <button type="button" class="btn btn-success btn-xs editProduct" data-toggle="modal" data-target=".bs-example-modal-editProduct" data-id="<?php echo $value['pid']; ?>" id="<?php echo $value['pid']; ?>" onclick="document.getElementById('editProduct').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_product'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Product/delete_products').'/'.$value['pid']; ?>" onclick="return confirm('Are you sure you want to delete this Product ?');"><i class="fa fa-trash"></i></a>
                        <?php } ?>
                        <a class="btn btn-warning btn-xs" href="<?php echo base_url().'pBarcode/'.$value['pid']; ?>" title="barcode" ><i class="fa fa-barcode"></i></a>
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


    <div class="modal fade bs-example-modal-product_add" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Product Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form method="POST" action="<?php echo base_url('Product/save_product'); ?>" enctype="multipart/form-data" >
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Product Code *</label>
              <input type="text" class="form-control" name="pCode" placeholder="Product Code" value="<?php echo $cusid;?>" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Product Name *</label>
              <input type="text" class="form-control" name="pName" placeholder="Product Name" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Select Category *</label>
              <select class="form-control" name="category" id="category" required >
                <option value="">Select One</option>
                <?php foreach($category as $value) { ?>
                <option value="<?php echo $value['catid']; ?>"><?php echo $value['catName']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Select Sub Category*</label>
              <select class="form-control" name="scategory" id="scategory">
                <option value="">Select Category First</option>
              </select>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Refundable *</label>
              <select class="form-control" name="refundable" required >
                <option value="">Select One</option>
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Select Unit *</label>
              <select class="form-control select2" name="unit" required >
                <option value="">Select One</option>
                <?php  foreach($unit as $value) { ?>
                <option value="<?php echo $value['untid']; ?>"><?php echo $value['unitName']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Rack Number</label>
              <input type="text" class="form-control" name="rNumber" placeholder="Rack Number" >
            </div>
            <div class="modal-footer form-group">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-editProduct" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Chemical Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Product/update_product'); ?>" method="post">
             <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Product Code *</label>
              <input type="text" class="form-control" name="pCode" id="pCode" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Product Name *</label>
              <input type="text" class="form-control" name="pName" id="pName" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Select Category *</label>
              <select class="form-control" name="category"  id="catid" required >
                <option value="">Select One</option>
                <?php foreach($category as $value) { ?>
                <option value="<?php echo $value['catid']; ?>"><?php echo $value['catName']; ?></option>
                <?php } ?>
              </select>
            </div>
            
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Refundable *</label>
              <select class="form-control" name="refundable" id="refundable" required >
                <option value="">Select One</option>
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Select Unit *</label>
              <select class="form-control" name="unit" id="untid" required >
                <option value="">Select One</option>
                <?php  foreach($unit as $value) { ?>
                <option value="<?php echo $value['untid']; ?>"><?php echo $value['unitName']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Rack Number</label>
              <input type="text" class="form-control" name="rNumber" id="rNumber" >
            </div>
                <!-- <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Purchase Price *</label>
                  <input type="text" class="form-control" name="pprice" id="uprice" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Sale Price *</label>
                  <input type="text" class="form-control" name="sprice" id="sprice" required >
                </div> -->
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Status</label>
              <select class="form-control" name="status" id="status" >
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <input type="hidden" id="pid" name="pid" required >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
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
                  <a href="<?php echo base_url('assets/templates/productsImport.xlsx') ?>" style="padding:1em;text-align: center;display:inline-block;text-decoration: none !important;margin:0 auto;">Blank format</a>
                </div>
              </div>
              <!--<div class="form-group col-md-6 col-sm-6 col-12">-->
              <!--  <div style="width: 100%;height: 100px;background: #fff4f4;text-align: center;">-->
              <!--    <a href="<?php echo base_url('Product/export_action') ?>" style="padding:1em;text-align: center;display:inline-block;text-decoration: none !important;margin:0 auto;">Sample data</a>-->
              <!--  </div>-->
              <!--</div>-->
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <form method="post" id="import_form" enctype="multipart/form-data" enctype="multipart/form-data" >
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
    
    <div class="modal fade bs-example-modal-dpStore" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Daage Product Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form method="POST" action="<?php echo base_url('Product/save_damage_product'); ?>" enctype="multipart/form-data" >
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Select Product *</label>
              <select class="form-control select2" name="product" required >
                <option value="">Select One</option>
                <?php foreach($product as $value) { ?>
                <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Quantity *</label>
              <input type="text" class="form-control" name="quantity" placeholder="Quantity" required >
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

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click','.editProduct',function(){
          var pid = $(this).attr('id');
            //alert(l_id);
          $('input[name="pid"]').val(pid);
          });

        $(document).on('click','.editProduct',function(){
          var id = $(this).attr('id');
          var url = '<?php echo base_url() ?>Product/get_product_data';
            //alert(id);
            $.ajax({
              method: 'POST',
              url     : url,
              dataType: 'json',
              data    : {'id' : id},
              success:function(data){ 
              //alert(data);
              var HTML = data["pName"];
              var HTML2 = data["catid"];
              var HTML3 = data["untid"];
              var HTML4 = data["uprice"];
              var HTML5 = data["sprice"];
              var HTML6 = data["status"];
              var HTML7 = data["rNumber"];
              var HTML8 = data['pCode'];
              var HTML9 = data['scategory']
              //alert(HTML);
              $("#pName").val(HTML);
              $("#catid").val(HTML2);
              $("#untid").val(HTML3);
              $("#uprice").val(HTML4);
              $("#sprice").val(HTML5);
              $("#refundable").val(data["refundable"]);
              $("#status").val(HTML6);
              $("#rNumber").val(HTML7);
              $("#pCode").val(HTML8);
              $("#scategory").val(HTML9);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
          $('#import_form').on('submit',function(event){
            event.preventDefault();
            $.ajax({
              url:"<?php echo base_url(); ?>Product/excel_import",
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
          $('#category').change(function(){
            var id = $('#category').val();
            var url = "<?php echo base_url(); ?>Product/get_subcategory_data";
                  // alert(url);alert(id);
              $.ajax({
                method: "POST",
                url     : url,
                dataType: 'json',
                data    : {"id" : id},
                success:function(data){ 
                    console.log(data);
                  $('#scategory').removeAttr("disabled")
                  var HTML = "<option value=''>Select One</option>";
                  for (var key in data) 
                    {
                    if(data.hasOwnProperty(key))
                      {
                      HTML +="<option value='"+data[key]["scatid"]+"'>" + data[key]["scatName"]+"</option>";
                    }}
                  $("#scategory").html(HTML);
                  $("#scategory").select2();
                  },
                error:function(data){
                  alert('error');
                  }
                });
            });
          });
      </script>