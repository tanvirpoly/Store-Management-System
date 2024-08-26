<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Refund</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Refund</li>
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
                <h3 class="card-title">Refund Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Returns/save_returns" >
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Refund Date *</label>
                      <input type="text" class="form-control datepicker" name="date" value="<?php echo date('m/d/Y'); ?>" required >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Requisition No. *</label>
                      <input type="text" class="form-control" name="invoice" value="<?php echo $returns['rInvoice']; ?>" required readonly >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Reference *</label>
                      <input type="text" class="form-control" name="reference" value="<?php echo $returns['reference']; ?>" readonly >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Employee *</label>
                      <input type="hidden" name="employee" value="<?php echo $returns['regby']; ?>" required >
                      <input type="text" class="form-control" value="<?php echo $returns['uName']; ?>" readonly >
                    </div>
                    <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                    <!--  <label>Select Product</label>-->
                    <!--  <select name="productID" id="productID" class="form-control select2" >-->
                    <!--    <option value="">Select One</option>-->
                    <!--    <?php foreach($product as $value): ?>-->
                    <!--    <option value="<?php echo $value['productID']; ?>"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></option>-->
                    <!--    <?php endforeach?>-->
                    <!--  </select>-->
                    <!--</div>-->
                  </div>

                  <div class="col-md-12 col-sm-12 col-12">
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Products</th>
                          <th>Stock</th>
                          <th>Request</th>
                          <th>Approved</th>
                          <th>Delivered</th>
                          <th>Returned</th>
                          <th>Return</th>
                          <th>Unit</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php foreach($rproduct as $value){
                        $id = $value['pid'];
                    
                        if($value['refundable'] == 1){
                        
                        $mp = $this->db->select('quantity')
                                  ->from('delivery_product')
                                  ->where('pid',$value['pid'])
                                  ->where('did',$value['did'])
                                  ->get()
                                  ->row();
                        if($mp)
                          {
                          $tdqnt = $mp->quantity;
                          }
                        else
                          {
                          $tdqnt = 0;
                          }
                          
                        $stock = $this->db->select('tquantity')
                                  ->from('stock')
                                  ->where('pid',$value['pid'])
                                  ->get()
                                  ->row();
                        if($stock)
                          {
                          $tstock = $stock->tquantity;
                          }
                        else
                          {
                          $tstock = 0;
                          }
                          $rt = $this->db->select('SUM(quantity) as rtq, returns.invoice')
                                  ->from('returns_product')
                                  ->join('returns', 'returns.returnId = returns_product.rt_id', 'left')
                                  ->where('returns.invoice',$returns['rInvoice'])
                                  ->where('productID',$value['pid'])
                                  ->get()
                                  ->row();
                        if($rt->rtq > 0)
                          {
                          $trtq = $rt->rtq;
                          }
                        else
                          {
                          $trtq = 0;
                          }
                        ?>
                        <tr>
                          <td>
                            <?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?>
                            <input type="hidden" name='product[]' id="pid_<?php echo $value['pid']?>" value="<?php echo $value['pid']; ?>" required >
                          </td>
                          <td><?php echo $tstock; ?></td>
                          <td><?php echo $tdqnt; ?></td>
                          <td><?php echo $value['quantity']; ?></td>
                          <td id="delivered">
                            <?php echo $value['quantity']; ?>
                          </td>
                          <td id="returned">
                            <?php echo $trtq; ?>
                          </td>
                          <td>
                            <input type='text' class="form-control" name='quantity[]' id="quantity_<?php echo $value['pid']?>" onkeyup="limit(<?= $value['pid']?>)" value="<?php echo $value['quantity'] - $trtq; ?>" min="1" max="<?php echo $value['quantity']; ?>" required >
                            <span id='psNumber_<?php echo $id; ?>'></span>
                          </td>
                          <td><?php echo $value['unitName']; ?></td>   
                          <td>
                            <span class='item_remove btn btn-danger btn-xs' onclick='deleteProduct(this)'>x</span>
                            <span class='btn btn-success btn-xs' onclick='add_serial_number("<?php echo $id ?>")'>+</span>
                            <span class='btn btn-primary btn-xs' onclick='remove_serial_number("<?php echo $id ?>")' data-toggle="tooltip" title="Remove Serial Numbers" >-</span>
                          </td>
                        </tr>
                        <?php } }?>
                      </tbody>
                    </table>  
                  </div>    

                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Note</label>
                      <input type="text" class="form-control" name="note" value="<?php echo $returns['notes']; ?>" >
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px; text-align: center;">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <a href="<?php echo site_url('newReturn') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
    function limit(id) {
        var pices = $('#quantity_' + id).val();
        // var salePrice = $('#sprice_' + id).val();
        var delivered = $('#delivered').html();
        var returned = $('#returned').html();
    
        if (parseFloat(pices) > parseFloat(delivered - returned)) {
            document.getElementById('quantity_' + id).style.background="#FFCCCB";
            alert('Not enough delivered item');
            document.getElementById('quantity_' + id).value = 0;
    
        } else {
            document.getElementById('quantity_' + id).style.background = "white";
        }
    }
