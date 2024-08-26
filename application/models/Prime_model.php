<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Prime_model extends CI_Model {

public function get_data($table,$where = false,$fields = false,$join_table = false,$other = false)
  {
  if ($fields != false)
    {
    foreach ($fields as $coll => $value)
      {
      $this->db->select($value);
      }
    }

  $this->db->from($table);

  if($join_table != false)
    {
    if(is_array($other) && array_key_exists('join',$other))
      {
      foreach($join_table as $coll => $value)
        {
        $this->db->join($coll, $value, $other['join']);
        }
      }
    else
      {
      foreach($join_table as $coll => $value)
        {
        $this->db->join($coll, $value);
        }
      }
    }

  if($where != false)
    {
    $this->db->where($where);
    }

  if($other != false)
    {
    if(array_key_exists('or_where', $other))
      {
      $this->db->or_where($other['or_where']);
      }
    if(array_key_exists('order_by', $other))
      {
      $this->db->order_by($other['order_by'], 'desc');
      }
    if(array_key_exists('group_by', $other))
      {
      $this->db->group_by($other['group_by']);
      }
    if(array_key_exists('limit', $other))
      {
      if(array_key_exists('offset', $other))
        {
        $this->db->limit($other['limit'], $other['offset']);
        }
      else
        {
        $this->db->limit($other['limit']);
        }
      }

    if(array_key_exists('like', $other))
      {
      foreach ($other['like'] as $key => $value)
        {
        $this->db->like($key, $value);
        }
      }
    if(array_key_exists('or_like', $other))
      {
      foreach ($other['or_like'] as $key => $value)
        {
        $this->db->or_like($key, $value);
        }
      }
    }
  $query = $this->db->get();

  $result = $query->result_array();

  return $result;
}

public function insert_data($table,$data)
  {
  $this->db->insert($table,$data);
  
  return $this->db->insert_id();
}

public function update_data($table,$data = false,$where = false)
  {
  $this->db->update($table,$data,$where);

  return $this->db->affected_rows();
}
public function get_sub_category_data($id)
  {
  $query = $this->db->select('*')
                ->from('sub_category')
                ->where('scatid',$id)
                ->get()
                ->row();
  return $query;
}
public function get_subcategory_data($id)
  {
  $query = $this->db->select('*')
                ->from('sub_category')
                ->where('catid',$id)
                ->get()
                ->result();
  return $query;
}
public function delete_data($table,$where)
  {
  $this->db->where($where);
  $this->db->delete($table);
  
  return $this->db->affected_rows();
}

public function count_all($tbl)
  {
  return $this->db->count_all($tbl);
}

public function all_query($sql)
  {
  return $result = $this->db->query($sql)->result_array();
}

public function company_details()
  {
  $query = $this->db->select('*')
                  ->from('com_profile')
                  ->where('compid',1)
                  ->get()
                  ->row();
  return $query;  
}

public function check_mobile($mid)
  {
  $query = $this->db->select("uid")
                  ->FROM('users')
                  ->where('uMobile',$mid)
                  ->get()
                  ->row();
  return $query;  
}

public function check_email($mid)
  {
  $query = $this->db->select("uid")
                  ->FROM('users')
                  ->where('uEmail',$mid)
                  ->get()
                  ->row();
  return $query;  
}

public function total_user_type()
  {
  $query = $this->db->select('*')
                ->from('access_lavels')
                ->where('axid >',2)
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function get_category_data($id)
  {
  $query = $this->db->select('*')
                ->from('categories')
                ->where('catid',$id)
                ->get()
                ->row();
  return $query;
}

public function get_unit_data($id)
  {
  $query = $this->db->select('*')
                ->from('sma_units')
                ->where('untid',$id)
                ->get()
                ->row();
  return $query;
}

public function get_cost_type_data($id)
  {
  $query = $this->db->select('*')
                ->from('cost_type')
                ->where('ctid',$id)
                ->get()
                ->row();
  return $query;
}

public function get_user_role_data($id)
  {
  $query = $this->db->select('*')
                ->from('access_lavels')
                ->where('axid',$id)
                ->get()
                ->row();
  return $query;
}

public function get_employee()
  {
  $emp = $this->db->select('empid')
              ->from('users')
              ->get()
              ->result_array();
    //var_dump($emp); exit();
  $emp_id = array_map (function($value){
    return $value['empid'];
    },$emp);
    //var_dump($emp_id); exit();
  if($emp_id)
    {
    $empid = $emp_id;
    }
  else
    {
    $empid = 0;
    }
    //var_dump($empid); exit();
  return $this->db->select('empid,empName')
              ->from('employees')
              ->where_not_in('empid',$empid)
              ->get()
              ->result();
}

public function get_user_data($id)
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('uid',$id)
                ->get()
                ->row();
  return $query;
}

public function total_user()
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('userrole >',2)
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function get_customer_data($id)
  {
  $query = $this->db->select('*')
                  ->from('customers')
                  ->where('custid',$id)
                  ->get()
                  ->row();
  return $query; 
}

public function get_supplier_data($id)
  {
  $query = $this->db->select('*')
                  ->from('suppliers')
                  ->where('supid',$id)
                  ->get()
                  ->row();
  return $query; 
}

public function get_emp_data($id)
  {
  $query = $this->db->select('*')
                  ->from('employees')
                  ->where('empid',$id)
                  ->get()
                  ->row();
  return $query; 
}

public function get_product_data($id)
  {
  $query = $this->db->select('*')
                ->from('products')
                ->where('pid',$id)
                ->get()
                ->row();
  return $query;
}

public function get_purchses_data()
  {
  $query = $this->db->select('
                        purchase.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('purchase')
                    ->join('suppliers','suppliers.supid = purchase.supid','left')
                    ->get()
                    ->result();
  return $query;
}

public function get_dpurchses_data($sdate,$edate,$supid)
  {
  if($supid == 'All')
    {
    $query = $this->db->select('
                        purchase.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('purchase')
                    ->join('suppliers','suppliers.supid = purchase.supid','left')
                    ->where('purchase.puDate >=',$sdate)
                    ->where('purchase.puDate <=',$edate)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                      purchase.*,
                      suppliers.supCode,
                      suppliers.supName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supid = purchase.supid','left')
                  ->where('purchase.puDate >=',$sdate)
                  ->where('purchase.puDate <=',$edate)
                  ->where('purchase.supid',$supid)
                  ->get()
                  ->result();
    }
  return $query;  
}

public function get_mpurchses_data($month,$year,$supid)
  {
  if($supid == 'All')
    {
    $query = $this->db->select('
                        purchase.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('purchase')
                    ->join('suppliers','suppliers.supid = purchase.supid','left')
                    ->where('MONTH(puDate)',$month)
                    ->where('YEAR(puDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                      purchase.*,
                      suppliers.supCode,
                      suppliers.supName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supid = purchase.supid','left')
                  ->where('MONTH(puDate)',$month)
                  ->where('YEAR(puDate)',$year)
                  ->where('purchase.supid',$supid)
                  ->get()
                  ->result();
    }
  return $query;  
}

public function get_ypurchses_data($year,$supid)
  {
  if($supid == 'All')
    {
    $query = $this->db->select('
                        purchase.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('purchase')
                    ->join('suppliers','suppliers.supid = purchase.supid','left')
                    ->where('YEAR(puDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                      purchase.*,
                      suppliers.supCode,
                      suppliers.supName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supid = purchase.supid','left')
                  ->where('YEAR(puDate)',$year)
                  ->where('purchase.supid',$supid)
                  ->get()
                  ->result();
    }
  return $query;  
}

public function get_receive_order_data()
  {
  $query = $this->db->select('
                        receive_order.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('receive_order')
                    ->join('suppliers','suppliers.supid = receive_order.supid','left')
                    ->get()
                    ->result();
  return $query;
}

public function get_dreceive_order_data($sdate,$edate,$supid)
  {
  if($supid == 'All')
    {
    $query = $this->db->select('
                        receive_order.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('receive_order')
                    ->join('suppliers','suppliers.supid = receive_order.supid','left')
                    ->where('receive_order.roDate >=',$sdate)
                    ->where('receive_order.roDate <=',$edate)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                        receive_order.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('receive_order')
                    ->join('suppliers','suppliers.supid = receive_order.supid','left')
                    ->where('receive_order.roDate >=',$sdate)
                    ->where('receive_order.roDate <=',$edate)
                    ->where('receive_order.supid',$supid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_mreceive_order_data($month,$year,$supid)
  {
  if($supid == 'All')
    {
    $query = $this->db->select('
                        receive_order.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('receive_order')
                    ->join('suppliers','suppliers.supid = receive_order.supid','left')
                    ->where('MONTH(roDate)',$month)
                    ->where('YEAR(roDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                        receive_order.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('receive_order')
                    ->join('suppliers','suppliers.supid = receive_order.supid','left')
                    ->where('MONTH(roDate)',$month)
                    ->where('YEAR(roDate)',$year)
                    ->where('receive_order.supid',$supid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_yreceive_order_data($year,$supid)
  {
  if($supid == 'All')
    {
    $query = $this->db->select('
                        receive_order.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('receive_order')
                    ->join('suppliers','suppliers.supid = receive_order.supid','left')
                    ->where('YEAR(roDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                        receive_order.*,
                        suppliers.supCode,
                        suppliers.supName')
                    ->from('receive_order')
                    ->join('suppliers','suppliers.supid = receive_order.supid','left')
                    ->where('YEAR(roDate)',$year)
                    ->where('receive_order.supid',$supid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_sales_data()
  {
  $query = $this->db->select('
                          sales.*,
                          users.uName,
                          users.uMobile')
                    ->from('sales')
                    ->join('users','users.uid = sales.regby','left')
                    ->get()
                    ->result();
  return $query;  
}

public function get_dsales_data($sdate,$edate,$empid)
  {
  if($empid == 'All')
    {
    $query = $this->db->select('
                          sales.*,
                          users.uName,
                          users.uMobile')
                    ->from('sales')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('saDate >=',$sdate)
                    ->where('saDate <=',$edate)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                          sales.*,
                          users.uName,
                          users.uMobile')
                    ->from('sales')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('saDate >=',$sdate)
                    ->where('saDate <=',$edate)
                    ->where('sales.regby',$empid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_msales_data($month,$year,$empid)
  {
  if($empid == 'All')
    {
    $query = $this->db->select('
                          sales.*,
                          users.uName,
                          users.uMobile')
                    ->from('sales')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('MONTH(saDate)',$month)
                    ->where('YEAR(saDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                          sales.*,
                          users.uName,
                          users.uMobile')
                    ->from('sales')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('MONTH(saDate)',$month)
                    ->where('YEAR(saDate)',$year)
                    ->where('sales.regby',$empid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_ysales_data($year,$empid)
  {
  if($empid == 'All')
    {
    $query = $this->db->select('
                          sales.*,
                          users.uName,
                          users.uMobile')
                    ->from('sales')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('YEAR(saDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                          sales.*,
                          users.uName,
                          users.uMobile')
                    ->from('sales')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('YEAR(saDate)',$year)
                    ->where('sales.regby',$empid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_delivery_data()
  {
  $query = $this->db->select('
                          delivery.*,
                          users.uName,
                          users.uMobile')
                    ->from('delivery')
                    ->join('users','users.uid = delivery.empid','left')
                    ->get()
                    ->result();
  return $query;  
}

public function get_ddelivery_data($sdate,$edate,$empid)
  {
  if($empid == 'All')
    {
    $query = $this->db->select('
                          delivery.*,
                          users.uName,
                          users.uMobile')
                    ->from('delivery')
                    ->join('users','users.uid = delivery.empid','left')
                    ->join('delivery_product','delivery_product.did = delivery.did','left')
                    ->join('products','products.pid = delivery_product.pid','left')
                    ->where('dDate >=',$sdate)
                    ->where('dDate <=',$edate)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                          delivery.*,
                          users.uName,
                          users.uMobile')
                    ->from('delivery')
                    ->join('users','users.uid = delivery.empid','left')
                    ->where('dDate >=',$sdate)
                    ->where('dDate <=',$edate)
                    ->where('delivery.empid',$empid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_mdelivery_data($month,$year,$empid)
  {
  if($empid == 'All')
    {
    $query = $this->db->select('
                          delivery.*,
                          users.uName,
                          users.uMobile')
                    ->from('delivery')
                    ->join('users','users.uid = delivery.empid','left')
                    ->where('MONTH(dDate)',$month)
                    ->where('YEAR(dDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                          delivery.*,
                          users.uName,
                          users.uMobile')
                    ->from('delivery')
                    ->join('users','users.uid = delivery.empid','left')
                    ->where('MONTH(dDate)',$month)
                    ->where('YEAR(dDate)',$year)
                    ->where('delivery.empid',$empid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_ydelivery_data($year,$empid)
  {
  if($empid == 'All')
    {
    $query = $this->db->select('
                          delivery.*,
                          users.uName,
                          users.uMobile')
                    ->from('delivery')
                    ->join('users','users.uid = delivery.empid','left')
                    ->where('YEAR(dDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                          delivery.*,
                          users.uName,
                          users.uMobile')
                    ->from('delivery')
                    ->join('users','users.uid = delivery.empid','left')
                    ->where('YEAR(dDate)',$year)
                    ->where('delivery.empid',$empid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_purchase_payment($id)
  {
  $payment = $this->db->select('SUM(ppAmount) as total')
              ->from('purchase_payment')
              ->where('puid',$id)
              ->get()
              ->row();

  $purchase = $this->db->select('tAmount')
              ->from('purchase')
              ->where('puid',$id)
              ->get()
              ->row();
  if($payment)
    {
    $query = $purchase->tAmount - $payment->total;
    }
  else
    {
    $query = $payment->total;
    }
  return $query; 
}

public function graph_data_point()
  {
  $date_arr = $this->getLastNDays(7, 'Y-m-d');
  $dataPoints = array();

  for($i = 0; $i < 7; $i++)
    {
    array_push($dataPoints, array("y" => $this->get_today_sale(preg_replace('/[^A-Za-z0-9\-]/','',$date_arr[$i])),"label" => preg_replace('/[^A-Za-z0-9\-]/','',$date_arr[$i])));
    }

    return $dataPoints;
}

public function get_today_sale($date)
  {
  $query = $this->db->select('*')
                ->from('sales')
                ->where('saDate',$date)
                ->get();

  $count = $query->num_rows();

  if($count)
    {
    return $count;
    }
  else
    {
    $dt = 0;
    return $dt;
    }
}

public function getLastNDays($days, $format = 'd-m')
  {
  $m = date("m"); $de= date("d"); $y= date("Y");
  $dateArray = array();
  for($i=0; $i<=$days-1; $i++)
    {
    $dateArray[] = '"'.date($format, mktime(0,0,0,$m,($de-$i),$y)).'"'; 
    }
  return array_reverse($dateArray);
}











public function today_sales_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(pAmount) as total")
                  ->FROM('sales')
                  ->where('saDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_purchases_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(pAmount) as total")
                  ->FROM('purchase')
                  ->where('puDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_cvoucher_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(tAmount) as total")
                  ->FROM('vaucher')
                  ->WHERE('vType','Credit Voucher')
                  ->where('vDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_dvoucher_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(tAmount) as total")
                  ->FROM('vaucher')
                  ->WHERE('vType','Debit Voucher')
                  ->where('vDate',$date)
                  ->get()
                  ->row();
  return $query;  
}



public function total_category()
  {
  $query = $this->db->select('*')
                ->from('categories')
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_unit()
  {
  $query = $this->db->select('*')
                ->from('sma_units')
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_cash_account()
  {
  $query = $this->db->select('*')
                ->from('cash')
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_bank_account()
  {
  $query = $this->db->select('*')
                ->from('bankaccount')
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_mobile_account()
  {
  $query = $this->db->select('*')
                ->from('mobileaccount')
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function get_cash_account($id)
  {
  $query = $this->db->select('*')
                ->from('cash')
                ->where('caid',$id)
                ->get()
                ->row();
  return $query;
}

public function get_bank_account($id)
  {
  $query = $this->db->select('*')
                ->from('bankaccount')
                ->where('baid',$id)
                ->get()
                ->row();
  return $query;
}

public function get_mobile_account($id)
  {
  $query = $this->db->select('*')
                ->from('mobileaccount')
                ->where('maid',$id)
                ->get()
                ->row();
  return $query;
}

public function total_customer()
  {
  $query = $this->db->select('*')
                ->from('customers')
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_supplier()
  {
  $query = $this->db->select('*')
                ->from('suppliers')
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_employee()
  {
  $query = $this->db->select('*')
                ->from('employees')
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}



public function get_stock_data($id)
  {
  $query = $this->db->select('*')
                ->from('stock')
                ->where('pid',$id)
                ->get()
                ->row();
  return $query;
}

public function get_sales_payment($id)
  {
  $query = $this->db->select('*')
              ->from('sales')
              ->where('said',$id)
              ->get()
              ->row();
  return $query; 
}

public function current_password_check($cpassword)
  {
  return $this->db->select('*')
                ->from('users')
                ->where('password',$cpassword)
                ->get()
                ->row();
}

public function get_voucher_data()
  {
  $query = $this->db->select("*")
                  ->from('vaucher')
                  ->get()
                  ->result();
  return $query;  
}

public function get_dall_voucher_data($sdate,$edate,$vtype)
  {
  if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('vDate >=', $sdate)
                    ->where('vDate <=', $edate)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('vDate >=', $sdate)
                    ->where('vDate <=', $edate)
                    ->where('vType',$vtype)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_mall_voucher_data($month,$year,$vtype)
  {
  if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('MONTH(vDate)',$month)
                    ->where('YEAR(vDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('MONTH(vDate)',$month)
                    ->where('YEAR(vDate)',$year)
                    ->where('vType',$vtype)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_yall_voucher_data($year,$vtype)
  {
  if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('YEAR(vDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('YEAR(vDate)',$year)
                    ->where('vType',$vtype)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function total_sale()
  {
  $query = $this->db->select("SUM(tAmount) as total")
                  ->FROM('sales')
                  ->get()
                  ->row();
  return $query;  
}

public function total_purchase()
  {
  $query = $this->db->select("SUM(tAmount) as total")
                  ->FROM('purchase')
                  ->get()
                  ->row();
  return $query;  
}

public function total_cvoucher_amount()
  {
  $query = $this->db->select("SUM(tAmount) as total")
                  ->FROM('vaucher')
                  ->WHERE('vType','Credit Voucher')
                  ->get()
                  ->row();
  return $query;  
}

public function total_dvoucher_amount()
  {
  $query = $this->db->select("SUM(tAmount) as total")
                  ->FROM('vaucher')
                  ->WHERE('vType','Debit Voucher')
                  ->get()
                  ->row();
  return $query;  
}

public function total_stock()
  {
  $query = $this->db->select('SUM(tquantity) as total')
                ->from('stock')
                ->get()
                ->row();
  return $query;
}

public function total_voucher()
  {
  $query = $this->db->select("SUM(tAmount) as total")
                  ->FROM('vaucher')
                  ->get()
                  ->row();
  return $query;  
}

public function sales_cust_ledger_data($custid)
  {
  $query = $this->db->select("*,SUM(sale_productOne.quantityOne) as quantityOne,SUM(sale_productOne.uprice) as uprice")
                  ->FROM('saleOne')
                  ->join('sale_productOne','sale_productOne.saidOne=saleOne.saidOne','left')
                  ->group_by('saleOne.saidOne')
                  ->WHERE('custid',$custid)
                  ->get()
                  ->result();
  return $query;  
}

public function voucher_cust_ledger_data($custid)
  {
  $query = $this->db->select("*")
                  ->FROM('vaucher')
                  ->WHERE('custid',$custid)
                  ->get()
                  ->result();
  return $query;  
}

public function sales_dcust_ledger_data($custid,$sdate,$edate)
  {
   $query = $this->db->select("*,SUM(sale_productOne.quantityOne) as quantityOne,SUM(sale_productOne.uprice) as uprice")
                  ->FROM('saleOne')
                  ->join('sale_productOne','sale_productOne.saidOne=saleOne.saidOne','left')
                  ->WHERE('custid',$custid)
                  ->where('saDateOne >=', $sdate)
                  ->where('saDateOne <=', $edate)
                  ->get()
                  ->result();
  return $query;  
}

public function voucher_dcust_ledger_data($custid,$sdate,$edate)
  {
  $query = $this->db->select("*")
                  ->FROM('vaucher')
                  ->WHERE('custid',$custid)
                  ->where('vDate >=', $sdate)
                  ->where('vDate <=', $edate)
                  ->get()
                  ->result();
  return $query;  
}

public function sales_mcust_ledger_data($custid,$month,$year)
  {
    $query = $this->db->select("*,SUM(sale_productOne.quantityOne) as quantityOne,SUM(sale_productOne.uprice) as uprice")
                  ->FROM('saleOne')
                  ->join('sale_productOne','sale_productOne.saidOne=saleOne.saidOne','left')
                  ->WHERE('custid',$custid)
                  ->where('MONTH(saDateOne)',$month)
                  ->where('YEAR(saDateOne)',$year)
                  ->get()
                  ->result();
  return $query;  
}

public function voucher_mcust_ledger_data($custid,$month,$year)
  {
  $query = $this->db->select("*")
                  ->FROM('vaucher')
                  ->WHERE('custid',$custid)
                  ->where('MONTH(vDate)',$month)
                  ->where('YEAR(vDate)',$year)
                  ->get()
                  ->result();
  return $query;  
}

public function sales_ycust_ledger_data($custid,$year)
  {
    $query = $this->db->select("*,SUM(sale_productOne.quantityOne) as quantityOne,SUM(sale_productOne.uprice) as uprice")
                  ->FROM('saleOne')
                  ->join('sale_productOne','sale_productOne.saidOne=saleOne.saidOne','left')
                  ->WHERE('custid',$custid)
                  ->where('YEAR(saDateOne)',$year)
                  ->get()
                  ->result();
  return $query;  
}

public function voucher_ycust_ledger_data($custid,$year)
  {
  $query = $this->db->select("*")
                  ->FROM('vaucher')
                  ->WHERE('custid',$custid)
                  ->where('YEAR(vDate)',$year)
                  ->get()
                  ->result();
  return $query;  
}

public function get_dspurchase_data($sdate,$edate,$sid)
  {
  $query = $this->db->select('*')
                  ->from('purchase')
                  ->where('puDate >=', $sdate)
                  ->where('puDate <=', $edate)
                  ->where('supid',$sid)
                  ->get()
                  ->result();

  return $query;  
}

public function get_dsvoucher_data($sdate,$edate,$sid)
  {
  $query = $this->db->select('*')
                  ->from('vaucher')
                  ->where('vDate >=', $sdate)
                  ->where('vDate <=', $edate)
                  ->where('supid',$sid)
                  ->get()
                  ->result();

  return $query;  
}

public function get_mspurchase_data($month,$year,$sid)
  {
  $query = $this->db->select('*')
                  ->from('purchase')
                  ->where('MONTH(puDate)',$month)
                  ->where('YEAR(puDate)',$year)
                  ->where('supid',$sid)
                  ->get()
                  ->result();

  return $query;  
}

public function get_msvoucher_data($month,$year,$sid)
  {
  $query = $this->db->select('*')
              ->from('vaucher')
              ->where('MONTH(vDate)',$month)
              ->where('YEAR(vDate)',$year)
              ->where('supid',$sid)
              ->get()
              ->result();

  return $query;  
}

public function get_yspurchase_data($year,$sid)
  {
  $query = $this->db->select('*')
              ->from('purchase')
              ->where('YEAR(puDate)',$year)
              ->where('supid',$sid)
              ->get()
              ->result();

  return $query;  
}

public function get_ysvoucher_data($year,$sid)
  {
  $query = $this->db->select('*')
              ->from('vaucher')
              ->where('YEAR(vDate)',$year)
              ->where('supid',$sid)
              ->get()
              ->result();

  return $query;  
}

public function check_user_email($id)
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('email',$id)
                ->get();

  $count_row = $query->num_rows();

  if($count_row == 0)
    {
    return 1;
    }
  else
    {
    return 0;
    }
}

public function get_page_and_function()
  {
  $query = $this->db->select('
              tbl_page_functions.pfunc_id,
              tbl_page_functions.pageid,
              tbl_page_functions.fcname,
              tbl_pages.pageid,
              tbl_pages.master_page,
              tbl_pages.cname,
              tbl_master_page_title.master_id,
              tbl_master_page_title.c_master_title')
            ->from('tbl_pages')
            ->join('tbl_master_page_title','tbl_master_page_title.master_id = tbl_pages.master_page','left')
            ->join('tbl_page_functions','tbl_page_functions.pageid = tbl_pages.pageid','left')
            ->get()
            ->result();
  return $query;
}

public function saveNewMaster_data($data)
  {
  $column = $data['master_title'] ;
  $table = 'tbl_user_m_permission';

  $fields = array(
    'preferences' => array('type' => 'INT','constraint' => 5 )
      );

  $fields2 = array(
    'preferences' => array(
      'name' => $column ,
      'type' => 'INT',
      'constraint' => 5
        ),
      );
    // $add = mysql_query("ALTER TABLE $table ADD $column INT( 1 ) NOT NULL");
  $this->load->dbforge();
  $this->dbforge->add_column('tbl_user_m_permission',$fields);

  $this->load->dbforge();
  $add = $this->dbforge->modify_column('tbl_user_m_permission',$fields2);
  // var_dump($add); exit();
  return $this->db->insert('tbl_master_page_title', $data); 
}

public function saveNewPage_data($data)
  {
  $column = $data['pagename'] ;
  $table = 'tbl_user_p_permission';

  $fields = array(
    'preferences' => array('type' => 'INT','constraint' => 5 )
      );

  $fields2 = array(
    'preferences' => array(
      'name' => $column,
      'type' => 'INT',
      'constraint' => 5
        ),
      );
    // $add = mysql_query("ALTER TABLE $table ADD $column INT( 1 ) NOT NULL");
  $this->load->dbforge();
  $this->dbforge->add_column('tbl_user_p_permission',$fields);

  $this->load->dbforge();
  $add = $this->dbforge->modify_column('tbl_user_p_permission',$fields2);
    // var_dump($add); exit();
  return $this->db->insert('tbl_pages', $data); 
}

public function saveNewPageFunction_data($data)
  {
  $column = $data['pfunc_name'] ;
  $table = 'tbl_user_f_permission';

  $fields = array(
    'preferences' => array('type' => 'INT','constraint' => 5 )
      );

  $fields2 = array(
    'preferences' => array(
      'name' => $column,
      'type' => 'INT',
      'constraint' => 5
        ),
      );
    // $add = mysql_query("ALTER TABLE $table ADD $column INT( 1 ) NOT NULL");
  $this->load->dbforge();
  $this->dbforge->add_column('tbl_user_f_permission',$fields);

  $this->load->dbforge();
  $add = $this->dbforge->modify_column('tbl_user_f_permission', $fields2);
    // var_dump($add); exit();
  return $this->db->insert('tbl_page_functions',$data); 
}

public function get_page_data_by_master($id)
  {
  $query = $this->db->select('*')
            ->from('tbl_pages')
            ->where('master_page',$id)
            ->get()
            ->result();
  return $query;
}

public function get_user_permission_data()
  {
  $emp = $this->db->select('compid')
                ->from('tbl_user_m_permission')
                ->get()
                ->result_array();
  //var_dump($emp); exit();
  $emp_id = array_map (function($value){
    return $value['compid'];
    },$emp);

  if ($emp_id == null) {
    $emp_id = 0;
    }

  $emps = $this->db->select('compid,name,compname')
                ->from('users')
                ->where_not_in('compid',$emp_id)
                ->where('userrole',2)
                ->get()
                ->result();
  return $emps;
}

public function get_delivery_emp_data($id)
  {
  $emp = $this->db->select('
                    returns.invoice,
                    returns_product.productID,
                    SUM(returns_product.quantity) as total,
                    SUM(delivery_product.quantity) as t2otal')
                ->from('returns_product')
                ->join('returns','returns_product.rt_id = returns.returnId','left')
                ->join('delivery_product','delivery_product.pid = returns_product.productID','left')
                //->where('SUM(returns_product.quantity) >=','SUM(delivery_product.quantity)')
                //->group_by('returns_product.productID')
                ->get()
                ->result_array();
    //var_dump($emp); exit();
  $emp_id = array_map(function($value){
  return $value['invoice'];
  },$emp);
    //var_dump($emp_id); exit();
  if($emp_id)
    {
    $empid = $emp_id;
    }
  else
    {
    $empid = 0;
    }
    
  $query = $this->db->select("
                        delivery.rInvoice,
                        delivery.reference,
                        delivery_product.*,
                        products.refundable")
                  ->FROM('delivery')
                  ->join('delivery_product', 'delivery_product.did = delivery.did', 'left')
                  ->join('products', 'products.pid = delivery_product.pid', 'left')
                  ->where('delivery.empid',$id)
                  ->where('products.refundable',1)
                  //->where_not_in('rInvoice',$empid)
                  ->get()
                  ->result();
  return $query;  
}

public function total_sales_amount()
  {
  $query = $this->db->select("SUM(pAmount) as total")
                  ->FROM('sales')
                  ->get()
                  ->row();
  return $query;  
}

public function total_purchases_amount()
  {
  $query = $this->db->select("SUM(pAmount) as total")
                    ->FROM('purchase')
                    ->get()
                    ->row();
  return $query;  
}

public function total_svoucher_amount()
  {
  $query = $this->db->select("SUM(tAmount) as total")
                    ->FROM('vaucher')
                    ->WHERE('vType','Supplier Pay')
                    ->get()
                    ->row();
  return $query;  
}

public function total_dsales_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(pAmount) as total")
                  ->FROM('sales')
                  ->where('sales.saDate >=', $sdate)
                  ->where('sales.saDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dpurchases_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(pAmount) as total")
                  ->FROM('purchase')
                  ->where('puDate >=', $sdate)
                  ->where('puDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_demp_payments_amount($sdate,$edate)
    {
    $query = $this->db->select("SUM(`salary`) as total")
                    ->FROM('employee_payment')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('regdate >=', $sdate)
                    ->where('regdate <=', $edate)
                    ->get()
                    ->row();
    return $query;  
}

public function total_dreturns_amount($sdate,$edate)
    {
    $query = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as sctotal")
                    ->FROM('returns')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('returnDate >=', $sdate)
                    ->where('returnDate <=', $edate)
                    ->get()
                    ->row();
    return $query;  
}

public function total_dcvoucher_amount($sdate,$edate)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Credit Voucher')
                    ->where('voucherdate >=', $sdate)
                    ->where('voucherdate <=', $edate)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ddvoucher_amount($sdate,$edate)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Debit Voucher')
                    ->where('voucherdate >=', $sdate)
                    ->where('voucherdate <=', $edate)
                    ->get()
                    ->row();
    return $query;  
}

public function total_dcusvoucher_amount($sdate,$edate)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Customer Pay')
                    ->where('voucherdate >=', $sdate)
                    ->where('voucherdate <=', $edate)
                    ->get()
                    ->row();
    return $query;  
}

public function total_dsvoucher_amount($sdate,$edate)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Supplier Pay')
                    ->where('voucherdate >=', $sdate)
                    ->where('voucherdate <=', $edate)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ddamage_amount($sdate,$edate)
    {
    $query = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as ctotal")
                    ->FROM('damages')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('damagedate >=', $sdate)
                    ->where('damagedate <=', $edate)
                    ->get()
                    ->row();
    return $query;  
}

public function total_msales_amount($month,$year)
    {
    $query = $this->db->select("SUM(`paidAmount`) as total")
                    ->FROM('sales')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('MONTH(sales.regdate)',$month)
                    ->where('YEAR(sales.regdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_mpurchases_amount($month,$year)
    {
    $query = $this->db->select("SUM(`paidAmount`) as total")
                    ->FROM('purchase')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('MONTH(purchaseDate)',$month)
                    ->where('YEAR(purchaseDate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_memp_payments_amount($month,$year)
    {
    $query = $this->db->select("SUM(`salary`) as total")
                    ->FROM('employee_payment')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('MONTH(regdate)',$month)
                    ->where('YEAR(regdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_mreturns_amount($month,$year)
    {
    $query = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as sctotal")
                    ->FROM('returns')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('MONTH(returnDate)',$month)
                    ->where('YEAR(returnDate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_mcvoucher_amount($month,$year)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Credit Voucher')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_mdvoucher_amount($month,$year)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Debit Voucher')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_mcusvoucher_amount($month,$year)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Customer Pay')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_msvoucher_amount($month,$year)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Supplier Pay')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_mdamage_amount($month,$year)
    {
    $query = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as ctotal")
                    ->FROM('damages')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('MONTH(damagedate)',$month)
                    ->where('YEAR(damagedate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ysales_amount($year)
    {
    $query = $this->db->select("SUM(`paidAmount`) as total")
                    ->FROM('sales')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('YEAR(sales.regdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ypurchases_amount($year)
    {
    $query = $this->db->select("SUM(`paidAmount`) as total")
                    ->FROM('purchase')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('YEAR(purchaseDate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_yemp_payments_amount($year)
    {
    $query = $this->db->select("SUM(`salary`) as total")
                    ->FROM('employee_payment')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('YEAR(regdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_yreturns_amount($year)
    {
    $query = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as sctotal")
                    ->FROM('returns')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('YEAR(returnDate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ycvoucher_amount($year)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Credit Voucher')
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ydvoucher_amount($year)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Debit Voucher')
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ycusvoucher_amount($year)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Customer Pay')
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ysvoucher_amount($year)
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->WHERE('vauchertype','Supplier Pay')
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function total_ydamage_amount($year)
    {
    $query = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as ctotal")
                    ->FROM('damages')
                    ->WHERE('compid',$_SESSION['compid'])
                    ->where('YEAR(damagedate)',$year)
                    ->get()
                    ->row();
    return $query;  
}

public function get_adjust_product_data($id)
    {
    $query = $this->db->select("*")
                    ->FROM('store_adjust')
                    ->where('said',$id)
                    ->get()
                    ->row();
    return $query;  
}

public function get_purchase_memo_data()
  {
  $emp = $this->db->select('roMemo')
              ->from('receive_order')
              ->get()
              ->result_array();
    //var_dump($emp); exit();
  $empid = array_map (function($value){
    return $value['roMemo'];
    },$emp);
    //var_dump($emp_id); exit();
  if($empid)
    {
    return $this->db->select('*')
              ->from('purchase')
              ->where_not_in('memoNo',$empid)
              ->where('status','Approved')
              ->get()
              ->result();
    }
  else
    {
    return $this->db->select('*')
              ->from('purchase')
            //  ->where_not_in('memoNo',$empid)
              ->where('status','Approved')
              ->get()
              ->result();
    }
    //var_dump($empid); exit();

}

public function get_sale_memo_data()
  {
  $emp = $this->db->select('rInvoice')
              ->from('delivery')
              ->get()
              ->result_array();
    //var_dump($emp); exit();
  $emp_id = array_map (function($value){
    return $value['rInvoice'];
    },$emp);
    //var_dump($emp_id); exit();
  if($emp_id)
    {
    $empid = $emp_id;
    }
  else
    {
    $empid = 0;
    }
    //var_dump($empid); exit();
  return $this->db->select('*')
              ->from('sales')
              ->where_not_in('invoice',$empid)
              ->where('status','Approved')
              ->get()
              ->result();
}
public function get_delivery_pro_data()
  {
  $emp = $this->db->select('rInvoice')
              ->from('delivery')
              ->get()
              ->result_array();
    // var_dump($emp); exit();
  $emp_id = array_map (function($value){
    return $value['rInvoice'];
    },$emp);
    //var_dump($emp_id); exit();
  if($emp_id)
    {
    $empid = $emp_id;
    }
  else
    {
    $empid = 0;
    }
    // var_dump($empid); exit();
  return $this->db->select('returns.*')
              ->from('returns')
            //   ->join('returns_product', 'returns_product.rt_id = returns.returnId', 'left')
            //   ->join('products', 'products.pid = returns_product.productID', 'left')
              ->where_not_in('invoice',$empid)
            //   ->where('products.refundable','1')
              ->get()
              ->result();
}

public function get_product_ptype_sstock_data($catid)
  {
  $emp = $this->db->select('pid')
        ->from('products')
        ->get()
        ->result_array();
    //var_dump($emp); exit();
  $emp_id = array_map (function($value){
  return $value['pid'];
  },$emp);
    //var_dump($emp_id); exit();
  if($emp_id == NULL)
      {
      $empid = 0;
      }
  else{
      $empid = $emp_id;
      }
  
//   if($catid == 1)
//     {
    $query = $this->db->select('products.*')
                ->from('products')
                ->where_in('products.refundable',$catid)
                ->get()
                ->result();
//     }
//   else
//     {
    // $query = $this->db->select('stock.*,products.productName,products.productcode,products.pprice,products.sprice')
    //             ->from('stock')
    //             ->join('products','products.productID = stock.product','left')
    //             ->where('dtquantity > 0')
    //             ->where_in('stock.product',$empid)
    //             ->get()
    //             ->result();
    // }
  return $query;  
}


public function get_stock_product_data()
  {
  $emp = $this->db->select('pid')
              ->from('stock')
              ->where('tquantity >',0)
              ->get()
              ->result_array();
    //var_dump($emp); exit();
  $emp_id = array_map (function($value){
    return $value['pid'];
    },$emp);
    //var_dump($emp_id); exit();
  if($emp_id)
    {
    $empid = $emp_id;
    }
  else
    {
    $empid = 0;
    }
    //var_dump($empid); exit();
  return $this->db->select('*')
              ->from('products')
              ->where_in('pid',$empid)
              ->where('status','Active')
              ->get()
              ->result();
}

public function get_not_store_product($id)
  {
  $emp = $this->db->select('pid')
              ->from('store_pdetails')
              ->where('spid',$id)
              ->get()
              ->result_array();
    //var_dump($emp); exit();
  $emp_id = array_map (function($value){
    return $value['pid'];
    },$emp);
    //var_dump($emp_id); exit();
  if($emp_id)
    {
    $empid = $emp_id;
    }
  else
    {
    $empid = 0;
    }
    //var_dump($empid); exit();
  return $this->db->select('pCode,pName')
              ->from('products')
              ->where_not_in('pid',$empid)
              ->get()
              ->result();
}

public function get_used_product_ostore_data()
  {
  $query = $this->db->select('store_pdetails.*,products.pName,products.pCode')
              ->from('store_pdetails')
              ->join('products','products.pid = store_pdetails.pid','left')
              ->get()
              ->result();
  return $query;
}

public function get_used_product_cstock_data()
  {
  $query = $this->db->select('store_adetails.*,products.pName,products.pCode')
              ->from('store_adetails')
              ->join('products','products.pid = store_adetails.pid','left')
              ->get()
              ->result();
  return $query;
}

public function get_used_product_order_data()
  {
  $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->get()
              ->result();
  return $query;
}

public function get_used_product_delivery_data()
  {
  $query = $this->db->select('delivery_product.*,products.pName,products.pCode,delivery.rInvoice,delivery.dDate')
              ->from('delivery_product')
              ->join('products','products.pid = delivery_product.pid','left')
              ->join('delivery','delivery.did = delivery_product.did','left')
              ->get()
              ->result();
  return $query;
}

public function get_dused_product_ostore_data($sdate,$edate,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('store_pdetails.*,products.pName,products.pCode')
              ->from('store_pdetails')
              ->join('products','products.pid = store_pdetails.pid','left')
              ->where('DATE(store_pdetails.regdate) >=', $sdate)
              ->where('DATE(store_pdetails.regdate) <=', $edate)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('store_pdetails.*,products.pName,products.pCode')
              ->from('store_pdetails')
              ->join('products','products.pid = store_pdetails.pid','left')
              ->where('DATE(store_pdetails.regdate) >=', $sdate)
              ->where('DATE(store_pdetails.regdate) <=', $edate)
              ->where('store_pdetails.pid', $pid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_dused_product_cstock_data($sdate,$edate,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('store_adetails.*,products.pName,products.pCode')
              ->from('store_adetails')
              ->join('products','products.pid = store_adetails.pid','left')
              ->where('DATE(store_adetails.regdate) >=', $sdate)
              ->where('DATE(store_adetails.regdate) <=', $edate)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('store_adetails.*,products.pName,products.pCode')
              ->from('store_adetails')
              ->join('products','products.pid = store_adetails.pid','left')
              ->where('DATE(store_adetails.regdate) >=', $sdate)
              ->where('DATE(store_adetails.regdate) <=', $edate)
              ->where('store_adetails.pid',$pid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_dused_product_order_data($sdate,$edate,$pid,$supid)
  {
  if($pid == 'All' && $supid == 'All')
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
                      ->from('purchase_product')
                      ->join('products','products.pid = purchase_product.pid','left')
                      ->join('purchase','purchase.puid = purchase_product.puid','left')
                      ->join('suppliers','suppliers.supid = purchase.supid','left')
                      ->where('puDate >=', $sdate)
                      ->where('puDate <=', $edate)
                      ->get()
                      ->result();
    }
  else if($pid == 'All')
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
                      ->from('purchase_product')
                      ->join('products','products.pid = purchase_product.pid','left')
                      ->join('purchase','purchase.puid = purchase_product.puid','left')
                      ->join('suppliers','suppliers.supid = purchase.supid','left')
                      ->where('puDate >=', $sdate)
                      ->where('puDate <=', $edate)
                      ->where('supid', $supid)
                      ->get()
                      ->result();
    }
  else if($supid == 'All')
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
                      ->from('purchase_product')
                      ->join('products','products.pid = purchase_product.pid','left')
                      ->join('purchase','purchase.puid = purchase_product.puid','left')
                      ->join('suppliers','suppliers.supid = purchase.supid','left')
                      ->where('puDate >=', $sdate)
                      ->where('puDate <=', $edate)
                      ->where('purchase_product.pid', $pid)
                      ->get()
                      ->result();
    }
  else
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
                      ->from('purchase_product')
                      ->join('products','products.pid = purchase_product.pid','left')
                      ->join('purchase','purchase.puid = purchase_product.puid','left')
                      ->join('suppliers','suppliers.supid = purchase.supid','left')
                      ->where('puDate >=', $sdate)
                      ->where('puDate <=', $edate)
                      ->where('purchase_product.pid', $pid)
                      ->where('supid', $supid)
                      ->get()
                      ->result();
    }
  return $query;
}

public function get_dused_product_delivery_data($sdate,$edate,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('delivery_product.*,products.pName,products.pCode,delivery.rInvoice,delivery.dDate, users.uName')
              ->from('delivery_product')
              ->join('products','products.pid = delivery_product.pid','left')
              ->join('delivery','delivery.did = delivery_product.did','left')
              ->join('users','users.uid = delivery.empid','left')
              ->where('dDate >=', $sdate)
              ->where('dDate <=', $edate)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('delivery_product.*,products.pName,products.pCode,delivery.rInvoice,delivery.dDate, users.uName')
              ->from('delivery_product')
              ->join('products','products.pid = delivery_product.pid','left')
              ->join('delivery','delivery.did = delivery_product.did','left')
              ->join('users','users.uid = delivery.empid','left')
              ->where('dDate >=', $sdate)
              ->where('dDate <=', $edate)
              ->where('delivery_product.pid', $pid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_mused_product_ostore_data($month,$year,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('store_pdetails.*,products.pName,products.pCode')
              ->from('store_pdetails')
              ->join('products','products.pid = store_pdetails.pid','left')
              ->where('MONTH(store_pdetails.regdate)', $month)
              ->where('YEAR(store_pdetails.regdate)', $year)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('store_pdetails.*,products.pName,products.pCode')
              ->from('store_pdetails')
              ->join('products','products.pid = store_pdetails.pid','left')
              ->where('MONTH(store_pdetails.regdate)', $month)
              ->where('YEAR(store_pdetails.regdate)', $year)
              ->where('store_pdetails.pid', $pid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_mused_product_cstock_data($month,$year,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('store_adetails.*,products.pName,products.pCode')
              ->from('store_adetails')
              ->join('products','products.pid = store_adetails.pid','left')
              ->where('MONTH(store_adetails.regdate)', $month)
              ->where('YEAR(store_adetails.regdate)', $year)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('store_adetails.*,products.pName,products.pCode')
              ->from('store_adetails')
              ->join('products','products.pid = store_adetails.pid','left')
              ->where('MONTH(store_adetails.regdate)', $month)
              ->where('YEAR(store_adetails.regdate)', $year)
              ->where('store_adetails.pid',$pid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_mused_product_order_data($month,$year,$pid,$supid)
  {
  if($pid == 'All' && $supid == 'All')
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->where('MONTH(puDate)', $month)
              ->where('YEAR(puDate)', $year)
              ->get()
              ->result();
    }
  else if($pid == 'All')
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->where('MONTH(puDate)', $month)
              ->where('YEAR(puDate)', $year)
              ->where('supid', $supid)
              ->get()
              ->result();
    }
  else if($supid == 'All')
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->where('MONTH(puDate)', $month)
              ->where('YEAR(puDate)', $year)
              ->where('purchase_product.pid', $pid)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->where('MONTH(puDate)', $month)
              ->where('YEAR(puDate)', $year)
              ->where('purchase_product.pid', $pid)
              ->where('supid', $supid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_mused_product_delivery_data($month,$year,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('delivery_product.*,products.pName,products.pCode,delivery.rInvoice,delivery.dDate, users.uName')
              ->from('delivery_product')
              ->join('products','products.pid = delivery_product.pid','left')
              ->join('delivery','delivery.did = delivery_product.did','left')
              ->join('users','users.uid = delivery.empid','left')
              ->where('MONTH(dDate)', $month)
              ->where('YEAR(dDate)', $year)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('delivery_product.*,products.pName,products.pCode,delivery.rInvoice,delivery.dDate, users.uName')
              ->from('delivery_product')
              ->join('products','products.pid = delivery_product.pid','left')
              ->join('delivery','delivery.did = delivery_product.did','left')
              ->join('users','users.uid = delivery.empid','left')
              ->where('MONTH(dDate)', $month)
              ->where('YEAR(dDate)', $year)
              ->where('delivery_product.pid', $pid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_yused_product_ostore_data($year,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('store_pdetails.*,products.pName,products.pCode')
              ->from('store_pdetails')
              ->join('products','products.pid = store_pdetails.pid','left')
              ->where('store_pdetails.quantity >', 0)
              ->where('YEAR(store_pdetails.regdate)', $year)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('store_pdetails.*,products.pName,products.pCode')
              ->from('store_pdetails')
              ->join('products','products.pid = store_pdetails.pid','left')
              ->where('store_pdetails.quantity >', 0)
              ->where('YEAR(store_pdetails.regdate)', $year)
              ->where('store_pdetails.pid', $pid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_yused_product_cstock_data($year,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('store_adetails.*,products.pName,products.pCode')
              ->from('store_adetails')
              ->join('products','products.pid = store_adetails.pid','left')
              ->where('YEAR(store_adetails.regdate)', $year)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('store_adetails.*,products.pName,products.pCode')
              ->from('store_adetails')
              ->join('products','products.pid = store_adetails.pid','left')
              ->where('YEAR(store_adetails.regdate)', $year)
              ->where('store_adetails.pid',$pid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_yused_product_order_data($year,$pid,$supid)
  {
    //   var_dump($pid, $supid);exit();
  if($pid == 'All' && $supid == 'All')
    {
        // echo 'all';
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->where('YEAR(puDate)', $year)
              ->get()
              ->result();
    }
  else if($pid == 'All')
    {
        // echo 'no sup';
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->where('YEAR(puDate)', $year)
              ->where('purchase.supid', $supid)
              ->get()
              ->result();
    }
  else if($supid == 'All')
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->where('YEAR(puDate)', $year)
              ->where('purchase_product.pid', $pid)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('purchase_product.*,products.pName,products.pCode,purchase.memoNo,purchase.puDate,purchase.supid,suppliers.supName')
              ->from('purchase_product')
              ->join('products','products.pid = purchase_product.pid','left')
              ->join('purchase','purchase.puid = purchase_product.puid','left')
              ->join('suppliers','suppliers.supid = purchase.supid','left')
              ->where('YEAR(puDate)', $year)
              ->where('purchase_product.pid', $pid)
              ->where('supid', $supid)
              ->get()
              ->result();
    }
  return $query;
}

public function get_yused_product_delivery_data($year,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('delivery_product.*,products.pName,products.pCode,delivery.rInvoice,delivery.dDate, users.uName')
              ->from('delivery_product')
              ->join('products','products.pid = delivery_product.pid','left')
              ->join('delivery','delivery.did = delivery_product.did','left')
              ->join('users','users.uid = delivery.empid','left')
              ->where('YEAR(dDate)', $year)
              ->get()
              ->result();
    }
  else
    {
    $query = $this->db->select('delivery_product.*,products.pName,products.pCode,delivery.rInvoice,delivery.dDate, users.uName')
              ->from('delivery_product')
              ->join('products','products.pid = delivery_product.pid','left')
              ->join('delivery','delivery.did = delivery_product.did','left')
              ->join('users','users.uid = delivery.empid','left')
              ->where('YEAR(delivery.dDate)', $year)
              ->where('delivery_product.pid', $pid)
              ->get()
              ->result();
    }
  return $query;
}


}