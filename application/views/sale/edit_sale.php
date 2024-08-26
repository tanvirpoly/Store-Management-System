<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Requisition</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Requisition</li>
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
                <h3 class="card-title">Update Requisition Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Sale/update_sale" >
                  <input type="hidden" name="said" value="<?php echo $sale['said']; ?>" required >
                  <div class="row">
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Requisition  Date *</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y', strtotime($sale['saDate'])) ?>" required >
                    </div> 
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Reference</label>
                      <select class="form-control" name="reference" >
                        <option value="">Select One</option>
                        <?php foreach($employee as $value){ ?>
                        <option <?php echo ($sale['reference'] == $value['empName'])?'selected':''?> value="<?php echo $value['empName']; ?>"><?php echo $value['empName'].' ( '.$value['empMobile'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div> 
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Reference Note</label>
                      <input type="text" class="form-control" name="rnote" value="<?php echo $sale['rnote']; ?>" >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Select Product</label>
                      <select class="form-control select2" id="productID" >
                        <option value="">Select One</option>
                        <?php foreach($product as $value){ ?>
                        <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-12 col-12"  >
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Products</th>
                          <!--<th>Stock</th>-->
                          <th>Quantity</th>
                          <th>Unit</th>
                          <!--<th>Sub Total</th> -->
                          <th>Action</th> 
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php
                        $sl = 0;
                        foreach($salesp as $value){
                        $id = $value['pid'];
                        ?>
                        <tr>
                          <td>
                            <?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?>
                            <input type='hidden' name='product[]' value="<?php echo $value['pid']; ?>" required >
                          </td>   
                          <td>
                            <input type='text' onkeyup='totalPrice(<?php echo $id ?>)' name='quantity[]' id='quantity_<?php echo $id ?>' value="<?php echo $value['quantity']; ?>" required >
                          </td>
						  <td><?php echo $value['unitName']?></td>
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
                      <label>Note</label>
                      <input type="text" class="form-control" name="note" value="<?php echo $sale['note']; ?>" >
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <a href="<?php echo site_url('requisition') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
        $('#productID').change(function(){ 
          var id = $('#productID').val();
          var info = {'id':id};
          var base_url = '<?php echo base_url() ?>'+'Sale/getDetails/';
            //alert(id);
          $.ajax({
            type: 'POST',
            async: false,
            url: base_url,
            data:info,
            dataType: 'json',
            success: function (data)
              {
              $('#mtable tbody').append(data);
              },
            error:function(data){
              alert('Your stock is over');
              }
            });
          });
        });
    </script>

    <script type="text/javascript" >
      function deleteProduct(o){
        var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);
         
        calculateTotalPrice();
        }
    </script>

    <script type="text/javascript">
      function totalPrice(id)
        {
        var pices = $('#quantity_'+id).val();
        var salePrice = $('#sprice_'+id).val();

        var totalPrice = (parseFloat(salePrice).toFixed(2)*pices);
        $('#tprice_'+id).val(parseFloat(totalPrice).toFixed(2));
        
        calculateTotalPrice();
        }

      function calculateTotalPrice()
        {
        var sum=0;
        $(".tprice").each(function()
          {
          sum += parseFloat($(this).val());
          });
        $('#tAmount').val(parseFloat(sum).toFixed(2));
        }
    </script>