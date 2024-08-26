<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Purchase</li>
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
                <h3 class="card-title">Purchase Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("PurchaseOne/savedPurchaseOne") ?>">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Purchase Date *</label>
                        <input type="text" name="purchaseDate" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                        <label style="padding-left:10px;">Purchased through</label>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Order Date *</label>
                        <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Of The Institute *</label>
                        <input type="text" name="istitudeP" class="form-control" value="Items mentioned below for the requirements of the department/branch/committee of the institute" required >
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <label>Work Order No. *</label>
                        <input type="text" name="workNO" class="form-control" placeholder="Work Order No." required >
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <label>With the approval of the authority, M/s  *</label>
                        <input type="text" name="permitName" class="form-control" placeholder="With the approval of the authority, M/s" required >
                      </div>
                      <div class=" col-md-4 col-sm-4 col-xs-12">
                        <label>Address *</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required >
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Memo No *</label>
                        <input type="text" name="memoNO" class="form-control" placeholder="Memo No" required >
                      </div>
                      
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Select Product *</label>
                        <select id="products" class="form-control select2" >
                          <option value="">Select One</option>
                          <?php foreach($product as $value){ ?>
                          <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div><br>
                    
                    <div class="row">
                        <table id="mtable" class="table table-bordered table-striped">
                          <thead class="btn-default">
                            <tr>
                              <th>Product</th>    
                              <th>Quantity</th>
                              <th>Unit Type</th>
                              <th>Unit Price</th>
                              <th>Total Price</th>
                              <th>Note</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="mtable">

                          </tbody>
                          <tbody>
                            <tr>
                              <td colspan="4" align="right">Total Price *</td>
                              <td><input type="text" class="form-control" name="totalPrice" id="totalPrice" required readonly ></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                      
                    <div class="row">
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
                      <div class="form-group col-md-4 col-sm-4 col-12 ">
                        <label>Note</label>
                        <textarea type="text" class="form-control" name="note" placeholder="If have any note" rows="1" ></textarea>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Name of Purchaser. *</label>
                        <input type="text" name="purchaseName" class="form-control" placeholder="Name of Purchaser" required >
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Designation. *</label>
                        <input type="text" name="podobi" class="form-control" placeholder="Designation" required >
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Entry No. *</label>
                        <input type="text" name="entryVuktiDate" class="form-control" placeholder="Designation" required >
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Receive Date *</label>
                        <input type="text" name="lastDate" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                      </div><br>
                      
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="checkbox" name="passed" >&nbsp;<label>Quality check passed, acceptable.</label>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="checkbox" name="missing" >&nbsp;<label>Some products missing, acceptable as noted in comments.</label>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="checkbox" name="ordered" >&nbsp;<label>Not as ordered, unacceptable, canceled.</label>
                      </div>
                    </div>
                                        
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                      <a href="<?php echo site_url('Purchase') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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

    <div id="supplier_add" class="modal fade bs-example-modal-supplier_add" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Supplier Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
            <div class="col-md-12 col-sm-12 col-12">
            <div class="row">
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Supplier Name *</label>
                <input type="text" class="form-control" name="supplierName" id="supplierName" placeholder="Supplier Name" required >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Supplier Company</label>
                <input type="text" class="form-control" name="compname" id="compname" placeholder="Supplier Company" >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Contact Number *</label>
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="example@sunshine.com" >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Address" >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Opening Balance</label>
                <input type="text" class="form-control" name="balance" id="balance" onkeypress="return isNumberKey(event)" placeholder="Amount" >
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

    <!--<div id="product_add" class="modal fade bs-example-modal-product" tabindex="-1" role="dialog" aria-hidden="true">-->
    <!--  <div class="modal-dialog modal-sm">-->
    <!--    <div class="modal-content">-->
    <!--      <div class="modal-header">-->
    <!--        <h4 class="modal-title">Product Information</h4>-->
    <!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>-->
    <!--      </div>-->
    <!--      <div class="col-md-12 col-sm-12 col-12">-->
    <!--        <div class="row">-->
    <!--          <div class="form-group col-md-12 col-sm-12 col-12">-->
    <!--            <label>Product Name *</label>-->
    <!--            <input type="text" class="form-control" name="productName" id="productName" placeholder="Product Name" required >-->
    <!--          </div>-->
    <!--          <div class="form-group col-md-12 col-sm-12 col-12">-->
    <!--            <label>Select category *</label>-->
    <!--            <select name="categoryID" id="categoryID" class="form-control" required >-->
    <!--              <option value="">Select One</option>-->
    <!--              <?php foreach($category as $value) { ?>-->
    <!--              <option value="<?php echo $value['categoryID']; ?>"><?php echo $value['categoryName']; ?></option>-->
    <!--              <?php } ?>-->
    <!--            </select>-->
    <!--          </div>-->
    <!--          <div class="form-group col-md-12 col-sm-12 col-12">-->
    <!--            <label>Select Unit *</label>-->
    <!--            <select name="unit" id="unit" class="form-control" required >-->
    <!--              <option value="">Select One</option>-->
    <!--              <?php  foreach($unit as $value) { ?>-->
    <!--              <option value="<?php echo $value['id']; ?>"><?php echo $value['unitName']; ?></option>-->
    <!--              <?php } ?>-->
    <!--            </select>-->
    <!--          </div>-->
    <!--          <div class="form-group col-md-12 col-sm-12 col-12">-->
    <!--            <label>Purchases Price *</label>-->
    <!--            <input type="text" class="form-control" id="pprice" name="pprice" placeholder="Purchase price" onkeypress="return isNumberKey(event)" required >-->
    <!--          </div>-->
    <!--          <div class="form-group col-md-12 col-sm-12 col-12">-->
    <!--            <label>Sale Price *</label>-->
    <!--            <input type="text" class="form-control" id="sprice" name="sprice" placeholder="Sale price" onkeypress="return isNumberKey(event)" required >-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="modal-footer">-->
    <!--        <button type="submit" class="btn btn-primary" id="psubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>-->
    <!--        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

<?php $this->load->view('footer/footer'); ?>

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
              var HTML = "";
              for (var key in data) 
                {
                if (data.hasOwnProperty(key))
                  {
                  HTML +="<option value='"+data[key]["supplierID"]+"'>" + data[key]["supplierName"]+' ( '+ data[key]["sup_id"]+' )'+"</option>";
                  }
                }
              $("#suppliers").html(HTML);
              },
            error:function(data){
               alert('error');
              }
            });
          }

        $("#pbsubmit").click(function(){
          var supplierName = $("#supplierName").val();
          var compname = $("#compname").val();
          var mobile = $("#mobile").val();
          var email = $("#email").val();
          var address = $("#address").val();
          var balance = $("#balance").val();
          var dataString = 'supplierName='+ supplierName + '&compname='+ compname + '&mobile='+ mobile + '&email='+ email + '&address='+ address + '&balance='+ balance;
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Supplier/save_supplier') ?>",
            data: dataString,
            cache: false,
            success: function(result){
              //alert(result);
              load_suppliers();
              $('#supplier_add').remove();
              $('.modal-backdrop').remove();
              window.location.reload();
              }
            });
          return false;
        });
      });
    </script>
    
    <script type="text/javascript">
    //   $(document).ready(function() {
    //     $('#suppliers').change(function() {
    //       var url = "<?php echo base_url(); ?>Purchase/get_purchase_product";
    //       var id = $('#suppliers').val() ;
    //         // alert(url);
    //         // alert(id);
    //       $.ajax({
    //         method: "POST",
    //         url     : url,
    //         dataType: 'json',
    //         data    : {"id" : id},
    //         success:function(data){ 
    //             //alert(data);
    //           $('#products').removeAttr("disabled")
    //           var HTML = "<option value=''>Select One</option>";
    //           for (var key in data) 
    //             {if (data.hasOwnProperty(key)) {
    //               HTML +="<option value='"+data[key]["productID"]+"'>" + data[key]["productName"]+' ( '+ data[key]["productcode"]+' )'+"</option>";
    //             }}
    //           $("#products").html(HTML);
    //           },
    //         error:function(data){
    //           alert('error');
    //           }
    //         });
    //       });
    //     });
    </script>

    <script type="text/javascript" >
    //   $(function(){
    //     load_products();
    //     function load_products(){
    //       var url = "<?php echo base_url()?>Purchase/get_purchase_product";
    //       //alert(url);
    //       $.ajax({
    //         type:'POST',
    //         url: url,       
    //         dataType: 'json',
    //         success:function(data){ 
    //         //alert(data);
    //           var HTML = "<option value=''>Select One</option>";
    //           for (var key in data) 
    //             {
    //             if (data.hasOwnProperty(key))
    //               {
    //               HTML +="<option value='"+data[key]["productID"]+"'>" + data[key]["productName"]+' ( '+ data[key]["productcode"]+' )'+"</option>";
    //               }
    //             }
    //           $("#products").html(HTML);
    //           },
    //         error:function(data){
    //           alert('error');
    //           }
    //         });
    //       }

    //     $("#psubmit").click(function(){
    //       var productName = $("#productName").val();
    //       var categoryID = $("#categoryID").val();
    //       var unit = $("#unit").val();
    //       var pprice = $("#pprice").val();
    //       var sprice = $("#sprice").val();
    //       var dataString = 'productName='+ productName + '&categoryID='+ categoryID + '&unit='+ unit + '&pprice='+ pprice + '&sprice='+ sprice;
    //       // AJAX Code To Submit Form.
    //       $.ajax({
    //         type: "POST",
    //         url: "<?php echo site_url('Product/add_product') ?>",
    //         data: dataString,
    //         cache: false,
    //         success: function(result){
    //           //alert(result);
    //           load_products();
    //           $('#product_add').remove();
    //           $('.modal-backdrop').remove();
    //           }
    //         });
    //       return false;
    //     });
    //   });
    </script>

    <script type="text/javascript" >
      function deleteProduct(o){
        var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);
         
        calculatePrice();
        calculate_remain();
        }
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#products').change(function(){    
          var id = $('#products').val();
            // alert(id);
          var base_url = '<?php echo base_url() ?>'+'PurchaseOne/get_Product/'+id;
                // alert(base_url);
          $.ajax({
            type: 'GET',
            url: base_url,
            dataType: 'text',
            success: function(data){
                  var jsondata = JSON.parse(data);                
                  $('#mtable').append(jsondata);
                  calculatePrice();
              
              }
            });
          });
        });
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

    <script type="text/javascript">
        function getTotal(id) {        
            var quantity = $('#quantity_'+id).val();
            var tp = $('#tp_'+id).val();
        // alert(tp);
        // alert(quantity);
            var totalPrice = quantity*parseFloat(tp);
            $('#totalPrice_' + id).val(parseFloat(totalPrice).toFixed(2));
            
            calculatePrice();
            }

        function calculatePrice() {
            var sum = 0;
            $("input[name='total_price[]']").each(function () {
                sum += parseFloat($(this).val());
            });
            $('#totalPrice').val(parseFloat(sum).toFixed(2));
            $('#tsAmount').val(parseFloat(sum).toFixed(2));
            $('#nAmount').val(parseFloat(sum).toFixed(2));
            // $('#Paid').val(parseFloat(sum).toFixed(2));

            // $('#remainging').val(totalPrice);
            calculate_remain();
            vatcostcalculator();
            discountType();
            }

        function calculate_remain(){
            var paid = $('#Paid').val();
            var total = $('#totalPrice').val();
            var remaining = parseFloat(total).toFixed(2)-parseFloat(paid).toFixed(2);
            $('#remainging').val(remaining);
            }
    </script>
    
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


    