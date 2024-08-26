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
                <h3 class="card-title">Purchase List</h3>
              
                <a href="<?php echo site_url('newPurchase'); ?>" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Purchase</a>
              </div>
              <div class="card-body">
                <div class="col-md-12 col-sm-12 col-12">
                  <table id="example2" class="table table-bordered table-responsive"  >
                    <thead>
                      <tr>
                        <th style="width: 5%;">#SN.</th>
                        <th>Purchase Date</th>
                        <th>Institute</th>
                        <th>Order No</th>
                        <th>authority</th>
                        <th>Address</th>
                        <th>Memo No</th>
                        <th>Purchase Date</th>
                        <th>Products</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>purchaseName</th>
                        <th>Designation</th>
                        <th>Entry No</th>
                        <th>lastDate</th>
                        <th style="width: 10%;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0;
                      foreach ($instant_purchase as $value) {
                        $i++;
                        $pp = $this->db->select('instant_purchase_product.quantity,products.pName')
                                      ->from('instant_purchase_product')
                                      ->join('products', 'products.pid = instant_purchase_product.product_id', 'left')
                                      ->where('insPurID', $value['insPurID'])
                                      ->get()
                                      ->result();
                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($value['date'])); ?></td>
                        <td><?php echo $value['istitudeP']; ?></td>
                        <td><?php echo $value['workNO']; ?></td>
                        <td><?php echo $value['permitName']; ?></td>
                        <td><?php echo $value['address']; ?></td>
                        <td><?php echo $value['memoNO']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($value['purchaseDate'])); ?></td>
                        <td>
                          <?php foreach ($pp as $p) { ?>
                          <?php echo $p->pName; ?><br>
                          <?php } ?>
                        </td>
                        <td>
                          <?php foreach ($pp as $p) { ?>
                          <?php echo $p->quantity; ?><br>
                          <?php } ?>
                        </td>
                        <td><?php echo number_format($value['totalPrice'], 2); ?></td>
                        <td><?php echo $value['purchaseName']; ?></td>
                        <td><?php echo $value['podobi']; ?></td>
                        <td><?php echo $value['entryVuktiDate']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($value['lastDate'])); ?></td>
                        <td>
                          <div class="input-group input-group-md mb-3">
                            <div class="input-group-prepend">
                              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Action </button>
                              <ul class="dropdown-menu">
                                <li class="dropdown-item"><a href="<?php echo site_url('viewPurchase') . '/' . $value['insPurID']; ?>"><i class="fa fa-eye"></i> View</a></li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item"><a href="<?php echo site_url('viewPurchasePr') . '/' . $value['insPurID']; ?>"><i class="fa fa-eye"></i> View Product Receive</a></li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item"><a href="<?php echo site_url('viewPurchaseLt') . '/' . $value['insPurID']; ?>"><i class="fa fa-eye"></i> View Letter of transfer</a></li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item"><a href="<?php echo site_url('editPurchase') . '/' . $value['insPurID']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item"><a href="<?php echo site_url('PurchaseOne/delete_purchases') . '/' . $value['insPurID']; ?>"><i class="fa fa-trash"></i> Delete</a></li>
                              </ul>
                            </div>
                          </div>
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
                <input type="text" class="form-control" name="damount" id="damount" readonly >
              </div>
              <input type="hidden" class="form-control" name="pamount" id="pamount" >
              <div class="form-group">
                <label>Paid Amount *</label>
                <input type="text" class="form-control" name="amount" placeholder="Amount" required >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                  <label>Payment Mode *</label>
                  <select class="form-control" name="accountType" id="accountType" required >
                    <option value="Cash">Cash</option>
                    <option value="Bank">Bank</option>
                    <option value="Mobile">Mobile</option>
                  </select>
                </div>
                <div class="form-group col-md-12 col-sm-12 col-12">
                  <label>Account *</label>
                  <select class="form-control" name="accountNo" id="accountNo" required >
                    <option value="">Select Account Type First</option>
                  </select>
                </div>
            </div>
            <input type="hidden" id="purchaseID" name="purchaseID" >
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
          var id = $(this).data('id');
        //alert(l_id);
          $('input[name="purchaseID"]').val(id);
          });

        $('.payment').click(function(){
          var id = $(this).data('id');
            //alert(id);
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
              var HTML = data["due"];
              var HTML2 = data["paidAmount"];
            //alert(HTML2);
              $("#damount").val(HTML);
              $("#pamount").val(HTML2);
              },
            error:function(){
              alert('error');
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
        $('#accountNo').val("<?php echo $caid; ?>");
        });
    
      $('#accountType').on('change',function(){
        var value = $(this).val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        });
        
        function getAccountNo(value,place){
          $(place).empty();
          if(value != ''){
              //alert(value);
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