<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Product extends CI_Controller {

public function __construct(){
  parent::__construct();       
  $this->load->model("prime_model",'pm');            
  $this->checkPermission();
  $this->load->library('PHPExcel');
  $this->load->library('excel');
  $this->load->library('zend');
  $this->zend->load('Zend/Barcode'); 
}

public function index()
  {
  $data['title'] = 'Product'; 

  $other = array(
    'join' => 'left' 
          );
  $field = array(
    'products' => 'products.*',
    'categories' => 'categories.catName',
    'sub_category' => 'sub_category.scatName',
    'sma_units' => 'sma_units.unitName'
          );
  $join = array(
    'categories' => 'categories.catid = products.catid',
    'sub_category' => 'sub_category.scatid = products.scatid',
    'sma_units' => 'sma_units.untid = products.untid'
          );

//   $data['product'] = $this->pm->get_data('products',false,$field,$join,$other);

  $where = array(
    'status' => 'Active' 
        );
  $data['category'] = $this->pm->get_data('categories',$where);
  $data['scategory'] = $this->pm->get_data('sub_category');
  $data['unit'] = $this->pm->get_data('sma_units',$where);
  
  if(isset($_GET['search']))
    {
    // $stid = $_GET['sType'];
 
      $catid = $_GET['ptype'];
      if($catid == 'all'){
          $data['product'] = $this->pm->get_data('products',false,$field,$join,$other);
      }else{
          
      $swhere = array(
        'refundable' => $catid 
              );
      $data['product'] = $this->pm->get_data('products',$swhere,$field,$join,$other);
      }

    }
  else
    {
    $data['product'] = $this->pm->get_data('products',false,$field,$join,$other);
    }
    
  $this->load->view('products/product',$data);
}

public function save_product()
  {
  $info = $this->input->post();

//   $query = $this->db->select('pid')
//                 ->from('products')
//                 ->limit(1)
//                 ->order_by('pid','DESC')
//                 ->get()
//                 ->row();
//   if($query)
//     {
//     $sn = $query->pid+1;
//     }
//   else
//     {
//     $sn = 1;
//     }

//   $cn = strtoupper(substr($_SESSION['company'],0,3));
//   $pc = sprintf("%'04d",$sn);

//   $cusid = 'P-'.$cn.$pc;
    //var_dump($cusid); exit();
  $pdata = [
    'compid'  => $_SESSION['compid'],
    'scatid'    => $info['scategory'],
    'pCode'   => $info['pCode'],
    'pName'   => $info['pName'],
    'catid'   => $info['category'],
    'untid'   => $info['unit'],
    'refundable'   => $info['refundable'],
    'rNumber' => $info['rNumber'],
    'uprice'  => 0,
    'sprice'  => 0,
    'regby'   => $_SESSION['uid']
          ];
    //var_dump($productID); exit();
       
  $result = $this->pm->insert_data('products',$pdata);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product add Successfully !</h4>
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
  redirect('Product');
}

public function view_product($id)
  {
  $data['title'] = 'Product'; 

  $where = array(
    'pid' => $id  
        );
  $other = array(
    'join' => 'left' 
        );
  $field = array(
    'products'   => 'products.*',
    'categories' => 'categories.catName',
    'sma_units'  => 'sma_units.unitName'
          );
  $join = array(
    'categories' => 'categories.catid = products.catid',
    'sma_units'  => 'sma_units.untid = products.untid'
          );

  $product = $this->pm->get_data('products',$where,$field,$join,$other);
  $data['product'] = $product[0];

  $this->load->view('products/view_product',$data);
}

public function get_product_data()
  {
  $section = $this->pm->get_product_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_product()
  {
  $info = $this->input->post();

  $pdata = [
      'pCode'   => $info['pCode'],
    'pName'   => $info['pName'],
    'catid'   => $info['category'],
    'untid'   => $info['unit'],
    'rNumber' => $info['rNumber'],
    // 'uprice' => $info['pprice'],
    // 'sprice' => $info['sprice'],
    'refundable'   => $info['refundable'],
    'status'  => $info['status'],
    'upby'    => $_SESSION['uid']
        ];
    //var_dump($info); exit();
  $where = array(
    'pid' => $info['pid']
        );
    //var_dump($where); exit();
  $result = $this->pm->update_data('products',$pdata,$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product update Successfully !</h4>
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
  redirect('Product');
}

public function delete_products($pid)
  {
  $where = array(
    'pid' => $pid
        );
    //var_dump($where); exit();
  $result = $this->pm->delete_data('products',$where);
  $this->pm->delete_data('stock',$where);
      
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product delete Successfully !</h4>
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
  redirect('Product');
}

public function product_barcode($id)
  {
  $data['title'] = 'Product';

  if(isset($_GET['search']))
    {
    $nopack = $_GET['nopack'];
    $data['nopack'] = $nopack;
    $data['product'] = $id;

    $where = array(
      'pid' => $id
          );

    $data['product'] = $this->pm->get_data('products',$where);
    }
  else
    {
    $where = array(
      'pid' => $id
          );

    $data['product'] = $this->pm->get_data('products',$where);
    }
    //var_dump($data['products']); exit();
  $this->load->view('products/product_barcode',$data);
}

public function store_products_list()
  {
  $data['title'] = 'Product Opening Stock'; 

  $other = array(
    'order_by' => 'spid' 
          );

  $data['store'] = $this->pm->get_data('store_product',false,false,false,$other);
    
  $this->load->view('products/store_product',$data);
}

public function new_store_product()
  {
  $data['title'] = 'Product Opening Stock'; 

  $where = array(
    'status' => 'Active' 
        );
  $data['product'] = $this->pm->get_data('products',$where);
    
  $this->load->view('products/new_store_product',$data);
}

public function get_product($id)
  {
  $str = "";
  if($id == 'all'){
      $productlist = $this->pm->get_data('products',false);
  }else{
      $where = array(
        'pid' => $id
            );
      $productlist = $this->pm->get_data('products',$where);
      
  }
  foreach($productlist as $value)
    {
    $pid = $value['pid'];
    $str .= "<tr>
    <td>".$value['pName'].' ( '.$value['pCode'].' )'."<input type='hidden'  name='product[]' value='".$pid."' required ></td>
    <td><input type='text' class='form-control' name='quantity[]' value='0' required ></td>
    <td><span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span>
    </tr>";
    }
  echo json_encode($str);
}

public function save_store_product()
  {
  $info = $this->input->post();

  $pdata = [
    'quantity' => array_sum($info['quantity']),
    'notes'    => $info['notes'],
    'regby'    => $_SESSION['uid']
          ];
    //var_dump($productID); exit();
       
  $result = $this->pm->insert_data('store_product',$pdata);
 
  $length = count($info['product']);
        
  for($i = 0; $i < $length; $i++)
    {

    $pproduct = array(
      'spid'     => $result,
      'pid'      => $info['product'][$i],
      'quantity' => $info['quantity'][$i],
      'regby'    => $_SESSION['uid']
              );
        //var_dump($purchase_product);            
    $this->pm->insert_data('store_pdetails',$pproduct); 

    $swhere = array(
      'pid' => $info['product'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);

    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $info['quantity'][$i]+$stpd[0]['tquantity'];
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

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Store Product add Successfully !</h4>
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
  redirect('storeProduct');
}

public function edit_store_adjust($id)
  {
  $data['title'] = 'Product Physical Count'; 
  
  $where = array(
    'said' => $id
          );

  $store = $this->pm->get_data('store_adjust',$where);
  $data['store'] = $store[0];
  
  $other = array(
    'join' => 'left'
          );
  $field = array(
    'store_adetails' => 'store_adetails.*',
    'products' => 'products.pName,products.pCode'
          );  
  $join = array(
    'products' => 'products.pid = store_adetails.pid'
          );
  $data['sproduct'] = $this->pm->get_data('store_adetails',$where,$field,$join,$other);
  
  $this->load->view('products/edit_store_adjust',$data);
}

public function update_store_adjust()
  {
  $info = $this->input->post();
  
  $where = array(
    'said' => $info['said']
            );
              
  $pdata = [
    //'pid'      => $info['product'],
    'quantity' => array_sum($info['pcount']),
    //'notes'    => $info['notes'],
    'regby'    => $_SESSION['uid']
          ];
    //var_dump($productID); exit();
       
  $result = $this->pm->update_data('store_adjust',$pdata,$where);
  $pp = $this->pm->get_data('store_adetails',$where);
  $this->pm->delete_data('store_adetails',$where);
  
  $lnth = count($pp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'pid' => $pp[$i]['pid']
          );

    $s2tpd = $this->pm->get_data('stock',$sswhere);
    $this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['tquantity']-$pp[$i]['quantity'];
      $tdqnt = $s2tpd[0]['tdquantity'];
      }
    else
      {
      $tsqnt = '-'.$pp[$i]['quantity'];
      $tdqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pp[$i]['pid'],
      'tquantity'  => $tsqnt,
      'tdquantity' => $tdqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock);  
    }
  
  $length = count($info['product']);
        
  for($i = 0; $i < $length; $i++)
    {
    $pproduct = array(
      'said'     => $result,
      'pid'      => $info['product'][$i],
      'cstock'   => $info['cstock'][$i],
      'pcount'   => $info['pcount'][$i],
      'quantity' => $info['quantity'][$i],
      'remarks'  => $info['remarks'][$i],
      'regby'    => $_SESSION['uid']
              );
        //var_dump($purchase_product);            
    $this->pm->insert_data('store_adetails',$pproduct); 

    $swhere = array(
      'pid' => $info['product'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);

    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $info['quantity'][$i]+$stpd[0]['tquantity'];
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

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Store Adjust add Successfully !</h4>
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
  redirect('productAdjust');
}

public function edit_store_product($id)
  {
  $data['title'] = 'Product Opening Stock'; 
  
  $where = array(
    'spid' => $id
          );

  $store = $this->pm->get_data('store_product',$where);
  $data['store'] = $store[0];
  
  $other = array(
    'join' => 'left'
          );
  $field = array(
    'store_pdetails' => 'store_pdetails.*',
    'products' => 'products.pName,products.pCode'
          );  
  $join = array(
    'products' => 'products.pid = store_pdetails.pid'
          );
  $data['sproduct'] = $this->pm->get_data('store_pdetails',$where,$field,$join,$other);
  
  $swhere = array(
    'status' => 'Active' 
        );
  $data['product'] = $this->pm->get_data('products',$swhere);
  $this->load->view('products/edit_store_product',$data);
}

public function update_store_product()
  {
  $info = $this->input->post();
  $where = array(
    'spid' => $info['spid']
            );
              
  $pdata = [
    'quantity' => array_sum($info['quantity']),
    'notes'    => $info['notes'],
    'upby'     => $_SESSION['uid']
          ];
    //var_dump($productID); exit();
       
  $result = $this->pm->update_data('store_product',$pdata,$where);
  $pp = $this->pm->get_data('store_pdetails',$where);
  $this->pm->delete_data('store_pdetails',$where);
  
  $lnth = count($pp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'pid' => $pp[$i]['pid']
          );

    $s2tpd = $this->pm->get_data('stock',$sswhere);
    $this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['tquantity']-$pp[$i]['quantity'];
      $tdsqnt = $s2tpd[0]['tdquantity'];
      }
    else
      {
      $tsqnt = '-'.$pp[$i]['quantity'];
      $tdsqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pp[$i]['pid'],
      'tquantity'  => $tsqnt,
      'tdquantity' => $tdsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock);  
    }
  
  $length = count($info['product']);
        
  for($i = 0; $i < $length; $i++)
    {
    $pproduct = array(
      'spid'     => $result,
      'pid'      => $info['product'][$i],
      'quantity' => $info['quantity'][$i],
      'regby'    => $_SESSION['uid']
              );
        //var_dump($purchase_product);            
    $this->pm->insert_data('store_pdetails',$pproduct); 

    $swhere = array(
      'pid' => $info['product'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);

    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $info['quantity'][$i]+$stpd[0]['tquantity'];
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

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Store Product add Successfully !</h4>
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
  redirect('storeProduct');
}

public function delete_store_adjusts($id)
  {
  $where = array(
    'said' => $id
        );
  $result = $this->pm->delete_data('store_adjust',$where); 
  $pp = $this->pm->get_data('store_adetails',$where);
  $this->pm->delete_data('store_adetails',$where);
    
  $lnth = count($pp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'pid' => $pp[$i]['pid']
          );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    $this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['tquantity']-$pp[$i]['quantity'];
      $tdqnt = $s2tpd[0]['tdquantity'];
      }
    else
      {
      $tsqnt = '-'.$pp[$i]['quantity'];
      $tdqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pp[$i]['pid'],
      'tquantity'  => $tsqnt,
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
      <h4><i class="icon fa fa-check"></i> Store Adjust deleted Successfully !</h4></div>'
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
  redirect('productAdjust');
}

public function delete_store_products($id)
  {
  $where = array(
    'spid' => $id
        );
  $result = $this->pm->delete_data('store_product',$where); 
  $pp = $this->pm->get_data('store_pdetails',$where);
  $this->pm->delete_data('store_pdetails',$where);
    
  $lnth = count($pp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'pid' => $pp[$i]['pid']
          );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    $this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['tquantity']-$pp[$i]['quantity'];
      $tdqnt = $s2tpd[0]['tdquantity'];
      }
    else
      {
      $tsqnt = '-'.$pp[$i]['quantity'];
      $tdqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pp[$i]['pid'],
      'tquantity'  => $tsqnt,
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
      <h4><i class="icon fa fa-check"></i> Store Product delete Successfully !</h4></div>'
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
  redirect('storeProduct');
}

public function products_adjust_list()
  {
  $data['title'] = 'Product Physical Count'; 

  $other = array(
    'order_by' => 'said',
    'join' => 'left'
          );
  $field = array(
    'store_adjust' => 'store_adjust.*',
    'products' => 'products.pName,products.pCode'
          );  
  $join = array(
    'products' => 'products.pid = store_adjust.pid'
          );
  $data['store'] = $this->pm->get_data('store_adjust',false,$field,$join,$other);
  
  $where = array(
    'status' => 'Active' 
        );
  $data['product'] = $this->pm->get_data('products',$where);
    
  $this->load->view('products/store_adjust',$data);
}

public function new_store_adjust()
  {
  $data['title'] = 'Product Physical Count'; 

  $where = array(
    'status' => 'Active' 
        );
  $data['product'] = $this->pm->get_data('products',$where);
    
  $this->load->view('products/new_store_adjust',$data);
}

public function save_store_adjustment()
  {
  $info = $this->input->post();

  $pdata = [
    //'pid'      => $info['product'],
    'quantity' => array_sum($info['pcount']),
    //'notes'    => $info['notes'],
    'regby'    => $_SESSION['uid']
          ];
    //var_dump($productID); exit();
       
  $result = $this->pm->insert_data('store_adjust',$pdata);
  
  $length = count($info['product']);
        
  for($i = 0; $i < $length; $i++)
    {
    $pproduct = array(
      'said'     => $result,
      'pid'      => $info['product'][$i],
      'cstock'   => $info['cstock'][$i],
      'pcount'   => $info['pcount'][$i],
      'quantity' => $info['quantity'][$i],
      'remarks'  => $info['remarks'][$i],
      'regby'    => $_SESSION['uid']
              );
        //var_dump($purchase_product);            
    $this->pm->insert_data('store_adetails',$pproduct); 

    $swhere = array(
      'pid' => $info['product'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);

    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $info['pcount'][$i];
      $tdqnt = $stpd[0]['tdquantity'];
      }
    else
      {
      $tqnt = $info['pcount'][$i];
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

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Store Adjustment add Successfully !</h4>
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
  redirect('productAdjust');
}

public function get_adjust_product_data()
  {
  $section = $this->pm->get_adjust_product_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_product_adjustment()
  {
  $info = $this->input->post();
  $where = array(
    'said' => $info['said']
            );
              
  $pdata = [
    'pid'      => $info['product'],
    'quantity' => $info['quantity'],
    'notes'    => $info['notes'],
    'upby'     => $_SESSION['uid']
          ];
    //var_dump($productID); exit();
  $pp = $this->pm->get_data('store_adjust',$where);
  $result = $this->pm->update_data('store_adjust',$pdata,$where);
  
  $lnth = count($pp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'pid' => $pp[$i]['pid']
          );

    $s2tpd = $this->pm->get_data('stock',$sswhere);
    $this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['tquantity']-$pp[$i]['quantity'];
      $tdsqnt = $s2tpd[0]['tdquantity'];
      }
    else
      {
      $tsqnt = '-'.$pp[$i]['quantity'];
      $tdsqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pp[$i]['pid'],
      'tquantity'  => $tsqnt,
      'tdquantity' => $tdsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock);  
    }
  
  $length = count($info['product']);
        
  for($i = 0; $i < $length; $i++)
    {
    $pproduct = array(
      'spid'     => $result,
      'pid'      => $info['product'][$i],
      'quantity' => $info['quantity'][$i],
      'regby'    => $_SESSION['uid']
              );
        //var_dump($purchase_product);            
    $this->pm->insert_data('store_pdetails',$pproduct); 

    $swhere = array(
      'pid' => $info['product'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);

    $this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $info['quantity'][$i]+$stpd[0]['tquantity'];
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

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product Adjust update Successfully !</h4>
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
  redirect('productAdjust');
}

public function delete_products_adjustment($id)
  {
  $where = array(
    'said' => $id
        );
    //var_dump($productID); exit();
  $pp = $this->pm->get_data('store_adjust',$where);
  $result = $this->pm->delete_data('store_adjust',$where);
  
  $lnth = count($pp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'pid' => $pp[$i]['pid']
          );

    $s2tpd = $this->pm->get_data('stock',$sswhere);
    $this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['tquantity']-$pp[$i]['quantity'];
      $tdsqnt = $s2tpd[0]['tdquantity'];
      }
    else
      {
      $tsqnt = '-'.$pp[$i]['quantity'];
      $tdsqnt = 0;
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'pid'        => $pp[$i]['pid'],
      'tquantity'  => $tsqnt,
      'tdquantity' => $tdsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock);  
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product Adjust Delete Successfully !</h4>
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
  redirect('productAdjust');
}

public function product_reports()
  {
  $data['title'] = 'Stock Report'; 

  $other = array(
    'join' => 'left'         
        );
  $field = array(
    'stock' => 'stock.*',
    'products' => 'products.pName,products.pCode,products.uprice'
          );
  $join = array(
    'products' => 'products.pid = stock.pid'
          );

  $data['stock'] = $this->pm->get_data('stock',false,$field,$join,$other);
  $data['company'] = $this->pm->company_details();
  
  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
    
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;
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
      else if($month == 02)
        {
        $name = 'February';
        }
      else if($month == 03)
        {
        $name = 'March';
        }
      else if($month == 04)
        {
        $name = 'April';
        }
      else if($month == 05)
        {
        $name = 'May';
        }
      else if($month == 06)
        {
        $name = 'June';
        }
      else if($month == 07)
        {
        $name = 'July';
        }
      else if($month == 8)
        {
        $name = 'August';
        }
      else if($month == 9)
        {
        $name = 'September';
        }
      else if($month == 10)
        {
        $name = 'October';
        }
      else if($month == 11)
        {
        $name = 'November';
        }
      else
        {
        $name = 'December';
        }

      $data['name'] = $name;
      $data['report'] = $report;
      }
    else if($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;
      }
    }
  else
    {
    
    }
    //var_dump($data['products']); exit();
  $this->load->view('products/product_report',$data);
}

public function product_used_reports()
  {
  $data['title'] = 'Used Product Report'; 
  $data['product'] = $this->pm->get_data('products',false);
  $data['supplier'] = $this->pm->get_data('suppliers',false);

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
    
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;
      $pid = $_GET['dproduct'];
      $supid = $_GET['dsupplier'];
      
      $data['supid'] = $supid;
      $data['pid'] = $pid;
      if($supid = 'All')
        {
        $data['ostore'] = $this->pm->get_dused_product_ostore_data($sdate,$edate,$pid);
        $data['cstock'] = $this->pm->get_dused_product_cstock_data($sdate,$edate,$pid);
        $data['deliver'] = $this->pm->get_dused_product_delivery_data($sdate,$edate,$pid);
        }
      else
        {
        $data['ostore'] = null;
        $data['cstock'] = null;
        $data['deliver'] = null;
        }
        
      $data['order'] = $this->pm->get_dused_product_order_data($sdate,$edate,$pid,$supid);
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
      else if($month == 02)
        {
        $name = 'February';
        }
      else if($month == 03)
        {
        $name = 'March';
        }
      else if($month == 04)
        {
        $name = 'April';
        }
      else if($month == 05)
        {
        $name = 'May';
        }
      else if($month == 06)
        {
        $name = 'June';
        }
      else if($month == 07)
        {
        $name = 'July';
        }
      else if($month == 8)
        {
        $name = 'August';
        }
      else if($month == 9)
        {
        $name = 'September';
        }
      else if($month == 10)
        {
        $name = 'October';
        }
      else if($month == 11)
        {
        $name = 'November';
        }
      else
        {
        $name = 'December';
        }

      $data['name'] = $name;
      $data['report'] = $report;
      $pid = $_GET['mproduct'];
      $supid = $_GET['msupplier'];
        //var_dump($pid);
      $data['supid'] = $supid;
      $data['pid'] = $pid;
      if($supid = 'All')
        {
        $data['ostore'] = $this->pm->get_mused_product_ostore_data($month,$year,$pid);
        $data['cstock'] = $this->pm->get_mused_product_cstock_data($month,$year,$pid);
        $data['deliver'] = $this->pm->get_mused_product_delivery_data($month,$year,$pid);
        }
      else
        {
        $data['ostore'] = null;
        $data['cstock'] = null;
        $data['deliver'] = null;
        }
      
      $data['order'] = $this->pm->get_mused_product_order_data($month,$year,$pid,$supid);
      //var_dump($data['ostore']); exit();
      }
    else if($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;
      $pid = $_GET['yproduct'];
      $supid = $_GET['ysupplier'];
      
      $data['pid'] = $pid;
      $data['supid'] = $supid;
    //   var_dump($supid);exit();
      if($supid == 'All')
        {
        $data['ostore'] = $this->pm->get_yused_product_ostore_data($year,$pid);
        $data['cstock'] = $this->pm->get_yused_product_cstock_data($year,$pid);
        $data['deliver'] = $this->pm->get_yused_product_delivery_data($year,$pid);
        }
      else
        {
        $data['ostore'] = null;
        $data['cstock'] = null;
        $data['deliver'] = null;
        }
      $data['order'] = $this->pm->get_yused_product_order_data($year,$pid,$supid);
      }
    }
  else
    {
    $data['supid'] = 'All';
    $data['ostore'] = $this->pm->get_used_product_ostore_data();
    $data['cstock'] = $this->pm->get_used_product_cstock_data();
    $data['order'] = $this->pm->get_used_product_order_data();
    $data['deliver'] = $this->pm->get_used_product_delivery_data();
    }
  $data['company'] = $this->pm->company_details();
    //var_dump($data['products']); exit();
  $this->load->view('products/used_preport',$data);
}

public function excel_import()
    {
    if(isset($_FILES["file"]["name"]))
        {
        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        foreach($object->getWorksheetIterator() as $worksheet)
            {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $catid = '';
            for($row=2; $row<=$highestRow; $row++)
                {
                $pCode = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $pName = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $catid = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $unit = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $opStock = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                
                if(is_numeric($catid)){
                    $cat = $this->db->select('catid')->from('categories')->where('catid', $catid)->get()->row();
                    
                    if(!$cat){
                        $catID = 0;
                    }else{
                        $catID = $cat->catid;
                    }
                    
                }else{
                    $cat = $this->db->select('catid')->from('categories')->where('catName', $catid)->get()->row();
                    if(!$cat){
                        $data = array(
                        'compid'       => $_SESSION['compid'],
                        'catName'      => $catid,
                        'regby'        => $_SESSION['uid']
                            );
                        $this->db->insert('categories',$data);
                        $catn = $this->db->select('catid')->from('categories')->where('catName', $catid)->get()->row();
                        $catID = $catn->catid;
                    }else{
                        $catID = $cat->catid;
                    }
                }
                if(is_numeric($unit)){
                    $unt = $this->db->select('untid')->from('sma_units')->where('untid', $unit)->get()->row();
                    
                    if(!$unt){
                        $uID = 0;
                    }else{
                        $uID = $unt->untid;
                    }
                    
                }else{
                    $unt = $this->db->select('untid')->from('sma_units')->where('unitName', $unit)->get()->row();
                    if(!$unt){
                        $data = array(
                        'compid'       => $_SESSION['compid'],
                        'unitName'      => $unit,
                        'regby'        => $_SESSION['uid']
                            );
                        $this->db->insert('sma_units',$data);
                        $untn = $this->db->select('untid')->from('sma_units')->where('unitName', $unit)->get()->row();
                        $uID = $untn->untid;
                    }else{
                        $uID = $unt->untid;
                    }
                }
            

                if($code){
                    $cusid = $pCode;
                }else{
                    
                    $query = $this->db->select('pCode')
                                  ->from('products')
                                  ->where('compid',$_SESSION['compid'])
                                  ->limit(1)
                                  ->order_by('pCode','DESC')
                                  ->get()
                                  ->row();
                    if($query)
                        {
                        $sn = substr($query->pCode,5)+1;
                        }
                    else
                        {
                        $sn = 1;
                        }
    
                    $cn = strtoupper(substr($_SESSION['name'],0,3));
                    $pc = sprintf("%'04d",$sn);
    
                    $cusid = 'P-'.$cn.$pc;
                }


                $data = array(
                    'compid'  => $_SESSION['compid'],
                    'pCode'   => $cusid,
                    'pName'   => $pName,
                    'catid'   => $catID,
                    'untid'   => $uID,
                    'regby'   => $_SESSION['uid']
                        );
                $result = $this->db->insert('products', $data);
                }
            }
            
        
        if($result)
            {
            $sdata = [
              'exception' =>'<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i> Product import Successfully !</h4>
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
    }   
}

public function opening_stock_import()
    {
    if(isset($_FILES["file"]["name"]))
        {
        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        $sum = 0;
        foreach($object->getWorksheetIterator() as $worksheet)
            {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            
            // var_dump($highestRow);exit();
            
            for($row=2; $row<=$highestRow; $row++)
                {
                $sum += $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                
                }
                // var_dump($sum);exit();
            $pdata = [
                'quantity' => $sum,
                'regby'    => $_SESSION['uid']
                      ];
                   
              $store = $this->pm->insert_data('store_product',$pdata);
            
            for($row=2; $row<=$highestRow; $row++)
                {
                $pid = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $quantity = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    
                // var_dump($pid, $quantity);exit();
                $pproduct = array(
                  'spid'     => $store,
                  'pid'      => $pid,
                  'quantity' => $quantity,
                  'regby'    => $_SESSION['uid']
                          );
                    //var_dump($purchase_product);            
                    $result = $this->pm->insert_data('store_pdetails',$pproduct); 
                
                    $swhere = array(
                      'pid' => $pid
                              );
                
                    $stpd = $this->pm->get_data('stock',$swhere);
                
                    $this->pm->delete_data('stock',$swhere);
                
                    if($stpd)
                      {
                      $tqnt = $quantity+$stpd[0]['tquantity'];
                      $tdsqnt = $stpd[0]['tdquantity'];
                      }
                    else
                      {
                      $tqnt = $quantity;
                      $tdsqnt = 0;
                      }
                
                    $stock = array(
                      'compid'     => $_SESSION['compid'],
                      'pid'        => $pid,
                      'tquantity'  => $tqnt,
                      'tdquantity' => $tdsqnt,
                      'regby'      => $_SESSION['uid']
                              );
                      //var_dump($stock_info);    
                    $this->pm->insert_data('stock',$stock);
                }
            }
            
        
        if($result)
            {
            $sdata = [
              'exception' =>'<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i> Product import Successfully !</h4>
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
    }   
}


public function save_damage_product()
  {
  $info = $this->input->post();
  
  $sswhere = array(
    'pid' => $info['product']
          );

  $s2tpd = $this->pm->get_data('stock',$sswhere);
  $this->pm->delete_data('stock',$sswhere);

  if($s2tpd)
    {
    $tsqnt = $s2tpd[0]['tquantity']-$info['quantity'];
    $tdsqnt = $s2tpd[0]['tdquantity']+$info['quantity'];
    }
  else
    {
    $tsqnt = '-'.$info['quantity'];
    $tdsqnt = $info['quantity'];
    }

  $stock = array(
    'compid'     => $_SESSION['compid'],
    'pid'        => $info['product'],
    'tquantity'  => $tsqnt,
    'tdquantity' => $tdsqnt,
    'regby'      => $_SESSION['uid']
            );
        //var_dump($stock_info);    
  $this->pm->insert_data('stock',$stock);  
  
  $pproduct = array(
    'pid'      => $info['product'],
    'quantity' => $info['quantity'],
    'notes'    => $info['notes'],
    'regby'    => $_SESSION['uid']
          );
        //var_dump($purchase_product);            
  $result = $this->pm->insert_data('store_dproduct',$pproduct);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Damage Product add Successfully !</h4>
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
  redirect('Product');
}

public function get_subcategory_data()
  {
  $section = $this->pm->get_subcategory_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

}