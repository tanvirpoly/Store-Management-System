<?php 
defined ('BASEPATH') OR exit('no direct script access allowed');
class Access_setup extends CI_Controller

#########################################################################
{     /* Code Start From Here */
#########################################################################

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

  #############################################################
  #       /* Pages start*/              #
  #############################################################
            
public function user_access_setup()
  {
  $data['title'] = 'Access Setup';
  $where = array('axid >'=> 2);
  $data['user'] = $this->pm->get_data('access_lavels',$where);
  
  $this->load->view('user_role/user_access_setup',$data);
}

public function view_uaccess_setup($id)
  {
  $data = ['title' => 'Access Setup'];

  $where = array('utype'=> $id);
  $data['master'] = $this->pm->get_data('tbl_user_m_permission',$where);
  $data['page'] = $this->pm->get_data('tbl_user_p_permission',$where);
  $data['function'] = $this->pm->get_data('tbl_user_f_permission',$where);

  $awhere = array('axid'=> $id);
  $data['user'] = $this->pm->get_data('access_lavels',$awhere);
  
  $this->load->view('user_role/view_uaccess_setup',$data);
}

public function edit_uaccess_setup($id)
  {
  $data = ['title' => 'Access Setup'];

  $where = array('utype'=> $id);
  $data['master'] = $this->pm->get_data('tbl_user_m_permission',$where);
  $data['page'] = $this->pm->get_data('tbl_user_p_permission',$where);
  $data['function'] = $this->pm->get_data('tbl_user_f_permission',$where);

  $awhere = array('axid'=> $id);
  $data['user'] = $this->pm->get_data('access_lavels',$awhere);
  
  $this->load->view('user_role/edit_uaccess_setup',$data);
}

public function setup_user_access($id)
  {
  $info = $this->input->post();

  $where = array(
    'utype' => $id
        );

  if(isset($info['products']))
    {
    $products = '1';
    }
  else
    {
    $products = '0';
    }
  if(isset($info['orders']))
    {
    $orders = '1';
    }
  else
    {
    $orders = '0';
    }
  if(isset($info['requisitions']))
    {
    $requisitions = '1';
    }
  else
    {
    $requisitions = '0';
    }
  if(isset($info['users']))
    {
    $users = '1';
    }
  else
    {
    $users = '0';
    }
  if(isset($info['setting']))
    {
    $setting = '1';
    }
  else
    {
    $setting = '0';
    }
  if(isset($info['access_setup']))
    {
    $access_setup = '1';
    }
  else
    {
    $access_setup = '0';
    }

  $mdata = [
    'dashboard'    => 1,
    'products'     => $products,
    'orders'       => $orders,
    'requisitions' => $requisitions,
    'users'        => $users,
    'setting'      => $setting,
    'access_setup' => $access_setup,
    'upby'         => $_SESSION['uid']
            ];
  //var_dump($where); var_dump($data); exit();
  $result = $this->pm->update_data('tbl_user_m_permission',$mdata,$where);
  
  if(isset($info['product_list']))
    {
    $product_list = '1';
    }
  else
    {
    $product_list = '0';
    }
  if(isset($info['stock_report']))
    {
    $stock_report = '1';
    }
  else
    {
    $stock_report = '0';
    }
  if(isset($info['order_list']))
    {
    $order_list = '1';
    }
  else
    {
    $order_list = '0';
    }
  if(isset($info['new_order']))
    {
    $new_order = '1';
    }
  else
    {
    $new_order = '0';
    }
  if(isset($info['order_receive']))
    {
    $order_receive = '1';
    }
  else
    {
    $order_receive = '0';
    }
  if(isset($info['order_report']))
    {
    $order_report = '1';
    }
  else
    {
    $order_report = '0';
    }
  if(isset($info['receive_report']))
    {
    $receive_report = '1';
    }
  else
    {
    $receive_report = '0';
    }
  if(isset($info['requisition_list']))
    {
    $requisition_list = '1';
    }
  else
    {
    $requisition_list = '0';
    }
  if(isset($info['delivery_list']))
    {
    $delivery_list = '1';
    }
  else
    {
    $delivery_list = '0';
    }
  if(isset($info['refund_list']))
    {
    $refund_list = 1;
    }
  else
    {
    $refund_list = 0;
    }
  if(isset($info['requisition_report']))
    {
    $requisition_report = '1';
    }
  else
    {
    $requisition_report = '0';
    }
  if(isset($info['delivery_report']))
    {
    $delivery_report = '1';
    }
  else
    {
    $delivery_report = '0';
    }
  if(isset($info['customer']))
    {
    $customer = '1';
    }
  else
    {
    $customer = '0';
    }
  if(isset($info['supplier']))
    {
    $supplier = '1';
    }
  else
    {
    $supplier = '0';
    }
  if(isset($info['employee']))
    {
    $employee = '1';
    }
  else
    {
    $employee = '0';
    }
  if(isset($info['users']))
    {
    $users = '1';
    }
  else
    {
    $users = '0';
    }
  if(isset($info['category']))
    {
    $category = '1';
    }
  else
    {
    $category = '0';
    }
  if(isset($info['units']))
    {
    $units = '1';
    }
  else
    {
    $units = '0';
    }
  if(isset($info['user_type']))
    {
    $user_type = '1';
    }
  else
    {
    $user_type = '0';
    }

  $pdata = [
    'product_list'       => $product_list,
    'stock_report'       => $stock_report,
    'order_list'         => $order_list,
    'new_order'          => $new_order,
    'order_receive'      => $order_receive,
    'order_report'       => $order_report,
    'receive_report'     => $receive_report,
    'requisition_list'   => $requisition_list,
    'delivery_list'      => $delivery_list,
    'refund_list'        => $refund_list,
    'requisition_report' => $requisition_report,
    'delivery_report'    => $delivery_report,
    'customer'           => $customer,
    'supplier'           => $supplier,
    'employee'           => $employee,
    'users'              => $users,
    'category'           => $category,
    'units'              => $units,
    'user_type'          => $user_type,
    'upby'               => $_SESSION['uid']
            ];
  
  $result2 = $this->pm->update_data('tbl_user_p_permission',$pdata,$where);

  if(isset($info['new_product']))
    {
    $new_product = '1';
    }
  else
    {
    $new_product = '0';
    }
  if(isset($info['edit_product']))
    {
    $edit_product = '1';
    }
  else
    {
    $edit_product = '0';
    }
  if(isset($info['delete_product']))
    {
    $delete_product = '1';
    }
  else
    {
    $delete_product = '0';
    }
  if(isset($info['edit_order']))
    {
    $edit_order = '1';
    }
  else
    {
    $edit_order = '0';
    }
  if(isset($info['delete_order']))
    {
    $delete_order = '1';
    }
  else
    {
    $delete_order = '0';
    }
  if(isset($info['approve_order']))
    {
    $approve_order = '1';
    }
  else
    {
    $approve_order = '0';
    }
  if(isset($info['payment_order']))
    {
    $payment_order = '1';
    }
  else
    {
    $payment_order = '0';
    }
  if(isset($info['new_receive']))
    {
    $new_receive = '1';
    }
  else
    {
    $new_receive = '0';
    }
  if(isset($info['edit_receive']))
    {
    $edit_receive = '1';
    }
  else
    {
    $edit_receive = '0';
    }
  if(isset($info['delete_receive']))
    {
    $delete_receive = '1';
    }
  else
    {
    $delete_receive = '0';
    }
  if(isset($info['new_requisition']))
    {
    $new_requisition = '1';
    }
  else
    {
    $new_requisition = '0';
    }
  if(isset($info['edit_requisition']))
    {
    $edit_requisition = '1';
    }
  else
    {
    $edit_requisition = '0';
    }
  if(isset($info['delete_requisition']))
    {
    $delete_requisition = '1';
    }
  else
    {
    $delete_requisition = '0';
    }
  if(isset($info['approve_requisition']))
    {
    $approve_requisition = '1';
    }
  else
    {
    $approve_requisition = '0';
    }
  if(isset($info['new_delivery']))
    {
    $new_delivery = '1';
    }
  else
    {
    $new_delivery = '0';
    }
  if(isset($info['edit_delivery']))
    {
    $edit_delivery = '1';
    }
  else
    {
    $edit_delivery = '0';
    }
  if(isset($info['delete_delivery']))
    {
    $delete_delivery = '1';
    }
  else
    {
    $delete_delivery = '0';
    }
  if(isset($info['new_refund']))
    {
    $new_refund = '1';
    }
  else
    {
    $new_refund = '0';
    }
  if(isset($info['delete_refund']))
    {
    $delete_refund = '1';
    }
  else
    {
    $delete_refund = '0';
    }
  if(isset($info['approve_refund']))
    {
    $approve_refund = '1';
    }
  else
    {
    $approve_refund = '0';
    }
  if(isset($info['new_customer']))
    {
    $new_customer = '1';
    }
  else
    {
    $new_customer = '0';
    }
  if(isset($info['edit_customer']))
    {
    $edit_customer = '1';
    }
  else
    {
    $edit_customer = '0';
    }
  if(isset($info['delete_customer']))
    {
    $delete_customer = '1';
    }
  else
    {
    $delete_customer = '0';
    }
  if(isset($info['new_supplier']))
    {
    $new_supplier = '1';
    }
  else
    {
    $new_supplier = '0';
    }
  if(isset($info['edit_supplier']))
    {
    $edit_supplier = '1';
    }
  else
    {
    $edit_supplier = '0';
    }
  if(isset($info['delete_supplier']))
    {
    $delete_supplier = '1';
    }
  else
    {
    $delete_supplier = '0';
    }
  if(isset($info['new_employee']))
    {
    $new_employee = '1';
    }
  else
    {
    $new_employee = '0';
    }
  if(isset($info['edit_employee']))
    {
    $edit_employee = '1';
    }
  else
    {
    $edit_employee = '0';
    }
  if(isset($info['delete_employee']))
    {
    $delete_employee = '1';
    }
  else
    {
    $delete_employee = '0';
    }
  if(isset($info['new_user']))
    {
    $new_user = '1';
    }
  else
    {
    $new_user = '0';
    }
  if(isset($info['edit_user']))
    {
    $edit_user = '1';
    }
  else
    {
    $edit_user = '0';
    }
  if(isset($info['delete_user']))
    {
    $delete_user = '1';
    }
  else
    {
    $delete_user = '0';
    }
  if(isset($info['new_category']))
    {
    $new_category = '1';
    }
  else
    {
    $new_category = '0';
    }
  if(isset($info['edit_category']))
    {
    $edit_category = '1';
    }
  else
    {
    $edit_category = '0';
    }
  if(isset($info['delete_category']))
    {
    $delete_category = '1';
    }
  else
    {
    $delete_category = '0';
    }
  if(isset($info['new_unit']))
    {
    $new_unit = '1';
    }
  else
    {
    $new_unit = '0';
    }
  if(isset($info['edit_unit']))
    {
    $edit_unit = '1';
    }
  else
    {
    $edit_unit = '0';
    }
  if(isset($info['delete_unit']))
    {
    $delete_unit = '1';
    }
  else
    {
    $delete_unit = '0';
    }
  if(isset($info['new_utype']))
    {
    $new_utype = '1';
    }
  else
    {
    $new_utype = '0';
    }
  if(isset($info['edit_utype']))
    {
    $edit_utype = '1';
    }
  else
    {
    $edit_utype = '0';
    }
  if(isset($info['delete_utype']))
    {
    $delete_utype = '1';
    }
  else
    {
    $delete_utype = '0';
    }

  $fdata = [
    'new_product'        => $new_product,
    'edit_product'       => $edit_product,
    'delete_product'     => $delete_product,
    'edit_order'         => $edit_order,
    'delete_order'       => $delete_order,
    'approve_order'      => $approve_order,
    'payment_order'      => $payment_order,
    'new_receive'        => $new_receive,
    'edit_receive'       => $edit_receive,
    'delete_receive'     => $delete_receive,
    'new_requisition'    => $new_requisition,
    'edit_requisition'   => $edit_requisition,
    'delete_requisition' => $delete_requisition,
    'approve_requisition' => $approve_requisition,
    'new_delivery'       => $new_delivery,
    'edit_delivery'      => $edit_delivery,
    'delete_delivery'    => $delete_delivery,
    'new_refund'         => $new_refund,
    'delete_refund'      => $delete_refund,
    'approve_refund'     => $approve_refund,
    'new_customer'       => $new_customer,
    'edit_customer'      => $edit_customer,
    'delete_customer'    => $delete_customer,
    'new_supplier'       => $new_supplier,
    'edit_supplier'      => $edit_supplier,
    'delete_supplier'    => $delete_supplier,
    'new_employee'       => $new_employee,
    'edit_employee'      => $edit_employee,
    'delete_employee'    => $delete_employee,
    'new_user'           => $new_user,
    'edit_user'          => $edit_user,
    'delete_user'        => $delete_user,
    'new_category'       => $new_category,
    'edit_category'      => $edit_category,
    'delete_category'    => $delete_category,
    'new_unit'           => $new_unit,
    'edit_unit'          => $edit_unit,
    'delete_unit'        => $delete_unit,
    'new_utype'          => $new_utype,
    'edit_utype'         => $edit_utype,
    'delete_utype'       => $delete_utype,
    'upby'               => $_SESSION['uid']
      ];
  //var_dump($data2); exit();
  $result3 = $this->pm->update_data('tbl_user_f_permission',$fdata,$where);

  if($result3)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> User Page and Function Access add Successfully !</h4>
      </div>'
          ];    
    }
  else
    {
    $sdata=[
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Failed !</h4>
      </div>'
          ];
    }

  $this->session->set_userdata($sdata);
  redirect('userAccess');
}




  #########################################################
  #       /* Pages End */             #
  #########################################################


#######################################################################
}     /* Code Ends Here */
#######################################################################