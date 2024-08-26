<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>
 <style>
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .form-group label {
            margin-right: 10px;
        }
        .form-group .form-control {
            flex: 1;
        }
    </style>
  <div class="content-wrapper">
    <!--<section class="content-header">-->
    <!--  <div class="container-fluid">-->
    <!--    <div class="row mb-2">-->
    <!--      <div class="col-sm-6">-->
    <!--        <h1>Purchase</h1>-->
    <!--      </div>-->
    <!--      <div class="col-sm-6">-->
    <!--        <ol class="breadcrumb float-sm-right">-->
    <!--          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>-->
    <!--          <li class="breadcrumb-item active">Purchase</li>-->
    <!--        </ol>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</section>-->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Purchase Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("PurchaseOne/update_purchase") ?>">
                  <div class="row">
                    <input type="hidden" name="purhcase_id" value="<?php echo $purchase['insPurID']; ?>" required >
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Purchase Date</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($purchase['purchaseDate'])) ?>" required >
                    </div>
                    <div class="form-group" style="padding-top:10px;padding-left:10px;">
                        <label>Of The Institute *</label>
                        <input type="text" name="istitudeP" class="form-control" placeholder="Items mentioned below for the requirements of the department/branch/committee of the institute" value="<?php echo $purchase['istitudeP']; ?>" required>
                        <label style="padding-left:10px;">Items mentioned below for the requirements of the department/branch/committee</label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Work Order No. *</label>
                        <input type="text" name="workNO" class="form-control" placeholder="Work Order No."value="<?php echo $purchase['workNO']; ?>" required>
                       
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>With the approval of the authority, M/s  *</label>
                        <input type="text" name="permitName" class="form-control" placeholder="With the approval of the authority, M/s" value="<?php echo $purchase['permitName']; ?>" required>
                        
                    </div>
                    <div class=" col-md-12 col-sm-12 col-xs-12">
                        <label>Address *</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" value="<?php echo $purchase['address']; ?>" required>
                        
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Memo No *</label>
                        <input type="text" name="memoNO" class="form-control" placeholder="Memo No" value="<?php echo $purchase['memoNO']; ?>" required>
                        
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12" style="padding-top:10px;padding-left:10px;">
                        <label>Purchase Date *</label>
                        <input type="text" name="purchaseDate" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" value="<?php echo $purchase['purchaseDate']; ?>" required >
                        <label style="padding-left:10px;">Purchased through</label>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Product</label>                        
                      <select name = "productID" id="products" class="form-control select2" >
                        <option value="">Select One</option>
                        <?php foreach($product as $value){ ?>
                        <option value="<?php echo $value['pid']; ?>"><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="col-md-12 col-sm-12 col-12">
                      <table id="mtable" class="table table-bordered table-striped">
                        <thead class="btn-default">
                          <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th style="width:30%;">Unit Type</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Note</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                          <?php $sl = 0; foreach($pproduct as $value){
                          $id = $value['product_id'];
                          ?>
                          <tr>
                            <td>
                              <?php echo $value['pName']; ?>
                              <input type="hidden" readonly='readonly' name='product_id[]' value="<?php echo $value['product_id']; ?>">
                            </td>
                            <td>
                              <input class="form-control" type='text' class="form-control" id="quantity_<?php echo $value['product_id']?>" onkeyup="getTotal('<?php echo $id ?>')" name='quantity[]' value="<?php echo $value['quantity']; ?>">
                            </td>
                            <td >
                                <div class="form-group " >
                                                 
                              <select name='unit[]' id="unit_[]" class="form-control select2" >
                                <option value="">Select One</option>
                                <?php foreach($expense as $valueOne){ ?>
                                <option <?php echo ($value['unit'] == $valueOne['untid'])?'selected':''?> value="<?php echo $valueOne['untid']; ?>"><?php echo $valueOne['unitName']; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            </td>
                            
                            <td>
                              <input class="form-control" type='text' onkeyup='getTotal(<?php echo $value['product_id']?>)' id='tp_<?php echo $id; ?>' name='pprice[]' value='<?php echo $value['pprice']?>' required >
                            </td>
                            <td>
                              <input class="form-control" readonly='readonly' type='text' id='totalPrice_<?php echo $id; ?>' name='total_price[]' value='<?php echo $value['total_price'];  $sl += $value['total_price'];?>'>
                            </td>
                            <td>
                              <input class="form-control" type='text' name='noteOne[]' value='<?php echo $value['noteOne'];?>'>
                            </td>
                            <td>
                              <span class="item_remove btn btn-danger btn-sm" onClick="$(this).parent().parent().remove();"><i class='fa fa-trash'></i></span>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                        <tbody>
                           
                            <tr>
                              <td colspan="4" align="right">Total Price *</td>
                              <td><input type="text" class="form-control" name="totalPrice" id="totalPrice" required readonly value="<?php echo $purchase['totalPrice'];?>"></td>
                              <td></td>
                            </tr>
                           
                        </tbody>
                      </table>  
                    </div>    

                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Account Type *</label>
                      <select class="form-control" name="accountType" id="accountType" required >
                        <option <?php echo ($purchase['accountType'] == 'Cash')?'selected':''?> value="Cash">Cash</option>
                        <option <?php echo ($purchase['accountType'] == 'Bank')?'selected':''?> value="Bank">Bank</option>
                        <option <?php echo ($purchase['accountType'] == 'Mobile')?'selected':''?> value="Mobile">Mobile</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Account Number *</label>
                      <select name="accountNo" id="accountNo" class="form-control" required >
                          <option value="">Select Account Type First</option>
                      </select>
                    </div>
                    
                    <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                    <!--  <label>Shipment Company</label>-->
                    <!--  <input type="text" class="form-control" name="sCompany" value="<?php echo $purchase['sCompany']; ?>" >-->
                    <!--</div>-->
                    <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                    <!--  <label>Shipment Persion</label>-->
                    <!--  <input type="text" class="form-control" name="sName" value="<?php echo $purchase['sName']; ?>" >-->
                    <!--</div>-->
                    <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                    <!--  <label>Shipment Contact Number</label>-->
                    <!--  <input type="text" class="form-control" name="sMobile" value="<?php echo $purchase['sMobile']; ?>" >-->
                    <!--</div>-->
                    <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                    <!--  <label>Shipment Address</label>-->
                    <!--  <input type="text" class="form-control" name="sAddress" value="<?php echo $purchase['sAddress']; ?>" >-->
                    <!--</div>-->
                    
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Note</label>
                      <textarea type="text" class="form-control" name="note" placeholder="If have any note" rows="1" ><?php echo $purchase['note']; ?></textarea>
                    </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Name of Purchaser. *</label>
                        <input type="text" name="purchaseName" class="form-control" placeholder="Name of Purchaser" value="<?php echo $purchase['purchaseName']; ?>"required>
                        
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Designation. *</label>
                        <input type="text" name="podobi" class="form-control" placeholder="Designation" value="<?php echo $purchase['podobi']; ?>" required>
                        
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Entry No. *</label>
                        <input type="text" name="entryVuktiDate" class="form-control" placeholder="Designation" value="<?php echo $purchase['entryVuktiDate']; ?>" required>
                        
                    </div>
                      <div class=" col-md-6 col-sm-6 col-xs-12">
                        <label>Date *</label>
                        <input type="text" name="lastDate" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($purchase['lastDate'])) ?>" required >
                      </div>
                    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input type="checkbox" name="passed" <?php if($purchase['passed'] == 1){ ?>checked<?php } ?> >&nbsp;<label>Quality check passed, acceptable.</label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="checkbox" name="missing" <?php if($purchase['missing'] == 1){ ?>checked<?php } ?> >&nbsp;<label>Some products missing, acceptable as noted in comments.</label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="checkbox" name="ordered" <?php if($purchase['ordered'] == 1){ ?>checked<?php } ?> >&nbsp;<label>Not as ordered, unacceptable, canceled.</label>
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <a href="<?php echo site_url('Purchase') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
<script type="text/javascript" >
      function deleteProduct(o){
        var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);
         
        calculatePrice();
        calculate_remain();
        }
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

    <script type="text/javascript">
      $(document).ready(function(){
        $('#products').change(function(){    
          var id = $('#products').val();
            //alert(id);
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
            $('#accountNo').val("<?php echo $purchase['accountNo'] ?>");
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

    <!--<script type="text/javascript">-->

    <!--    function getTotal(id) {        -->
    <!--        var tp = $('#tp_'+id).val();-->
    <!--        var quantity = $('#quantity_'+id).val();-->
        <!--// alert(tp);-->
        <!--// alert(quantity);-->
    <!--        var totalPrice = parseFloat(quantity)*parseFloat(tp);-->
    <!--        $('#totalPrice_' + id).val(parseFloat(totalPrice).toFixed(2));-->
    <!--        calculatePrice();-->
    <!--        }-->

    <!--    function calculatePrice() {-->
    <!--        var totalPrice = Number(0),-->
    <!--        pruchaseCost;-->
    <!--        $("input[name='total_price[]']").each(function () {-->
    <!--            totalPrice = Number(parseFloat(totalPrice) + parseFloat($(this).val()));-->
    <!--        });-->
    <!--        $('#totalPrice').val(totalPrice.toFixed(2));-->

    <!--        $('#remainging').val(totalPrice);-->
    <!--        }-->

    <!--    function calculate_remain(){-->
    <!--        var paid = $('#Paid').val();-->
    <!--        var total = $('#totalPrice').val();-->
    <!--        var remaining = parseFloat(total).toFixed(2)-parseFloat(paid).toFixed(2);-->
    <!--        $('#remainging').val(remaining);-->
    <!--        }-->
    <!--</script>-->
    
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
        discountType();
        
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
        // calculate_remain();
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