<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Voucher Report</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Voucher Report</h3>
            </div>

            <div class="card-body">
              <div class="col-sm-12 col-md-12 col-12">
                <form action="<?php echo base_url() ?>vReports" method="get">
                  
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
                        <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('d-m-Y') ?>" id="sdate" required="" >
                      </div>
                      <div class="form-group col-md-2 col-sm-2 col-12">
                        <label>End Date *</label>
                        <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('d-m-Y') ?>" id="edate" required="" >
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Voucher Type *</label>
                        <select class="form-control" name="dvtype" id="dvtype" required="" >
                          <option value="All">All</option>
                          <option value="Credit Voucher">Credit Voucher</option>
                          <option value="Debit Voucher">Debit Voucher</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus"></i>&nbsp;Search</button>
                      </div>
                    </div>
                  </div>

                  <div class="d-none" id="mreports">
                    <div class="row">
                      <div class="form-group col-md-2 col-sm-2 col-12">
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
                        <label>Voucher Type *</label>
                        <select class="form-control" name="mvtype" id="mvtype" required="" >
                          <option value="All">All</option>
                          <option value="Credit Voucher">Credit Voucher</option>
                          <option value="Debit Voucher">Debit Voucher</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus"></i>&nbsp;Search</button>
                      </div>
                    </div>
                  </div>

                  <div class="d-none" id="yreports">
                    <div class="row">
                      <div class="form-group col-md-2 col-sm-2 col-12">
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
                        <label>Voucher Type *</label>
                        <select class="form-control" name="yvtype" id="yvtype" required="" >
                          <option value="All">All</option>
                          <option value="Credit Voucher">Credit Voucher</option>
                          <option value="Debit Voucher">Debit Voucher</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

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
                <div class="col-sm-12 col-md-12 col-12">
                  <?php if(isset($_GET['search'])) { ?>
                  <?php if ($report == 'dailyReports') { ?>
                  <div class="box-header" style="text-align: center;">
                    <h3 class="box-title"><b>Voucher Reports in : <?php echo $sdate.' - '.$edate; ?></b></h3>
                  </div>
                  <?php } else if ($report == 'monthlyReports') { ?>
                  <div class="box-header" style="text-align: center;">
                    <h3 class="box-title"><b>Voucher Reports in : <?php echo $name.' '.$year; ?></b></h3>
                  </div>
                  <?php } else if ($report == 'yearlyReports') { ?>
                  <div class="box-header" style="text-align: center;">
                    <h3 class="box-title"><b>Voucher Reports in : <?php echo $year; ?></b></h3>
                  </div>
                  <?php } ?>
                  <?php } ?>      

                  <table id="example" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 5%;">#SN.</th>
                        <th>Date</th>
                        <th>V-No.</th>
                        <th>V-Type</th>
                        <th>Customer</th>
                        <th>Supplier</th>
                        <th>Employee</th>
                        <th style="width: 10%;">Credit</th>
                        <th style="width: 10%;">Debit</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0;
                      $tc = 0;
                      $td = 0;
                      foreach ($voucher as $value){
                      $i++;
                      $cid = $value->custid;
                      $eid = $value->regby;
                      $sid = $value->supid;

                      $customer = $this->db->select('custCode,custName')
                                        ->from('customers')
                                        ->where('custid',$cid)
                                        ->get()
                                        ->row();

                      $employee = $this->db->select('empid,uName')
                                        ->from('users')
                                        ->where('uid',$eid)
                                        ->get()
                                        ->row();

                      $supplier = $this->db->select('supCode,supName')
                                        ->from('suppliers')
                                        ->where('supid',$sid)
                                        ->get()
                                        ->row();
                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d-m-Y',strtotime($value->vDate)); ?></td>
                        <td><?php echo $value->invoice; ?></td>
                        <td><?php echo $value->vType; ?></td>
                        <td>
                          <?php if($customer){ ?>
                          <?php echo $customer->custName; ?>
                          <?php } else{ ?>
                          <?php echo 'N/A'; ?>
                          <?php } ?>
                        </td>
                        <td>
                          <?php if($supplier){ ?>
                          <?php echo $supplier->supName; ?>
                          <?php } else{ ?>
                          <?php echo 'N/A'; ?>
                          <?php } ?>
                        </td>
                        <td>
                          <?php if($employee){ ?>
                          <?php echo $employee->uName; ?>
                          <?php } else{ ?>
                          <?php echo 'N/A'; ?>
                          <?php } ?>
                        </td>
                        <td>
                          <?php if($value->vType == 'Credit Voucher'){ ?>
                          <?php echo number_format($value->tAmount, 2); $tc += $value->tAmount; ?>
                          <?php } else{ ?>
                          <?php echo '00'; ?>
                          <?php } ?>
                        </td>
                        <td>
                          <?php if($value->vType == 'Debit Voucher'){ ?>
                          <?php echo number_format($value->tAmount, 2); $td += $value->tAmount; ?>
                          <?php } else{ ?>
                          <?php echo '00'; ?>
                          <?php } ?>
                        </td>
                      </tr>  
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <th colspan="7" style="text-align: right;">Total Amount</th>
                      <th><?php echo number_format($tc, 2); ?></th>
                      <th><?php echo number_format($td, 2); ?></th>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center; margin-top: 20px">
                <a href="javascript:void(0)" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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
          $('#dvtype').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mvtype').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#yvtype').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dvtype').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          $('#mvtype').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#yvtype').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dvtype').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mvtype').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          $('#yvtype').attr('required','required');
          });
        });
    </script>






