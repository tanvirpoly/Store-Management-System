<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class PurchaseOne extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Purchase';

  $other = array(
    'order_by'=>'insPurID'
        );
   
  $data['instant_purchase'] = $this->pm->get_data('instant_purchase',false,false,false,$other);

  $this->load->view('purchaseOne/purchase_list',$data);
}

public function new_purchase() 
  {
  unset($_SESSION['stockProducts']);
  $data['title'] = 'Purchase';

  $where = array(
    'compid' => $_SESSION['compid']
        );
  $uwhere = array(
    'status' => 'Active',
    'compid' => $_SESSION['compid']  
        );

  $data['product'] = $this->pm->get_data('products',$where);
  $data['supplier'] = $this->pm->get_data('suppliers',$where);
  $data['category'] = $this->pm->get_data('categories',$uwhere);
  $data['unit'] = $this->pm->get_data('sma_units',$uwhere);

  $this->load->view('purchaseOne/newPurchase',$data);
}

public function get_purchase_supplier()
  {
      $other = array(
        'order_by' => 'supplierID',
        
            );
  $where = array(
    'compid' => $_SESSION['compid'],
    'status' => 'Active'
        );
  $grup = $this->pm->get_data('suppliers',$where,false,false,$other);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function get_purchase_product()
  {
  $where = array(
    'compid'   => $_SESSION['compid'],
    'supplier' => $_POST['id']
        );
  $grup = $this->pm->get_data('products',$where);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

// public function getDetails2($id)
//     {
//     $table = 'products';
//     // $id = $this->input->post('id');

// 	if(isset($_SESSION['stockProducts'])){
// 		$tempStock= $_SESSION['stockProducts'];
// 		 if( in_array($id , $tempStock) )
// 		 {
			 
// 			  echo json_encode(2);
// 		 }
// 		 else{
// 			 array_push($tempStock,$id);
// 			 $this->session->set_userdata('stockProducts', $tempStock);
// 			 $this->get_Product($id);
			 
// 		 }
// 	 }
// 	 else{
// 		 $tempStock=array($id);
// 		 $this->session->set_userdata('stockProducts', $tempStock);
// 		 $this->get_Product($id);
		 
// 	 }
// }

public function get_Product($id)
    {
    $str = "";

    $where = array(
        'pid' => $id
            );
  $data['expense'] = $this->pm->get_data('sma_units');
    $productlist = $this->pm->get_data('products',$where);
    foreach ($productlist as $value)
        {
        $id = $value['pid'];
        $str .= "<tr>
        <td>".$value['pName']."<input type='hidden' readonly='readonly' name='product_id[]' value='".$id."'></td>
        <td><input type='text' class='form-control' id='quantity_".$id."' onkeyup='getTotal(".$id.")' name='quantity[]' value='1'></td>
        <td>
    <div class='form-group col-md-3 col-sm-3 col-12'>
        <select class='form-control select2' style='width:150px;' id='unit_' name='unit[]' required >
            <option value='0'>Select One</option>";
        
        foreach ($data['expense'] as $cat) {
            $str .= "<option value='" . $cat['untid'] . "'>" . $cat['unitName'] . "</option>";
        }

        $str .= "   </select>
    </div>
    
    </td>
        <td><input type='text' class='form-control' onkeyup='getTotal(".$id.")' id='tp_".$id."' name='pprice[]' value='0'></td>
        <td><input type='text' class='form-control totalPrice' id='totalPrice_".$id."' name='total_price[]' value='0' readonly ></td>
         <td><input type='text' class='form-control'  name='noteOne[]' value='' ></td>
        <td><span class='item_remove btn btn-danger btn-sm' onclick='deleteProduct(this)'><i class='fa fa-trash'></i></span>
        </td></tr>";
        }
    echo json_encode($str);
}

public function savedPurchaseOne()
  {
  $info = $this->input->post();

  $purchase = array(
    'date'         => date('Y-m-d', strtotime($info['date'])),
    'istitudeP'    => $info['istitudeP'],
    'workNO'       => $info['workNO'],
    'permitName'   => $info['permitName'],
    'address'      => $info['address'],
    'memoNO'       => $info['memoNO'],             
    'purchaseDate' => date('Y-m-d', strtotime($info['purchaseDate'])),
    // 'products'     => $info['productID'],
    'totalPrice'   => $info['totalPrice'],
    'accountType'  => $info['accountType'],
    'accountNo'    => $info['accountNo'],             
    'note'         => $info['note'],
    'purchaseName' => $info['purchaseName'],
    'podobi'       => $info['podobi'],
    'entryVuktiDate' => date('Y-m-d', strtotime($info['entryVuktiDate'])),
    'lastDate'     => date('Y-m-d', strtotime($info['lastDate'])),
    'passed'       => $info['passed'],
    'missing'      => $info['missing'],
    'ordered'      => $info['ordered'],
            );
       // var_dump($purchase); exit();
  $result = $this->pm->insert_data('instant_purchase',$purchase);
    // var_dump($result);
  $length = count($info['product_id']);
        
  for($i = 0; $i < $length; $i++)
    {
    $pproduct = array(
      'insPurID'    => $result,
      'product_id'  => $info['product_id'][$i],
      'unit'        => $info['unit'][$i],
      'noteOne'     => $info['noteOne'][$i],
      'quantity'    => $info['quantity'][$i],
      'pprice'      => $info['pprice'][$i],                    
      'total_price' => $info['total_price'][$i]
                );
        //var_dump($purchase_product);            
    $result2 = $this->pm->insert_data('instant_purchase_product',$pproduct); 

    $pid = $info['product_id'][$i];
        // $aid = $_SESSION['compid'];
        // var_dump($pid);
    $swhere = array(
      'pid' => $pid
            );

    $stpd = $this->pm->get_data('stock',$swhere);

    $this->pm->delete_data('stock',$swhere);

        if($stpd)
            {
            $tquantity = $info['quantity'][$i]+$stpd[0]['tquantity'];
            $dtqnt = $stpd[0]['tdquantity'];
            }
        else{
            $tquantity = $info['quantity'][$i];
            $dtqnt = 0;
            }

        $stock_info = array(
            // 'compid'     => $_SESSION['compid'],
            'pid'    => $info['product_id'][$i],
            'tquantity' => $tquantity,
            'tdquantity' => $dtqnt
                    );
        //var_dump($stock_info);    
        $this->pm->insert_data('stock',$stock_info);                 
        }
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Purchase add Successfully !</h4>
            </div>'
                ];  
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Failed !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('Purchase');
}

public function view_purchase($id)
    {
  $data['title'] = 'Purchase';

    $pwhere = array(
        'insPurID' => $id
            );
    $pfield = array(
        'instant_purchase_product' => 'instant_purchase_product.*',
        'products' => 'products.pName,products.pCode'
            );
    $pjoin = array(
        'products' => 'products.pid = instant_purchase_product.product_id'
            );
    $pother = array(
        'join' => 'left'
            );

    $data['pproduct'] = $this->pm->get_data('instant_purchase_product',$pwhere,$pfield,$pjoin,$pother);

    $purchase = $this->pm->get_data('instant_purchase',$pwhere);
    $data['purchase'] = $purchase[0];

    $where = array(
       'compid' => $_SESSION['compid'] ,
       'status' => 'Active'
            );

    $data['product'] = $this->pm->get_data('products',$where);
    $data['supplier'] = $this->pm->get_data('suppliers',$where);

    $data['company'] = $this->pm->company_details();
    
    $this->load->view('purchaseOne/viewPurchase',$data);
}
public function view_purchasePr($id)
    {
  $data['title'] = 'Purchase';

    $pwhere = array(
        'insPurID' => $id
            );
    $pfield = array(
        'instant_purchase_product' => 'instant_purchase_product.*',
        'products' => 'products.pName,products.pCode',
        'sma_units' => 'sma_units.unitName'
            );
    $pjoin = array(
        'products' => 'products.pid = instant_purchase_product.product_id',
         'sma_units' => 'sma_units.untid = instant_purchase_product.unit'
            );

    $pother = array(
        'join' => 'left'
            );

    $data['pproduct'] = $this->pm->get_data('instant_purchase_product',$pwhere,$pfield,$pjoin,$pother);

    $purchase = $this->pm->get_data('instant_purchase',$pwhere);
    $data['purchase'] = $purchase[0];

    $where = array(
       'compid' => $_SESSION['compid'] ,
       'status' => 'Active'
            );

    $data['product'] = $this->pm->get_data('products',$where);
    $data['supplier'] = $this->pm->get_data('suppliers',$where);

    $data['company'] = $this->pm->company_details();
    
    $this->load->view('purchaseOne/view_purchasePr',$data);
}
public function view_purchaseLt($id)
    {
  $data['title'] = 'Purchase';

    $pwhere = array(
        'insPurID' => $id
            );
       $pfield = array(
        'instant_purchase_product' => 'instant_purchase_product.*',
        'products' => 'products.pName,products.pCode',
        'sma_units' => 'sma_units.unitName'
            );
    $pjoin = array(
        'products' => 'products.pid = instant_purchase_product.product_id',
         'sma_units' => 'sma_units.untid = instant_purchase_product.unit'
            );
    $pother = array(
        'join' => 'left'
            );

    $data['pproduct'] = $this->pm->get_data('instant_purchase_product',$pwhere,$pfield,$pjoin,$pother);

    $purchase = $this->pm->get_data('instant_purchase',$pwhere);
    $data['purchase'] = $purchase[0];

    $where = array(
       'compid' => $_SESSION['compid'] ,
       'status' => 'Active'
            );

    $data['product'] = $this->pm->get_data('products',$where);
    $data['supplier'] = $this->pm->get_data('suppliers',$where);

    $data['company'] = $this->pm->company_details();
    
    $this->load->view('purchaseOne/view_purchaseLt',$data);
}
public function edit_purchase($id)
    {
    $data['title'] = 'Purchase';

    $pwhere = array(
        'insPurID' => $id
            );
    $pfield = array(
        'instant_purchase_product' => 'instant_purchase_product.*',
        'products' => 'products.pName,products.pCode',
        'sma_units' => 'sma_units.unitName'
            );
    $pjoin = array(
        'products' => 'products.pid = instant_purchase_product.product_id',
        'sma_units' => 'sma_units.untid = instant_purchase_product.unit'
        
            );
    $pother = array(
        'join' => 'left'
            );

    $data['pproduct'] = $this->pm->get_data('instant_purchase_product',$pwhere,$pfield,$pjoin,$pother);
    $data['expense'] = $this->pm->get_data('sma_units');
    $purchase = $this->pm->get_data('instant_purchase',$pwhere);
    $data['purchase'] = $purchase[0];

    $where = array(
       'compid' => $_SESSION['compid'] ,
       'status' => 'Active'
            );

    $data['product'] = $this->pm->get_data('products',$where);
    $data['supplier'] = $this->pm->get_data('suppliers',$where);
    
    $this->load->view('purchaseOne/editPurchase',$data);
}

public function update_purchase()
  {
  $info = $this->input->post();

  $purchase = array(
        'date'              => date('Y-m-d', strtotime($info['date'])),
        'istitudeP'         => $info['istitudeP'],
        'workNO'            => $info['workNO'],
        'permitName'        => $info['permitName'],
        'address'           => $info['address'],
        'memoNO'            => $info['memoNO'],             
        'purchaseDate'      => date('Y-m-d', strtotime($info['purchaseDate'])),
        // 'products'          => $info['productID'],
        'totalPrice'        => $info['totalPrice'],
        'accountType'       => $info['accountType'],
        'accountNo'         => $info['accountNo'],             
        'note'              => $info['note'],
        'purchaseName'      => $info['purchaseName'],
        'podobi'            => $info['podobi'],
        'entryVuktiDate'    => $info['entryVuktiDate'],
        'lastDate'          => date('Y-m-d', strtotime($info['lastDate'])),
        'passed'            => $info['passed'],
    'missing'               => $info['missing'],
    'ordered'               => $info['ordered'],
        );

  $where = array(
    'insPurID' => $info['purhcase_id']
        );

  $result = $this->pm->update_data('instant_purchase',$purchase,$where);
  $pproduct = $this->pm->get_data('instant_purchase_product',$where);
//   var_dump($pproduct);
  $this->pm->delete_data('instant_purchase_product',$where);
  $lnth = count($pproduct);

  for($i = 0; $i < $lnth; $i++)
    {
    $swhere = array(
      'pid' => $pproduct[$i]['product_id']
            );

    $spd = $this->pm->get_data('stock',$swhere);
    $this->pm->delete_data('stock',$swhere);
        
    if($spd)
      {
      if($pproduct)
        {
        $tquantity = ($spd[0]['tquantity']-$pproduct[$i]['quantity']);
        $dtqnt = $spd[0]['tdquantity'];
        }
      else
        {
        $tquantity = $spd[0]['tquantity'];
        $dtqnt = $spd[0]['tdquantity'];
        }
      }
    else
      {
      $tquantity = 0;
      $dtqnt = 0;
      }

    $stockinfo = array(
    //   'compid'     => $_SESSION['compid'],
      'pid'    => $pproduct[$i]['product_id'],
      'tquantity' => $tquantity,
      'tdquantity' => $dtqnt
    //   'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stockinfo); 
    }

      $length = count($info['product_id']);
        
    for ($i = 0; $i < $length; $i++)
        {
        $purchase_product = array(
            'insPurID' => $info['purhcase_id'],
            'product_id'  => $info['product_id'][$i],
            'unit'  => $info['unit'][$i],
            'noteOne'  => $info['noteOne'][$i],
            'quantity'   => $info['quantity'][$i],
            'pprice'     => $info['pprice'][$i],                    
            'total_price' => $info['total_price'][$i]
                );
        //var_dump($purchase_product);            
        $result2 = $this->pm->insert_data('instant_purchase_product',$purchase_product); 

    $pid = $this->input->post('product_id')[$i];
    // $aid = $_SESSION['compid'];

    $swhere = array(
    //   'compid'  => $_SESSION['compid'],
      'pid' => $pid
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tquantity = $info['quantity'][$i]+$stpd[0]['tquantity'];
        $dtqnt = $stpd[0]['tdquantity'];
      }
    else
      {
      $tquantity = $info['quantity'][$i];
      $dtqnt = 0;
      }

    $stock_info = array(
    //   'compid'     => $_SESSION['compid'],
      'pid'    => $this->input->post('product_id')[$i],
      'tquantity' => $tquantity,
      'tdquantity' => $dtqnt
      
              );
        //var_dump($stock_info); exit();    
    $this->pm->insert_data('stock',$stock_info);                 
    }





  if($result && $result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Purchase update Successfully !</h4></div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Failed !</h4></div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('Purchase');
}

public function delete_purchases($id)
    {
    $where = array(
        'insPurID' => $id
            );

    $result = $this->pm->delete_data('instant_purchase',$where);
    $pproduct = $this->pm->get_data('instant_purchase_product',$where);
    $result2 = $this->pm->delete_data('instant_purchase_product',$where);


    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Purchase delete Successfully !</h4>
            </div>'
                ];  
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Failed !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('Purchase');
}

public function purchases_reports()
    {
    $data = ['title' => 'Purchase Reports'];
    $where = array('compid' => $_SESSION['compid']);

    $data['supplier'] = $this->pm->get_data('suppliers',$where);
    $data['company'] = $this->pm->get_data('com_profile',false);

    if(isset($_GET['search']))
        {
        $report = $_GET['reports'];
        
        if($report == 'dailyReports')
            {
            $sdate = date("Y-m-d", strtotime($_GET['sdate']));
            $edate = date("Y-m-d", strtotime($_GET['edate']));
            $supid = $_GET['dsupplier'];
            $compid = 1;
            $data['sdate'] = $sdate;
            $data['edate'] = $edate;
            $data['report'] = $report;
            //var_dump($employee); exit();
            $data['purchase'] = $this->pm->get_dpurchses_data($sdate,$edate,$supid,$compid);
            }
        else if ($report == 'monthlyReports')
            {
            $month = $_GET['month'];
            $data['month'] = $month;
            $year = $_GET['year'];
            $data['year'] = $year;
            //var_dump($data['month']); exit();
            if($month == 01)
                {
                $name = 'January';
                }
            elseif ($month == 02)
                {
                $name = 'February';
                }
            elseif ($month == 03)
                {
                $name = 'March';
                }
            elseif ($month == 04)
                {
                $name = 'April';
                }
            elseif ($month == 05)
                {
                $name = 'May';
                }
            elseif ($month == 06)
                {
                $name = 'June';
                }
            elseif ($month == 07)
                {
                $name = 'July';
                }
            elseif ($month == 8)
                {
                $name = 'August';
                }
            elseif ($month == 9)
                {
                $name = 'September';
                }
            elseif ($month == 10)
                {
                $name = 'October';
                }
            elseif ($month == 11)
                {
                $name = 'November';
                }
            else
                {
                $name = 'December';
                }
            $supid = $_GET['msupplier'];
            $compid = 1;
            $data['name'] = $name;
            $data['report'] = $report;

            $data['purchase'] = $this->pm->get_mpurchses_data($month,$year,$supid,$compid);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $supid = $_GET['ysupplier'];
            $data['year'] = $year;
            $data['report'] = $report;
            $compid = 1;

            $data['purchase'] = $this->pm->get_ypurchses_data($year,$supid,$compid);
            }
        }
    else
        {
        $data['purchase'] = $this->pm->get_purchses_data();
        }

    $this->load->view('purchaseOne/purchase_reports',$data);
}

public function get_purchase_payment()
    {
    $section = $this->pm->get_purchase_payment($_POST['id']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function save_purchase_payment()
    {
    $info = $this->input->post();

    $sale = [
        'pur_id' => $info['purchaseID'],
        'amount' => $info['amount'], 
        'accountType' => $info['accountType'],            
        'accountNo' => $info['accountNo'],
        'regby'  => $_SESSION['uid']
            ];
    //var_dump($sale); exit();
    $result = $this->pm->insert_data('purchase_payment',$sale);

    $where = array(
        'purchaseID' => $info['purchaseID']
                );

    $data = [
        'paidAmount' => $info['amount']+$info['pamount'],
        'due'        => $info['damount']-$info['amount'],
        'upby'       => $_SESSION['uid']
            ];
       
    $result2 = $this->pm->update_data('purchase',$data,$where);
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Purchase Payment add Successfully !</h4>
            </div>'
                ];  
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Failed !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('Purchase');
}

public function daily_purchases_reports()
    {
    $data = ['title' => 'Purchase Reports'];
    $where = array('compid' => $_SESSION['compid']);

    $data['supplier'] = $this->pm->get_data('suppliers',$where);

    $sdate = date('Y-m-d');
    $edate = date('Y-m-d');
    $supplier = 'All';
    $compid = 'All';
    $data['sdate'] = $sdate;
    $data['edate'] = $edate;
    $data['report'] = 'dailyReports';
        //var_dump($employee); exit();
    $data['purchase'] = $this->pm->get_dpurchses_data($sdate,$edate,$supplier, $compid);

    $this->load->view('purchaseOne/purchase_reports',$data);
}





}