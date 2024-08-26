<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Cost extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Expense Type';

  $data['cost'] = $this->pm->get_data('cost_type',false);

  $this->load->view('costs/costTypes',$data);
}

public function save_expense_type()
  {
  $info = $this->input->post();

  $data = array(
    'compid' => $_SESSION['compid'],
    'ctName' => $info['ctName'],         
    'regby'  => $_SESSION['uid']
        );

  $result = $this->pm->insert_data('cost_type',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Expense Type add Successfully !</h4>
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
  redirect('costType');
}

public function get_cost_type_data()
  {
  $section = $this->pm->get_cost_type_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_cost_type()
  {
  $info = $this->input->post();

  $data = array(
    'compid' => $_SESSION['compid'],
    'ctName' => $info['ctName'],
    'status' => $info['status'],             
    'upby'   => $_SESSION['uid']
        );
  $where = array(
    'ctid' => $info['ctid']
        );

  $result = $this->pm->update_data('cost_type',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Expense Type update Successfully !</h4></div>'
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
  redirect('costType');
}

public function cost_type_delete($id)
  {
  $where = array(
    'ctid' => $id
        );
  $empu = $this->pm->get_data('vaucher',$where);

  if(!$empu)
    {
    $result = $this->pm->delete_data('cost_type',$where);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Expense Type delete Successfully !</h4>
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
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> All ready add this Expense Type !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('costType');
}









public function expense_report_list()
  {
  $data['title'] = 'Expense Report';
  $data['cost'] = $this->pm->get_data('cost_type',false);

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
      
      $data['expense'] = $this->pm->get_dcost_report_data($sdate,$edate,$vtype);
      }
    else if ($report == 'monthlyReports')
      {
      $month = $_GET['month'];
      $data['month'] = $month;
      $year = $_GET['year'];
      $data['year'] = $year;
            //var_dump($data['month']); exit();
      if($month == 1)
        {
        $name = 'January';
        }
      elseif ($month == 2)
        {
        $name = 'February';
        }
      elseif ($month == 3)
        {
        $name = 'March';
        }
      elseif ($month == 4)
        {
        $name = 'April';
        }
      elseif ($month == 5)
        {
        $name = 'May';
        }
      elseif ($month == 6)
        {
        $name = 'June';
        }
      elseif ($month == 7)
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
      $vtype = $_GET['mvtype'];
      
      $data['expense'] = $this->pm->get_mcost_report_data($month,$year,$vtype);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;
      $vtype = $_GET['yvtype'];
      
      $data['expense'] = $this->pm->get_ycost_report_data($year,$vtype);
      }
    }
  else
    {
    $data['expense'] = $this->pm->get_cost_report_data();
    }
    
  $this->load->view('costs/cost_report',$data);
}





}