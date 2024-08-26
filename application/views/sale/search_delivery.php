<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Delivery</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Delivery</li>
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
                <h3 class="card-title">Delivery Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Sale/save_delivery") ?>">
                  <div class="row">
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Delivery Date</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($sales['saDate'])) ?>" required >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Requisition No. *</label>
                      <input type="text" class="form-control" name="invoice" value="<?php echo $sales['invoice']; ?>" required readonly >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Reference *</label>
                      <input type="text" class="form-control" name="reference" value="<?php echo $sales['reference']; ?>" readonly >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <label>Employee *</label>
                      <input type="hidden" name="employee" value="<?php echo $sales['regby']; ?>" required >
                      <input type="text" class="form-control" value="<?php echo $sales['uName']; ?>" readonly >
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-12">
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Products</th>
                          <th>Stock</th>
                          <th>Request</th>
                          <th>Approve</th>
                          <th>Delivery</th>
                          <th>Unit</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php foreach($sproduct as $value){
                        $id = $value['pid'];
                        
                        $mp = $this->db->select('quantity')
                                  ->from('sale_product')
                                  ->where('pid',$value['pid'])
                                  ->where('said',$value['said'])
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
                        ?>
                        <tr>
                          <td>
                            <?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?>
                            <input type="hidden" name='product[]' id="pid_<?php echo $value['pid']?>" value="<?php echo $value['pid']; ?>" required >
                          </td>
                          <td><?php echo $tstock; ?></td>
                          <td><?php echo $tdqnt; ?></td>
                          <td><?php echo $value['quantity']; ?></td>
                          <td>
                            <input type='text' class="form-control" name='quantity[]' id="quantity_<?php echo $value['pid']?>"  value="<?php echo $value['quantity']; ?>" min="1" max="<?php echo $value['quantity']; ?>" required >
                            <span id='psNumber_<?php echo $id; ?>'></span>
                          </td>
                          <td><?php echo $value['unitName']; ?></td>   
                          <td>
                            <span class='item_remove btn btn-danger btn-xs' onclick='deleteProduct(this)'>x</span>
                            <span class='btn btn-success btn-xs' onclick='add_serial_number("<?php echo $id ?>")'>+</span>
                            <span class='btn btn-primary btn-xs' onclick='remove_serial_number("<?php echo $id ?>")' data-toggle="tooltip" title="Remove Serial Numbers" >-</span>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>  
                  </div>    

                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Note</label>
                      <input type="text" class="form-control" name="note" value="<?php echo $sales['note']; ?>" >
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                    <a href="<?php echo site_url('delivery'); ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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