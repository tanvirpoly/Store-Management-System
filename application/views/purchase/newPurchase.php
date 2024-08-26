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
                <form method="POST" action="<?php echo site_url("Purchase/save_purchase"); ?>">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-3 col-sm-3 col-xs-12">
                        <label>Order Date *</label>
                        <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-xs-12">
                        <label>Memo/Challan No. *</label>
                        <input type="text" class="form-control" name="memoNo" placeholder="Memo Random" required >
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Select Supplier *</label>
                        <div class="input-group">
                          <select class="form-control select2" name="supplier" id="supplier" required >
                          </select>
                          <span class="input-group-append" style="margin-left:-20px;">
                            <button type="button" style="position: absolute; height: -webkit-fill-available;" class="btn btn-danger btn-sm addSupp" data-toggle="modal" data-target=".bs-example-modal-addSupp" ><i class="fa fa-plus"></i></button>
                          </span>
                        </div>
                      </div>
                      <!--<div class="form-group col-md-3 col-sm-3 col-12">-->
                      <!--  <label>Select Supplier *</label>-->
                      <!--  <select class="form-control select2" name="supplier" required >-->
                      <!--    <option value="">Select One</option>-->
                      <!--    <?php foreach($supplier as $value){ ?>-->
                      <!--    <option value="<?php echo $value['supid']; ?>"><?php echo $value['supCName'].' ( '.$value['supCode'].' )'; ?></option>-->
                      <!--    <?php } ?>-->
                      <!--  </select>-->
                      <!--</div>-->
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Select Products *</label>
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
                        <tbody id="mtable">

                        </tbody>
                        <tbody>
                            <!--       <tr>-->
                            <!--    <td colspan="3" align="right" >VAT (%)</td>-->
                            <!--    <td>-->
                            <!--      <input type="hidden" class="form-control" id="tsAmount"  value="0" required >-->
                            <!--      <input type="text" class="form-control" name="vCost" id="vCost" onkeyup="vatcostcalculator()" value="0" >-->
                            <!--      <input type="hidden" class="form-control" name="vType" id="vType" value="0" >-->
                            <!--      <input type="hidden" class="form-control" name="vAmount" id="vAmount" value="0" >-->
                            <!--    </td>-->
                            <!--    <td></td>-->
                            <!--  </tr>-->
                            <!--  <tr>-->
                            <!--    <td colspan="3" align="right" >Net Amount</td>-->
                            <!--    <td>-->
                            <!--      <input type="text" class="form-control" name="nAmount" id="nAmount" required readonly >-->
                            <!--    </td>-->
                            <!--    <td></td>-->
                            <!--  </tr>-->
                            <!--  <tr>-->
                            <!--    <td colspan="3" align="right" >Discount</td>-->
                            <!--    <td>-->
                            <!--      <input type="text" class="form-control" name="discount" id="discount" onkeyup="discountType()" value="0" >-->
                            <!--      <input type="hidden" class="form-control" id="disType" name="disType" value="0" >-->
                            <!--      <input type="hidden" class="form-control" id="disAmount" name="disAmount" value="0" >-->
                            <!--    </td>-->
                            <!--    <td></td>-->
                            <!--</tr>-->
                            <tr>

                              
                                 <td colspan="3" align="right">Total Amount *</td>
                                 <td><input type="text" class="form-control" name="tAmount" id="tAmount" value="0" required readonly ></td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Paid Amount *</td>
                              <td><input type="text" class="form-control" name="Paid" value="0" onkeyup="calculate_remain()" id="Paid" value="0" required ></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Due Amount *</td>
                              <td><input type="text" class="form-control" name="due" id="remainging" readonly ></td>
                              <td></td>
                            </tr>
                          </tbody>
                      </table>
                    </div>

                    <div class="row">
                      
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note" placeholder="If have any note">
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Account Type *</label>
                        <select class="form-control" name="accountType" id="accountType" required >
                          <option value="Cash">Cash</option>
                          <option value="Bank">Bank</option>
                          <option value="Mobile">Mobile</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Account Number *</label>
                        <select name="accountNo" id="accountNo" class="form-control" required >
                          <option value="">Select Account Type First</option>
                        </select>
                      </div>
                    </div>  
                    
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                      <a href="<?php echo site_url(); ?>workOrder" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
  
    <div id="supplier_add" class="modal fade bs-example-modal-addSupp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Supplier Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <div class="row">
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Supplier Name *</label>
                <input type="text" class="form-control" name="supName" id="supName" placeholder="Supplier Name" required >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Supplier Company</label>
                <input type="text" class="form-control" name="supCName" id="supCName" placeholder="Supplier Company" >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Contact Number *</label>
                <input type="text" class="form-control" name="supMobile" id="supMobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Email</label>
                <input type="email" class="form-control" name="supEmail" id="supEmail" placeholder="example@sunshine.com" >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Address</label>
                <input type="text" class="form-control" name="supAddress" id="supAddress" placeholder="Address" >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="pbsubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
          </div>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>
 <script type="text/javascript">
        $(document).ready(function(){
            var value = $("#accountType").val();
            $('#accountNo').empty();
            getAccountNo(value, '#accountNo');
            $('#accountNo').val(1);
            });
            
      $('#accountType').on('change',function(){
        var value = $(this).val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        });
        
        function getAccountNo(value,place){
          $(place).empty();
          if(value != ''){
            $.ajax({
              url: '<?php echo site_url()?>Voucher/getAccountNo',
              async: false,
              dataType: "json",
              data: 'id=' + value,
              type: "POST",
              success: function (data){
                $(place).append(data);
                $(place).trigger("chosen:updated");
                }
              });
            }
          else
            {
            customAlert('Please Select Account Type', "error", true);
            }
          }
    </script>
    <script type="text/javascript" >
      $(function(){
        load_suppliers();
        function load_suppliers(){
          var url = "<?php echo base_url()?>Purchase/get_purchase_supplier";
          //alert(url);
          $.ajax({
            type:'POST',
            url: url,       
            dataType: 'json',
            success:function(data){ 
            //alert(data);
              var HTML = "<option value=''>Select One</option>";
              for (var key in data) 
                {
                if (data.hasOwnProperty(key))
                  {
                  HTML +="<option value='"+data[key]["supid"]+"'>" + data[key]["supName"]+' ( '+ data[key]["supCode"]+' )'+"</option>";
                  }
                }
              $("#supplier").html(HTML);
              },
            error:function(data){
               alert('error');
              }
            });
          }

        $("#pbsubmit").click(function(){
          var supName = $("#supName").val();
          var supCName = $("#supCName").val();
          var supMobile = $("#supMobile").val();
          var supEmail = $("#supEmail").val();
          var supAddress = $("#supAddress").val();
          var dataString = 'supName='+ supName + '&supCName='+ supCName + '&supMobile='+ supMobile + '&supEmail='+ supEmail + '&supAddress='+ supAddress;
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Supplier/add_supplier') ?>",
            data: dataString,
            cache: false,
            success: function(result){
              //alert(result);
              load_suppliers();
              $('#supplier_add').remove();
              $('.modal-backdrop').remove();
              }
            });
          return false;
          });
        });
    </script>

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
        calculate_remain();
        }
         function calculate_remain(){
            var paid = $('#Paid').val();
            var total = $('#tAmount').val();
            var remaining = parseFloat(total).toFixed(2)-parseFloat(paid).toFixed(2);
            $('#remainging').val(remaining);
            }
    </script>
       <script type="text/javascript">
        $(document).ready(function(){
            var value = $("#accountType").val();
            $('#accountNo').empty();
            getAccountNo(value, '#accountNo');
            $('#accountNo').val(1);
            });
            
      $('#accountType').on('change',function(){
        var value = $(this).val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        });
        
        function getAccountNo(value,place){
          $(place).empty();
          if(value != ''){
            $.ajax({
              url: '<?php echo site_url()?>Voucher/getAccountNo',
              async: false,
              dataType: "json",
              data: 'id=' + value,
              type: "POST",
              success: function (data){
                $(place).append(data);
                $(place).trigger("chosen:updated");
                }
              });
            }
          else
            {
            customAlert('Please Select Account Type', "error", true);
            }
          }
    </script>

    // <script type="text/javascript">
    //     function getTotal(id) {        
    //         var quantity = $('#quantity_'+id).val();
    //         var tp = $('#tp_'+id).val();
    //     // alert(tp);
    //     // alert(quantity);
    //         var totalPrice = quantity*parseFloat(tp);
    //         $('#totalPrice_' + id).val(parseFloat(totalPrice).toFixed(2));
            
    //         calculatePrice();
    //         }

    //     function calculatePrice() {
    //         var sum = 0;
    //         $("input[name='total_price[]']").each(function () {
    //             sum += parseFloat($(this).val());
    //         });
    //         $('#totalPrice').val(parseFloat(sum).toFixed(2));
    //         $('#tsAmount').val(parseFloat(sum).toFixed(2));
    //         $('#nAmount').val(parseFloat(sum).toFixed(2));
    //         // $('#Paid').val(parseFloat(sum).toFixed(2));

    //         // $('#remainging').val(totalPrice);
    //         calculate_remain();
    //         vatcostcalculator();
    //         discountType();
    //         }

    //     function calculate_remain(){
    //         var paid = $('#Paid').val();
    //         var total = $('#totalPrice').val();
    //         var remaining = parseFloat(total).toFixed(2)-parseFloat(paid).toFixed(2);
    //         $('#remainging').val(remaining);
    //         }
    // </script>
    
    <script type="text/javascript">
      function shippingCost(){
        var sCost = 0;
        var total = $('#tsAmount').val();
        // var tdis = $('#disAmount').val();
        var tvat = $('#vAmount').val();
    //   console.log(sCost, total, tdis);
        var da = +sCost + +total;
        var dat = +da + +tvat;
            //alert(da);alert(dat);
        var total = dat;
            //alert(remaining);
        
        $('#nAmount').val(parseFloat(total).toFixed(2));
        $('#totalPrice').val(parseFloat(total).toFixed(2));
        // $('#Paid').val(parseFloat(total).toFixed(2));
        calculate_remain();
        }
    </script>
    
    <script type="text/javascript">
      function vatcostcalculator(){
        var vat = $('#vCost').val();
        var total = $('#tsAmount').val();
        var discc = vat.slice(-1);
        var disca = vat.substring(0, vat.length - 1);
        //alert(discc);
        $('#vType').val(discc);
        
        if(discc == '%')
          {
          var da = parseFloat(total).toFixed(2)*parseFloat(disca).toFixed(2);
          var dat = parseFloat(da).toFixed(2)/100;
            //alert(da);alert(dat);
          //var remaining = parseFloat(total).toFixed(2)-parseFloat(dat).toFixed(2);
            
          $('#vAmount').val(dat);
          }
        else
          {
          var remaining = parseFloat(total).toFixed(2)-parseFloat(vat).toFixed(2);
          $('#vAmount').val(vat);
          }
            //alert(remaining);
        shippingCost();
        }
    </script>
    
    <script type="text/javascript">
      function discountType(){
        var disc = $('#discount').val();
        var total = $('#nAmount').val();
        var discc = disc.slice(-1);
        var disca = disc.substring(0, disc.length - 1);
            //alert(discc);
        $('#disType').val(discc);
        
        if(discc == '%')
          {
          var da = parseFloat(total).toFixed(2)*parseFloat(disca).toFixed(2);
          var dat = parseFloat(da).toFixed(2)/100;
            //alert(da);alert(dat);
          var remaining = parseFloat(total).toFixed(2)-parseFloat(dat).toFixed(2);
            
          $('#disAmount').val(dat);
          }
        else
          {
          var remaining = parseFloat(total).toFixed(2)-parseFloat(disc).toFixed(2);
          $('#disAmount').val(disc);
          }
          //alert(remaining);
        
        $('#totalPrice').val(parseFloat(remaining).toFixed(2));
        // $('#Paid').val(parseFloat(remaining).toFixed(2));
        calculate_remain();
        }
    </script>