<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Report</li>
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
                <h3 class="card-title">Report</h3>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url('saleReport'); ?>" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Sales Report</span>
                          <span class="info-box-number"><?php echo number_format($sale->total, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url('purReport'); ?>" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Purchase Report</span>
                          <span class="info-box-number"><?php echo number_format($purchase->total, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>stockReport" > 
                      <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Stock Report</span>
                          <span class="info-box-number"><?php echo $stock->total; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>vReports" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-adjust"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Voucher Report</span>
                          <span class="info-box-number"><?php echo number_format($voucher->total, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>custReport" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Customer Report</span>
                          <span class="info-box-number"><?php echo $customer; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>custLedger" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="far fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Customer Ledger</span>
                          <span class="info-box-number"><?php echo $customer; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>supReport" > 
                      <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Supplier Report</span>
                          <span class="info-box-number"><?php echo $supplier; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>supLedger" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="far fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Supplier Ledger</span>
                          <span class="info-box-number"><?php echo $supplier; ?></span>
                        </div>
                      </div>
                    </a>
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