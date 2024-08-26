<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Stock Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Stock Report</li>
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
                <h3 class="card-title">Product Stock Report</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>stockReport" method="get">
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Year *</label>
                            <select class="form-control" name="year" id="year" required="" >
                              <?php $d = date("Y"); ?>
                              <option value="">Select One</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
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
                              <option value="">Select One</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
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
                
                <div id="print">
                  <div class="row" id="header" style="display: none" >
                    <?php if($company){ ?>
                    <div class="col-sm-2 col-md-2 col-2" style="margin-top: 30px;">
                      <img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>" style="width: 100%; height: auto;">
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
                  </div>
                  <div class="col-sm-12 col-md-12 col-12">
                    <table id="example1" class="table table-striped table-bordered" >
                      <thead>
                        <tr>
                          <th style="width: 5%;">#SN.</th>
                          <th>Name</th>
                          <th>Code</th>
                          <th>In Qty</th>
                          <th>Out Qty</th>
                          <th>Rf Qty</th>
                          <th>Open Stock</th>
                          <th>Stock</th>
                          <th style="width: 10%;">Damage</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 0;
                        $tpq = 0;
                        $tsq = 0;
                        $trq = 0;
                        $tps = 0;
                        $tq = 0;
                        $tr = 0;
                        $taq = 0;
                        foreach ($stock as $result){
                        
                        $pid = $result['pid'];
                        $cid = $result['compid'];
                        if(isset($_GET['search']))
                          {
                          $report = $_GET['reports'];
                          $data['report'] = $report;
                              //var_dump($data['report']); exit();
                          if($report == 'dailyReports')
                            {
                            $rp = $this->db->select("SUM(quantity) as trq")
                                          ->from('returns_product')
                                          ->where('productID',$pid)
                                          ->where('DATE(regdate) >=', $sdate)
                                          ->where('DATE(regdate) <=', $edate)
                                          ->get()
                                          ->row();
                            $pp = $this->db->select("SUM(quantity) as tpq")
                                          ->from('purchase_product')
                                          ->where('pid',$pid)
                                          ->where('DATE(regdate) >=', $sdate)
                                          ->where('DATE(regdate) <=', $edate)
                                          ->get()
                                          ->row();
                            $spp = $this->db->select("SUM(quantity) as tsq")
                                          ->from('delivery_product')
                                          ->where('pid',$pid)
                                          ->where('DATE(regdate) >=', $sdate)
                                          ->where('DATE(regdate) <=', $edate)
                                          ->get()
                                          ->row();
                            $pspp = $this->db->select("SUM(quantity) as tsq")
                                          ->from('store_pdetails')
                                          ->where('pid',$pid)
                                          ->where('DATE(regdate) >=', $sdate)
                                          ->where('DATE(regdate) <=', $edate)
                                          ->get()
                                          ->row();
                            $pds = $this->db->select("SUM(quantity) as tsq")
                                          ->from('store_dproduct')
                                          ->where('pid',$pid)
                                          ->where('DATE(regdate) >=', $sdate)
                                          ->where('DATE(regdate) <=', $edate)
                                          ->get()
                                          ->row();
                            }
                          else if($report == 'monthlyReports')
                            {
                            $rp = $this->db->select("SUM(quantity) as trq")
                                          ->from('returns_product')
                                          ->where('productID',$pid)
                                          ->where('MONTH(regdate)',$month)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            $pp = $this->db->select("SUM(quantity) as tpq")
                                          ->from('purchase_product')
                                          ->where('pid',$pid)
                                          ->where('MONTH(regdate)',$month)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            $spp = $this->db->select("SUM(quantity) as tsq")
                                          ->from('delivery_product')
                                          ->where('pid',$pid)
                                          ->where('MONTH(regdate)',$month)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            $pspp = $this->db->select("SUM(quantity) as tsq")
                                          ->from('store_pdetails')
                                          ->where('pid',$pid)
                                          ->where('MONTH(regdate)',$month)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            $pds = $this->db->select("SUM(quantity) as tsq")
                                          ->from('store_dproduct')
                                          ->where('pid',$pid)
                                          ->where('MONTH(regdate)',$month)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            }
                          else if($report == 'yearlyReports')
                            {
                            $rp = $this->db->select("SUM(quantity) as trq")
                                          ->from('returns_product')
                                          ->where('productID',$pid)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            $pp = $this->db->select("SUM(quantity) as tpq")
                                          ->from('purchase_product')
                                          ->where('pid',$pid)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            $spp = $this->db->select("SUM(quantity) as tsq")
                                          ->from('delivery_product')
                                          ->where('pid',$pid)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            $pspp = $this->db->select("SUM(quantity) as tsq")
                                          ->from('store_pdetails')
                                          ->where('pid',$pid)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            $pds = $this->db->select("SUM(quantity) as tsq")
                                          ->from('store_dproduct')
                                          ->where('pid',$pid)
                                          ->where('YEAR(regdate)',$year)
                                          ->get()
                                          ->row();
                            }
                          }
                        else
                          {
                          $rp = $this->db->select("SUM(quantity) as trq")
                                      ->from('returns_product')
                                      ->where('productID',$pid)
                                      ->get()
                                      ->row();
                          $pp = $this->db->select("SUM(quantity) as tpq")
                                      ->from('purchase_product')
                                      ->where('pid',$pid)
                                      ->get()
                                      ->row();
                          $spp = $this->db->select("SUM(quantity) as tsq")
                                      ->from('delivery_product')
                                      ->where('pid',$pid)
                                      ->get()
                                      ->row();
                          $pspp = $this->db->select("SUM(quantity) as tsq")
                                      ->from('store_pdetails')
                                      ->where('pid',$pid)
                                      ->get()
                                      ->row();
                          $pds = $this->db->select("SUM(quantity) as tsq")
                                      ->from('store_dproduct')
                                      ->where('pid',$pid)
                                      ->get()
                                      ->row();
                          }
						if($result['pName'] != NULL){
						$i++;
                        ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $result['pName']; ?></td>
                          <td><?php echo $result['pCode']; ?></td>
                          <td>
                            <?php if($pp->tpq > 0){ ?>
                            <?php echo $pp->tpq; $tpq += $pp->tpq; ?>
                            <?php } else{ ?>
                            <?php echo '0'; $tpq += '0'; ?>
                            <?php } ?>
                          </td>
                          <td>
                            <?php if($spp->tsq > 0){ ?>
                            <?php echo $spp->tsq; $tsq += $spp->tsq; ?>
                            <?php } else{ ?>
                            <?php echo '0'; $tsq += '0'; ?>
                            <?php } ?>
                          </td>
                          <td>
                            <?php if($rp->trq > 0){ ?>
                            <?php echo $rp->trq; $trq += $rp->trq; ?>
                            <?php } else{ ?>
                            <?php echo '0'; $trq += '0'; ?>
                            <?php } ?>
                          </td>
                          <td>
                            <?php if($pspp->tsq > 0){ ?>
                            <?php echo $pspp->tsq; $tps += $pspp->tsq; ?>
                            <?php } else{ ?>
                            <?php echo '0'; $tps += 0; ?>
                            <?php } ?>
                          </td>
                          <td><?php echo (($pp->tpq+$pspp->tsq)-($spp->tsq+$pds->tsq)); $tq += (($pp->tpq+$pspp->tsq)-($spp->tsq+$pds->tsq)); ?></td>
                          <td><?php echo $pds->tsq; $tr += $pds->tsq; ?></td>
                        </tr>
                        <?php } } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="3" style="text-align: right;" >Total</th>
                          <th><?php echo $tpq; ?></th>
                          <th><?php echo $tsq; ?></th>
                          <th><?php echo $trq; ?></th>
                          <th><?php echo $tps; ?></th>
                          <th><?php echo $tq; ?></th>
                          <th><?php echo $tr; ?></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                <div class="row" id="printOnly" style="bottom:0;position: fixed;width:100%;">
              
                      <div class="col-md-12 col-12" style="text-align: center;">
                          <br><br>
                        <div class="row">
                         <div class="col-md-3 col-sm-3 col-3">
                                  <p>------------------------</p>
                                  <p>Store officer</p>
                                  
                              </div>
                              <div class="col-md-3 col-sm-3 col-3">
                                 
                                  
                              </div>
                              <div class="col-md-3 col-sm-3 col-3">
                                  
                                  
                              </div>
                              <div class="col-md-3 col-sm-3 col-3">
                                  <p>------------------------</p>
                                  <p>Register Officer</p>
                                  
                              </div>
                        </div>
                      </div>
                    </div>
              
                </div><br>
                <div class="form-group col-md-12" style="text-align: center;margin-top: 20px">
                  <a href="javascript:void(0)" value="Print" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"> </i>  Print</a>
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

          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          });
        });
    </script>