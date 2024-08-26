<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Returns extends CI_Controller {

public function __construct(){
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
    {
    $data['title'] = 'Returns';
    
    $other = array(
        'join' => 'left',
        'order_by' => 'rid'
            );
    $where = array(
        'returns.compid' => $_SESSION['compid']
            );
    $field = array(
        'returns' => 'returns.*',
        'users' => 'users.uName,users.uid'
            );
    $join = array(
        'users' => 'users.uid = returns.employee'
            );

    $data['return'] = $this->pm->get_data('returns',$where,$field,$join,$other);

    $this->load->view('return/returns',$data);
}

public function new_return()
  {
  $data['title'] = 'Returns';

  $data['users'] = $this->pm->get_data('users',false);

  $this->load->view('return/newReturn',$data);
}

public function get_delivery_req_by_emp()
  {
  $grup = $this->pm->get_delivery_emp_data($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function getDetails()
    {
    $join = false;
    $other = false;
    $table = $this->input->post('table');
    $id = $this->input->post('id');
 
    if($table == "products")
        {
        $where = array('productID' => $id);
        }

    $products = $this->pm->get_data($table,$where,false,$join,$other);
    $str='';
    foreach($products as $value){
        $id=$value['productID'];
        $str.="<tr>
        <td>".$value['productName']." ( ".$value['productcode']." )"."<input type='hidden' name='productID[]' value='".$value['productID']."'>
        </td>
        <td><input type='text' onkeyup='totalPrice(".$id.")' name='pices[]' id='pices_".$value['productID']."' value='0'>
        </td>
        <td><input type='text' onkeyup='totalPrice(".$id.")' name='salePrice[]' id='salePrice_".$value['productID']."' value='".$value['sprice']."'>
        </td>
        <td><input type='text' class='totalPrice' name='totalPrice[]' readonly id='totalPrice_".$value['productID']."' value='0'>
        </td>
        <td><input type='button' class='btn btn-danger' value='Remove' onClick='$(this).parent().parent().remove();''></td>
        </tr>";
        }
    echo json_encode($str);
}






public function save_returns()
{
    $info = $this->input->post();

    // Retrieve the latest return ID
    $query = $this->db->select('rid')
                      ->from('returns')
                      ->limit(1)
                      ->order_by('rid', 'DESC')
                      ->get()
                      ->row();

    // Generate the new return ID
    if ($query) {
        $sn = substr($query->rid, 2) + 1; // Modified to correctly extract the number from the 'rid'
    } else {
        $sn = 1;
    }

    $pc = sprintf("%'05d", $sn);
    $cusid = 'R-' . $pc;

    // Prepare data for the 'returns' table
    $data = array(
        'returnDate' => date('Y-m-d', strtotime($info['date'])),
        'rid'        => $cusid,
        'compid'     => $_SESSION['compid'],
        'employee'   => $info['employee'],
        'invoice'    => $info['invoice'],
        'reference'  => $info['reference'],      
        'note'       => $info['note'],          
        'regby'      => $_SESSION['uid']
    );

    // Insert data into the 'returns' table
    $result = $this->pm->insert_data('returns', $data);

    $length = count($info['product']);

    // Loop through the products and prepare data for the 'returns_product' table
    for ($i = 0; $i < $length; $i++) {
        $rpdata = array(
            'rt_id'      => $result,
            'compid'     => $_SESSION['compid'],
            'productID'  => $info['product'][$i],
            'quantity'   => $info['quantity'][$i],
            'regby'      => $_SESSION['uid']
        );

        // Insert data into the 'returns_product' table
        $result2 = $this->pm->insert_data('returns_product', $rpdata);

        $pid = $info['product'][$i];

        // Update stock information
        $swhere = array(
            'pid' => $pid
        );

        $stpd = $this->pm->get_data('stock', $swhere);

        if ($stpd) {
            $tquantity = $info['quantity'][$i] + $stpd[0]['tquantity'];
        } else {
            $tquantity = $info['quantity'][$i];
        }

        $stock_info = array(
            'pid'       => $info['product'][$i],
            'tquantity' => $tquantity,
            'regby'     => $_SESSION['uid']
        );

        // Insert or update stock data
        if ($stpd) {
            $this->pm->update_data('stock', $stock_info, $swhere);
        } else {
            $this->pm->insert_data('stock', $stock_info);
        }
    }

    // Set session data based on success or failure
    if ($result && $result2) {
        $sdata = [
            'exception' => '<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i> Products Refunded Successfully!</h4>
                </div>'
        ];
    } else {
        $sdata = [
            'exception' => '<div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> Failed!</h4>
                </div>'
        ];
    }

    $this->session->set_userdata($sdata);
    redirect('refund');
}





public function view_return($id)
    {
    $data['title'] = 'Refund View';

    $other = array(
        'join' => 'left'
            );
    $where = array(
        'returnId' => $id
            );
    $field = array(
        'returns' => 'returns.*',
        'users' => 'users.*'
            );
    $join = array(
        'users' => 'users.uid = returns.employee'
            );

    $returns = $this->pm->get_data('returns',$where,$field,$join,$other);
    $data['returns'] = $returns[0];


    $rwhere = array(
        'rt_id' => $id,            
            );
    $rfield = array(
        'returns_product' => 'returns_product.*',
        'products' => 'products.pName,products.pCode, products.untid',
        'sma_units' => 'sma_units.unitName'
            );
    $rjoin = array(
        'products' => 'returns_product.productID = products.pid',
        'sma_units' => 'products.untid = sma_units.untid'
            );

    $data['rproduct']=$this->pm->get_data('returns_product',$rwhere,$rfield,$rjoin,$other);
    $data['company'] = $this->pm->company_details();

    $this->load->view('return/viewReturns',$data);
}

public function approve_refund($id)
    {
    $where = array(
        'returnId' => $id
            );
    
    $data = array(
        'approval' => 1,
        'upby'   => $_SESSION['uid']
            );
    
    $result = $this->pm->update_data('returns',$data,$where);
    $rwhere = array(
        'rt_id' => $id
            );
    $pproduct = $this->pm->get_data('returns_product',$rwhere);
    $result2 = $this->pm->delete_data('returns_product',$rwhere);
    
    $length = count($pproduct);

  for($i = 0; $i < $length; $i++)
    {
    $swhere = array(
      'pid' => $pproduct[$i]['productID']
            );

    $spd = $this->pm->get_data('stock',$swhere);
    
    $this->pm->delete_data('stock',$swhere);
        
    if($spd)
      {
      if($pproduct)
        {
        $tquantity = ($spd[0]['tquantity']+$pproduct[$i]['quantity']);
        $dtqnt = $stpd[0]['tdquantity'];
        }
      else
        {
        $tquantity = $spd[0]['tquantity'];
        $dtqnt = $stpd[0]['tdquantity'];
        }
      }
    else
      {
      $tquantity = 0;
      $dtqnt = 0;
      }

    $stock_info = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pproduct[$i]['productID'],
      'tquantity'  => $tquantity,
      'tdquantity' => $dtqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock_info); 
    }
  
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Refund Approved Successfully !</h4>
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
    redirect('refund');
}


public function get_delivery_req_by_ref()
  {
    $where = array(
    //   'compid'   => $_SESSION['compid'],
      'reference' => $_POST['id']
            );
  $ref = $_POST['id'];
  $grup = $this->pm->get_delivery_ref_data($ref);
//   $grup = $this->pm->get_data('delivery',$where);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function returns_by_sales_invoice()
    {
    
    $id = $this->input->post('returnid');
    $swhere = array(
        'rInvoice' => $id
            );
    $cother = array(
        'join' => 'left'
            );
    $cfield = array(
        'delivery' => 'delivery.*',
        // 'products' => 'products.pName,products.pCode',
        'users' => 'users.uName'
            );
    $cjoin = array(
        // 'products' => 'products.pid = delivery_product.pid',
        'users' => 'users.uid = delivery.regby'
            );
    $sales = $this->pm->get_data('delivery',$swhere,$cfield,$cjoin,$cother);
    if($sales)
        {
    $data['returns'] = $sales[0];
    
    $data['title'] = 'Returns';

    $cwhere = array(
        'compid' => $_SESSION['compid']
            );
    

    $data['customer'] = $this->pm->get_data('customers',$cwhere);
    $data['product'] = $this->pm->get_data('products',$cwhere);

    $where = array(
        'did' => $sales[0]['did']            
            );
    $other = array(
        'join' => 'left',
        'products.refundable' => '1'           
        );
    $field = array(
        'delivery_product' => 'delivery_product.*',
        'products' => 'products.pName,products.pCode, products.untid, products.refundable',
         'sma_units' => 'sma_units.unitName'
            );
    $join = array(
        'products' => 'products.pid = delivery_product.pid',
        'sma_units' => 'sma_units.untid = products.untid'
            );
    $data['rproduct'] = $this->pm->get_data('delivery_product',$where,$field,$join,$other);
    
    // var_dump($data['rproduct']);exit();

    $this->load->view('return/editReturn',$data);
    
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> This Requisition ID Can not exit !</h4>
            </div>'
                ];
        $this->session->set_userdata($sdata);
        redirect('newReturn');
        }
}

public function edit_returns($id)
    {
    $data['title'] = 'Returns';

    $cwhere = array(
        'compid' => $_SESSION['compid']
            );  

    $data['customer'] = $this->pm->get_data('customers',$cwhere);
    $data['product'] = $this->pm->get_data('products',$cwhere);

    $swhere = array(
        'returnId' => $id
            );
    $sales = $this->pm->get_data('returns',$swhere);
    $data['returns'] = $sales[0];

    $where = array(
        'rt_id' => $id            
            );
    $field = array(
        'returns_product' => 'returns_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $join = array(
        'products'=>'returns_product.productID = products.productID'
            );
    $other = array(
        'join'=>'left'
            );
    $data['rproduct'] = $this->pm->get_data('returns_product',$where,$field,$join,$other);

    $this->load->view('return/editReturn',$data);
}

// public function update_returns()
//   {
//   $info = $this->input->post();

//   if($info['sctype'] == '%')
//     {
//     $amount = ($info['totalprice']*$info['scAmount'])/100;
//     }
//   else
//     {
//     $amount = $info['scharge'];
//     }

//   $sale = array(
//     'returnDate' => date('Y-m-d',strtotime($info['date'])),
//     'customerID' => $info['customer'],
//     'invoice'    => $info['invoice'],
//     'totalPrice' => $info['totalprice'],
//     'paidAmount' => $info['totalprice']-$amount,
//     'scharge'    => $info['scharge'],      
//     'sctype'     => $info['sctype'],
//     'scAmount'   => $amount,
//     'accountType'=> $info['accountType'],
//     'accountNo'  => $info['accountNo'], 
//     'note'       => $info['note'],            
//     'upby'       => $_SESSION['uid']
//         );
//     //var_dump($sale); exit();
//   $where = array(
//     'returnId' => $info['returnId']
//         );
//   $result = $this->pm->update_data('returns',$sale,$where);

//   $rwhere = array(
//     'rt_id' => $info['returnId']
//         );

//   $pp = $this->pm->get_data('returns_product',$rwhere);
//   $this->pm->delete_data('returns_product',$rwhere);
  
//   $lnth = count($pp);

//   for($i = 0; $i < $lnth; $i++)
//     {
//     $swhere = array(
//       'product' => $pp[$i]['productID']
//             );

//     $spd = $this->pm->get_data('stock',$swhere);
    
//     $this->pm->delete_data('stock',$swhere);
        
//     if($spd)
//       {
//       if($pproduct)
//         {
//         $tquantity = ($spd[0]['totalPices']+$pp[$i]['quantity']);
//         $dtqnt = $stpd[0]['dtquantity'];
//         }
//       else
//         {
//         $tquantity = $spd[0]['totalPices'];
//         $dtqnt = $stpd[0]['dtquantity'];
//         }
//       }
//     else
//       {
//       $tquantity = 0;
//       $dtqnt = 0;
//       }

//     $stockinfo = array(
//       'compid'     => $_SESSION['compid'],
//       'product'    => $pp[$i]['productID'],
//       'totalPices' => $tquantity,
//       'dtquantity' => $dtqnt,
//       'regby'      => $_SESSION['uid']
//               );
//         //var_dump($stock_info);    
//     $this->pm->insert_data('stock',$stockinfo); 
//     }
    
//   $length = count($info['productID']);
//         //var_dump($length); exit();
//   for($i = 0;$i < $length;$i++)
//     {
//     $rproduct = array(
//       'rt_id'      => $info['returnId'],
//       'productID'  => $info['productID'][$i],
//       'quantity'   => $info['pices'][$i],
//       'salePrice'  => $info['salePrice'][$i],
//       'totalPrice' => $info['totalPrice'][$i],
//       'regby'      => $_SESSION['uid']
//           );

//     $rp_id = $this->pm->insert_data('returns_product',$rproduct);

//     $pid = $info['productID'][$i];
//     $aid = $_SESSION['compid'];

//     $swhere = array(
//       'product' => $pid
//               );

//     $stpd = $this->pm->get_data('stock',$swhere);
//     $this->pm->delete_data('stock',$swhere);

//     if($stpd)
//       {
//       $tquantity = $info['pices'][$i]+$stpd[0]['totalPices'];
//       $dtqnt = $stpd[0]['dtquantity'];
//       }
//     else
//       {
//       $tquantity = $info['pices'][$i];
//       $dtqnt = 0;
//       }

//     $stock_info = array(
//       'compid'     => $_SESSION['compid'],
//       'product'    => $info['productID'][$i],
//       'totalPices' => $tquantity,
//       'dtquantity' => $dtqnt,
//       'regby'      => $_SESSION['uid']
//               );
//       //var_dump($stock_info);    
//     $this->pm->insert_data('stock',$stock_info); 
//     }
//   if($result)
//     {
//     $sdata = [
//       'exception' =>'<div class="alert alert-danger alert-dismissible">
//       <h4><i class="icon fa fa-check"></i> Products Returns update Successfully !</h4></div>'
//             ];  
//     }
//   else
//     {
//     $sdata = [
//       'exception' =>'<div class="alert alert-danger alert-dismissible">
//       <h4><i class="icon fa fa-ban"></i> Failed !</h4></div>'
//             ];
//     }
//   $this->session->set_userdata($sdata);
//   redirect('Return');
// }

public function delete_returns($id)
    {
    $where = array(
        'returnId' => $id
            );

    $result = $this->pm->delete_data('returns',$where);

    $rwhere = array(
        'rt_id' => $id
            );
    $pproduct = $this->pm->get_data('returns_product',$rwhere);
    $result2 = $this->pm->delete_data('returns_product',$rwhere);
    
    $length = count($pproduct);

  for($i = 0; $i < $length; $i++)
    {
    $swhere = array(
      'pid' => $pproduct[$i]['productID']
            );

    $spd = $this->pm->get_data('stock',$swhere);
    
    $this->pm->delete_data('stock',$swhere);
        
    if($spd)
      {
      if($pproduct)
        {
        $tquantity = ($spd[0]['tquantity']-$pproduct[$i]['quantity']);
        $dtqnt = $stpd[0]['tdquantity'];
        }
      else
        {
        $tquantity = $spd[0]['tquantity'];
        $dtqnt = $stpd[0]['tdquantity'];
        }
      }
    else
      {
      $tquantity = 0;
      $dtqnt = 0;
      }

    $stock_info = array(
      'compid'    => $_SESSION['compid'],
      'pid'        => $pproduct[$i]['productID'],
      'tquantity'  => $tquantity,
      'tdquantity' => $dtqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock_info); 
    }
    
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Refund delete Successfully !</h4>
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
    redirect('refund');
}

public function purchase_return_list()
    {
    $data['title'] = 'Returns';
    
    $other = array(
        'join' => 'left',
        'order_by' => 'prid'
            );
    $field = array(
        'preturns' => 'preturns.*',
        'suppliers' => 'suppliers.supplierName,suppliers.sup_id'
            );
    $join = array(
        'suppliers' => 'suppliers.supplierID = preturns.customerID'
            );

    $data['return'] = $this->pm->get_data('preturns',false,$field,$join,$other);

    $this->load->view('return/purchase_returns',$data);
}

public function new_purchase_return()
    {
    $data['title'] = 'Returns';
    
    $where = array(
        'compid' => $_SESSION['compid']
            );
            
    $data['customer'] = $this->pm->get_data('suppliers',$where);
    $data['product'] = $this->pm->get_data('products',$where);

    $this->load->view('return/new_preturn',$data);
}

public function returns_by_purchase_invoice()
    {
    $id = $this->input->post('prid');
    
    $where = array(
        'challanNo' => $id
            );
    $sales = $this->pm->get_data('purchase',$where);
    
    if($sales)
        {
    $data['returns'] = $sales[0];
    
    $data['title'] = 'Returns';

    $cwhere = array(
        'compid' => $_SESSION['compid']
            );  

    $data['customer'] = $this->pm->get_data('suppliers',$cwhere);
    $data['product'] = $this->pm->get_data('products',$cwhere);
    
    $pwhere = array(
        'purchaseID' => $sales[0]['purchaseID']
            );

    $field = array(
        'purchase_product' => 'purchase_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $join = array(
        'products' => 'products.productID = purchase_product.productID'
            );
    $other = array(
        'join'=>'left'
            );
    $data['rproduct'] = $this->pm->get_data('purchase_product',$pwhere,$field,$join,$other);

    $this->load->view('return/edit_preturn',$data);
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> This Invoice ID Can not exit !</h4>
            </div>'
                ];
        $this->session->set_userdata($sdata);
        redirect('newpReturn');
        }
}

public function save_preturns()
    {
    $info = $this->input->post();

    $query = $this->db->select('prid')
                  ->from('preturns')
                  ->limit(1)
                  ->order_by('prid','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = $query->prid+1;
        }
    else
        {
        $sn = 1;
        }

    $cn = strtoupper(substr($_SESSION['compname'],0,3));
    $pc = sprintf("%'05d", $sn);

    $cusid = 'PR-'.$cn.$pc;

    $data = array(
        'prDate'     => date('Y-m-d',strtotime($info['date'])),
        'prCode'     => $cusid,
        'customerID' => $info['customer'],
        'challanNo'  => $info['invoice'],
        'totalPrice' => $info['totalprice'],
        'paidPrice'  => $info['totalprice'],
        'accountType'=> $info['accountType'],
        'accountNo'  => $info['accountNo'], 
        'note'       => $info['note'],          
        'regby'      => $_SESSION['uid']
            );
    //var_dump($sale); exit();
    
    $result = $this->pm->insert_data('preturns',$data);
       
    $length = count($info['productID']);

    for ($i = 0;$i < $length;$i++)
        {
        $rpdata = array(
            'prid'     => $result,
            'product'  => $info['productID'][$i],
            'quantity' => $info['pices'][$i],
            'pPrice'   => $info['salePrice'][$i],
            'tPrice'   => $info['totalPrice'][$i],
            'regby'    => $_SESSION['uid']
                );

        $result2 = $this->pm->insert_data('preturns_product',$rpdata);

        $pid = $info['productID'][$i];
        $aid = $_SESSION['compid'];

        $swhere = array(
            'product' => $pid,
            'compid' => $aid
                    );

        $stpd = $this->pm->get_data('stock',$swhere);

        $this->pm->delete_data('stock',$swhere);

        if($stpd)
            {
            $tquantity = $stpd[0]['totalPices']-$info['pices'][$i];
            $dtqnt = $stpd[0]['dtquantity'];
            }
        else{
            $tquantity = '-'.$info['pices'][$i];
            $dtqnt = 0;
            }

        $stock_info = array(
            'compid'     => $_SESSION['compid'],
            'product'    => $info['productID'][$i],
            'totalPices' => $tquantity,
            'dtquantity' => $dtqnt,
            'regby'      => $_SESSION['uid']
                    );
        //var_dump($stock_info);    
        $this->pm->insert_data('stock',$stock_info); 
        }
        
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Purchase Returns add Successfully !</h4>
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
    redirect('pReturn');
}

public function view_purchase_return($id)
    {
    $data['title'] = 'Return View';

    $other = array(
        'join' => 'left'
            );
    $where = array(
        'prid' => $id
            );
    $field = array(
        'preturns' => 'preturns.*',
        'suppliers' => 'suppliers.*'
            );
    $join = array(
        'suppliers' => 'suppliers.supplierID = preturns.customerID'
            );

    $returns = $this->pm->get_data('preturns',$where,$field,$join,$other);
    $data['returns'] = $returns[0];

    $rfield = array(
        'preturns_product' => 'preturns_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $rjoin = array(
        'products' => 'products.productID = preturns_product.product',
            );

    $data['rproduct']=$this->pm->get_data('preturns_product',$where,$rfield,$rjoin,$other);
    $data['company'] = $this->pm->company_details();

    $this->load->view('return/view_preturns',$data);
}

public function edit_purchase_return($id)
    {
    $data['title'] = 'Returns';

    $cwhere = array(
        'compid' => $_SESSION['compid']
            );  

    $data['customer'] = $this->pm->get_data('suppliers',$cwhere);
    $data['product'] = $this->pm->get_data('products',$cwhere);

    $where = array(
        'prid' => $id
            );
    $sales = $this->pm->get_data('preturns',$where);
    $data['returns'] = $sales[0];

    $field = array(
        'preturns_product' => 'preturns_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $join = array(
        'products' => 'products.productID = preturns_product.product',
            );
    $other = array(
        'join'=>'left'
            );
    $data['rproduct'] = $this->pm->get_data('preturns_product',$where,$field,$join,$other);

    $this->load->view('return/edit_preturn',$data);
}

public function update_preturns()
  {
  $info = $this->input->post();

  $sale = array(
    'prDate'      => date('Y-m-d',strtotime($info['date'])),
    'customerID'  => $info['customer'],
    'challanNo'   => $info['invoice'],
    'totalPrice'  => $info['totalprice'],
    'paidPrice'   => $info['totalprice'],
    'accountType' => $info['accountType'],
    'accountNo'   => $info['accountNo'], 
    'note'        => $info['note'],            
    'upby'        => $_SESSION['uid']
          );
    //var_dump($sale); exit();
  $where = array(
    'prid' => $info['prid']
        );

  $result = $this->pm->update_data('preturns',$sale,$where);

  $pp = $this->pm->get_data('preturns_product',$where);
  $this->pm->delete_data('preturns_product',$where);
  
  $lnth = count($pp);

  for($i = 0; $i < $lnth; $i++)
    {
    $swhere = array(
      'product' => $pp[$i]['product']
            );

    $spd = $this->pm->get_data('stock',$swhere);
    $this->pm->delete_data('stock',$swhere);
        
    if($spd)
      {
      if($pp)
        {
        $tquantity = ($spd[0]['totalPices']-$pp[$i]['quantity']);
        $dtqnt = $stpd[0]['tdquantity'];
        }
      else
        {
        $tquantity = $spd[0]['totalPices'];
        $dtqnt = $stpd[0]['tdquantity'];
        }
      }
    else
      {
      $tquantity = 0;
      $dtqnt = 0;
      }

    $stockinfo = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $pp[$i]['product'],
      'totalPices' => $tquantity,
      'tdquantity' => $dtqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stockinfo); 
    }

  $length = count($info['productID']);
        //var_dump($length); exit();
  for($i = 0;$i < $length;$i++)
    {
    $return_product = array(
      'prid'     => $info['prid'],
      'product'  => $info['productID'][$i],
      'quantity' => $info['pices'][$i],
      'pPrice'   => $info['salePrice'][$i],
      'tPrice'   => $info['totalPrice'][$i],
      'regby'    => $_SESSION['uid']
            );

    $rp_id = $this->pm->insert_data('preturns_product',$return_product);

    $pid = $info['productID'][$i];
    $aid = $_SESSION['compid'];

    $swhere = array(
      'product' => $pid
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tquantity = $stpd[0]['totalPices']-$info['pices'][$i];
      $dtqnt = $stpd[0]['tdquantity'];
      }
    else
      {
      $tquantity = '-'.$info['pices'][$i];
      $dtqnt = 0;
      }

    $stock_info = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $info['productID'][$i],
      'totalPices' => $tquantity,
      'tdquantity' => $dtqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock_info); 
    }
    
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Purchase Returns update Successfully !</h4></div>'
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
  redirect('pReturn');
}

