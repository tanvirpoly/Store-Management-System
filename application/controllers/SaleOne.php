<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class SaleOne extends CI_Controller {

public function __construct(){
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Sale';
    
  $other = array(
    'join' => 'left',
    'order_by' => 'saidOne'
        );
  $field = array(
    'saleOne' => 'saleOne.*',
    'users' => 'users.uName, users.empid',
    'employees' => 'employees.empDpt',
    'customers' => 'customers.custName'
    
        );
  $join = array(
    'users' => 'users.uid = saleOne.regbyOne',
    'employees' => 'employees.empid = users.empid',
    'customers' => 'customers.custid = saleOne.custid'
        );
  if($_SESSION['userrole'] == 4)
    {
    $where = array(
      'saleOne.regbyOne' => $_SESSION['uid']
            );
    $data['sales'] = $this->pm->get_data('saleOne',$where,$field,$join,$other);
    }
  else
    {
    $data['sales'] = $this->pm->get_data('saleOne',false,$field,$join,$other);
    }
  $this->load->view('saleOne/sales_list_one',$data);
}

public function new_sale_one()
  {
  $data['title'] = 'New Sale';

//   $data['customer'] = $this->pm->get_data('customers',false);
  $data['employee'] = $this->pm->get_data('employees',false);
  $data['product'] = $this->pm->get_data('products',false);
  $data['category'] = $this->pm->get_data('categories',false);
  $data['Customer'] = $this->pm->get_data('customers',false);
  //$data['product'] = $this->pm->get_stock_product_data();

  $this->load->view('saleOne/NewSaleOne',$data);
}

public function getDetails()
  {
  $pid = $this->input->post('id');
  //$pid = 6;
 
  $where = array(
    'products.pid' => $pid,
    'tdquantity >' => 0
        );
  $join = array(
    'sma_units' => 'sma_units.untid = products.untid',
    'stock' => 'stock.pid = products.pid',
        );
	
  
  $products = $this->pm->get_data('products',$where,false,$join);
    //var_dump($products); exit();
 if($products){
  $str='';
  foreach($products as $value){
    $id = $value['pid'];
    $str.="<tr>
      <td>".$value['pName'].' ( '.$value['pCode'].' )'."<input type='hidden' name='product[]' value='".$id."' required ></td>
       <td>".$value['tdquantity']."</td>
      <td><input type='text' onkeyup='totalPrice(".$id.")' name='quantity[]' id='quantity_".$id."' value='1' min='1' required ></td>
      <td><input type='text' onkeyup='totalPrice(".$id.")' name='uprice[]' id='uprice_".$id."' required ></td>
	  <td>".$value['unitName']."</td>
	  <td><input type='text' class='totalPrice'  name='totalPrice[]' readonly id='totalPrice_".$id."' value='0'></td>
      <td><span class='item_remove btn btn-danger btn-xs' onclick='deleteProduct(this)'>x</span></td>
      </tr>";
      }
            
      
    echo json_encode($str);
 }
    else{
        alert('NO DAMAGE STOCK AVAILABLE!!!');
    }
}
public function saved_sale_one()
  {
  $info = $this->input->post();

  $query = $this->db->select('saidOne')
                ->from('saleOne')
                ->limit(1)
                ->order_by('saidOne','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->saidOne+1;
    }
  else
    {
    $sn = 1;
    }
  $cn = strtoupper(substr($_SESSION['company'],0,3));
  $pc = sprintf("%'04d", $sn);


  $cusid = $cn.$pc;
   //var_dump($due); exit();
   
//   if($info['rnote'])
//     {
//     $reference = $info['rnote'];
//     }
//   else
//     {
//     $reference = $info['reference'];
//     }
  $sale = array(
    'compidOne'    => $_SESSION['compid'],
    'invoiceOne'   => $cusid,
    'tAmount' => $info['tAmount'],
    
    'saDateOne'    => date('Y-m-d', strtotime($info['date'])),
    'referenceOne' => $info['reference'],
    'custid'       => $info['custid'],
    'rnoteOne'     => $info['rnote'],
    'noteOne'      => $info['note'],             
    'regbyOne'     => $_SESSION['uid']
        );
    //var_dump($sale); exit();
  $result = $this->pm->insert_data('saleOne',$sale);

  $length = count($info['product']);

  for($i = 0; $i < $length; $i++)
    {
    $spdata = array(
      'saidOne'     => $result,
      'pidOne'      => $info['product'][$i],
      'uprice'      => $info['uprice'][$i],
      'quantityOne' => $info['quantity'][$i],
      'totalPrice' => $info['totalPrice'][$i],
      
      'regbyOne'    => $_SESSION['uid']
            );

    $this->pm->insert_data('sale_productOne',$spdata);
    $pid = $info['product'][$i];
        $aid = $_SESSION['compid'];

        $swhere = array(
            'compid'  => $_SESSION['compid'],
            'pid' => $pid
                    );

        $stpd = $this->pm->get_data('stock',$swhere);

        $this->pm->delete_data('stock',$swhere);

        if($stpd)
            {
            $tdquantity = $stpd[0]['tdquantity']-($info['quantity'][$i]);
            $tquantity  = $stpd[0]['tquantity'];
            }
        else{
            $tdquantity = '-'.($info['quantity'][$i]);
            $tquantity = 0;
            }

        $stock_info = array(
            'compid'     => $_SESSION['compid'],
            'pid'    => $info['product'][$i],
            'tdquantity' => $tdquantity,
            'tquantity' =>  $tquantity,
            'regby'      => $_SESSION['uid']
                    );
        //      if($stpd)
        //     {
        //     $tdquantity = $stpd[0]['totalPices']-($info['pices'][$i]);
        //     $dtqnt = $stpd[0]['dtquantity'];
        //     }
        // else{
        //     $tquantity = '-'.($info['pices'][$i]);
        //     $dtqnt = 0;
        //     }

        // $stock_info = array(
        //     'compid'     => $_SESSION['compid'],
        //     'product'    => $info['product'][$i],
        //     'totalPices' => $tquantity,
        //     'dtquantity' => $dtqnt,
        //     'regby'      => $_SESSION['uid']
        //             );
        //var_dump($stock_info);    
        $this->pm->insert_data('stock',$stock_info);
    }
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Product Sale Successfully !</h4></div>'
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
  redirect('sale');
}

public function view_invoice_one($id)
  {
  $data['title'] = 'Requisition';

  $where = array(
    'saidOne' => $id
        );
  $other = array(
    'join' => 'left'
        );
  $field = array(
    'saleOne' => 'saleOne.*',
    'users' => 'users.uName, users.empid',
    'employees' => 'employees.empDpt',
    'customers' => 'customers.custName'
    
        );
  $join = array(
    'users' => 'users.uid = saleOne.regbyOne',
    'employees' => 'employees.empid = users.empid',
    'customers' => 'customers.custid = saleOne.custid'
        );
  $prints = $this->pm->get_data('saleOne',$where,$field,$join,$other);
  $data['prints'] = $prints[0];
  
  $pwhere = array(
    'sale_productOne.saidOne' => $id
        );
  $pfield = array(
    'sale_productOne' => 'sale_productOne.*',
    'products' => 'products.pName,products.pCode',
    'saleOne' => 'saleOne.invoiceOne',
	'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.pid = sale_productOne.pidOne',
    'saleOne' => 'saleOne.saidOne = sale_productOne.saidOne',
    'sma_units' => 'sma_units.untid = products.untid'
        );

  $data['salesp'] = $this->pm->get_data('sale_productOne',$pwhere,$pfield,$pjoin,$other);
  //   //var_dump($cusid); exit();
  $data['company'] = $this->pm->company_details();
    
  $this->load->view('saleOne/print_page_one',$data);
}

public function edit_sale_one($id)
  {
  $data['title'] = 'Sale';
 
  $where = array(
    'saidOne' => $id
        );

  $prints = $this->pm->get_data('saleOne',$where);
  $data['sale'] = $prints[0];

  $other = array(
    'join' => 'left'
        );
//   $pfield = array(
//     'sale_productOne' => 'sale_productOne.*',
//     'products' => 'products.pName,products.pCode',
//     'saleOne' => 'saleOne.invoiceOne',
// 	'sma_units' => 'sma_units.unitName'
//         );
//   $pjoin = array(
//     'products' => 'products.pid = sale_productOne.pidOne',
//     'saleOne' => 'saleOne.saidOne = sale_productOne.saidOne',
//     'sma_units' => 'sma_units.untid = products.untid'
//         );
  $pfield = array(
    'sale_productOne' => 'sale_productOne.*',
    'products' => 'products.pName,products.pCode,products.pid',
	'sma_units' => 'sma_units.unitName',
	'stock' => 'stock.tdquantity'
        );
  $pjoin = array(
    'products' => 'products.pid = sale_productOne.pidOne',
	'sma_units' => 'sma_units.untid = products.untid',
	'stock' => 'stock.pid = sale_productOne.pidOne'
	 );

  $data['salesp'] = $this->pm->get_data('sale_productOne',$where,$pfield,$pjoin,$other);
  $data['Customer'] = $this->pm->get_data('customers',false);
  $data['category'] = $this->pm->get_data('categories',false);
  $data['employee'] = $this->pm->get_data('employees',false);
  $data['product'] = $this->pm->get_data('products',false);

  $this->load->view('saleOne/edit_sale_one',$data);
}

public function update_sale_One()
  {
  $info = $this->input->post();
  $sale = array(
    'compidOne'    => $_SESSION['compid'],
    // 'invoiceOne'   => $cusid,
    'saDateOne'    => date('Y-m-d', strtotime($info['saDateOne'])),
    'referenceOne' => $info['reference'],
    'custid'       => $info['custid'],
    'rnoteOne'     => $info['rnoteOne'],
    'noteOne'      => $info['noteOne'],             
    'regbyOne'     => $_SESSION['uid']
            );

  $where = array(
    'saidOne' => $info['saidOne']
        );
    //var_dump($sale); exit();
  $result = $this->pm->update_data('saleOne',$sale,$where);
  $pp = $this->pm->get_data('sale_productOne',$where);
  $this->pm->delete_data('sale_productOne',$where);
  
  $length = count($pp);
   for($i = 0; $i < $length; $i++)
    {
    $swhere = array(
      'compid'  => $_SESSION['compid'],
      'pid' => $pp[$i]['pidOne']
            );

    $spd = $this->pm->get_data('stock',$swhere);
    
    $this->pm->delete_data('stock',$swhere);
        
    if($spd)
      {
      if($pp)
        {
        $tquantity = ($spd[0]['tquantity']);
        $dtqnt = $spd[0]['tdquantity']+$pp[$i]['quantityOne'];
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
      'compid'      => $_SESSION['compid'],
      'pid'     => $pp[$i]['pidOne'],
      'tquantity'  => $tquantity,
      'tdquantity'  => $dtqnt,
      'regby'       => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stockinfo); 
    }
    $length = count($info['product']);
   for($i = 0; $i < $length; $i++)
    {
    $spdata = array(
      'saidOne'     => $info['saidOne'],
      'pidOne'      => $info['product'][$i],                       
      'quantityOne' => $info['quantity'][$i],
      'uprice' => $info['uprice'][$i],
      'regbyOne'    => $_SESSION['uid']
            );

    $this->pm->insert_data('sale_productOne',$spdata);
    $pid = $info['product'][$i];
    $aid = $_SESSION['compid'];

    $swhere = array(
      'compid'  => $_SESSION['compid'],
      'pid' => $pid
     
              );

    $stpd = $this->pm->get_data('stock',$swhere);

    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tquantity = ($stpd[0]['tquantity']);
      $dtqnt = $stpd[0]['tdquantity']-$info['quantity'][$i];
       
      }
    else
      {
      $tquantity = 0;
      $dtqnt = '-'.$info['quantity'][$i];
      }

    $stock_info = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $info['product'][$i],
      'tquantity'  => $tquantity,
      'tdquantity'  => $dtqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $result2 = $this->pm->insert_data('stock',$stock_info); 
    }
  if($result || $result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Sale update Successfully !</h4>
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
  redirect('sale');
}

public function delete_sales($id)
  {
  $where = array(
    'saidOne' => $id
        );
    //var_dump($sale); exit();
  $result = $this->pm->delete_data('saleOne',$where);
  $this->pm->delete_data('sale_productOne',$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Sale delete Successfully !</h4>
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
  redirect('sale');
}

public function approve_sales($id)
  {
  $data['title'] = 'Approve Requisition';
  
  $data['said'] = $id;
  
  $where = array(
    'said' => $id
        );
  $other = array(
    'join' => 'left'
        );
  $pfield = array(
    'sale_product' => 'sale_product.*',
    'products' => 'products.pName,products.pCode',
    'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.pid = sale_product.pid',
    'sma_units' => 'sma_units.untid = products.untid'
        );

  $data['salesp'] = $this->pm->get_data('sale_product',$where,$pfield,$pjoin,$other);
  
  $field = array(
    'sales' => 'sales.*',
    'users' => 'users.uName'
        );
  $join = array(
    'users' => 'users.uid = sales.regby'
        );
  $prints = $this->pm->get_data('sales',$where,$field,$join,$other);
  $data['prints'] = $prints[0];

  $this->load->view('sale/approve_sales',$data);
}

public function save_approve_sales()
  {
  $info = $this->input->post();

  $sale = array(
    'status' => 'Approved',              
    'upby'   => $_SESSION['uid']
            );
  $where = array(
    'said' => $info['said']
        );
    //var_dump($sale); exit();
  $result = $this->pm->update_data('sales',$sale,$where);
  //$this->pm->delete_data('sale_product',$where);
  
  $length = count($info['product']);

  for($i = 0; $i < $length; $i++)
    {
    $spdata = array(
      'said'     => $info['said'],
      'pid'      => $info['product'][$i],                       
      'quantity' => $info['quantity'][$i],
      'regby'    => $_SESSION['uid']
            );

    $this->pm->insert_data('sale_aproduct',$spdata);
    }
    
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Requisition Approved Successfully !</h4>
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
  redirect('requisition');
}

public function delivery_list()
  {
  $data['title'] = 'Delivery';

  $other = array(
    'order_by' => 'did',
    'join' => 'left'
        );
  $join = array(
    'users' => 'users.uid = delivery.empid',
    'employees' => 'employees.empid = users.empid'
        );
  $field = array(
    'delivery' => 'delivery.*',
    'users' => 'users.uName,users.uMobile',
    'employees' => 'employees.empDpt'
        );    
  $data['delivery'] = $this->pm->get_data('delivery',false,$field,$join,$other);

  $this->load->view('sale/delivery_list',$data);
}

public function new_delivery()
  {
  $data['title'] = 'Delivery';
  $data['memo'] = $this->pm->get_sale_memo_data();

  $this->load->view('sale/new_delivery',$data);
}

public function search_delivery()
  {
  $data['title'] = 'Delivery';
  
  $info = $this->input->post();

  $where = array(
    'invoice' => $info['mNumber'],
    'sales.status' => 'Approved'
        );
  $other = array(
    'join' => 'left'
        );
  $join = array(
    'users' => 'users.uid = sales.regby'
        );
  $field = array(
    'sales' => 'sales.*',
    'users' => 'users.uName'
        );

  $purchase = $this->pm->get_data('sales',$where,$field,$join,$other);
    //var_dump($purchase); exit();
  $data['sales'] = $purchase[0];

  $pwhere = array(
    'said' => $purchase[0]['said']
        );
  $pfield = array(
    'sale_aproduct' => 'sale_aproduct.*',
    'products' => 'products.pName,products.pCode,products.rNumber',
    'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.pid = sale_aproduct.pid',
    'sma_units' => 'sma_units.untid = products.untid'
        );

  $data['sproduct'] = $this->pm->get_data('sale_aproduct',$pwhere,$pfield,$pjoin,$other);

  $this->load->view('sale/search_delivery',$data);
}

public function get_dproduct()
  {
  $id = $this->input->post('id');
  $qnt = $this->input->post('qnt');
  $str = "";
  for($i = 0; $i < $qnt; $i++)
    {
    $str .= '<span><input type="text" name="sNumber[]" placeholder="Serial Number"><input type="hidden" name="rproduct[]" value="'.$id.'"><span class="btn btn-danger btn-sm" onClick="$(this).parent().remove();">x</span></span>';
    }
  echo json_encode($str);
}

public function save_delivery()
  {
  $info = $this->input->post();

  $sale = array(
    'dDate'    => date('Y-m-d', strtotime($info['date'])),
    'rInvoice' => $info['invoice'],
    'empid'    => $info['employee'],
    'reference'=> $info['reference'],
    'notes'    => $info['note'],          
    'regby'    => $_SESSION['uid']
        );
    //var_dump($sale); exit();
  $result = $this->pm->insert_data('delivery',$sale);

  $length = count($info['product']);

  for($i = 0; $i < $length; $i++)
    {
    $spdata = array(
      'did'      => $result,
      'pid'      => $info['product'][$i],
      'quantity' => $info['quantity'][$i],
      'regby'    => $_SESSION['uid']
            );

    $this->pm->insert_data('delivery_product',$spdata);

    $swhere = array(
      'pid' => $info['product'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $stpd[0]['tquantity']-$info['quantity'][$i];
      $dtqnt = $stpd[0]['tdquantity'];
      }
    else
      {
      $tqnt = '-'.$info['quantity'][$i];
      $dtqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $info['product'][$i],
      'tquantity'  => $tqnt,
      'tdquantity' => $dtqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock);  
    }
    
    if(isset($info['rproduct'])){
        
      $lnth = count($info['rproduct']);
        
      for($j = 0; $j < $lnth; $j++)
        {
        $rpdata = array(
          'did'      => $result,
          'pid'      => $info['rproduct'][$j],
          'sNumber'  => $info['sNumber'][$j],
          'regby'    => $_SESSION['uid']
                );
    
        $this->pm->insert_data('delivery_pserial',$rpdata);
        }
    }
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Delivery Successfully !</h4></div>'
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
  redirect('delivery');
}

public function view_delivery($id)
  {
  $data['title'] = 'Delivery';

  $pwhere = array(
    'delivery_product.did' => $id
        );
  $other = array(
    'join' => 'left'
        );
  $pfield = array(
    'delivery_product' => 'delivery_product.*',
    'products' => 'products.pName,products.pCode',
    'delivery' => 'delivery.rInvoice',
    'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.pid = delivery_product.pid',
    'sma_units' => 'sma_units.untid = products.untid',
    'delivery' => 'delivery.did = delivery_product.did'
        );

  $data['dproduct'] = $this->pm->get_data('delivery_product',$pwhere,$pfield,$pjoin,$other);
  $where = array(
    'did' => $id
        );
  $join = array(
    'users' => 'users.uid = delivery.empid',
    'employees' => 'employees.empid = users.empid'
        );
  $field = array(
    'delivery' => 'delivery.*',
    'users' => 'users.*',
    'employees' => 'employees.empDpt'
        );

  $purchase = $this->pm->get_data('delivery',$where,$field,$join,$other);
  $data['prints'] = $purchase[0];
    //var_dump($cusid); exit();
  $data['company'] = $this->pm->company_details();
    
  $this->load->view('sale/view_delivery',$data);
}

public function delete_delivery($id)
  {
  $where = array(
    'did' => $id
        );

  $result = $this->pm->delete_data('delivery',$where);
  $pproduct = $this->pm->get_data('delivery_product',$where);
  $this->pm->delete_data('delivery_product',$where);
  $this->pm->delete_data('delivery_pserial',$where);

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
        $tqnt = ($spd[0]['tquantity']+$pproduct[$i]['quantity']);
        $dtqnt = $spd[0]['tdquantity'];
        }
      else
        {
        $tqnt = $spd[0]['tquantity'];
        $dtqnt = $spd[0]['tdquantity'];
        }
      }
    else
      {
      $tqnt = 0;
      $dtqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pproduct[$i]['pid'],
      'tquantity'  => $tqnt,
      'tdquantity' => $dtqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock); 
    }
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Deliver delete Successfully !</h4>
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
  redirect('delivery');
}

public function all_sales_reports()
  {
  $data['title'] = 'Requisition Report';

  $data['employee'] = $this->pm->get_data('users',false);
  $data['company'] = $this->pm->company_details();

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
    
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $empid = $_GET['demployee'];
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;
            //var_dump($employee); exit();
      $data['sales'] = $this->pm->get_dsales_data($sdate,$edate,$empid);
      }
    else if($report == 'monthlyReports')
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
      elseif($month == 02)
        {
        $name = 'February';
        }
      elseif($month == 03)
        {
        $name = 'March';
        }
      elseif($month == 04)
        {
        $name = 'April';
        }
      elseif($month == 05)
        {
        $name = 'May';
        }
      elseif($month == 06)
        {
        $name = 'June';
        }
      elseif($month == 07)
        {
        $name = 'July';
        }
      elseif($month == 8)
        {
        $name = 'August';
        }
      elseif($month == 9)
        {
        $name = 'September';
        }
      elseif($month == 10)
        {
        $name = 'October';
        }
      elseif($month == 11)
        {
        $name = 'November';
        }
      else
        {
        $name = 'December';
        }
      $empid = $_GET['memployee'];
      $data['name'] = $name;
      $data['report'] = $report;

      $data['sales'] = $this->pm->get_msales_data($month,$year,$empid);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $empid = $_GET['memployee'];
      $data['year'] = $year;
      $data['report'] = $report;

      $data['sales'] = $this->pm->get_ysales_data($year,$empid);
      }
    }
  else
    {
    $data['sales'] = $this->pm->get_sales_data();
    }

  $this->load->view('sale/all_sales',$data);
}

