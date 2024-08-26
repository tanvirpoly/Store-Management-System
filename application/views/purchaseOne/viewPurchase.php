<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>
<style>
    #printOnly {
       display : none;
    }
    
    @media print {

        #printOnly {
           display : block;
           text-align:center;
        }
    }
 
</style>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Purchase</li>
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
                <h3 class="card-title">Purchase Information</h3>
              </div>

              <div class="card-body">
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row" >
                      <div class="col-12">
                        <h3>
                          <?php if($company){ ?><img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>" style="height:90px; width: auto;position:relative; top:80px;"><?php } ?>
                        </h3>
                      </div>
                    </div>
                    <div class="row invoice-info" style="text-align:center;">
                      <div class="col-sm-12 col-12 invoice-col">
                        <address>
                         <?php if($company){ ?><?php echo '<h5>'.'<b>'.$company->compName.'</b>'; ?><?php } ?><br>
                          <?php if($company){ ?><?php echo '<b>'.$company->compAddress.'</b>'; ?><?php } ?><br>
                         <?php if($company){ ?><?php echo '<b>'.$company->compMobile.'</b>'; ?><?php } ?><br>
                        <?php if($company){ ?><?php echo '<b>'.$company->compEmail.'</b>'; ?><?php } ?><br>
                        </address>
                      </div>
                    </div>
                    <div class="row" style="text-align:center">
                      <div  class="col-sm-12 col-12">
                        <h2><b>Cash purchase invoice</b></h2>
                      </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
                      <label>Date:</label>
                      <?php echo date('m/d/Y',strtotime($purchase['purchaseDate'])) ?>
                    </div>
                    
                    
                    <div class="row">
                        <div class=" col-md-12 col-sm-12 col-xs-12"style="padding-left:8px;">
                            <label>Of The Institute *</label>
                            <?php echo $purchase['istitudeP']; ?>
                            <label style="padding-left:10px;">Items mentioned below for the requirements of the department/branch/committee</label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <label>Work Order No. *</label>
                           <?php echo $purchase['workNO']; ?>
                           <br>
                           <label>With the approval of the authority, M/s  *</label>
                            <?php echo $purchase['permitName']; ?>
                            <br>
                            <label>Address *</label>
                           <?php echo $purchase['address']; ?>
                        </div>
                       
                        <div class="form-group col-md-6 col-sm-6 col-xs-6" >
                            <div style="margin-left:60px;">
                                <label>Memo No *</label>
                                <?php echo $purchase['memoNO']; ?>
                            </div>
                            <div style="margin-left:60px;">
                                <label>Purchase Date *</label>
                                <?php echo $purchase['purchaseDate']; ?>
                            <label style="padding-left:10px;">Purchased through</label>
                            
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-12">
                        <table class="table table-striped">
                        <thead class="topics">
                          <tr>
                            <th>SL No</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                          </tr>
                        </thead>
                        <tbody class="topics">
                          <?php $i = 0;foreach($pproduct as $value){
                            $i++;
                          ?>
                          <tr>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                              <?php echo $value['pName']; ?>
                           
                            </td>
                            <td>
                             <?php echo $value['quantity']; ?>
                            </td>
                            <td>
                              <?php echo $value['pprice']; ?>
                           </td>
                            <td>
                              <?php echo $value['total_price'];?>
                            </td>
                            
                           
                          </tr>
                          <?php } ?>
                        </tbody>
                        <tr>
                           <td>
                               <?php $twa = round(abs($purchase['totalPrice'])); ?>
                              <td>(<b>In Words</b>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo '<b>'.convertNumber($twa).'</b>'; ?> )</td>
                            </td>
                            <td></td>
                            <td><b>Total Price:</b></td>
                            <td colspan="4"><?php echo '<b>'.$purchase['totalPrice'].'</b>';?></td>   
                        </tr>
                        </table>
                      </div>
                    </div>
                   
                <!--    <div class="row hidden">-->
                <!--     <div class="form-group col-md-3 col-sm-3 col-xs-12">-->
                <!--      <label>Account Type *</label>-->
                <!--      <?php echo $purchase['accountType'];?>-->
                <!--    </div>-->
                <!--    <div class="form-group col-md-3 col-sm-3 col-xs-12">-->
                <!--      <label>Account Number *</label>-->
                      
                <!--      <?php echo $purchase['accountNo'];?>-->
                <!--    </div>-->

                <!--    <div class="form-group col-md-3 col-sm-3 col-xs-12">-->
                <!--      <label>Note</label>-->
                <!--      <?php echo $purchase['note']; ?>-->
                <!--      </div>-->
                    
                <!--</div>-->
                <div class="row"style="margin-top:3px;">
                   
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           
                                <label>Name of Purchaser. *</label>
                               <?php echo $purchase['purchaseName']; ?>
                                <br>
                           
                                <b>Name of Purchaser Signature:</b>
                                <br>
                          
                                <label>Designation. *</label>
                                <?php echo $purchase['podobi']; ?>
                           
                        </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <div style="margin-left:60px;">
                                <label>Entry No. *</label>
                               <?php echo $purchase['entryVuktiDate']; ?>
                            </div>
                                
                             <div style="margin-left:60px;">
                                <label>Date *</label>
                               <?php echo date('m/d/Y',strtotime($purchase['lastDate'])) ?>
                             </div>
                           
                                
                             
                    </div>
                 
                </div>
                    
                    <!--<div class="row">-->
                        
                    <!--    <div class="col-md-3 col-sm-3 col-xs-12">-->
                    <!--        <label>Entry No. *</label>-->
                    <!--       <?php echo $purchase['entryVuktiDate']; ?>-->
                    <!--    </div>-->
                    <!--      <div class=" col-md-3 col-sm-3 col-xs-12">-->
                    <!--        <label>Date *</label>-->
                    <!--       <?php echo date('m/d/Y',strtotime($purchase['lastDate'])) ?>-->
                    <!--       </div>-->
                    <!--   </div>-->
                 
                <div class="row" id="printOnly" style="bottom:40px;position: fixed;width:100%;">
              
                      <div class="col-md-12 col-12" style="text-align: center;">
                          <br><br>
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-4">
                            <p>------------------------------</p>
                            <p> Qualities are subject to verification </p>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                            <p>------------------------------</p>
                            <p> Head of Security Department </p>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                            <p>------------------------------</p>
                            <p>Head of Warehousing Department</p>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  
                  <div class="row no-print" >
                    <div class="col-12" style="text-align: center;">
                      <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')" ><i class="fas fa-print"></i> Print</a>
                      <a href="<?php echo site_url('Purchase') ?>" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
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