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
                <h3 class="card-title">Products Physical Count Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Product/save_store_adjustment"); ?>">
                  <div class="col-md-12 col-sm-12 col-12">
                    <!--<div class="row">-->
                    <!--  <div class="form-group col-md-4 col-sm-4 col-12">-->
                    <!--    <label>Select Products *</label>-->
                    <!--    <select class="form-control select2" id="products" >-->
                    <!--      <option value="">Select One</option>-->
                    <!--      <?php foreach($product as $value){ ?>-->
                    <!--      <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>-->
                    <!--      <?php } ?>-->
                    <!--    </select>-->
                    <!--  </div>-->
                    <!--</div>-->
                        
                    <div class="col-md-12 col-sm-12 col-12">
                      <table class="table table-bordered table-striped">
                        <thead class="btn-default">
                          <tr>
                            <th>Products</th>
                            <th>Current Stock</th>
                            <th>Physical Count</th>
                            <th>Loss</th>
                            <th>Remarks</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="mtable">
                          <?php foreach($product as $value){
                          $id = $value['pid'];

                          $pp = $this->db->select('tquantity')
                                  ->from('stock')
                                  ->where('pid',$id)
                                  ->get()
                                  ->row();
                          if($pp)
                            {
                            $tsqnt = $pp->tquantity;
                            }
                          else
                            {
                            $tsqnt = 0;
                            }
                          ?>
                          <tr>
                            <td>
                              <?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?>
                              <input type="hidden" name='product[]' value="<?php echo $value['pid']; ?>" required >
                            </td>
                            <td>
                              <input type='text' class="form-control" name='cstock[]' id='cstock_<?php echo $id; ?>'  value="<?php echo $tsqnt; ?>" required readonly >
                            </td>
                            <td>
                              <input type='text' class="form-control" name='pcount[]' id='pcount_<?php echo $id; ?>'  onkeyup='totalPrice(<?php echo $id ?>)' value="0" required >
                            </td>
                            <td>
                              <input type='text' class="form-control" name='quantity[]' id='quantity_<?php echo $id; ?>'  value="0" required readonly >
                            </td>
                            <td>
                              <input type='text' class="form-control" name='remarks[]' id='remarks_<?php echo $id; ?>'>
                            </td>
                            <td>
                              <span class="item_remove btn btn-danger btn-sm" onClick="$(this).parent().parent().remove();">x</span>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>           
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;SUBMIT</button>
                      <a href="<?php echo site_url('productAdjust'); ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;BACK</a>
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

<?php $this->load->view('footer/footer'); ?>

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

    <script type="text/javascript">
      function totalPrice(id)
        {
        var pices = $('#cstock_'+id).val();
        var salePrice = $('#pcount_'+id).val();

        var totalPrice = pices-salePrice;
        $('#quantity_'+id).val(parseFloat(totalPrice).toFixed(2));
        }
    </script>
