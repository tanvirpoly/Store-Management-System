<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Delivery Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Delivery Reports</li>
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
                <h3 class="card-title">Delivery Reports</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>devReport" method="get">
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Start Date *</label>
                            <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('m/d/Y') ?>" id="sdate" required="" >
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>End Date *</label>
                            <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('m/d/Y') ?>" id="edate" required="" >
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Employee *</label>
                            <select class="form-control select2" name="demployee" id="demployee" required="" >
                              <option value="All">All</option>
                              <?php foreach($employee as $value){ ?>
                              <option value="<?php echo $value['uid']; ?>"><?php echo $value['uName']; ?></option>
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Month *</label>
                            <select class="form-control" name="month" id="month" required="" >
                              <option value="">Select Month</option>
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Year *</label>
                            <select class="form-control" name="year" id="year" required="" >
                              <?php $d = date("Y"); ?>
                              <option value="">Select Year</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Employee *</label>
                            <select class="form-control select2" name="memployee" id="memployee" required="" >
                              <option value="All">All</option>
                              <?php foreach($employee as $value){ ?>
                              <option value="<?php echo $value['uid']; ?>"><?php echo $value['uName']; ?></option>
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Year *</label>
                            <select class="form-control" name="ryear" id="ryear" required="" >
                              <?php $d = date("Y"); ?>
                              <option value="">Select Year</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Employee *</label>
                            <select class="form-control select2" name="yemployee" id="yemployee" required="" >
                              <option value="All">All</option>
                              <?php foreach($employee as $value){ ?>
                              <option value="<?php echo $value['uid']; ?>"><?php echo $value['uName']; ?></option>
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
                        <img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>"  style="width: 100%;">
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
                    <?php 
                    
                        if(isset($_GET['search'])) {
                            $empName = $this->db->select('uName')
                                                ->from('users')
                                                ->where('uid', $empid)
                                                ->get()
                                                ->row();
                            if($empName){
                                $str = $empName->uName;
                            }else{
                                $str = 'All Employees';
                            }
                    ?>
                    <?php if ($report == 'dailyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b><?= $str.' ';?> Reports in : <?php echo $sdate.' To '.$edate; ?></b></h3>
                    </div>
                    <?php } else if ($report == 'monthlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b><?= $str.' ';?> Reports in : <?php echo $name.' To '.$year; ?></b></h3>
                    </div>
                    <?php } else if ($report == 'yearlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b><?= $str.' ';?> Reports in : <?php echo $year; ?></b></h3>
                    </div>
                    <?php } } ?>

                    <div class="col-sm-12 col-md-12 col-12">
                      <table id="example1" class="table table-bordered" >
                        <thead>
                          <tr>
                            <th style="width: 5%;">#SN.</th>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th style="width: 10%;">Notes</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          $ts = 0;
                          $td = 0;
                          $tda = 0;
                          $temp2 = '';
                          foreach ($sales as $sale){
                          $temp = '';
                              $i++;
    
                              $pp = $this->db->select('
                                            delivery_product.*,
                                            products.pName,
                                            products.pCode')
                                      ->from('delivery_product')
                                      ->join('products','products.pid = delivery_product.pid','left')
                                      ->where('did',$sale->did)
                                      ->get()
                                      ->result();
                            
                                // if($temp == $sale->rInvoice){
                                //     $temp = '-';
                                // }else{
                                //     $temp = $sale->rInvoice;
                                // }
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $sale->rInvoice; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($sale->dDate)); ?></td>
                            <td><?php echo $sale->uName; ?></td>
                            <!--<td><?php echo $sale->pName.'<br>'; ?></td>-->
                            <!--<td><?php echo $sale->quantity; ?></td>-->
                            <td>
                              <?php foreach($pp as $p){ ?>
                              <?php echo $p->pName.'-'.$p->pCode; ?><hr style="padding:0;margin:0;">
                              <?php } ?>
                            </td>
                            <td>
                              <?php 
                                $tp = 0;
                                foreach($pp as $p){
                                    echo $p->quantity.'<hr style="padding:0;margin:0;">';
                                    $tp += $p->quantity;
                                }
                                echo 'Total = '.$tp; 
                              ?>
                            </td>
                            <td><?php echo $sale->notes; ?></td>
                          </tr> 
                          <?php } ?>
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
          $('#demployee').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#memployee').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#yemployee').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#demployee').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          $('#memployee').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#yemployee').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#demployee').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#memployee').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          $('#yemployee').attr('required','required');
          });
        });
    </script>