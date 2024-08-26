<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customer Ledger</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Customer Ledger</li>
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
                <h3 class="card-title">Customer Ledger</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>custLedger" method="get">
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="form-group">
                        <b>
                          <input type="radio" name="reports" value="ocust" id="ocust" required >&nbsp;&nbsp;Customer All Ledger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="dailyReports" id="daily" required >&nbsp;&nbsp;Daily Ledger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="monthlyReports" id="monthly" required >&nbsp;&nbsp;Monthly Ledger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="yearlyReports" id="yearly" required >&nbsp;&nbsp;Yearly Ledger
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
                            <label>Select Customer *</label>
                            <select name="dcustomer" class="form-control" id="dcustomer" required="" >
                              <option value="">Select One</option>
                              <?php foreach ($customer as $value) { ?>
                              <option value="<?php echo $value['custid']; ?>" ><?php echo $value['custName'].' ( '.$value['custCode'].' )'; ?></option>
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
                              <option value="">Select One</option>
                              <?php $d = date("Y"); ?>
                              <option value="">Select One</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Customer *</label>
                            <select name="mcustomer" class="form-control" id="mcustomer" required="" >
                              <option value="">Select One</option>
                              <?php foreach ($customer as $value) { ?>
                              <option value="<?php echo $value['custid']; ?>" ><?php echo $value['custName'].' ( '.$value['custCode'].' )'; ?></option>
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
                              <option value="">Select One</option>
                              <?php $d = date("Y"); ?>
                              <option value="">Select One</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Customer *</label>
                            <select name="ycustomer" class="form-control" id="ycustomer" required="" >
                              <option value="">Select One</option>
                              <?php foreach ($customer as $value) { ?>
                              <option value="<?php echo $value['custid']; ?>" ><?php echo $value['custName'].' ( '.$value['custCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="reports">
                        <div class="row">
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Customer *</label>
                            <select name="customer" class="form-control" id="customer" required="" >
                              <option value="">Select One</option>
                              <?php foreach ($customer as $value) { ?>
                              <option value="<?php echo $value['custid']; ?>" ><?php echo $value['custName'].' ( '.$value['custCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                    </div>
                  </form>
                </div><hr>

                <div class="box-body">
                  <div id="print">
                      <?php if($company) { ?>
                    <div class="row" id="header" style="display: none" >
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
                    </div>
                    <?php } ?>
                    <?php if(isset($_GET['search'])) { ?>
                    <div class="col-sm-12 col-md-12 col-12">
                      <div class="col-sm-12 col-md-12 col-12">
                        Customer ID&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $cust[0]['custCode']; ?>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        Customer Name&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $cust[0]['custName']; ?>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $cust[0]['custAddress']; ?>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        Contact No&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $cust[0]['custMobile']; ?>
                      </div>
                    </div>
                    <?php if ($report == 'dailyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Customer Ledger Reports in : <?php echo $sdate.' - '.$edate; ?></b></h3>
                    </div>
                    <?php } else if ($report == 'monthlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Customer Ledger Reports in : <?php echo $name.' '.$year; ?></b></h3>
                    </div>
                    <?php } else if ($report == 'yearlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Customer Ledger Reports in : <?php echo $year; ?></b></h3>
                    </div>
                    <?php } else { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Customer Ledger Reports</b></h3>
                    </div>
                    <?php } ?>
                  
                    <div id="table-content">
                      <table id="" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>#SN.</th>
                            <th>Date</th>
                            <th>Invoice</th>
                            <th>Particulars</th>
                            <th>Total</th>
                            <th>Quantity</th>
                            <!--<th>Price</th>-->
                            <!--<th>Due</th>-->
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($sale != null) { ?>

                          <?php
                          $i = 0;
                          $tsa = 0;
                          $tpa = 0;
                          $tda = 0;
                          $tdu = 0;
                          foreach ($sale as $value){
                          $i++;
                          ?>
                          <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($value->saDateOne)); ?></td>
                            <td><?php echo $value->invoiceOne; ?></td>
                            <td><?php echo 'Sales'; ?></td>
                            <td><?php echo number_format(($value->quantityOne), 2); $tsa += $value->quantityOne; ?></td> 
                            <td><?php echo number_format(($value->uprice), 2); $tda += $value->uprice; ?></td>
                            <!--<td><?php echo number_format(($value->pAmount), 2); $tpa += $value->pAmountOne; ?></td>-->
                            <!--<td><?php echo number_format(($value->dAmount), 2); $tdu += $value->dAmount; ?></td> -->
                          </tr>   
                          <?php } ?> 
                          <?php } else{ ?>
                          <?php $i = 0; ?>
                          <?php $tsa = 0; $tpa = 0; $tda = 0; $tdu = 0; ?>
                          <?php } ?>

                          <?php if ($voucher != null) { ?>

                          <?php
                          $j = $i;
                          $tcva = 0;
                          foreach ($voucher as $value) {
                          $j++;
                          ?>
                          <tr class="gradeX">
                            <td><?php echo $j; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($value->vDate)); ?></td>
                            <td><?php echo $value->invoice; ?></td>
                            <td><?php echo $value->vType; ?></td>
                            <td><?php echo '00'; ?></td> 
                            <td><?php echo '00'; ?></td> 
                            <td><?php echo number_format(($value->tAmount), 2); $tcva += $value->tAmount; ?></td> 
                            <td><?php echo '00'; ?></td> 
                          </tr>   
                          <?php } ?>
                          <?php } else{ ?>
                          <?php $tcva = 0; ?>
                          <?php } ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th colspan="4" style="text-align: right;">Total Amount</th>
                            <th><?php echo number_format($tsa, 2); ?></th>
                            <th><?php echo number_format($tda, 2); ?></th>
                            <!--<th><?php echo number_format(($tpa+$tcva), 2); ?></th>-->
                            <!--<th><?php echo number_format(($tdu-$tcva), 2); ?></th>-->
                          </tr>
                        </tfoot>
                      </table>
                    </div>

                    <div class="col-sm-12 col-md-12 col-12" style="position: fixed; bottom: 0;">
                      <div class="row">
                        <div class="col-md-4 col-sm-4 col-4" style="text-align: center;">
                          <p>------------------------------</p>
                          <p>Prepared By</p>
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
                    <?php } ?>
                  </div><br>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center; margin-top: 20px">
                    <a href="javascript:void(0)" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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
      $(document).ready(function(){
        $('#daily').click(function(){
          $('#dreports').removeAttr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');
          $('#reports').attr('class','d-none');

          $('#sdate').attr('required','required');
          $('#edate').attr('required','required');
          $('#dcustomer').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mcustomer').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ycustomer').removeAttr('required','required');

          $('#customer').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');
          $('#reports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dcustomer').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          $('#mcustomer').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ycustomer').removeAttr('required','required');

          $('#customer').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#reports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dcustomer').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mcustomer').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          $('#ycustomer').attr('required','required');

          $('#customer').removeAttr('required','required');
          });

        $('#ocust').click(function(){
          $('#yreports').attr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#reports').removeAttr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dcustomer').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mcustomer').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ycustomer').removeAttr('required','required');

          $('#customer').attr('required','required');
          });
        });
    </script> 