<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cash Account</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Cash Account</li>
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
          <div class="col-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cash Account List</h3>
              </div>

              <div class="card-body">
                <table class="table table-responsive table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Account Name</th>
                      <th>Opening</th>
                      <th>Current</th>
                      <th style="width: 15%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    $tba = 0;
                    foreach ($cash as $value){

                    $id = $value['caid'];
                          //var_dump($id);
                    $sa = $this->db->select('SUM(pAmount) as total')
                                ->from('sales')
                                ->where('accountType','Cash')
                                ->where('accountNo',$id)
                                ->get()
                                ->row();
                          //var_dump($sa); exit();
                    if($sa)
                      {
                      $saa = $sa->total;
                      }
                    else
                      {
                      $saa = 0;
                      }

                    $pa = $this->db->select("SUM(pAmount) as total")
                                ->from('purchase')
                                ->where('accountType','Cash')
                                ->where('accountNo',$id)
                                ->get()
                                ->row();
                          //var_dump($pa); exit();
                    if($pa)
                      {
                      $paa = $pa->total;
                      }
                    else
                      {
                      $paa = 0;
                      }

                    $va = $this->db->select("SUM(tAmount) as total")
                                ->from('vaucher')
                                ->where('vType','Credit Voucher')
                                ->where('accountType','Cash')
                                ->where('accountNo',$id)
                                ->get()
                                      ->row();
                          //var_dump($pa); //exit();
                    if($va)
                      {
                      $vaa = $va->total;
                      }
                    else
                      {
                      $vaa = 0;
                      }

                    $va2 = $this->db->select("SUM(tAmount) as total")
                                ->from('vaucher')
                                ->where_not_in('vType','Credit Voucher')
                                ->where('accountType','Cash')
                                ->where('accountNo',$id)
                                ->get()
                                ->row();
                          //var_dump($pa); //exit();
                    if($va2)
                      {
                      $vaa2 = $va2->total;
                      }
                    else
                      {
                      $vaa2 = 0;
                      }
                    $tva = $vaa-$vaa2;

                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['cashName']; ?></td>
                      <td><?php echo number_format(($value['balance']), 2); ?></td>
                      <td><?php echo number_format(((($value['balance'])+$saa+$tva)-$paa), 2); $tba += ((($value['balance'])+$saa+$tva)-$paa); ?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-sm bank_edit" data-toggle="modal" data-target=".bs-example-modal-ebank" data-id="<?php echo $value['caid']; ?>" id="<?php echo $value['caid']; ?>" onclick="document.getElementById('bank_edit').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <a href="<?php echo site_url('CashAccount/cash_account_delete').'/'.$value['caid'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Cash Account ?');" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cash Account Information</h3>
              </div>

              <div class="card-body">
                <form action="<?php echo base_url('CashAccount/save_cash_account');?>" method="post">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <label>Account Name *</label>
                      <input type="text" class="form-control" name="accountName" placeholder="Account Name" required >
                    </div>
                    <div class="form-group">
                      <label>Opening Balance</label>
                      <input type="text" class="form-control" name="balance" placeholder="Opening Balance" >
                    </div>
                  </div>
                  <div class="form-groupr col-md-12 col-sm-12 col-12" style="text-align: center;">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    <div class="modal fade bs-example-modal-ebank" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" >Cash Account Info.</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('CashAccount/update_cash_account');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label>Account Name *</label>
                <input type="text" class="form-control" name="accountName" id="accountName" required >
              </div>
              <div class="form-group">
                <label>Account Balance</label>
                <input type="text" class="form-control" name="balance" id="balance" >
              </div>
              <div class="form-group" >
                <label>Status</label>
                <select class="form-control" name="status" id="status" >
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
              <input type="hidden" id="caid" name="caid" required >
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>


<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click','.bank_edit',function(){
          var catid = $(this).attr('id');
            //alert(l_id);
          $('input[name="caid"]').val(catid);
          });

        $(document).on('click','.bank_edit',function(){
          var id = $(this).attr('id');
          var url = '<?php echo base_url() ?>CashAccount/get_cash_account';
            //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
                //alert(data);
              var HTML = data["cashName"];
              var HTML2 = data["balance"];
              var HTML3 = data["status"];
                //alert(HTML);
              $("#accountName").val(HTML);
              $("#balance").val(HTML2);
              $("#status").val(HTML3);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>