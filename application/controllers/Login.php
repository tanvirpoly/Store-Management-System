<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Login extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model",'pm');
  $this->load->library('email');
}

        ################################################
        #   /* Pages  start*/                          #
        ################################################

public function index()
  {
  $data['title'] = 'Sign In';
  $data['company'] = $this->pm->company_details();
        
  $this->load->view('login',$data);
}
public function register() {
    // $data['title'] = 'Register';
        $this->load->view('register');  // Assuming you have a 'register' view
    }
    
 public function save_employeeOne() {       
        $info = $this->input->post();

        // Get the latest employee ID
        $query = $this->db->select('empid')
                          ->from('employees')
                          ->limit(1)
                          ->order_by('empid', 'DESC')
                          ->get()
                          ->row();
        $sn = ($query) ? $query->empid + 1 : 1;

        // Generate the employee code
        $cn = strtoupper(substr($this->session->userdata('company'), 0, 3)); // Ensure 'company' is set
        $pc = sprintf("%'05d", $sn);
        $cusid = 'E-' . $cn . $pc;

        // File upload configuration
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;

        $this->load->library('upload', $config);

        // Upload first file
        $img = '';
        if ($this->upload->do_upload('userfile')) {
            $img = $this->upload->data('file_name');
        }

        // Reinitialize for second file upload
        $this->upload->initialize($config);
        $imgOne = '';
        if ($this->upload->do_upload('userfileOne')) {
            $imgOne = $this->upload->data('file_name');
        }

        // Prepare employee data
        $employee = array(
            'empCode'    => $cusid,                     
            'empName'    => $info['empName'],           
            'empMobile'  => $info['empMobile'],         
            'empAddress' => $info['empAddress'],        
            'empEmail'   => $info['empEmail'],          
            'empDpt'     => $info['empDpt'],            
            'joinDate'   => date('Y-m-d', strtotime($info['joinDate'])), 
            'image'      => $img,                       
            'imageOne'   => $imgOne                         
        );

        // Insert employee data into the database
        $result = $this->pm->insert_data('employees', $employee);

        // Prepare feedback message
        if ($result) {
            $sdata = [
                'exception' => '<div class="alert alert-success alert-dismissible">
                                <h4><i class="icon fa fa-check"></i> User added Successfully!</h4></div>'
            ];
        } else {
            $sdata = [
                'exception' => '<div class="alert alert-danger alert-dismissible">
                                <h4><i class="icon fa fa-ban"></i> Failed!</h4></div>'
            ];
        }

        // Set feedback message and redirect
        $this->session->set_userdata($sdata);
        redirect('Login');
    }
