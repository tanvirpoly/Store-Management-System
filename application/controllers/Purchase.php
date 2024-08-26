<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Purchase extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Work Order';

  $other = array(
    'order_by' => 'puid',
    'join' => 'left'
        );
  $join = array(
    'suppliers' => 'suppliers.supid = purchase.supid'
        );
  $field = array(
    'purchase' => 'purchase.*',
    'suppliers' => 'suppliers.supName,suppliers.supMobile'
        );    
  $data['purchase'] = $this->pm->get_data('purchase',false,$field,$join,$other);

  $this->load->view('purchase/purchase_list',$data);
}

public function new_purchase() 
  {
  $data['title'] = 'Work Order';

  $where = array(
    'status' => 'Active' 
        );

  $data['product'] = $this->pm->get_data('products',$where);
  $data['supplier'] = $this->pm->get_data('suppliers',$where);
  //var_dump($data['product']); exit();
  $this->load->view('purchase/newPurchase',$data);
}

public function get_purchase_supplier()
  {
  $grup = $this->pm->get_data('suppliers',false);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function get_Product($id)
  {
  $str = "";
  $where = array(
    'pid' => $id
        );

  $productlist = $this->pm->get_data('products',$where);
  
  foreach($productlist as $value)
    {
    $id = $value['pid'];
    $str .= "<tr>
    <td>".$value['pName'].' ( '.$value['pCode'].' )'."<input type='hidden' name='product[]' value='".$value['pid']."' required ></td>
    <td><input type='text' id='quantity_".$value['pid']."' onkeyup='getTotal(".$id.")' name='quantity[]' value='0' required ></td>
    <td><input type='text' id='uprice_".$value['pid']."' onkeyup='getTotal(".$id.")' name='uprice[]' value='".$value['uprice']."' required ></td>
    <td><input type='text' class='tprice' id='tprice_".$value['pid']."' name='tprice[]' value='0.00' required readonly ></td>
    <td><span class='item_remove btn btn-danger btn-xs' onclick='deleteProduct(this)'>x</span></td></tr>";
    }
  echo json_encode($str);
}

public function save_purchase()
  {
  $info = $this->input->post();
  
  $purchase = $this->db->select('puid')
                ->from('purchase')
                ->where('memoNo',$info['memoNo'])
                ->get()
                ->row();
  if($purchase)
	{
	$sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> This Memo number allready exit. !</h4>
        </div>'
            ];
	}
  else
    {
  $query = $this->db->select('puid')
                ->from('purchase')
                ->limit(1)
                ->order_by('puid','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->puid+1;
    }
  else
    {
    $sn = 1;
    }
  $cn = strtoupper(substr($_SESSION['company'],0,3));
  $pc = sprintf("%'05d",$sn);

  $cusid = 'PU-'.$cn.$pc;
    //var_dump($cusid); exit();
  $purchase = array(
    'compid'    => $_SESSION['compid'],
    'challanNo' => $cusid,
    'puDate'    => date('Y-m-d', strtotime($info['date'])),
    'supid'     => $info['supplier'],
    'memoNo'    => $info['memoNo'],
    'tAmount'   => $info['tAmount'],
    'pAmount'   => $info['Paid'],
    'dAmount'   => $info['due'],
    'accountType'   => $info['accountType'],
    'accountNo'   => $info['accountNo'],
    'note'      => $info['note'],
    'regby'     => $_SESSION['uid']
        );
       // var_dump($purchase); exit();
  $result = $this->pm->insert_data('purchase',$purchase);

  $length = count($info['product']);
        
  for($i = 0; $i < $length; $i++)
    {
    $pproduct = array(
      'puid'     => $result,
      'pid'      => $info['product'][$i],
      'quantity' => $info['quantity'][$i],
      'pprice'   => $info['uprice'][$i],                    
      'tprice'   => $info['tprice'][$i],
      'regby'    => $_SESSION['uid']
          );
        //var_dump($purchase_product);            
    $result2 = $this->pm->insert_data('purchase_product',$pproduct);
    }
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Work Order add Successfully !</h4>
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
	}
  $this->session->set_userdata($sdata);
  redirect('workOrder');
}