public function delete_preturns($id)
    {
    $where = array(
        'prid' => $id
            );

    $result = $this->pm->delete_data('preturns',$where);
    $pproduct = $this->pm->get_data('preturns_product',$where);
    $result2 = $this->pm->delete_data('preturns_product',$where);
    
    $length = count($pproduct);

  for($i = 0; $i < $length; $i++)
    {
    $swhere = array(
      'product' => $pproduct[$i]['product']
            );

    $spd = $this->pm->get_data('stock',$swhere);
    
    $this->pm->delete_data('stock',$swhere);
        
    if($spd)
      {
      if($pproduct)
        {
        $tquantity = ($spd[0]['totalPices']-$pproduct[$i]['quantity']);
        $dtqnt = $stpd[0]['tdquantity'];
        }
      else
        {
        $tquantity = $spd[0]['totalPices'];
        $dtqnt = $stpd[0]['tdquantity'];
        }
      }
    else
      {
      $tquantity = 0;
      $dtqnt = 0;
      }

    $stock_info = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $pproduct[$i]['product'],
      'totalPices' => $tquantity,
      'tdquantity' => $dtqnt,
      'regby'      => $_SESSION['uid']
              );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock_info); 
    }
    
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i> purchase Returns delete Successfully !</h4>
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
    redirect('pReturn');
}





}