<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Dashboard</h3>
              </div>

              <div class="card-body">
                <section class="content">
                  <div class="container-fluid">
                    <div class="box-header with-border">
                      <h2><b>Welcome To "<?php echo $_SESSION['company']; ?>"</b></h2>
                    </div>
                    <div class="row">
                      <?php if($_SESSION['requisition_list'] == 1){ ?>
                      <div class="col-lg-3 col-6">
                        <a href="<?php echo base_url() ?>requisition" >
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3><?php echo $sale; ?></h3>
                            <p>Total Requisition</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                          </div>
                        </div>
                        </a>
                      </div>
                      <?php } if($_SESSION['order_list'] == 1){ ?>
                      <div class="col-lg-3 col-6">
                        <a href="<?php echo base_url() ?>workOrder" >
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3><?php echo $purchase; ?></h3>
                            <p>Total Work Order</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                        </div>
                        </a>
                      </div>
                      <?php } if($_SESSION['product_list'] == 1){ ?>
                      <div class="col-lg-3 col-6">
                        <a href="<?php echo base_url() ?>Product" >
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3><?php echo $product; ?></h3>
                            <p>Total Product</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                          </div>
                        </div>
                        </a>
                      </div>
                      <?php } if($_SESSION['supplier'] == 1){ ?>
                      <div class="col-lg-3 col-6">
                        <a href="<?php echo base_url() ?>Supplier" >
                        <div class="small-box bg-warning">
                          <div class="inner">
                            <h3><?php echo $supplier; ?></h3>
                            <p>Total Supplier</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-person-add"></i>
                          </div>
                        </div>
                        </a>
                      </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="card">
                        <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                      </div>
                    </div>

                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      window.onload = function() {

        CanvasJS.addColorSet("greenShades",
          [
          "#1382d6",
          "#1382d6",
          "#1382d6",
          "#1382d6",
          "#1382d6" ,               
          "#1382d6" ,               
          "#1382d6"                
          ]);
 
        var chart = new CanvasJS.Chart("chartContainer", {
          animationEnabled: true,
          theme: "light1",
          colorSet: "greenShades",
          title:{
            text: "Last 7 Days Requisition"
            },
          axisY: {
            title: "Products Uses"
            },
          data: [{
            type: "column",
            yValueFormatString: "#,##0.## Taka",
            dataPoints: <?php echo json_encode($this->pm->graph_data_point(), JSON_NUMERIC_CHECK); ?>
          }]
        });
      chart.render();
      }
    </script>