public function view_purchase($id)
  {
  $data['title'] = 'Work Order';

  $where = array(
    'puid' => $id
        );
  $pwhere = array(
    'purchase_product.puid' => $id
        );
  $other = array(
    'join' => 'left'
        );
  $pfield = array(
    'purchase_product' => 'purchase_product.*',
    'products' => 'products.pName,products.pCode,products.rNumber',
    'purchase' => 'purchase.memoNo'
        );
  $pjoin = array(
    'products' => 'products.pid = purchase_product.pid',
    'purchase' => 'purchase.puid = purchase_product.puid'
        );

  $data['pproduct'] = $this->pm->get_data('purchase_product',$pwhere,$pfield,$pjoin,$other);

  $join = array(
    'suppliers' => 'purchase.supid = suppliers.supid'
        );
  $field = array(
    'purchase' => 'purchase.*',
    'supplier' => 'suppliers.*'
        );

  $purchase = $this->pm->get_data('purchase',$where,$field,$join,$other);
  $data['purchase'] = $purchase[0];
    //var_dump($cusid); exit();
  $data['company'] = $this->pm->company_details();
    
  $this->load->view('purchase/viewPurchase',$data);
}

public function edit_purchase($id)
  {
  $data['title'] = 'Work Order';

  $where = array(
    'puid' => $id
        );
  $other = array(
    'join' => 'left'
        );
  $pfield = array(
    'purchase_product' => 'purchase_product.*',
    'products' => 'products.pName,products.pCode'
        );
  $pjoin = array(
    'products' => 'products.pid = purchase_product.pid'
        );
  $data['pproduct'] = $this->pm->get_data('purchase_product',$where,$pfield,$pjoin,$other);

  $purchase = $this->pm->get_data('purchase',$where);
  $data['purchase'] = $purchase[0];

  $swhere = array(
    'status' => 'Active'  
        );
  $data['product'] = $this->pm->get_data('products',$swhere);
  $data['supplier'] = $this->pm->get_data('suppliers',$swhere);
    
  $this->load->view('purchase/editPurchase',$data);
}

public function update_purchase()
  {
  $info = $this->input->post();

  $purchase = array(
    'puDate'  => date('Y-m-d',strtotime($info['date'])),
    'supid'   => $info['supplier'],
    'memoNo'  => $info['memoNo'],
    'tAmount' => $info['tAmount'],
    'note'    => $info['note'],
    'upby'    => $_SESSION['uid']
          );
  $where = array(
    'puid' => $info['puid']
        );
  $result = $this->pm->update_data('purchase',$purchase,$where);
  $this->pm->delete_data('purchase_product',$where);
  
  $length = count($info['product']);
        
  for($i = 0; $i < $length; $i++)
    {
    $pproduct = array(
      'puid'     => $info['puid'],
      'pid'      => $info['product'][$i],
      'quantity' => $info['quantity'][$i],
      'pprice'   => $info['uprice'][$i],                    
      'tprice'   => $info['tprice'][$i],
      'regby'    => $_SESSION['uid']
          );
        //var_dump($purchase_product);            
    $result2 = $this->pm->insert_data('purchase_product',$pproduct);
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Work Order update Successfully !</h4>
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
  redirect('workOrder');
}

public function delete_purchases($id)
  {
  $where = array(
    'puid' => $id
        );

  $result = $this->pm->delete_data('purchase',$where);
  $this->pm->delete_data('purchase_product',$where);
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Work Order delete Successfully !</h4>
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
  redirect('workOrder');
}

public function approve_purchases($id)
  {
  $info = $this->input->post();

  $purchase = array(
    'status' => 'Approved',
    'upby'   => $_SESSION['uid']
          );
  $where = array(
    'puid' => $id
        );
  $result = $this->pm->update_data('purchase',$purchase,$where);
   
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Work Order Approve Successfully !</h4>
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
  redirect('workOrder');
}

public function work_order_list()
  {
  $data['title'] = 'Work Order';

  $other = array(
    'order_by' => 'roid',
    'join' => 'left'
        );
  $join = array(
    'suppliers' => 'suppliers.supid = receive_order.supid'
        );
  $field = array(
    'receive_order' => 'receive_order.*',
    'suppliers' => 'suppliers.supName,suppliers.supMobile'
        );    
  $data['purchase'] = $this->pm->get_data('receive_order',false,$field,$join,$other);

  $this->load->view('purchase/work_order_list',$data);
}

public function purchase_order_receive()
  {
  $data['title'] = 'Work Order Receive';
  $data['memo'] = $this->pm->get_purchase_memo_data();
  
  $this->load->view('purchase/purchase_receive',$data);
}

public function work_order_receive()
  {
  $info = $this->input->post();

  $data['title'] = 'Work Order Receive';

  $where = array(
    'memoNo' => $info['mNumber'],
    'purchase.status' => 'Approved'
        );
  $other = array(
    'join' => 'left'
        );
  $join = array(
    'suppliers' => 'purchase.supid = suppliers.supid'
        );
  $field = array(
    'purchase' => 'purchase.*',
    'supplier' => 'suppliers.*'
        );

  $purchase = $this->pm->get_data('purchase',$where,$field,$join,$other);
  
  if($purchase)
    {
    $data['purchase'] = $purchase[0];
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Approve Work Orders First !</h4>
        </div>'
            ];  
    $this->session->set_userdata($sdata);
    redirect('newOReceive');
    }

  $pwhere = array(
    'purchase_product.puid' => $purchase[0]['puid']
        );
  $pfield = array(
    'purchase_product' => 'purchase_product.*',
    'products' => 'products.pName,products.pCode,products.rNumber',
    'purchase' => 'purchase.memoNo'
        );
  $pjoin = array(
    'products' => 'products.pid = purchase_product.pid',
    'purchase' => 'purchase.puid = purchase_product.puid'
        );

  $data['pproduct'] = $this->pm->get_data('purchase_product',$pwhere,$pfield,$pjoin,$other);

  $this->load->view('purchase/order_receive',$data);
}

