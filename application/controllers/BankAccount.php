<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class BankAccount extends  CI_Controller {

public function __construct()
  {
  parent::__construct(); 
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Bank Account';    

  $data['bank'] = $this->pm->get_data('bankaccount',false);

  $this->load->view('bankaccount/bankAccountList',$data);
}

public function save_bank_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'     => $_SESSION['compid'],
    'accountName'=> $info['accountName'],
    'accountNo'  => $info['accountNo'],
    'bankName'   => $info['bankName'],
    'branchName' => $info['branchName'],      
    'balance'    => $info['balance'],        
    'regby'      => $_SESSION['uid']
        );
  //var_dump($sale); exit();
  $result = $this->pm->insert_data('bankaccount',$data);

  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-primary alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Bank Account Setting is complete. !</h4></div>'
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
  redirect('BankAccount');
}

public function get_bank_account()
  {
  $grup = $this->pm->get_bank_account($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function update_bank_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'     => $_SESSION['compid'],
    'accountName'=> $info['accountName'],
    'accountNo'  => $info['accountNo'],
    'bankName'   => $info['bankName'],
    'branchName' => $info['branchName'],      
    'balance'    => $info['balance'],        
    'upby'       => $_SESSION['uid']
        );
  //var_dump($sale); exit();
  $where = [
    'baid' => $info['baid']
          ]; 
  $result = $this->pm->update_data('bankaccount',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-primary alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Bank Account update is complete. !</h4></div>'
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
  redirect('BankAccount');
}

public function bank_account_delete($id)
  {
  $where = array(
    'baid' => $id
          );

  $result = $this->pm->delete_data('bankaccount',$where);
  
  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Bank Account delete is complete. !</h4></div>'
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
  redirect('BankAccount');
}







}