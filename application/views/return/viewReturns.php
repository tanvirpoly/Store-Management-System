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
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row">
                      <div class="col-12">
                        <h4>
                          <?php if($company){ ?><img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>" style="height:50px; width:auto;"><?php } ?>
                        </h4>
                      </div>
                    </div>
                    <div class="row invoice-info">
                      <div class="col-sm-4 col-4 invoice-col">
                        From
                        <address>
                          Address : <?php if($company){ ?><?php echo $company->compAddress; ?><?php } ?><br>
                          Mobile : <?php if($company){ ?><?php echo $company->compMobile; ?><?php } ?><br>
                          Email : <?php if($company){ ?><?php echo $company->compEmail; ?><?php } ?><br>
                        </address>
                      </div>
                      <div class="col-sm-4 col-4 invoice-col">
                        To
                        <address>
                          Employee : <?php echo $returns['uName']; ?><br>
                          Mobile : <?php echo $returns['uMobile']; ?><br>
                        </address>
                      </div>
                      <div class="col-sm-4 col-4 invoice-col">
                        <b>Refund No. # <?php echo $returns['rid']; ?></b><br>
                        <b>Req. No. # <?php echo $returns['invoice']; ?></b><br>
                        <b>Date :</b> <?php echo date('d-m-Y', strtotime($returns['returnDate'])); ?><br>
                        <b>Reference # <?php echo $returns['reference']; ?></b><br>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <h3 style="text-align:center;"><b>Refund</b></h3>
                      </div>
                    </div><br>

                    <div class="row">
                      <div class="col-12 table-responsive">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>Product</th>
                              <th>Dev. Quantity</th>
                              <th>Refund</th>
                              <th>Unit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tq = 0;
                            $tdq = 0;
                            foreach ($rproduct as $value){
                            $i++;
                            $mp = $this->db->select('delivery.rInvoice,SUM(delivery_product.quantity) as total')
                                      ->from('delivery')
                                      ->join('delivery_product', 'delivery_product.did = delivery.did', 'left')
                                      ->where('rInvoice',$returns['invoice'])
                                      ->where('pid',$value['productID'])
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
                            
                            // $rproduct = $this->db->select('sNumber')
                            //               ->from('delivery_pserial')
                            //               ->where('pid',$value['pid'])
                            //               ->where('did',$returns['did'])
                            //               ->get()
                            //               ->result();
                            ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></td>
                              <td><?php echo round($tdqnt); $tq += $tdqnt; ?></td>
                              <td><?php echo round($value['quantity']); $tdq += $value['quantity'];  ?></td>
                              <td><?php echo $value['unitName']; ?></td>   
                            </tr>
                            <?php } ?>
                          </tbody>
                          <tbody>
                            <tr>
                              <td colspan="2" align="right">Total </td>
                              <td><?php echo $tq; ?></td>
                              <td><?php echo $tdq; ?></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
                      <p class="lead"><?php echo $returns['note']; ?></p>
                    </div>

                    <div class="row">
                      <div class="col-md-12 col-12" >
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-4" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Employee</p>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Verified By</p>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Authorized By</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row no-print" >
                    <div class="col-12" style="text-align: center;">
                      <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')" ><i class="fas fa-print"></i> Print</a>
                      <a href="<?php echo site_url('refund') ?>" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>
    