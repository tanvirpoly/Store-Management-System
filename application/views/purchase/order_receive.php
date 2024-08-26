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
                <h3 class="card-title">Order Receive Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Purchase/save_work_receive_order") ?>">
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Receive Date</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($purchase['puDate'])) ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Memo No. *</label>
                      <input type="text" class="form-control" name="memoNo" value="<?php echo $purchase['memoNo']; ?>" required readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Supplier *</label>
                      <input type="hidden" name="supplier" value="<?php echo $purchase['supid']; ?>" required >
                      <input type="text" class="form-control" value="<?php echo $purchase['supName']; ?>" readonly >
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-12">
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Products</th>
                          <th>Rack</th>
                          <th>Warranty / Expired</th>
                          <th>Order</th>
                          <th>Quantity</th>
                          <th>Unit Price</th>
                          <th>Total Price</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php 
                        $toq = 0;
                        foreach($pproduct as $value){
                        $id = $value['pid'];
                        
                        $mp = $this->db->select('SUM(receive_product.quantity) as total,receive_order.roMemo')
                                  ->from('receive_product')
                                  ->join('receive_order','receive_order.roid = receive_product.roid','left')
                                  ->where('pid',$value['pid'])
                                  ->where('roMemo',$value['memoNo'])
                                  ->get()
                                  ->row();
                        if($mp)
                          {
                          $tdqnt = $mp->total;
                          }
                        else
                          {
                          $tdqnt = 0;
                          }
                        $tqnt = ($value['quantity']-$tdqnt);
                        
                        $qnt = $value['quantity'];
    
                        ?>
                        <tr <?php if($tdqnt >= $value['quantity']){ ?>class="d-none"<?php } ?>>
                          <td>
                            <?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?>
                            <input type="hidden" name='product[]' value="<?php echo $value['pid']; ?>" id="pid_<?php echo $value['pid']; ?>" required >
                          </td>
                          <td>
                            <input type="text" class="form-control" name='rNumber[]' value="<?php echo $value['rNumber']; ?>" >
                          </td>
                          <td>
                            <input type="text" class="form-control datepicker" name='pWarranty[]' placeholder="Product Warranty" >
                            <span id='pWarranty_<?php echo $id; ?>'></span>
                          </td>
                          <td><?php echo $value['quantity']; ?></td>
                          <td>
                            <input type='text' class="form-control" name='quantity[]' id="quantity_<?php echo $value['pid']?>" onkeyup="getTotal('<?php echo $id ?>')" value="<?php echo $tqnt; ?>" min="1" max="<?php echo $tqnt; ?>" required >
                            <span id='psNumber_<?php echo $id; ?>'></span>
                          </td>
                          <td>
                            <input type='text' class="form-control" name='uprice[]' id='uprice_<?php echo $id; ?>' onkeyup='getTotal(<?php echo $value['pid']; ?>)' value='<?php echo $value['pprice']; ?>' required readonly >
                          </td>
                          <td>
                            <input type='text' class='tprice form-control' id='tprice_<?php echo $id; ?>' name='tprice[]' value='<?php echo ($value['pprice']*$tqnt); ?>' readonly >
                          </td>
                          <td>
                            <span class='item_remove btn btn-danger btn-xs' onclick='deleteProduct(this)' data-toggle="tooltip" title="Remove Product">x</span>
                            <span class='btn btn-success btn-xs' onclick='add_serial_number("<?php echo $id ?>")' data-toggle="tooltip" title="Add Serial Numbers">+</span>
                            <span class='btn btn-primary btn-xs' onclick='remove_serial_number("<?php echo $id ?>")' data-toggle="tooltip" title="Remove Serial Numbers" >-</span>
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
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Paid Amount *</label>
                      <input type="text" class="form-control" name="pAmount" id="pAmount" value="<?php echo $purchase['pAmount']; ?>" required readonly  >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Due Amount *</label>
                      <input type="text" class="form-control" name="dAmount" id="dAmount" value="<?php echo $purchase['dAmount']; ?>" required readonly  >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Note</label>
                      <input type="text" class="form-control" name="note" value="<?php echo $purchase['note']; ?>" >
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                    <a href="<?php echo site_url('orderReceive'); ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
      function getTotal(id)
        {
        var tp = $('#uprice_' + id).val();
        var quantity = $('#quantity_' + id).val();

        var totalPrice = parseFloat(quantity) * parseFloat(tp);
        $('#tprice_' + id).val(parseFloat(totalPrice).toFixed(2));

        calculatePrice();
        //add_waranty(id);
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
    
    <script type="text/javascript" >
      function deleteProduct(o){
        var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);
         
        calculatePrice();
        }
    </script>
    
    <script type="text/javascript" >
      function deleteSerial(o){
        var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);
         
        calculatePrice();
        }
    </script>
    
    <script type="text/javascript">
      function add_serial_number(id){
        var id = $('#pid_'+id).val();
        var qnt = $('#quantity_'+id).val();
        var url = '<?php echo base_url() ?>'+'Purchase/get_rproduct';
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