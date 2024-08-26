<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Voucher extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Voucher';

  $other = array(
    'order_by' => 'vuid'
        );

  $data['vaucher'] = $this->pm->get_data('vaucher',false,false,false,$other);
  $this->load->view('vouchers/voucher',$data);
}

public function new_voucher()
  {
  $data['title'] = 'Voucher';
  $data['customer'] = $this->pm->get_data('customers',false);
  $data['supplier'] = $this->pm->get_data('suppliers',false);

  $this->load->view('vouchers/newvoucher',$data);
}

public function getAccountNo()
  {
  $str = '';
  $where = array(
    'status' => 'Active'
        );

  $accountType = $this->input->post('id');
    //$accountType = 'Cash';
  if($accountType == 'Bank')
    {
    $accounts = $this->pm->get_data('bankaccount',$where);
    if(count($accounts) == 0)
      {
      $str .= "<option value='0'>Please Add Bank account</option>";
      } 
    else 
      {
      foreach ($accounts as $value)
        {
        $str .= "<option value='".$value['baid']."'>".$value['bankName'].' '.$value['branchName'].' '.$value['accountNo'].' '.$value['accountName']."</option>";
        }
      }
    } 
  else if($accountType == 'Mobile')
    {
    $accounts = $this->pm->get_data('mobileaccount',$where);
    if(count($accounts) == 0) 
      {
      $str .= "<option value='0'>Please Add mobile account</option>";
      } 
    else 
      {
      foreach($accounts as $value)
        {
        $str .= "<option value='".$value['maid']."'>".$value['accountName'].' '.$value['accountNo']."</option>";
        }
      }
    } 
  else if($accountType == 'Cash') 
    {
    $accounts = $this->pm->get_data('cash',$where);
    if(count($accounts) == 0) 
      {
      $str .= "<option value='0'>Please Add cash account</option>";
      } 
    else 
      {
      foreach ($accounts as $value)
        {
        $str .= "<option value='".$value['caid']."'>".$value['cashName']."</option>";
        }
      }
    } 
  else 
    {
    $str .= "<option >Please account Type</option>";
    }
  echo json_encode($str);
}

