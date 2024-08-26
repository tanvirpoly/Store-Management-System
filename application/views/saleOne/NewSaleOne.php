<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sale</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Sale</li>
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
                <h3 class="card-title">Sale Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>SaleOne/saved_sale_one" >
                  <div class="row">
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Sale Date *</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Reference *</label>
                      <select class="form-control select2" name="reference" required >
                        <option value="">Select One</option>
                        <?php foreach($employee as $value){ ?>
                        <option value="<?php echo $value['empName']; ?>"><?php echo $value['empName'].' ( '.$value['empMobile'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Reference Note</label>
                      <input type="text" class="form-control" name="rnote" placeholder="Reference">
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Select Customer *</label>
                        <div class="input-group input-group-sm">
                          <select class="form-control select2" name="custid" id="custid" >
                            <option value="">Select One</option>
                            <?php foreach($Customer as $value){ ?>
                            <option value="<?php echo $value['custid']; ?>"><?php echo $value['custName']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                    </div>
					<div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Select Category *</label>
                        <div class="input-group input-group-sm">
                          <select class="form-control select2" name="categories" id="categories" >
                            <option value="">Select One</option>
                            <?php foreach($category as $value){ ?>
                            <option value="<?php echo $value['catid']; ?>"><?php echo $value['catName']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Select Product *</label>
                        <select name="pid" id="products" class="form-control select2" required >
                          <option value="">Select Category Frist</option>
                        </select>
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-12" >
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Product</th>
                          <th>Damage Stock</th>
                          <th>Quantity</th>
                          <th>Unit Price</th>
                          <th>Unit</th>
                          <th>Sub Total</th> 
                          <th>Action</th>                       
                        </tr>
                      </thead>
                      <tbody id="tbody">

                      </tbody>
                    </table>
                  </div>

                  <div class="row" >
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Total Amount *</label>
                      <input type="text" class="form-control" name="tAmount" id="tAmount" placeholder="Amount" required readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Note</label>
                      <input type="text" class="form-control" name="note" placeholder="If have any note">
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                    <a href="<?php echo site_url('sale'); ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
          var info = {'id':id};
          var base_url = '<?php echo base_url() ?>'+'SaleOne/getDetails/';
            //alert(id); alert(base_url);
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
              alert('NO DAMAGE STOCK AVAILABLE!!!');
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
        var salePrice = $('#uprice_'+id).val();

        var totalPrice = (parseFloat(salePrice).toFixed(2)*pices);
        $('#totalPrice_'+id).val(parseFloat(totalPrice).toFixed(2));
        
        calculateTotalPrice();
        }

      function calculateTotalPrice()
        {
        var sum=0;
        $(".totalPrice").each(function()
          {
          sum += parseFloat($(this).val());
          });
        $('#tAmount').val(parseFloat(sum).toFixed(2));
        }
    </script>
	    <script type="text/javascript">
      $(document).ready(function() {
        $('#categories').change(function() {
          var url = "<?php echo base_url(); ?>Sale/get_sale_product";
          var id = $('#categories').val() ;
            // alert(url);
            // alert(id);
          $.ajax({
            method: "POST",
            url     : url,
            dataType: 'json',
            data    : {"id" : id},
            success:function(data){ 
                //alert(data);
              $('#products').removeAttr("disabled")
              var HTML = "<option value=''>Select One</option>";
              for (var key in data) 
                {if (data.hasOwnProperty(key)) {
                  HTML +="<option value='"+data[key]["pid"]+"'>" + data[key]["pName"]+' ( '+ data[key]["pCode"]+' )'+"</option>";
                }}
              $("#products").html(HTML);
              },
            error:function(data){
              alert('error');
              }
            });
          });
        });
    </script>