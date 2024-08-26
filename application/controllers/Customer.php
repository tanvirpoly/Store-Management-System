<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Customer extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Customer';
  $data['customer'] = $this->pm->get_data('customers',false);

  $this->load->view('customers/customer',$data);
}

public function save_customer()
  {
  $info = $this->input->post();

  $query = $this->db->select('custid')
                ->from('customers')
                ->limit(1)
                ->order_by('custid','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->custid+1;
    }
  else
    {
    $sn = 1;
    }
    //var_dump($sn); exit();
  $cn = strtoupper(substr($_SESSION['company'],0,3));
  $pc = sprintf("%'05d",$sn);

  $cusid = 'C-'.$cn.$pc;

  $data = array(
    'compid'      => $_SESSION['compid'],
    'custCode'    => $cusid,
    'custName'    => $info['custName'],
    'custMobile'  => $info['mobile'],
    'custAddress' => $info['address'],
    'custEmail'   => $info['email'],
    // 'custBalance' => $info['balance'],
    'regby'       => $_SESSION['uid']
          );

  $result = $this->pm->insert_data('customers',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Customer add Successfully !</h4></div>'
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
  redirect('Customer');
}

public function get_customer_data()
  {
  $section = $this->pm->get_customer_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_customer()
  {
  $info = $this->input->post();

  $data = array(
    'custName'    => $info['custName'],
    'custMobile'  => $info['mobile'],
    'custAddress' => $info['address'],
    'custEmail'   => $info['email'],
    // 'custBalance' => $info['balance'],
    'status'      => $info['status'],         
    'upby'        => $_SESSION['uid']
            );

  $where = array(
    'custid' => $info['custid']
        );

  $result = $this->pm->update_data('customers',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Customer update Successfully !</h4></div>'
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
  redirect('Customer');
}

public function delete_customer($id)
  {
  $where = array(
    'custid' => $id
        );
  $sales = $this->pm->get_data('sales',$where);

  if($sales)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> All ready sales on this customer !</h4></div>'
            ];
    }
  else
    {
    $result = $this->pm->delete_data('customers',$where);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Customer delete Successfully !</h4></div>'
              ];  
      }
    else
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4></div>'
              ];
      }
    }
  $this->session->set_userdata($sdata);
  redirect('Customer');
}







public function all_customer_reports()
  {
  $data['title'] = 'Customers Report';

  $data['customer'] = $this->pm->get_data('customers',false);
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

  $this->load->view('customers/customerReport',$data);
}

public function customer_ledger_report()
  {
  $data['title'] = 'Customers Report';
  $data['customer'] = $this->pm->get_data('customers',false);
  $data['company'] = $this->pm->company_details();

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
    
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $custid = $_GET['dcustomer'];
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;

      $cwhere = array('custid' => $custid);

      $data['cust'] = $this->pm->get_data('customers',$cwhere);
      $data['sale'] = $this->pm->sales_dcust_ledger_data($custid,$sdate,$edate);
      $data['voucher'] = $this->pm->voucher_dcust_ledger_data($custid,$sdate,$edate);
      }
    else if($report == 'monthlyReports')
      {
      $month = $_GET['month'];
      $data['month'] = $month;
      $year = $_GET['year'];
      $data['year'] = $year;
      $custid = $_GET['mcustomer'];
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

      $cwhere = array('custid' => $custid);

      $data['cust'] = $this->pm->get_data('customers',$cwhere);
      $data['sale'] = $this->pm->sales_mcust_ledger_data($custid,$month,$year);
      $data['voucher'] = $this->pm->voucher_mcust_ledger_data($custid,$month,$year);
      }
    else if($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;
      $custid = $_GET['ycustomer'];

      $cwhere = array('custid' => $custid);

      $data['cust'] = $this->pm->get_data('customers',$cwhere);
      $data['sale'] = $this->pm->sales_ycust_ledger_data($custid,$year);
      $data['voucher'] = $this->pm->voucher_ycust_ledger_data($custid,$year);
      }
    else if($report == 'ocust')
      {
      $data['report'] = $report;
      $custid = $_GET['customer'];

      $cwhere = array('custid' => $custid);

      $data['cust'] = $this->pm->get_data('customers',$cwhere);
      $data['sale'] = $this->pm->sales_cust_ledger_data($custid);
      $data['voucher'] = $this->pm->voucher_cust_ledger_data($custid);
      }
    }
  else
    {
    
    }
    
  $this->load->view('customers/customerLedger',$data);
}








}