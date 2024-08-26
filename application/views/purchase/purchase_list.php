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
                <h3 class="card-title">Work Orders List</h3>
                <?php if($_SESSION['new_order'] == 1){ ?>
                <a href="<?php echo site_url(); ?>newWOrder" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Work Order</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Memo No.</th>
                      <th>Date</th>
                      <th>Supplier</th>
                      <!--<th>Mobile</th>-->
                      <th>Order</th>
                      <th>Received</th>
                      <th>Paid</th>
                      <th>Due</th>
                      <th>Approve Status</th>
                      <th>Receive Status</th>
                      <th style="width: 13%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach($purchase as $value){
                    $i++;
                    
                    $mp = $this->db->select('SUM(quantity) total')
                                  ->from('purchase_product')
                                  ->where('puid',$value['puid'])
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
                    
                    $dp = $this->db->select('SUM(receive_product.quantity) total,SUM(receive_product.tprice) tra,receive_order.roMemo')
                                  ->from('receive_product')
                                  ->join('receive_order','receive_order.roid = receive_product.roid','left')
                                  ->where('roMemo',$value['memoNo'])
                                  ->get()
                                  ->row();
                    if($dp)
                      {
                      $tqnt = $dp->total;
                      $trqnt = $dp->tra;
                      }
                    else
                      {
                      $tqnt = 0;
                      $trqnt = 0;
                      }
                    $payment = $this->db->select('SUM(ppAmount) as total')
                                      ->from('purchase_payment')
                                      ->where('puid',$value['puid'])
                                      ->get()
                                      ->row();
                    if($payment)
                      {
                      $tpa = $payment->total;
                      }
                    else
                      {
                      $tpa = 0;
                      }
                      
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['memoNo'] ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['puDate'])) ?></td>
                      <td><?php echo $value['supName'] ?></td>
                      <!--<td><?php echo $value['supMobile'] ?></td>-->
                      <td><?php echo number_format($value['tAmount'], 2) ?></td>
                      
                      <td><?php echo number_format(($trqnt-$tpa), 2) ?></td>
                      <td><?php if($value['pAmount']!='null'){echo $value['pAmount'];}else{echo 'N/A';}?></td>
                      <td><?php if($value['dAmount']!='null'){echo $value['dAmount'];}else{echo 'N/A';} ?></td>
                      <td><?php echo $value['status']; ?></td>
                      <td>
                        <?php if($tqnt > 0 && $tqnt < $tdqnt){ ?>
                        <?php echo 'Partial Received'; ?>
                        <?php } else if($tqnt >= $tdqnt){ ?>
                        <?php echo 'Received'; ?>
                        <?php } else { ?>
                        <?php echo 'Not Received'; ?>
                        <?php } ?>
                      </td>
                      <td>
                        <a class="btn btn-info btn-xs" href="<?php echo site_url().'viewWOrder/'.$value['puid']; ?>" title="view" ><i class="fa fa-eye"></i></a>
                        <?php if($value['status'] == "On Process"){ ?>
                        <?php if($_SESSION['edit_order'] == 1){ ?>
                        <a class="btn btn-success btn-xs" href="<?php echo site_url().'editWOrder/'.$value['puid']; ?>" title="edit" ><i class="fa fa-edit"></i></a>
                        <?php } if($_SESSION['delete_order'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Purchase/delete_purchases').'/'.$value['puid']; ?>" onclick="return confirm('Are you sure you want to delete this Work Order ?');" title="Delete" ><i class="fa fa-trash"></i></a>
                        <?php } if($_SESSION['approve_order'] == 1){ ?>
                        <a class="btn btn-warning btn-xs" href="<?php echo site_url('Purchase/approve_purchases').'/'.$value['puid']; ?>" onclick="return confirm('Are you sure you want to Approve this Work Order ?');" title="Approve" ><i class="fa fa-check"></i></a>
                        <?php } } ?>
                        <?php if($tqnt >= $tdqnt){ ?>
                        <?php if(($value['tAmount']-$tpa) > 0){ ?>
                        <?php if($_SESSION['payment_order'] == 1){ ?>
                        <!--<a href="#" class="payment btn btn-warning btn-xs" data-toggle="modal" data-target=".bs-example-modal-payment" data-id="<?php echo $value['puid']; ?>"><i class="fa fa-plus"></i></a>-->
                        <?php } } } ?>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
    <div class="modal fade bs-example-modal-payment" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > Payment Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Purchase/save_purchase_payment');?>" method="post">
            <div class="col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label>Due Amount</label>
                <input type="text" class="form-control" name="tAmount" id="tAmount" readonly >
              </div>
              <div class="form-group">
                <label>Paid Amount *</label>
                <input type="text" class="form-control" name="pAmount" id="pAmount" placeholder="Amount" required >
              </div>
              <div class="form-group">
                <label>Notes</label>
                <input type="text" class="form-control" name="notes" placeholder="If Have any notes" >
              </div>
            </div>
            <input type="hidden" id="puid" name="puid" required >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="pbsubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".payment").click(function(){
          var puid = $(this).data('id');
            //alert(puid);
          $('input[name="puid"]').val(puid);
          });

        $('.payment').click(function(){
          var id = $(this).data('id');
          var url = '<?php echo base_url() ?>Purchase/get_purchase_payment';
            //alert(url);
          $.ajax({
            type: 'POST',
            async: false,
            url: url,
            data:{"id":id},
            dataType: 'json',
            success: function(data){
                //alert(data);
              var HTML = data;
                //alert(HTML2);
              $("#tAmount").val(HTML);
              $("#pAmount").val(HTML);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>