public function save_voucher()
  {
  $info = $this->input->post();

  $query = $this->db->select('vuid')
                ->from('vaucher')
                ->limit(1)
                ->order_by('vuid','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->vuid+1;
    }
  else
    {
    $sn = 1;
    }
  $cn = strtoupper(substr($_SESSION['company'],0,3));
  $pc = sprintf("%'05d", $sn);

  $cusid = 'V-'.$cn.$pc;

  $data = array(
    'compid'      => $_SESSION['compid'],
    'vDate'       => date('Y-m-d',strtotime($info['date'])),
    'invoice'     => $cusid,
    'custid'      => $info['customer'],
    'supid'       => $info['supplier'],
    'vType'       => $info['vaucher'],
    'accountType' => $info['accountType'],
    'accountNo'   => $info['accountNo'],
    'tAmount'     => array_sum($info['amount']),
    'notes'       => $info['notes'],
    'regby'       => $_SESSION['uid']
        );
    
  $result = $this->pm->insert_data('vaucher',$data);
    //var_dump($vid); exit();
  $length = count($info['amount']);
    //var_dump($length); exit();
  for($i = 0; $i < $length; $i++)
    {
    $partdata = array(
      'vuid'        => $result,
      'particulars' => $info['particular'][$i],
      'amount'      => $info['amount'][$i],
      'regby'       => $_SESSION['uid']
          );
      //var_dump($partdata);    
    $result2 = $this->pm->insert_data('vaucher_particular',$partdata); 
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Voucher Add Successfully !</h4>
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
  redirect('Voucher');
}

public function voucher_details($id)
  {
  $data['title'] = 'Voucher';

  $where = array(
    'vuid' => $id
        );
  $other = array(
    'join' => 'left'
        );
  $field = array(
    'vaucher' => 'vaucher.*',
    'customers' => 'customers.*',
    'users' => 'users.empid,users.uName,users.uMobile',
    'suppliers' => 'suppliers.*',
        );
  $join = array(
    'customers' => 'customers.custid = vaucher.custid',
    'users' => 'users.uid = vaucher.regby',
    'suppliers' => 'suppliers.supid = vaucher.supid'
        );

  $voucher = $this->pm->get_data('vaucher',$where,$field,$join,$other);
  $data['voucher'] = $voucher[0];
    //var_dump($data['voucher']);
  $data['voucherp'] = $this->pm->get_data('vaucher_particular',$where);
  $data['company'] = $this->pm->company_details();

  $this->load->view('vouchers/viewvoucher',$data);
}

public function voucher_edit($id)
  {
  $data['title'] = 'Voucher';
  $data['customers'] = $this->pm->get_data('customers',false);
  $data['supplier'] = $this->pm->get_data('suppliers',false);

  $where = array(
    'vuid' => $id
        );

  $voucher = $this->pm->get_data('vaucher',$where);
  $data['voucher'] = $voucher[0];

  $data['voucherp'] = $this->pm->get_data('vaucher_particular',$where);

  $this->load->view('vouchers/editvoucher',$data);
}

public function update_voucher()
  {
  $info = $this->input->post();

  $where = array(
    'vuid' => $info['vuid']
        );
    
  if($info['vType'] == 'Credit Voucher')
    {
    $cust = $info['customer'];
    $sup = 0;
    }
  else if($info['vType'] == 'Debit Voucher')
    {
    $sup = $info['supplier'];
    $cust = 0;
    }
  else
    {
    $cust = 0;
    $sup = 0;
    }
    
  $data = array(
    'vDate'       => date('Y-m-d',strtotime($info['date'])),
    'custid'      => $cust,
    'supid'       => $sup,
    'vType'       => $info['vType'],
    'tAmount'     => array_sum($info['amount']),
    'accountType' => $info['accountType'],
    'accountNo'   => $info['accountNo'],
    'notes'       => $info['notes'],
    'upby'        => $_SESSION['uid']
        );
    
  $result = $this->pm->update_data('vaucher',$data,$where);
    //var_dump($vid); exit();
  $this->pm->delete_data('vaucher_particular',$where);

  $length = count($info['amount']);
    //var_dump($length); exit();
  for($i = 0; $i < $length; $i++)
    {
    $partdata = array(
      'vuid'        => $info['vuid'],
      'particulars' => $info['particular'][$i],
      'amount'      => $info['amount'][$i],
      'upby'        => $_SESSION['uid']
          );
      //var_dump($partdata);    
    $result2 = $this->pm->insert_data('vaucher_particular',$partdata);
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Voucher update Successfully !</h4>
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
  redirect('Voucher');
}

public function voucher_delete($id)
  {
  $where = array(
    'vuid' => $id
        );
  
  $result = $this->pm->delete_data('vaucher',$where);
    //var_dump($vid); exit();
  $this->pm->delete_data('vaucher_particular',$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Voucher delete Successfully !</h4>
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
  redirect('Voucher');
}

public function voucher_report()
  {
  $data['title'] = 'Voucher Report';
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

      $vtype = $_GET['dvtype'];

      $data['voucher'] = $this->pm->get_dall_voucher_data($sdate,$edate,$vtype);
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
      $data['name'] = $name;
      $data['report'] = $report;

      $vtype = $_GET['mvtype'];

      $data['voucher'] = $this->pm->get_mall_voucher_data($month,$year,$vtype);
      }
    else if($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;

      $vtype = $_GET['yvtype'];

      $data['voucher'] = $this->pm->get_yall_voucher_data($year,$vtype);
      }
    }
  else
    {
    $data['voucher'] = $this->pm->get_voucher_data();
    }

  $this->load->view('vouchers/voucher_reports',$data);
}

public function profit_loss()
  {
  $data['title'] = 'Profit Loss';
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

      $data['sale'] = $this->pm->total_dsales_amount($sdate,$edate);
      $data['purchase'] = $this->pm->total_dpurchases_amount($sdate,$edate);
      $data['cvoucher'] = $this->pm->total_dcvoucher_amount($sdate,$edate);
      $data['dvoucher'] = $this->pm->total_ddvoucher_amount($sdate,$edate);
      $data['svoucher'] = $this->pm->total_dsvoucher_amount($sdate,$edate);
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
      $data['name'] = $name;
      $data['report'] = $report;

      $data['sale'] = $this->pm->total_msales_amount($month,$year);
      $data['purchase'] = $this->pm->total_mpurchases_amount($month,$year);
      $data['cvoucher'] = $this->pm->total_mcvoucher_amount($month,$year);
      $data['dvoucher'] = $this->pm->total_mdvoucher_amount($month,$year);
      $data['svoucher'] = $this->pm->total_msvoucher_amount($month,$year);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;

      $data['sale'] = $this->pm->total_ysales_amount($year);
      $data['purchase'] = $this->pm->total_ypurchases_amount($year);
      $data['cvoucher'] = $this->pm->total_ycvoucher_amount($year);
      $data['dvoucher'] = $this->pm->total_ydvoucher_amount($year);
      $data['svoucher'] = $this->pm->total_ysvoucher_amount($year);
      }
    }
  else
    {
    $data['sale'] = $this->pm->total_sales_amount();
    $data['purchase'] = $this->pm->total_purchases_amount();
    $data['cvoucher'] = $this->pm->total_cvoucher_amount();
    $data['dvoucher'] = $this->pm->total_dvoucher_amount();
    $data['svoucher'] = $this->pm->total_svoucher_amount();
    }

  $this->load->view('vouchers/profit_loss',$data,TRUE);
}





}