public function login_process()
  {
  $info = $this->input->post();

  $uname = $info['username'];
  if(is_numeric($uname))
    {     
    $where = array(
      'uMobile'  => $info['username'],
      'status'   => 'Active',
      'password' => $info['password']
          );
    }
  else
    {
    $where = array(
      'uEmail'   => $info['username'],
      'status'   => 'Active',
      'password' => $info['password']
          );
    }
    //var_dump($where);
  $user_data = $this->pm->get_data('users',$where);
    //var_dump($user_data); exit();
  if($user_data)
    {
    $udata = [
      'uid'      => $user_data[0]['uid'],
      'compid'   => $user_data[0]['compid'],
      'empid'    => $user_data[0]['empid'],
      'name'     => $user_data[0]['uName'],
      'company'  => $user_data[0]['uCName'],
      'userrole' => $user_data[0]['userrole'],
      'uMobile'  => $user_data[0]['uMobile']
          ];
        //var_dump($udata); exit();
    $this->session->set_userdata($udata);
    
    $pwhere = array(
      'utype' => $user_data[0]['userrole']
                );

    $master = $this->pm->get_data('tbl_user_m_permission',$pwhere);
    $page = $this->pm->get_data('tbl_user_p_permission',$pwhere);
    $function = $this->pm->get_data('tbl_user_f_permission',$pwhere);
        //var_dump($pwhere); var_dump($page); var_dump($function); //exit();
    if($page)
      {
      $mdata = [
        'dashboard'    => $master[0]['dashboard'],
        'products'     => $master[0]['products'],
        'orders'       => $master[0]['orders'],
        'requisitions' => $master[0]['requisitions'],
        'users'        => $master[0]['users'],
        'setting'      => $master[0]['setting'],
        'access_setup' => $master[0]['access_setup']
                ];
            
      $pdata = [
        'product_list'       => $page[0]['product_list'],
        'stock_report'       => $page[0]['stock_report'],
        'order_list'         => $page[0]['order_list'],
        'new_order'          => $page[0]['new_order'],
        'order_receive'      => $page[0]['order_receive'],
        'order_report'       => $page[0]['order_report'],
        'receive_report'     => $page[0]['receive_report'],
        'requisition_list'   => $page[0]['requisition_list'],
        'delivery_list'      => $page[0]['delivery_list'],
        'refund_list'        => $page[0]['refund_list'],
        'requisition_report' => $page[0]['requisition_report'],
        'delivery_report'    => $page[0]['delivery_report'],
        'customer'           => $page[0]['customer'],
        'supplier'           => $page[0]['supplier'],
        'employee'           => $page[0]['employee'],
        'user_list'          => $page[0]['users'],
        'category'           => $page[0]['category'],
        'sub_category'       => $page[0]['sub_category'],
        'units'              => $page[0]['units'],
        'user_type'          => $page[0]['user_type']
                        ];

      $fdata = [
        'new_product'        => $function[0]['new_product'],
        'edit_product'       => $function[0]['edit_product'],
        'delete_product'     => $function[0]['delete_product'],
        'edit_order'         => $function[0]['edit_order'],
        'delete_order'       => $function[0]['delete_order'],
        'approve_order'      => $function[0]['approve_order'],
        'payment_order'      => $function[0]['payment_order'],
        'new_receive'        => $function[0]['new_receive'],
        'edit_receive'       => $function[0]['edit_receive'],
        'delete_receive'     => $function[0]['delete_receive'],
        'new_requisition'    => $function[0]['new_requisition'],
        'edit_requisition'   => $function[0]['edit_requisition'],
        'delete_requisition' => $function[0]['delete_requisition'],
        'approve_requisition' => $function[0]['approve_requisition'],
        'new_delivery'       => $function[0]['new_delivery'],
        'edit_delivery'      => $function[0]['edit_delivery'],
        'delete_delivery'    => $function[0]['delete_delivery'],
        'new_refund'         => $function[0]['new_refund'],
        'delete_refund'      => $function[0]['delete_refund'],
        'approve_refund'     => $function[0]['approve_refund'],
        'new_customer'       => $function[0]['new_customer'],
        'edit_customer'      => $function[0]['edit_customer'],
        'delete_customer'    => $function[0]['delete_customer'],
        'new_supplier'       => $function[0]['new_supplier'],
        'edit_supplier'      => $function[0]['edit_supplier'],
        'delete_supplier'    => $function[0]['delete_supplier'],
        'new_employee'       => $function[0]['new_employee'],
        'edit_employee'      => $function[0]['edit_employee'],
        'delete_employee'    => $function[0]['delete_employee'],
        'new_user'           => $function[0]['new_user'],
        'edit_user'          => $function[0]['edit_user'],
        'delete_user'        => $function[0]['delete_user'],
        'new_category'       => $function[0]['new_category'],
        'edit_category'      => $function[0]['edit_category'],
        'delete_category'    => $function[0]['delete_category'],
        'new_unit'           => $function[0]['new_unit'],
        'edit_unit'          => $function[0]['edit_unit'],
        'delete_unit'        => $function[0]['delete_unit'],
        'new_utype'          => $function[0]['new_utype'],
        'edit_utype'         => $function[0]['edit_utype'],
        'delete_utype'       => $function[0]['delete_utype'],
        // 'new_sub_category'   => $function[0]['new_sub_category'],
        'edit_sub_category'  => $function[0]['edit_sub_category'],
        'delete_sub_category' => $function[0]['delete_sub_category']
                ];
      //  var_dump($pdata); var_dump($fdata); exit();
      $this->session->set_userdata($mdata);
      $this->session->set_userdata($pdata);
      $this->session->set_userdata($fdata);
      }
        
    redirect('Dashboard');
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Invalid Login id or Password !</h4>
        </div>'
            ];

    $this->session->set_userdata($sdata);
    redirect('Login');
    }
}

public function forget_password()
  {
  $data['title'] = 'Forget Password';
  $data['company'] = $this->pm->company_details();
      
  $this->load->view('forget_password',$data);
}

