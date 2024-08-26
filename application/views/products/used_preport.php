<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Used Product Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Used Product Report</li>
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
                <h3 class="card-title">Used Product Report</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>usedPReport" method="get">
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
                            <label>Select Product *</label>
                            <select class="form-control select2" name="dproduct" id="dproduct" required="" >
                              <option value="All">All Product</option>
                              <?php foreach($product as $value){ ?>
                              <option value="<?php echo $value['pid']; ?>" ><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <select class="form-control select2" name="dsupplier" id="dsupplier" required="" >
                              <option value="All">All Supplier</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supid']; ?>" ><?php echo $value['supName'].' ( '.$value['supCode'].' )'; ?></option>
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
                            <label>Select Product *</label>
                            <select class="form-control select2" name="mproduct" id="mproduct" required="" >
                              <option value="All">All Product</option>
                              <?php foreach($product as $value){ ?>
                              <option value="<?php echo $value['pid']; ?>" ><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <select class="form-control select2" name="msupplier" id="msupplier" required="" >
                              <option value="All">All Supplier</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supid']; ?>" ><?php echo $value['supName'].' ( '.$value['supCode'].' )'; ?></option>
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Product *</label>
                            <select class="form-control select2" name="yproduct" id="yproduct" required="" >
                              <option value="All">All Product</option>
                              <?php foreach($product as $value){ ?>
                              <option value="<?php echo $value['pid']; ?>" ><?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <select class="form-control select2" name="ysupplier" id="ysupplier" required="" >
                              <option value="All">All Supplier</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supid']; ?>" ><?php echo $value['supName'].' ( '.$value['supCode'].' )'; ?></option>
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
                  <?php 
                    if(isset($_GET['search'])) { 
                        if($supid != 'All'){
                            $sup = $this->db->select('*')
                                            ->from('suppliers')
                                            ->where('supid', $supid)
                                            ->get()
                                            ->row();
                            if($sup){
                                $customTitle = $sup->supName;
                            }else{
                                $customTitle = 'All';
                            }
                        }elseif($pid != 'All'){
                            $pro = $this->db->select('*')
                                            ->from('products')
                                            ->where('pid', $pid)
                                            ->get()
                                            ->row();
                            if($pro){
                                $customTitle = $pro->pName;
                            }else{
                                $customTitle = 'All';
                            }
                        }
                  
                  ?>
                  <?php if ($report == 'dailyReports') {?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b><?php if(isset($customTitle)){ echo $customTitle; } ?>  Reports in : <?php echo date('d-m-Y',strtotime($sdate)).' To '.date('d-m-Y',strtotime($edate)); ?></b></h3>
                    </div>
                  <?php } else if ($report == 'monthlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b><?php if(isset($customTitle)){ echo $customTitle; } ?>   Reports in : <?php echo $name.' To '.$year; ?></b></h3>
                    </div>
                  <?php } else if ($report == 'yearlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b><?php if(isset($customTitle)){ echo $customTitle; } ?>   Reports in : <?php echo $year; ?></b></h3>
                    </div>
                  <?php } ?>
                  <?php } ?>
                  
                  <?php if(isset($_GET['search'])) { ?>  
                  <div class="col-sm-12 col-md-12 col-12">
                    <table id="example1" class="table table-striped table-bordered" >
                      <thead>
                        <tr>
                          <th style="width: 5%;">#SN.</th>
                          <th>Product</th>
                          <th>Particulars</th>
                          <th>Qty</th>
                          <?php
                            if($order && $deliver){
                                echo '<th>Suppliers Name</th>';
                                echo '<th>Employee Name</th>';
                            }
                            else{
                                if($order){
                                    echo '<th>Supplier Name</th>';
                                }
                                if($deliver){
                                    echo '<th>Employee Name</th>';
                                }
                            }
                          ?>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 0;
                        if($ostore){
                        foreach($ostore as $value) {
                        $i++;
                        
                        // $price = $this->db->select('pprice')
                        //                   ->from('purchase_product')
                        //                   ->where('purchase_product.pid', $value->pid)
                        //                   ->get()
                        //                   ->row();
                        // var_dump($price);
                        
                        ?>
                        <tr class="gradeX" <?php if($supid != 'All'){ ?> style="display: none;" <?php } ?>>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $value->pName.' ('.$value->pCode.')'; ?></td>
                          <td><?php echo 'Opening'; ?></td>
                          <td><?php echo $value->quantity; ?></td>
                          <?php
                            if($order && $deliver){
                                echo '<td></td>';
                            }
                          ?>
                          <td></td>
                          <td><?php echo date('d-m-Y',strtotime($value->regdate)); ?></td>
                        </tr>   
                        <?php } } ?>
                        <?php
                        $j = $i;
                        if($cstock){
                        foreach($cstock as $svalue) {
                        $j++;
                        ?>
                        <tr class="gradeX" <?php if($supid != 'All'){ ?> style="display: none;" <?php } ?> >
                          <td><?php echo $j; ?></td>
                          <td><?php echo $svalue->pName; ?></td>
                          <td><?php echo 'Adjusted Stock'; ?></td>
                          <td><?php echo $svalue->quantity; ?></td>
                          <?php
                            if($order && $deliver){
                                echo '<td></td>';
                            }
                          ?>
                          <td></td>
                          <td><?php echo date('d-m-Y',strtotime($svalue->regdate)); ?></td>
                        </tr>   
                        <?php } } ?>
                        <?php
                        if($supid == 'All')
                          {
                          $k = $j;
                          }
                        else
                          {
                          $k = 0;
                          }
                          if($order){
                        //   var_dump($order);exit();
                        foreach($order as $ovalue) {
                        $k++;
                        ?>
                        <tr class="gradeX">
                          <td><?php echo $k; ?></td>
                          <td><?php echo $ovalue->pName; ?></td>
                          <td><a href="<?php echo site_url().'viewWOrder/'.$ovalue->puid; ?>" target="_blank" ><?php echo $ovalue->memoNo; ?></a></td>
                          <td><?php echo $ovalue->quantity; ?></td>
                          <td><?php echo $ovalue->supName; ?></td>
                          <?php
                            if($order && $deliver){
                                echo '<td></td>';
                            }
                          ?>
                          <td><?php echo date('d-m-Y',strtotime($ovalue->puDate)); ?></td>
                        </tr>   
                        <?php } } ?>
                        <?php
                        $l = $k;
                        if($deliver){
                        foreach($deliver as $dvalue) {
                        $l++;
                        ?>
                        <tr class="gradeX" <?php if($supid != 'All'){ ?> style="display: none;" <?php } ?> >
                          <td><?php echo $l; ?></td>
                          <td><?php echo $dvalue->pName; ?></td>
                          <td><a href="<?php echo site_url().'viewDelivery/'.$dvalue->did; ?>" target="_blank" ><?php echo $dvalue->rInvoice; ?></td>
                          <td><?php echo $dvalue->quantity; ?></td>
                          <?php
                            if($order && $deliver){
                                echo '<td></td>';
                            }
                          ?>
                          <td><?php echo $dvalue->uName; ?></td>
                          <td><?php echo date('d-m-Y',strtotime($dvalue->dDate)); ?></td>
                        </tr>   
                        <?php } } ?>
                      </tbody>
                    </table>
                  </div>
                  <?php } ?>
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
      $(document).ready(function(){
        $('#daily').click(function(){
          $('#dreports').removeAttr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').attr('required','required');
          $('#edate').attr('required','required');
          $('#dproduct').attr('required','required');
          $('#dsupplier').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mproduct').removeAttr('required','required');
          $('#msupplier').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#yproduct').removeAttr('required','required');
          $('#ysupplier').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dproduct').removeAttr('required','required');
          $('#dsupplier').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          $('#mproduct').attr('required','required');
          $('#msupplier').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#yproduct').removeAttr('required','required');
          $('#ysupplier').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dproduct').removeAttr('required','required');
          $('#dsupplier').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mproduct').removeAttr('required','required');
          $('#msupplier').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          $('#yproduct').attr('required','required');
          $('#ysupplier').attr('required','required');
          });
        });
    </script>