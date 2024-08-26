<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Purchase Reports</li>
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
                <h3 class="card-title">Purchase Reports</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>purchaseReport" method="get">
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
                            <select class="form-control select2" name="dsupplier" id="dsupplier" required="" >
                              <option value="All">All Supplier</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supplierID']; ?>"><?php echo $value['supplierName'].' ( '.$value['sup_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <!--<div class="form-group col-md-3 col-sm-3 col-12">-->
                          <!--  <label>Select Company *</label>-->
                          <!--  <select class="form-control" name="dcompany"  >-->
                          <!--    <option value="All">All Company</option>-->
                          <!--    <?php foreach($company as $value){ ?>-->
                          <!--    <option value="<?php echo $value['com_pid']; ?>"><?php echo $value['com_name']; ?></option>-->
                          <!--    <?php } ?>-->
                          <!--  </select>-->
                          <!--</div>-->
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
                              <option value="">Select Year</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <select class="form-control select2" name="msupplier" id="msupplier" required="" >
                              <option value="All">All Supplier</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supplierID']; ?>"><?php echo $value['supplierName'].' ( '.$value['sup_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <!--<div class="form-group col-md-3 col-sm-3 col-12">-->
                          <!--  <label>Select Company *</label>-->
                          <!--  <select class="form-control" name="mcompany"  >-->
                          <!--    <option value="All">All Company</option>-->
                          <!--    <?php foreach($company as $value){ ?>-->
                          <!--    <option value="<?php echo $value['com_pid']; ?>"><?php echo $value['com_name']; ?></option>-->
                          <!--    <?php } ?>-->
                          <!--  </select>-->
                          <!--</div>-->
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
                            <select class="form-control select2" name="ysupplier" id="ysupplier" required="" >
                              <option value="All">All Supplier</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supplierID']; ?>"><?php echo $value['supplierName'].' ( '.$value['sup_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <!--<div class="form-group col-md-3 col-sm-3 col-12">-->
                          <!--  <label>Select Company *</label>-->
                          <!--  <select class="form-control" name="ycompany"  >-->
                          <!--    <option value="All">All Company</option>-->
                          <!--    <?php foreach($company as $value){ ?>-->
                          <!--    <option value="<?php echo $value['com_pid']; ?>"><?php echo $value['com_name']; ?></option>-->
                          <!--    <?php } ?>-->
                          <!--  </select>-->
                          <!--</div>-->
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
                    <div class="">
                      <table id="example" class="table table-responsive table-bordered" >
                        <thead>
                          <tr>
                            <th style="width: 5%;">#SN</th>
                            <th>Challan</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Purchase</th>
                            <th>Paid</th>
                            <th style="width: 10%;">Due</th>
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
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $result->challanNo; ?></td>
                            <td><?php echo date('j F Y',strtotime($result->purchaseDate)) ?></td>
                            <td><?php echo $result->supplierName.' ( '.$result->sup_id.' )'; ?></td>
                            <td><?php echo number_format($result->totalPrice, 2); $tp += $result->totalPrice; ?></td>
                            <td><?php echo number_format($result->paidAmount, 2); $tpa += $result->paidAmount; ?></td>
                            <td><?php echo number_format($result->due, 2); $td += $result->due; ?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                        <tbody>
                          <tr>
                            <td colspan="4" align="right">Total Amount</td>
                            <td><?php echo number_format($tp, 2); ?></td>
                            <td><?php echo number_format($tpa, 2); ?></td>
                            <td><?php echo number_format($td, 2); ?></td>
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