</script>

<script type="text/javascript">
      function add_serial_number(id){
        var id = $('#pid_'+id).val();
        var qnt = $('#quantity_'+id).val();
        var url = '<?php echo base_url() ?>'+'Sale/get_dproduct';
            //alert(id); alert(qnt); alert(url);
        $.ajax({
          type: 'POST',
          url: url,
          data : {"id" : id,"qnt" : qnt},
          dataType: 'json',
          success: function(data){
              //alert(data);
            //var jsondata = JSON.parse(data);
            $('#psNumber_'+id).html(data);
            }
          });
        }
    </script>
    
    <script type="text/javascript">
      function remove_serial_number(id){
        var HTML = '';
        //alert(HTML);
        $('#psNumber_'+id).html(HTML);
        }
    </script>

    <script type="text/javascript">
      $('#productID').on('change',function(){
        var productID = $('#productID option:selected').val();
        //alert(productID);
        var table = 'products';
        var info = {'id':productID,'table':table};
        var base_url = '<?php echo base_url() ?>' + 'Returns/getDetails/';
        
        $.ajax({
          type: 'POST',
          async: false,
          url: base_url,
          data:info,
          dataType: 'json',
          success: function (data) {                            
              $('#mtable tbody').append(data);
              }
          });
        });
    </script>

    <script type="text/javascript">

      function totalPrice(id){
        var pices = $('#pices_'+id).val();
        var salePrice = $('#salePrice_'+id).val();
        
        var totalPrice = (parseFloat(salePrice).toFixed(2)*pices);
        $('#totalPrice_'+id).val(parseFloat(totalPrice).toFixed(2));
        
        calculateTotalPrice();
        }

      function calculateTotalPrice() {
        var sum=0;
        $(".totalPrice").each(function(){
          sum += parseFloat($(this).val());
          });
        $('#totalprice').val(parseFloat(sum).toFixed(2));
        }
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        var value = $("#accountType").val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        $('#accountNo').val("<?php echo $returns['accountNo']; ?>");
        });

      var url = '<?php echo site_url('Voucher')?>';

      $('#accountType').on('change',function(){
        var value = $(this).val();
        $('#accountNo').empty();
        getAccountNo(value,'#accountNo');
        });

        function getAccountNo(value,place){
          $(place).empty();
          if(value != '')
            {
            $.ajax({
              url: url+'/getAccountNo',
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
          else {
            $.alert({
              title: 'Alert!',
              content: 'Please Select Account Type',
              type: "red",
              icon: 'fa fa-warning',
              theme: "material",
              });
            }
        }
    </script>

    <script type="text/javascript">
      function discountType(){
        var disc = $('#scharge').val();
        var discc = disc.slice(-1);
        var disca = disc.substring(0, disc.length - 1);
        //alert(disca);
        $('#sctype').val(discc);
        $('#scAmount').val(disca);
        }
    </script>