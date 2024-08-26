<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Work Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Work Orders</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Work Order Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Purchase/update_purchase") ?>">
                  <div class="row">
                    <input type="hidden" name="puid" value="<?php echo $purchase['puid']; ?>" required >
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Order Date</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($purchase['puDate'])) ?>" required >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Memo No. *</label>
                      <input type="text" class="form-control" name="memoNo" value="<?php echo $purchase['memoNo']; ?>" required >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Select Supplier *</label>
                      <select class="form-control select2" name="supplier" required >
                        <option value="">Select One</option>
                        <?php foreach ($supplier as $value) { ?>
                        <option <?php echo ($purchase['supid'] == $value['supid'])?'selected':''?> value="<?php echo $value['supid']; ?>" ><?php echo $value['supCName'].' ( '.$value['supCode'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Select Products</label>
                      <select  class="form-control select2" id="products" >
                        <option value="">Select One</option>
                        <?php foreach($product as $value){ ?>
                        <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-12">
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Products</th>
                          <th>Quantity</th>
                          <th>Unit Price</th>
                          <th>Total Price</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php foreach($pproduct as $value){
                        $id = $value['pid'];
                        ?>
                        <tr>
                          <td>
                            <?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?>
                            <input type="hidden" name='product[]' value="<?php echo $value['pid']; ?>" required >
                          </td> 
                          <td>
                            <input type='text' class="form-control" name='quantity[]' id="quantity_<?php echo $value['pid']?>" onkeyup="getTotal('<?php echo $id ?>')"  value="<?php echo $value['quantity']; ?>" required >
                          </td>
                          <td>
                            <input type='text' onkeyup='getTotal(<?php echo $value['pid']; ?>)' id='uprice_<?php echo $id; ?>' name='uprice[]' value='<?php echo $value['pprice']?>' required >
                          </td>
                          <td>
                            <input type='text' class='tprice' id='tprice_<?php echo $id; ?>' name='tprice[]' value='<?php echo $value['tprice']; ?>' readonly >
                          </td>
                          <td>
                            <span class='item_remove btn btn-danger btn-xs' onclick='deleteProduct(this)'>x</span>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>  
                  </div>    

                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Total Amount *</label>
                      <input type="text" class="form-control" name="tAmount" id="tAmount" value="<?php echo $purchase['tAmount']; ?>" required readonly  >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Note</label>
                      <input type="text" class="form-control" name="note" value="<?php echo $purchase['note']; ?>" >
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <a href="<?php echo site_url('workOrder'); ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
            //alert(id);
          var base_url = '<?php echo base_url() ?>'+'Purchase/get_Product/'+id;
                // alert(base_url);
          $.ajax({
            type: 'GET',
            url: base_url,
            dataType: 'text',
            success: function(data){
              var jsondata = JSON.parse(data);                
              $('#mtable').append(jsondata);

              $('#products').val('');
              }
            });
          });
        });
    </script>

    <script type="text/javascript" >
      function deleteProduct(o){
        var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);
         
        calculatePrice();
        }
    </script>

    <script type="text/javascript">
      function getTotal(id)
        {
        var tp = $('#uprice_' + id).val();
        var quantity = $('#quantity_' + id).val();

        var totalPrice = parseFloat(quantity) * parseFloat(tp);
        $('#tprice_' + id).val(parseFloat(totalPrice).toFixed(2));

        calculatePrice();
        }

      function calculatePrice()
        {
        var sum=0;
        $(".tprice").each(function()
          {
          sum += parseFloat($(this).val());
          });
        $('#tAmount').val(parseFloat(sum).toFixed(2));
        }
    </script>