<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Supplier extends CI_Controller {

function __construct() {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Supplier';
  $data['supplier'] = $this->pm->get_data('suppliers',false);

  $this->load->view('suppliers/suppliers',$data);
}

public function save_supplier()
  {
  $info = $this->input->post();

  $query = $this->db->select('supid')
                  ->from('suppliers')
                  ->limit(1)
                  ->order_by('supid','DESC')
                  ->get()
                  ->row();
  if($query)
    {
    $sn = $query->supid+1;
    }
  else
    {
    $sn = 1;
    }

  $cn = strtoupper(substr($_SESSION['company'],0,3));
  $pc = sprintf("%'05d", $sn);

  $cusid = 'S-'.$cn.$pc;

  $data = array(
    'compid'     => $_SESSION['compid'],
    'supCode'    => $cusid,
    'supName'    => $info['supName'],
    'supCName'   => $info['supCName'],
    'supMobile'  => $info['supMobile'],
    'supEmail'   => $info['supEmail'],
    'supAddress' => $info['supAddress'],
    //'balance'    => $info['balance'],      
    'regby'      => $_SESSION['uid']
          );

  $result = $this->pm->insert_data('suppliers',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Supplier add Successfully !</h4></div>'
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
  redirect('Supplier');
}

public function get_supplier_data()
  {
  $section = $this->pm->get_supplier_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_supplier()
  {
  $info = $this->input->post();

  $data = array(
    'supName'    => $info['supName'],
    'supCName'   => $info['supCName'],
    'supMobile'  => $info['supMobile'],
    'supEmail'   => $info['supEmail'],
    'supAddress' => $info['supAddress'],
    //'balance'    => $info['balance'],
    'status'     => $info['status'],      
    'upby'       => $_SESSION['uid']
          );

  $where = array(
    'supid' => $info['supid']
        );

  $result = $this->pm->update_data('suppliers',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Supplier update Successfully !</h4></div>'
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
  redirect('Supplier');
}

public function delete_supplier($id)
  {
  $where = array(
    'supid' => $id
        );
  $purchase = $this->pm->delete_data('purchase',$where);

  if($purchase)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> All ready purchase from this supplier !</h4></div>'
            ];
    }
  else
    {
    $result = $this->pm->delete_data('suppliers',$where);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Supplier delete Successfully !</h4></div>'
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
  redirect('Supplier');
}

public function add_supplier()
  {
  $query = $this->db->select('supid')
                  ->from('suppliers')
                  ->limit(1)
                  ->order_by('supid','DESC')
                  ->get()
                  ->row();
  if($query)
    {
    $sn = $query->supid+1;
    }
  else
    {
    $sn = 1;
    }

  $cn = strtoupper(substr($_SESSION['company'],0,3));
  $pc = sprintf("%'05d", $sn);

  $cusid = 'S-'.$cn.$pc;

  $data = array(
    'compid'     => $_SESSION['compid'],
    'supCode'    => $cusid,
    'supName'    => $_POST['supName'],
    'supCName'   => $_POST['supCName'],
    'supMobile'  => $_POST['supMobile'],
    'supEmail'   => $_POST['supEmail'],
    'supAddress' => $_POST['supAddress'],      
    'regby'      => $_SESSION['uid']
            );

  $result = $this->pm->insert_data('suppliers',$data);

  if($result)
    {
    echo "Supplier Added Successfully!";
    }
  else
    {
    echo "Supplier Added Failed!";
    }
}



public function supplier_report()
  {
  $data['title'] = 'Supplier Reports';
  
  $data['supplier'] = $this->pm->get_data('suppliers',false);
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

  $this->load->view('suppliers/supplier_report',$data);
}

public function supplier_ledger()
  {
  $data['title'] = 'Supplier Ledger';

  $data['supplier'] = $this->pm->get_data('suppliers',false);
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

      $sid = $_GET['dsupplier'];
      $where = array('supid' => $sid);

      $data['supp'] = $this->pm->get_data('suppliers',$where);
      $data['purchase'] = $this->pm->get_dspurchase_data($sdate,$edate,$sid);
      $data['voucher'] = $this->pm->get_dsvoucher_data($sdate,$edate,$sid);
      }
    else if($report == 'monthlyReports')
      {
      $month = $_GET['month'];
      $data['month'] = $month;
      $year = $_GET['year'];
      $data['year'] = $year;
        
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

      $sid = $_GET['msupplier'];
      $where = array('supid' => $sid);

      $data['supp'] = $this->pm->get_data('suppliers',$where);
      $data['purchase'] = $this->pm->get_mspurchase_data($month,$year,$sid);
      $data['voucher'] = $this->pm->get_msvoucher_data($month,$year,$sid);
      }
    else if($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;

      $sid = $_GET['ysupplier'];
      $where = array('supid' => $sid);

      $data['supp'] = $this->pm->get_data('suppliers',$where);
      $data['purchase'] = $this->pm->get_yspurchase_data($year,$sid);
      $data['voucher'] = $this->pm->get_ysvoucher_data($year,$sid);
      }
    }
  else
    {
    $data['purchase'] = '';
    $data['voucher'] = '';
    }
    //var_dump('Hello');
  $this->load->view('suppliers/supplier_ledger',$data);
}






}