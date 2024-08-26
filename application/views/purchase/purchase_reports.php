<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Order Reports</li>
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
                <h3 class="card-title">Order Reports</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url(); ?>orderReport" method="get">
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <b>
                          <input type="radio" name="reports" value="dailyReports" id="daily" required >&nbsp;&nbsp;Daily Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="monthlyReports" id="monthly" required >&nbsp;&nbsp;Monthly Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="yearlyReports" id="yearly" required >&nbsp;&nbsp;Yearly Reports
                        </b>
                      </div>

                      <div class="d-none" id="dreports">
                        <div class="row">
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Start Date *</label>
                            <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('m/d/Y') ?>" id="sdate" required="" >
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>End Date *</label>
                            <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('m/d/Y') ?>" id="edate" required="" >
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <select class="form-control" name="dsupplier" id="dsupplier" required="" >
                              <option value="All">All</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supid']; ?>"><?php echo $value['supName'].' ( '.$value['supCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="mreports">
                        <div class="row">
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Select Month *</label>
                            <select class="form-control" name="month" id="month" required="" >
                              <option value="">Select One</option>
                              <option value="01">January</option>
                              <option value="02">February</option>
                              <option value="03">March</option>
                              <option value="04">April</option>
                              <option value="05">May</option>
                              <option value="06">June</option>
                              <option value="07">July</option>
                              <option value="08">August</option>
                              <option value="09">September</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="12">December</option>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Select Year *</label>
                            <select class="form-control" name="year" id="year" required="" >
                              <?php $d = date("Y"); ?>
                            <option value="">Select One</option>
                            <?php for ($x = 2020; $x <= $d; $x++) { ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                            <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <select class="form-control" name="msupplier" id="msupplier" required="" >
                              <option value="All">All</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supid']; ?>"><?php echo $value['supName'].' ( '.$value['supCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="yreports">
                        <div class="row">
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Select Year *</label>
                            <select class="form-control" name="ryear" id="ryear" required="" >
                              <?php $d = date("Y"); ?>
                            <option value="">Select One</option>
                            <?php for ($x = 2020; $x <= $d; $x++) { ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                            <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <select class="form-control" name="ysupplier" id="ysupplier" required="" >
                              <option value="All">All</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supid']; ?>"><?php echo $value['supName'].' ( '.$value['supCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-xs-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="col-sm-12 col-md-12 col-12">
                  <div id="print">
                    <div class="row" id="header" style="display: none" >
                      <?php if($company){ ?>
                      <div class="col-sm-2 col-md-2 col-2" style="margin-top: 30px;">
                        <img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>"  style="width: 100%; height: auto;">
                      </div>
                      <div class="col-sm-10 col-md-10 col-10">
                        <div class="col-sm-12 col-md-12 col-12">
                          <h3><b><?php echo $company->compName; ?></b></h3>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->compAddress; ?></b>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->compEmail; ?></b>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->compMobile; ?></b>
                        </div>
                      </div>
                      <?php } ?>
                    </div><br>
                    <?php if(isset($_GET['search'])) { ?>
                    <?php if ($report == 'dailyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Order Reports in : <?php echo $sdate.' To '.$edate; ?></b></h3>
                    </div>
                    <?php } else if ($report == 'monthlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Order Reports in : <?php echo $name.' To '.$year; ?></b></h3>
                    </div>
                    <?php } else if ($report == 'yearlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Order Reports in : <?php echo $year; ?></b></h3>
                    </div>
                    <?php } } ?>

                    <div class="col-sm-12 col-md-12 col-12">
                      <table id="example1" class="table table-striped table-bordered" >
                        <thead>
                          <tr>
                            <th style="width: 5%;">#SN</th>
                            <th>Memo</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Products</th>
                            <th>Order Quantity</th>
                            <th>Received Quantity</th>
                            <th>Total</th>
                            <th style="width: 10%;">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          $tp = 0;
                          $tpa = 0;
                          $td = 0;
                          foreach ($purchase as $result){
                          $i++;

                          $pp = $this->db->select('
                                        purchase_product.*,
                                        purchase.memoNo,
                                        products.pName,
                                        products.pCode')
                                  ->from('purchase_product')
                                  ->join('products','products.pid = purchase_product.pid','left')
                                  ->join('purchase','purchase.puid = purchase_product.puid','left')
                                  ->where('purchase_product.puid',$result->puid)
                                  ->get()
                                  ->result();
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $result->memoNo; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($result->puDate)) ?></td>
                            <td><?php echo $result->supName; ?></td>
                            <td>
                              <?php foreach($pp as $p){ ?>
                              <?php echo $p->pName.'-'.$p->pCode; ?><br>
                              <?php } ?>
                            </td>
                            <td>
                              <?php foreach($pp as $p){ ?>
                              <?php echo $p->quantity; ?><br>
                              <?php } ?>
                            </td>
                            <td>
                              <?php foreach($pp as $p){
                              $mp = $this->db->select('SUM(receive_product.quantity) as total,receive_order.roMemo')
                                      ->from('receive_product')
                                      ->join('receive_order','receive_order.roid = receive_product.roid','left')
                                      ->where('pid',$p->pid)
                                      ->where('roMemo',$p->memoNo)
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
                              ?>
                              <?php echo $tdqnt; ?><br>
                              <?php } ?>
                            </td>
                            <td><?php echo number_format($result->tAmount, 2); $tp += $result->tAmount; ?></td>
                            <td><?php echo $result->status; ?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                        <tbody>
                          <tr>
                            <th colspan="7" style="text-align: right;">Total Amount</th>
                            <th><?php echo number_format($tp, 2); ?></th>
                            <th></th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row no-print" >
                    <div class="col-12" style="text-align: center;">
                      <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')" ><i class="fas fa-print"></i> Print</a>
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

    <script type="text/javascript">
      $(document).ready(function() {
        $('#daily').click(function(){
          $('#dreports').removeAttr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').attr('required','required');
          $('#edate').attr('required','required');
          $('#dsupplier').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#msupplier').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ysupplier').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dsupplier').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          $('#msupplier').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ysupplier').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dsupplier').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#msupplier').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          $('#ysupplier').attr('required','required');
          });
        });
    </script>