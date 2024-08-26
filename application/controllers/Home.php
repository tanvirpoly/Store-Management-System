<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Home extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model",'pm');       
  $this->checkPermission();
}

        ################################################
        #   /* Pages  start*/                          #
        ################################################

public function index()
  {
  $data['title'] = 'Dashboard';

  $data['sale'] = $this->pm->count_all('sales');
  $data['purchase'] = $this->pm->count_all('purchase');
  $data['product'] = $this->pm->count_all('products');
  $data['supplier'] = $this->pm->count_all('suppliers');
    
  $this->load->view('home',$data);
}

public function setting_pages()
  {
  $data['title'] = 'Setting';

  $data['category'] = $this->pm->count_all('categories');
  $data['unit'] = $this->pm->count_all('sma_units');
  $data['ctype'] = $this->pm->count_all('cost_type');
  $data['utype'] = $this->pm->total_user_type();
  $data['cash'] = $this->pm->count_all('cash');
  $data['bank'] = $this->pm->count_all('bankaccount');
  $data['mobile'] = $this->pm->count_all('mobileaccount');
  $data['subCategory'] = $this->pm->count_all('sub_category');
  
  $this->load->view('setting_pages',$data);
}

public function user_setting_pages()
  {
  $data['title'] = 'Settings';

  $data['customer'] = $this->pm->count_all('customers');
  $data['supplier'] = $this->pm->count_all('suppliers');
  $data['employee'] = $this->pm->count_all('employees');
  $data['user'] = $this->pm->total_user();
  
  $this->load->view('user_setting',$data);
}

public function user_reports_pages()
  {
  $data['title'] = 'User Reports';

  $data['sale'] = $this->pm->total_sale();
  $data['purchase'] = $this->pm->total_purchase();
  $data['pcvoucher'] = $this->pm->total_cvoucher_amount();
  $data['pdvoucher'] = $this->pm->total_dvoucher_amount();
  $data['customer'] = $this->pm->total_customer();
  $data['supplier'] = $this->pm->total_supplier();
  $data['stock'] = $this->pm->total_stock();
  $data['voucher'] = $this->pm->total_voucher();
  
  $this->load->view('report_settings',$data);
}

public function company_profile()
  {
  $data['title'] = 'Profile';
  $data['company'] = $this->pm->company_details();
  
  $this->load->view('company_profile',$data);
}

public function save_company_profile()
  {
  $info = $this->input->post();
      //var_dump('hello'); exit();
  $config['upload_path'] = './upload/company/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
  $config['max_size'] = 0;
  $config['max_width'] = 0;
  $config['max_height'] = 0;

  $this->load->library('upload',$config);
  $this->upload->initialize($config);
  
  $store = $this->pm->company_details();
                    
  if($this->upload->do_upload('userfile'))
    {
    $limg = $this->upload->data('file_name');
    }
  else
    {
    if($store)
      {
      $limg = $store->compLogo;
      }
    else
      {
      $limg = '';
      }
    } 

  $data = [
    'compName'    => $info['com_name'],
    'compMobile'  => $info['com_mobile'],
    'compAddress' => $info['com_address'],
    'compEmail'   => $info['com_email'],
    'compLogo'    => $limg,
    'regby'       => $_SESSION['uid']
          ];
    //var_dump($info); exit();
    
  if($store)
    {
    $where = array(
      'compid' => $store->compid
          );

    $result = $this->pm->update_data('com_profile',$data,$where);
    }
  else
    {
    $result = $this->pm->insert_data('com_profile',$cdata);
    }
    
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Company Profile Setting Successfully !</h4>
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
  redirect('Dashboard');
}

public function account_setting()
  {
  $data['title'] = 'Account Setting';
    
  $this->load->view('accountSetting',$data);
}

public function save_account_setting()
  {
  $cpassword = $this->input->post('cpassword');
  $password  = $this->input->post('password');
  $npassword = $this->input->post('npassword');

  if($password == $npassword)
    {
    $cpc = $this->pm->current_password_check($cpassword);
    //var_dump($fpe); exit();
    if($cpc)
      {
      $empdata = [
        'password' => $password,
        'upby'     => $_SESSION['uid']
            ];

      $where = [
        'uid' => $_SESSION['uid']
            ];   
            
      $result = $this->pm->update_data('users',$empdata,$where);

      if($result)
        {
        $sdata = [
          'exception' => '<div class="alert alert-primary alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Account Setting is complete. !</h4>
            </div>'
                ]; 

        $this->session->set_userdata($sdata);
        redirect('aSetting');
        }
      else
        {
        $sdata = [
          'exception' => '<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Some things is worng. Check !</h4>
            </div>'
                ]; 

        $this->session->set_userdata($sdata);
        redirect('aSetting');
        }
      }
    else
      {
      $sdata = [
        'exception' => '<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Can not mass previous Password !</h4>
          </div>'
              ]; 

      $this->session->set_userdata($sdata);
      redirect('aSetting');
      }
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Confirm Your Password !</h4>
        </div>'
            ]; 

    $this->session->set_userdata($sdata);
    redirect('aSetting');
    }
}


        ################################################
        #   /* Pages  end*/                            #
        ################################################
}