public function get_rproduct()
  {
  $id = $this->input->post('id');
  $qnt = $this->input->post('qnt');
  $str = "";
  for($i = 0; $i < $qnt; $i++)
    {
    $str .= '<span><input type="text" name="sNumber[]" placeholder="Serial Number" ><input type="hidden" name="rproduct[]" value="'.$id.'" required ><span class="btn btn-danger btn-sm" onClick="$(this).parent().remove();">x</span></span>';
    }
  echo json_encode($str);
}

public function get_wproduct()
  {
  $id = $this->input->post('id');
  $qnt = $this->input->post('qnt');
  $str = "";
  for($i = 1; $i < $qnt; $i++)
    {
    $str .= '<span><input type="text" class="form-control datepicker" name="pWarranty[]" placeholder="Product Warranty" ><input type="hidden" name="wproduct[]" value="'.$id.'" required ><span class="btn btn-danger btn-sm" onClick="$(this).parent().remove();">x</span></span>';
    }
  echo json_encode($str);
}

public function save_work_receive_order()
  {
  $info = $this->input->post();

  $sale = array(
    'roDate'  => date('Y-m-d', strtotime($info['date'])),
    'roMemo'  => $info['memoNo'],
    'supid'   => $info['supplier'],
    'tAmount' => $info['tAmount'],
    'note'    => $info['note'],          
    'regby'   => $_SESSION['uid']
        );
    //var_dump($sale); exit();
  $result = $this->pm->insert_data('receive_order',$sale);
  $where = array(
    'memoNo' => $info['memoNo']
        );
  $pur = array(
    'pAmount'  => array_sum($info['tprice']),
    'dAmount'  => 0
        );
    //var_dump($sale); exit();
  $resultPur = $this->pm->update_data('purchase',$pur,$where);
  
  $length = count($info['product']);

  for($i = 0; $i < $length; $i++)
    {
    if($info['quantity'][$i] > 0)
      {
      $spdata = array(
        'roid'      => $result,
        'pid'       => $info['product'][$i],
        'rNumber'   => $info['rNumber'][$i],
        //'pWarranty' => date('Y-m-d', strtotime($info['pWarranty'][$i])),
        //'sNumber'   => $info['sNumber'][$i],
        'quantity'  => $info['quantity'][$i],
        'pprice'    => $info['uprice'][$i],                    
        'tprice'    => $info['tprice'][$i],
        'regby'     => $_SESSION['uid']
                );

      $result2 = $this->pm->insert_data('receive_product',$spdata);
      }
    
    $swhere = array(
      'pid' => $info['product'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $stpd[0]['tquantity']+$info['quantity'][$i];
      $tdqnt = $stpd[0]['tdquantity'];
      }
    else
      {
      $tqnt = $info['quantity'][$i];
      $tdqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $info['product'][$i],
      'tquantity'  => $tqnt,
      'tdquantity' => $tdqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock);  
    }
    
    
//   $lnth = count($info['rproduct']);
    
//   for($j = 0; $j < $lnth; $j++)
//     {
//     $rpdata = array(
//       'roid'     => $result,
//       'pid'      => $info['rproduct'][$j],
//       'sNumber'  => $info['sNumber'][$j],
//       'regby'    => $_SESSION['uid']
//             );

//     $this->pm->insert_data('receive_pserial',$rpdata);
//     }
  
//   $lwnth = count($info['wproduct']);
    
//   for($k = 0; $k < $lwnth; $k++)
//     {
//     $wpdata = array(
//       'roid'     => $result,
//       'pid'      => $info['wproduct'][$k],
//       'pWarranty' => date('Y-m-d', strtotime($info['pWarranty'][$k])),
//       'regby'    => $_SESSION['uid']
//             );

//     $this->pm->insert_data('receive_pwarranty',$wpdata);
//     }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Product Receive Successfully !</h4></div>'
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
  redirect('orderReceive');
}

public function view_work_receive($id)
  {
  $data['title'] = 'Work Order';

  $where = array(
    'roid' => $id
        );
  $pwhere = array(
    'receive_product.roid' => $id
        );
  $other = array(
    'join' => 'left'
        );
  $pfield = array(
    'receive_product' => 'receive_product.*',
    'products' => 'products.pName,products.pCode',
    'receive_order' => 'receive_order.roMemo'
        );
  $pjoin = array(
    'products' => 'products.pid = receive_product.pid',
    'receive_order' => 'receive_order.roid = receive_product.roid'
        );

  $data['pproduct'] = $this->pm->get_data('receive_product',$pwhere,$pfield,$pjoin,$other);
//   var_dump($data['pproduct']);
  $join = array(
    'suppliers' => 'receive_order.supid = suppliers.supid'
        );
  $field = array(
    'receive_order' => 'receive_order.*',
    'supplier' => 'suppliers.*'
        );

  $purchase = $this->pm->get_data('receive_order',$where,$field,$join,$other);
  $data['purchase'] = $purchase[0];
    //var_dump($cusid); exit();
  $data['company'] = $this->pm->company_details();
    
  $this->load->view('purchase/view_receive',$data);
}

public function delete_receive_order($id)
  {
  $where = array(
    'roid' => $id
        );

  $result = $this->pm->delete_data('receive_order',$where);
  $pproduct = $this->pm->get_data('receive_product',$where);
  $this->pm->delete_data('receive_product',$where);
  $this->pm->delete_data('receive_pserial',$where);
   $this->pm->delete_data('receive_pwarranty',$where);

  $lnth = count($pproduct);

  for($i = 0; $i < $lnth; $i++)
    {
    $swhere = array(
      'pid' => $pproduct[$i]['pid']
            );

    $spd = $this->pm->get_data('stock',$swhere);
    $this->pm->delete_data('stock',$swhere);
        
    if($spd)
      {
      if($pproduct)
        {
        $tqnt = ($spd[0]['tquantity']-$pproduct[$i]['quantity']);
        $tdqnt = $spd[0]['tdquantity'];
        }
      else
        {
        $tqnt = $spd[0]['tquantity'];
        $tdqnt = $spd[0]['tdquantity'];
        }
      }
    else
      {
      $tqnt = 0;
      $tdqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pproduct[$i]['pid'],
      'tquantity'  => $tqnt,
      'tdquantity' => $tdqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock); 
    }
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Receive Order delete Successfully !</h4>
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
  redirect('orderReceive');
}

public function purchases_reports()
  {
  $data['title'] = 'Order Reports';

  $data['supplier'] = $this->pm->get_data('suppliers',false);
  $data['company'] = $this->pm->company_details();

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
    
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $supid = $_GET['dsupplier'];
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;
            //var_dump($employee); exit();
      $data['purchase'] = $this->pm->get_dpurchses_data($sdate,$edate,$supid);
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
      $data['name'] = $name;
      $data['report'] = $report;

      $data['purchase'] = $this->pm->get_mpurchses_data($month,$year,$supid);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $supid = $_GET['ysupplier'];
      $data['year'] = $year;
      $data['report'] = $report;

      $data['purchase'] = $this->pm->get_ypurchses_data($year,$supid);
      }
    }
  else
    {
    $data['purchase'] = $this->pm->get_purchses_data();
    }

  $this->load->view('purchase/purchase_reports',$data);
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
    'puid'     => $info['puid'],
    'ppAmount' => $info['pAmount'],
    'notes'    => $info['notes'],    
    'regby'    => $_SESSION['uid']
        ];
    //var_dump($sale); exit();
  $result = $this->pm->insert_data('purchase_payment',$sale);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Work Order Payment Successfully !</h4></div>'
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
  redirect('workOrder');
}

public function receive_order_reports()
  {
  $data['title'] = 'Receive Reports';

  $data['supplier'] = $this->pm->get_data('suppliers',false);
  $data['company'] = $this->pm->company_details();

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
    
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $supid = $_GET['dsupplier'];
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;
      $data['supid'] = $supid;
            //var_dump($employee); exit();
      $data['purchase'] = $this->pm->get_dreceive_order_data($sdate,$edate,$supid);
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
      $data['name'] = $name;
      $data['report'] = $report;
      $data['supid'] = $supid;

      $data['purchase'] = $this->pm->get_mreceive_order_data($month,$year,$supid);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $supid = $_GET['ysupplier'];
      $data['year'] = $year;
      $data['report'] = $report;
      $data['supid'] = $supid;

      $data['purchase'] = $this->pm->get_yreceive_order_data($year,$supid);
      }
    }
  else
    {
    $data['purchase'] = $this->pm->get_receive_order_data();
    }

  $this->load->view('purchase/receive_reports',$data);
}



}