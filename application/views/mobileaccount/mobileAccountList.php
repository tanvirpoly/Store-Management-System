<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mobile Account</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Mobile Account</li>
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
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Mobile Account</h3>
              <button type="button" class="btn btn-primary mobilet" data-toggle="modal" data-target=".bs-example-modal-mobile" style="float: right" ><i class="fa fa-plus"></i> New Mobile Account</button>
            </div>

            <div class="card-body">
              <table class="table-responsive table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="width: 5%;">#SN.</th>
                    <th>Account Name</th>
                    <th>Account No</th>
                    <th>Account Owner</th>
                    <th>Opening</th>
                    <th>Current</th>
                    <th style="width: 10%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  $tba = 0;
                  foreach ($maccount as $value){
                  $id = $value['maid'];

                  $sa = $this->db->select('SUM(pAmount) as total')
                                ->from('sales')
                                ->where('accountType','Mobile')
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
                              ->where('accountType','Mobile')
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
                              ->where('accountType','Mobile')
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
                              ->where('accountType','Mobile')
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
                    <td><?php echo $value['accountName']; ?></td>
                    <td><?php echo $value['accountNo']; ?></td>
                    <td><?php echo $value['accountOwner']; ?></td>
                    <td><?php echo number_format(($value['balance']), 2); ?></td>
                    <td><?php echo number_format(((($value['balance'])+$saa+$tva)-$paa), 2); $tba += ((($value['balance'])+$saa+$tva)-$paa); ?></td>
                    <td>
                      <button type="button" class="btn btn-success btn-xs mobile_edit" data-toggle="modal" data-target=".bs-example-modal-emobt" data-id="<?php echo $value['maid']; ?>" id="<?php echo $value['maid']; ?>" onclick="document.getElementById('mobile_edit').style.display='block'" ><i class="fa fa-edit"></i></button>
                      <a href="<?php echo site_url('MobileAccount/mobile_account_delete').'/'.$value['maid'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this Mobile Account ?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                  </tr>   
                  <?php } ?> 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    <div class="modal fade bs-example-modal-mobile" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Mobile Account Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('MobileAccount/save_mobile_account');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Account Name *</label>
                  <input type="text" class="form-control" name="accountName" placeholder="Account Name" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Account No *</label>
                  <input type="text" class="form-control" name="accountNo" placeholder="Account No" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Account Owner</label>
                  <input type="text" class="form-control" name="accountOwner" placeholder="Account Owner" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Account Balance</label>
                  <input type="text" class="form-control" name="balance" placeholder="Account Balance" >
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-emobt" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" >Mobile Account Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('MobileAccount/update_mobile_account');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label>Account Name *</label>
                  <input type="text" class="form-control" name="accountName" id="accountName" placeholder="Account Name" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label>Account No *</label>
                  <input type="text" class="form-control" name="accountNo" id="accountNo" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label>Account Owner</label>
                  <input type="text" class="form-control" name="accountOwner" id="accountOwner" placeholder="Account Owner" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label>Account Balance</label>
                  <input type="text" class="form-control" name="balance" id="balance" placeholder="Account Balance" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                  <label>Status</label>
                  <select class="form-control" name="status" id="status" >
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                </div>
              </div>
              <input type="hidden" id="maid" name="maid" required >
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
        $(document).on('click','.mobile_edit',function(){
          var catid = $(this).attr('id');
            //alert(l_id);
          $('input[name="maid"]').val(catid);
          });

        $(document).on('click','.mobile_edit',function(){
          var id = $(this).attr('id');
          var url = '<?php echo base_url() ?>MobileAccount/get_mobile_account';
            //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
                //alert(data);
              var HTML = data["accountNo"];
              var HTML2 = data["accountName"];
              var HTML3 = data["accountOwner"];
              var HTML4 = data["balance"];
              var HTML5 = data["status"];
                //alert(HTML);
              $("#accountNo").val(HTML);
              $("#accountName").val(HTML2);
              $("#accountOwner").val(HTML3);
              $("#balance").val(HTML4);
              $("#status").val(HTML5);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>