<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class CashAccount extends  CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}


public function index()
  {
  $data['title'] = 'Cash Account';    

  $data['cash'] = $this->pm->get_data('cash',false);

  $this->load->view('cashaccount/cash_account',$data);
}

public function save_cash_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'cashName' => $info['accountName'],     
    'balance'  => $info['balance'],        
    'regby'    => $_SESSION['uid']
        );
  //var_dump($sale); exit();
  $result = $this->pm->insert_data('cash',$data);

  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-primary alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Cash Account Setting is complete. !</h4></div>'
            ]; 
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Some things is worng. Check !</h4></div>'
            ]; 
    }
  $this->session->set_userdata($sdata);
  redirect('CashAccount');
}

public function get_cash_account()
  {
  $grup = $this->pm->get_cash_account($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function update_cash_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'cashName' => $info['accountName'],
    'status'   => $info['status'],      
    'balance'  => $info['balance'],        
    'upby'     => $_SESSION['uid']
        );
  //var_dump($sale); exit();
  $where = [
    'caid' => $info['caid']
          ]; 
  $result = $this->pm->update_data('cash',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-primary alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Cash Account update is complete. !</h4></div>'
            ]; 
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Some things is worng. Check !</h4></div>'
            ]; 
    }
  $this->session->set_userdata($sdata);
  redirect('CashAccount');
}

public function cash_account_delete($id)
  {
  $where = array(
    'caid' => $id
          );

  $result = $this->pm->delete_data('cash',$where);
  
  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Cash Account delete is complete. !</h4></div>'
            ]; 
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Some things is worng. Check !</h4></div>'
            ]; 
    }
  $this->session->set_userdata($sdata);
  redirect('CashAccount');
}




 
}