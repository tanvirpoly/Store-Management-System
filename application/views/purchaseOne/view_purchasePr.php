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
                            <h2><b>Goods Receipt Report</b></h2>
                         </div>
                     </div>
                      <div class="form-group col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
                      <label>Purchase Date</label>
                      <?php echo date('m/d/Y',strtotime($purchase['purchaseDate'])) ?>
                    </div>
                    <!--<div class="form-group" style="padding-top:10px;padding-left:10px;">-->
                    <!--    <label>Of The Institute *</label>-->
                    <!--    <?php echo $purchase['istitudeP']; ?>-->
                    <!--    <label style="padding-left:10px;">Items mentioned below for the requirements of the department/branch/committee</label>-->
                    <!--</div>-->
                    <!--<div class="col-md-12 col-sm-12 col-xs-12">-->
                    <!--    <label>Work Order No. *</label>-->
                    <!--   <?php echo $purchase['workNO']; ?>-->
                       
                    <!--</div>-->
                    <!--<div class="col-md-12 col-sm-12 col-xs-12">-->
                    <!--    <label>With the approval of the authority, M/s  *</label>-->
                    <!--    <?php echo $purchase['permitName']; ?>-->
                    <!--</div>-->
                    <!--<div class=" col-md-12 col-sm-12 col-xs-12">-->
                    <!--    <label>Address *</label>-->
                    <!--   <?php echo $purchase['address']; ?>-->
                        
                    <!--</div>-->
                    <!--<div class="col-md-12 col-sm-12 col-xs-12">-->
                    <!--    <label>Memo No *</label>-->
                    <!--   <?php echo $purchase['memoNO']; ?>-->
                        
                    <!--</div>-->
                    <!--<div class="form-group col-md-12 col-sm-12 col-xs-12" style="padding-top:10px;padding-left:10px;">-->
                    <!--    <label>Purchase Date *</label>-->
                    <!--   <?php echo $purchase['purchaseDate']; ?>-->
                    <!--    <label style="padding-left:10px;">Purchased through</label>-->
                    <!--</div>-->
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
                    <style>
                        .bordered {
                                border-top: 1px solid black;    /* Top border */
                                border-bottom: 1px solid black; /* Bottom border */
                            }
                            
                            .bordered .col-md-6, .bordered .col-sm-6 {
                                margin-bottom: 6px;             /* Optional: Adjust the space between the rows */
                            }
                            
                            .bordered .col-md-6:last-child, .bordered .col-sm-6:last-child {
                                border-bottom: none; /* Remove bottom border for the last item */
                            }
                            
                            .bordered .col-md-6:not(:last-child), .bordered .col-sm-6:not(:last-child) {
                                border-right: 1px solid black; /* Vertical border between the two columns */
                            }

                    </style>
                    <!--<div class="row bordered" style="line-height:2.6;">-->
                    <!--    <div class="col-md-6 col-sm-6">-->
                    <!--        <label>provider way:</label>-->
                    <!--        <br>-->
                    <!--        <label >provider Location:</label>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-6 col-sm-6" >-->
                    <!--        <label>Vehicle Receipt No:</label>-->
                    <!--        <br>-->
                    <!--        <label>Date:</label>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="row">
                      <div class="col-12">
                        <table class="table table-striped">
                          
                          
                             <thead class="topics">
                          <tr>
                            <th>SL NO</th>
                            <th>Product</th>
                            <!--<th>Location</th>-->
                            <!--<th>Code No</th>-->
                            <th>Quantity</th>
                            <th>Unit Type</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Note</th>
                          </tr>
                        </thead>
                        <tbody class="topics">
                          <?php $i =0;foreach($pproduct as $value){
                                $i++;
                          ?>
                          <tr>
                            <td>
                             <?php echo $i;?>
                            </td>
                            <td>
                              <?php echo $value['pName']; ?>
                           
                            </td>
                            <!--<td>-->
                            <!-- <input></input>-->
                            <!--</td>-->
                            <!--<td>-->
                            <!-- <input></input>-->
                            <!--</td>-->
                            <td>
                             <?php echo $value['quantity']; ?>
                            </td>
                            <td>
                             <?php echo $value['unitName']; ?>
                            </td>
                            <td>
                              <?php echo $value['pprice']; ?>
                           </td>
                            <td>
                              <?php echo $value['total_price'];?>
                            </td>
                            <td>
                              <?php echo $value['noteOne'];?>
                            </td>
                           
                          </tr>
                          <?php } ?>
                        </tbody>
                       <tr>
                           <td>
                               <?php $twa = round(abs($purchase['totalPrice'])); ?>
                              <td>(In Words&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo convertNumber($twa); ?> )</td>
                            </td>
                            <td></td>
                            <td></td>
                            <td>Total Price:</td>
                            <td colspan="4"><?php echo $purchase['totalPrice'];?></td>   
                        </tr>
                     
                        </table>
                      </div>
                    </div>
                   
                <!--    <div class="row">-->
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
                <!--<div class="row">-->
                <!--     <div class="col-md-12 col-sm-12 col-xs-12">-->
                <!--        <label>Name of Purchaser. *</label>-->
                <!--       <?php echo $purchase['purchaseName']; ?>-->
                <!--    </div>-->
                <!--     <div class="col-md-12 col-sm-12 col-12">-->
                <!--        <b>Name of Purchaser Signature:</b> <span style="margin-top:3px;">----------------------</span></p>-->
                <!--    </div>-->
                <!--    <div class="col-md-12 col-sm-12 col-xs-12">-->
                <!--        <label>Designation. *</label>-->
                <!--        <?php echo $purchase['podobi']; ?>-->
                <!--    </div>-->
                <!--</div>-->
                    
                <!--    <div class="row">-->
                        
                <!--        <div class="col-md-3 col-sm-3 col-xs-12">-->
                <!--            <label>Entry No. *</label>-->
                <!--           <?php echo $purchase['entryVuktiDate']; ?>-->
                <!--        </div>-->
                <!--          <div class=" col-md-3 col-sm-3 col-xs-12">-->
                <!--            <label>Date *</label>-->
                <!--           <?php echo date('m/d/Y',strtotime($purchase['lastDate'])) ?>-->
                <!--           </div>-->
                <!--       </div>-->
                       
                       <style>
                        .vl {
                          border-left: 1px solid black;
                          height: 200px;
                         
                        }
                        
                        </style>
                      <div class="row">
                        
                        <div style="display: inline-block; width: 100%; margin-bottom: 10px;">
                            <label>Manufacturer:</label>
                        </div>
                        <?php if($purchase['passed']){ ?>
                        <div style="display: inline-block; width: 100%; margin-bottom: 10px;">
                            <label>A) Quality check passed, acceptable.</label>
                        </div>
                        <?php } if($purchase['missing']){ ?>
                        <div style="display: inline-block; width: 100%; margin-bottom: 10px;">
                            <label>B) Some products missing, acceptable as noted in comments.</label>
                        </div>
                        <?php } if($purchase['ordered']){ ?>
                        <div style="display: inline-block; width: 100%; margin-bottom: 10px;">
                            <label>C) Not as ordered, unacceptable, canceled.</label>
                        </div>
                        <?php } ?>
                    </div>
                    <!--<div class="row col-md-12 col-sm-12">-->
                    <!--    Opinion:-->
                    <!--</div>-->
                    <!--<div class="row bordered vl"style="line-height: .6;margin-top:60px;" >-->
                    <!--    <div class="col-md-3 col-sm-3">-->
                            
                    <!--        <label style="margin-top:30px;">Quality Assurance:</label>-->
                    <!--        <br>-->
                    <!--        <label style="margin-top:30px;">Date:</label>-->
                    <!--        <br>-->
                    <!--        <label style="margin-top:30px;">Mr. Q. Letter no:</label>-->
                    <!--        <br>-->
                    <!--        <label style="margin-top:30px;">Date:</label>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-3 col-sm-3 vl "style="text-align: center;" >-->
                    <!--        <label></label>-->
                    <!--        <br><label>-->
                                
                    <!--        </label>-->
                    <!--        <br>-->
                    <!--        <label></label>-->
                    <!--        <br>-->
                    <!--        <label></label>-->
                    <!--        <br>-->
                    <!--        <label></label>-->
                    <!--        <br>-->
                    <!--        <label></label>-->
                    <!--        <br>-->
                    <!--        <label></label>-->
                    <!--        <br>-->
                    <!--        <label style="margin-top:90px; ">Officer-in-Charge (Stores)</label>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-3 col-sm-3 vl" >-->
                    <!--        <label></label>-->
                           
                    <!--       <br>-->
                    <!--        <label style="margin-top:60px;">Appraiser:</label>-->
                    <!--        <br>-->
                    <!--        <label style="margin-top:30px;">Source, Jabeda/ Voucher No.:</label>-->
                    <!--        <br>-->
                    <!--        <label style="margin-top:30px;">Date:</label>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-3 col-sm-3 vl" >-->
                    <!--        <label></label>-->
                    <!--        <br>-->
                    <!--       <br>-->
                    <!--        <label style="margin-top:100px;">Khatian Recorder:</label>-->
                           
                    <!--        <br>-->
                    <!--        <label style="margin-top:30px;">Date:</label>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <div style="margin-top:120px;"class="row">
                        <div class="col-sm-3 col-md-3 col-xs-3">
                            <label style="">Quality Assurance:</label>
                        </div>
                        <div class="col-sm-3 col-md-3 col-xs-3">
                           
                        </div>
                          <div class="col-md-4 col-sm-4 col-4">
                         
                        <label >Officer-in-Charge (Stores)</label>
                          </div>
                          
                        
                    </div>
                    <div style="margin-top:30px;" class="row">
                        
                         <div class="col-md-4 col-sm-4 col-4">
                          
                            <label>Date:</label>
                          </div>
                          <div class="col-md-2 col-sm-2 col-2">
                          
                            
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                          
                            <label style="">Date:</label>
                          </div>
                           
                    </div>
                    <div class="row" id="printOnly" style="bottom:100;position: fixed;width:100%;">
                         <div class="col-md-12 col-12" style="text-align: center;">
                          <br><br>
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-4">
                            <lable></lable>
                            <label>Qualities are subject to verification</label>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                            <lable></lable>
                            <label>Head of Security Department</label>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                            <lable></lable>
                            <label>Head of Warehousing Department</label>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  
                  <div class="row no-print" style="margin-top:50px;">
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