<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sale</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Sale</li>
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
                <h3 class="card-title">Sale Information</h3>
              </div>

              <div class="card-body">
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row">
						<div class="col-sm-3 col-3 invoice-col">
						</div>
						<div class="col-sm-6 col-6 invoice-col text-center">
							<?php if($company){ ?><h3><b><?php echo $company->compName; ?></b></h3><?php } ?>
							<?php if($company){ ?><?php echo $company->compAddress; ?><?php } ?><br>
							<!--<?php if($company){ ?><?php echo $company->compMobile; ?><?php } ?>-->
						</div>
						<div class="col-sm-3 col-3 invoice-col">
							<h4>
                              <?php if($company){ ?><img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>" style="height:100px; width:auto;"><?php } ?>
                            </h4>
						</div>
                          <!--<div class="col-sm-12 col-md-12 col-12">-->
                          <!--  <h4 style="text-align:center;"><b>Goods Requisition</b></h4>-->
                          <!--</div>-->
					</div><br>
                    <div class="row invoice-info">
                      <div class="col-sm-6 col-6 invoice-col" style="float:left">
                        <b>Req. No. #</b> <?php echo $prints['invoiceOne']; ?>
                      </div>
                      <div class="col-sm-6 col-6 invoice-col">
                        <span style="float:right"><b>Date :</b> <?php echo date('d-m-Y', strtotime($prints['saDateOne'])); ?></span>
                      </div>
                    </div><br>
                    <div class="row invoice-info">
                      <div class="col-sm-4 col-4 invoice-col">
                        <div>
                          Employee : <?php echo $prints['uName']; ?><br>
                          Customer : <?php echo $prints['custName']; ?><br>
                          Reference : <?php echo $prints['referenceOne']; ?><br>
                        </div>
                      </div>
                    </div><br>

                    <div class="row">
                      <div class="col-12 table-responsive">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>Product</th>
                              <th>Quantity</th>
                              <th>Unit Price</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tq = 0;
                            $tdq = 0;
                            $tu = 0;
                            foreach ($salesp as $value){
                            $i++;
                            
                            
                            
                            ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></td>
                              <td><?php echo round($value['quantityOne']); $tq += $value['quantityOne']; ?></td>
                              <td><?php echo round($value['uprice']); $tu += $value['uprice']; ?></td>
                              
                            </tr>
                            <?php } ?>
                          </tbody>
                          <tbody>
                            <tr>
                              <td colspan="2" align="right">Total </td>
                              <td><?php echo $tq; ?></td>
                              <td><?php echo $tu; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-8 col-sm-8 col-8" >
                        <p class="lead">Reference Note&nbsp;:&nbsp;</p>
                        <p class="lead"><?php echo $prints['rnoteOne']; ?></p>
                      </div>
                      <div class="col-md-4 col-sm-4 col-4" >
                        <p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
                        <p class="lead"><?php echo $prints['noteOne']; ?></p>
                      </div>
                    </div><br>

                    <div class="row">
                      <div class="col-md-12 col-12" >
                        <div class="row">
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Signature and designation of the formatter</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;">
                            <p>------------------------------</p> 
                            <p>Signature of Approving Officer 2 Designation</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Signature and designation of supplier</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Signature and seal of the officer-in-charge of the branch</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;margin-top:50px;">
                            <p>------------------------------</p>
                            <p>Signature and seal of acceptor</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row no-print" >
                    <div class="col-12" style="text-align: center;">
                      <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')" ><i class="fas fa-print"></i> Print</a>
                      <a href="<?php echo site_url('sale') ?>" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
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
