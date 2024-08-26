<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Work Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Work Order</li>
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
                <h3 class="card-title">Work Order Information</h3>
              </div>

              <div class="card-body">
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row">
                      <div class="col-12">
                        <h4>
                          <?php if($company){ ?><img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>" style="height:50px; width: auto;"><?php } ?>
                        </h4>
                      </div>
                    </div>
                    <div class="row invoice-info">
                      <div class="col-sm-4 col-4 invoice-col">
                        From
                        <address>
                          Address : <?php if($company){ ?><?php echo $company->compAddress; ?><?php } ?><br>
                          Phone : <?php if($company){ ?><?php echo $company->compMobile; ?><?php } ?><br>
                          Email : <?php if($company){ ?><?php echo $company->compEmail; ?><?php } ?><br>
                        </address>
                      </div>
                      <div class="col-sm-4 col-4 invoice-col">
                        To
                        <address>
                          Supplier : <?php echo $purchase['supName'].' ( '.$purchase['supCode'].' )'; ?><br>
                          Mobile : <?php echo $purchase['supMobile']; ?><br>
                          Address : <?php echo $purchase['supAddress']; ?><br>
                        </address>
                      </div>
                      <div class="col-sm-4 col-4 invoice-col">
                        <b>Memo No. # <?php echo $purchase['roMemo']; ?></b><br>
                        <b>Receive Date :</b> <?php echo date('d-m-Y', strtotime($purchase['roDate'])); ?>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-12">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>Product</th>
                              <th>Rack</th>
                              <th>Warranty</th>
                              <th>Order Quantity</th>
                              <th>Received Quantity</th>
                              <th>Unit Price</th>
                              <th>Sub Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tq = 0;
                            $tpa = 0;
                            foreach ($pproduct as $value) {
                            $i++;
                            
                            $mp = $this->db->select('SUM(purchase_product.quantity) as total,purchase.memoNo')
                                          ->from('purchase_product')
                                          ->join('purchase','purchase.puid = purchase_product.puid','left')
                                          ->where('pid',$value['pid'])
                                          ->where('memoNo',$value['roMemo'])
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
                            
                            $rproduct = $this->db->select('sNumber')
                                          ->from('receive_pserial')
                                          ->where('pid',$value['pid'])
                                          ->where('roid',$purchase['roid'])
                                          ->get()
                                          ->result();
                            
                            $wproduct = $this->db->select('pWarranty')
                                          ->from('receive_pwarranty')
                                          ->where('pid',$value['pid'])
                                          ->where('roid',$purchase['roid'])
                                          ->get()
                                          ->result();
                                 
                            ?>
                            <tr style="min-height: 200px;">
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['pName']; ?> <?php if($rproduct){ ?>( <?php foreach($rproduct as $rvalue){ ?><?php echo $rvalue->sNumber; ?>, <?php } ?>)<?php } ?></td>
                              <td><?php echo $value['rNumber']; ?></td>
                              <td> <?php if($wproduct){ ?><?php foreach($wproduct as $wvalue){ ?><?php echo date('d-m-Y', strtotime($wvalue->pWarranty)); ?>, <br><?php } ?><?php } ?></td>
                              <td><?php echo round($tdqnt); ?></td>
                              <td><?php echo round($value['quantity']); $tq += $value['quantity']; ?></td>
                              <td><?php echo number_format($value['pprice'], 2); ?></td>
                              <td><?php echo number_format($value['tprice'], 2); $tpa += $value['tprice']; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                          <tbody>
                            <tr>
                              <td colspan="5" align="right">Total</td>
                              <td><?php echo $tq; ?></td>
                              <td></td>
                              <td><?php echo number_format($tpa, 2); ?></td>
                            </tr>
                          </tbody>
                          <tbody style="text-align: center;">
                            <tr>
                              <?php $twa = round(abs($tpa)); ?>
                              <td colspan="8">( In Words&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo convertNumber($twa); ?> )</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
                      <p class="lead"><?php echo $purchase['note']; ?></p>
                    </div>

                    <div class="row">
                      <div class="col-md-12 col-12" style="text-align: center;">
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-4">
                            <p>------------------------------</p>
                            <p>Department-Head</p>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                           
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                            <p>------------------------------</p>
                            <p>Store Officer</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row no-print" >
                    <div class="col-12" style="text-align: center;">
                      <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')" ><i class="fas fa-print"></i> Print</a>
                      <a href="<?php echo site_url('orderReceive'); ?>" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
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

    <?php
      function convertNumber($number){
        $words = array(
          '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty');
    
        $number_length = strlen($number);

        $number_array = array(0,0,0,0,0,0,0,0,0);        
        $received_number_array = array();
    
        for($i=0;$i<$number_length;$i++)
          {    
          $received_number_array[$i] = substr($number,$i,1);    
          }
        
        for($i=9-$number_length,$j=0;$i<9;$i++,$j++)
          { 
          $number_array[$i] = $received_number_array[$j]; 
          }
        $number_to_words_string = "";

        for($i=0,$j=1;$i<9;$i++,$j++)
          {
          if($i==0 || $i==2 || $i==4 || $i==7)
            {
            if($number_array[$j]==0 || $number_array[$i] == "1")
              {
              $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
              $number_array[$i] = 0;
              }
            }
          }
        $value = "";
        for($i=0;$i<9;$i++)
          {
          if($i==0 || $i==2 || $i==4 || $i==7)
            {    
            $value = $number_array[$i]*10; 
            }
          else
            { 
            $value = $number_array[$i];    
            }            
          if($value!=0)
            {
            $number_to_words_string.= $words["$value"]." ";
            }
          if($i==1 && $value!=0)
            {
            $number_to_words_string.= "Crores ";
            }
          if($i==3 && $value!=0)
            {
            $number_to_words_string.= "Lakhs ";
            }
          if($i==5 && $value!=0)
            {
            $number_to_words_string.= "Thousand ";
            }
          if($i==6 && $value!=0)
            {
            $number_to_words_string.= "Hundred ";
            }            
          }
        if($number_length>9)
          {
          $number_to_words_string = "Sorry This does not support more than 99 Crores";
          }
        return ucwords(strtolower($number_to_words_string)." Taka Only.");
        }
    ?>