public function check_forget_password_email()
  {
  $this->load->library('email');

  $empemail = $this->input->post('username');
  
  if(is_numeric($empemail))
    {
    $mid = '+88'.$this->input->post('username');
    $fpe = $this->pm->check_mobile($mid);
    // var_dump($fpe); var_dump($mid); exit();
    if($fpe)
      {
      $prdata = [
        'useruid' => $fpe->uid
            ];
      
      $this->session->set_userdata($prdata);
        
      $digits = 6;
      $otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
      $msg = $otp.' is your otp code for verify. Expires in 10 minites. Sunshine it';
      
      $to = $mid;
      $token = "44515996325214391599632521";
      $message = urlencode($msg);
      //$url = "http://sms.iglweb.com/api/v1/send?api_key=44515996325214391599632521&contacts=$mid&senderid=8801844532630&msg=$message";
      //var_dump($url); //exit();
      $data = array(
        'to'      => "$to",
        'message' => "$message",
        'token'   =>"$token"
              );
                  
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_ENCODING, '');
      curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $smsresult = curl_exec($ch);
      //var_dump($smsresult); exit();
        
      $udata = array(
        'otp'  => $otp,
        'upby' => $_SESSION['useruid']
            );

      $uwhere = array(
        'uMobile' => $mid,
        'uid'     => $_SESSION['useruid']
            );

      $result = $this->pm->update_data('users',$udata,$uwhere);
            
      if($result)
        {
        $sdata = [
            'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Enter Your OTP code !</h4>
            </div>'
                ];

        $this->session->set_userdata($sdata);
        redirect('otpPassword');
        }
      else
        {
        $sdata = [
            'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Somethings is Wrong !</h4>
            </div>'
                ];
    
        $this->session->set_userdata($sdata);
        redirect('forgetPassword');
        }
      }
    else
      {
      $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-ban"></i> This mobile is not exit !</h4>
          </div>'
              ];
  
      $this->session->set_userdata($sdata);
      redirect('forgetPassword');
      }
    }
  else
    {
    $fpe = $this->pm->check_email($empemail);
    
    $prdata = [
      'useruid' => $fpe->uid
          ];
  
    $this->session->set_userdata($prdata);
        //var_dump($fpe); exit();
    if($fpe)
      {
      $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://sunshine.com.bd', 
        'smtp_port' => 465,
        'smtp_user' => 'example@gmail.com',
        'smtp_pass' => '123456',
        'smtp_crypto' => 'ssl',
        'mailtype' => 'text',
        'smtp_timeout' => '4', 
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
                );

      $to = $fpe->email;

      $message = "how r u ?";
      $this->load->library('email',$config);
      $this->email->set_newline("\r\n");
      $this->email->from('sajadulshogib43@gmail.com'); // change it to yours
      $this->email->to($to);// change it to yours
      $this->email->subject('Forget Password');
      $this->email->message($message);
        //var_dump($this->email->send()); exit();
      if($this->email->send())
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Check Your email !</h4>
          </div>'
                    ];  

        $this->session->set_userdata($sdata);
        redirect('Login');
        }
      else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-ban"></i> Somethings is Wrong !</h4>
          </div>'
                ];

        $this->session->set_userdata($sdata);
        redirect('forgetPassword');
        }
      }
    else
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> This email id is not exit !</h4>
          </div>'
              ];
  
      $this->session->set_userdata($sdata);
      redirect('forgetPassword');
      }
    }
}

public function otp_password()
  {
  $data['title'] = 'Forget Password';
  $data['company'] = $this->pm->company_details();
      
  $this->load->view('otp_password',$data);
}

public function check_otp()
  {
  $info = $this->input->post();

  $where = array(
    'otp' => $info['otp'],
    'uid' => $_SESSION['useruid']
          );
  $result = $this->pm->get_data('users',$where);
   // var_dump($result); exit();

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Password Setup !</h4>
        </div>'
            ];  

    $this->session->set_userdata($sdata);
    redirect('passwordSetup');
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4>
        </div>'
            ];

    $this->session->set_userdata($sdata);
    redirect('forgetPassword');
    }
}

public function password_setup()
  {
  $data['title'] = 'Password Setup';
  $data['company'] = $this->pm->company_details();
      
  $this->load->view('pass_setup',$data);
}

public function save_passord_setup()
  {
  $info = $this->input->post();

  $npassword = $info['npassword'];
  $cpassword = $info['cpassword'];

  if($npassword == $cpassword)
    {
    $info = [
      'password' => $info['npassword'],
      'upby'     => $_SESSION['useruid']
            ];
    
    $where = array(
      'uid' => $_SESSION['useruid']
            );
        //var_dump($where); exit();
    $result = $this->pm->update_data('users',$info,$where);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> New Password Setup Successfully !</h4>
          </div>'
              ];  

      $this->session->set_userdata($sdata);
      redirect('Login');
      }
    else
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4>
          </div>'
              ];

      $this->session->set_userdata($sdata);
      redirect('passwordSetup');
      }
    }
  else
    {
    $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Password can not match !</h4>
        </div>'
            ];

    $this->session->set_userdata($sdata);
    redirect('passwordSetup');
    }
}

public function account_verify()
  {
  $where = [
    'email' => $_SESSION['useremail']
        ];

  $info = [
    'status' => 'Active',
    'upby'   => $_SESSION['uid']
        ];
       
  $result = $this->pm->update_data('users',$info,$where);
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> User verify Successfully !</h4>
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
  redirect('Login');
}

public function logout()
  {
  $this->session->sess_destroy();
  redirect('Login');
}


        ################################################
        #   /* Pages  end*/                            #
        ################################################
}