public function requisition_delivery_reports()
  {
  $data['title'] = 'Delivery Report';

  $data['employee'] = $this->pm->get_data('users',false);
  $data['company'] = $this->pm->company_details();

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
    
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $empid = $_GET['demployee'];
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;
      $data['empid'] = $empid;
            //var_dump($employee); exit();
      $data['sales'] = $this->pm->get_ddelivery_data($sdate,$edate,$empid);
      }
    else if($report == 'monthlyReports')
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
      elseif($month == 02)
        {
        $name = 'February';
        }
      elseif($month == 03)
        {
        $name = 'March';
        }
      elseif($month == 04)
        {
        $name = 'April';
        }
      elseif($month == 05)
        {
        $name = 'May';
        }
      elseif($month == 06)
        {
        $name = 'June';
        }
      elseif($month == 07)
        {
        $name = 'July';
        }
      elseif($month == 8)
        {
        $name = 'August';
        }
      elseif($month == 9)
        {
        $name = 'September';
        }
      elseif($month == 10)
        {
        $name = 'October';
        }
      elseif($month == 11)
        {
        $name = 'November';
        }
      else
        {
        $name = 'December';
        }
      $empid = $_GET['memployee'];
      $data['name'] = $name;
      $data['report'] = $report;
      $data['empid'] = $empid;

      $data['sales'] = $this->pm->get_mdelivery_data($month,$year,$empid);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $empid = $_GET['yemployee'];
      $data['year'] = $year;
      $data['report'] = $report;
      $data['empid'] = $empid;
        // var_dump($empid);exit();
      $data['sales'] = $this->pm->get_ydelivery_data($year,$empid);
      }
    }
  else
    {
    $data['sales'] = $this->pm->get_delivery_data();
    }

  $this->load->view('sale/delivery_report',$data);
}

public function get_sale_product()
  {
    $where = array(
      'catid' => $_POST['id']
            );
  $grup = $this->pm->get_data('products',$where);
  $someJSON = json_encode($grup);
  echo $someJSON;
}


}