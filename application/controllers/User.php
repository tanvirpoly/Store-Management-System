<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class User extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}


public function user_role()
  {
  $data['title'] = 'User Role';
  $where = array(
    'axid >' => 2
        );
  $data['role'] = $this->pm->get_data('access_lavels',$where);

  $this->load->view('users/user_role',$data);
}

public function save_accesslavel()
  {
  $info = $this->input->post();

  $urole = array(
    'compid'    => $_SESSION['compid'],
    'lavelName' => $info['lavelName'],
    'regby'     => $_SESSION['uid']
        );
 
  $result = $this->pm->insert_data('access_lavels',$urole);
  
  $pdata = [
    'utype'        => $result,
    'compid'       => $_SESSION['compid'],
    'regby'        => $_SESSION['uid'],
    'dashboard'    => 1
        ];

  $fdata = [
    'utype'        => $result,
    'compid'       => $_SESSION['compid'],
    'regby'        => $_SESSION['uid']
        ];

  $this->pm->insert_data('tbl_user_m_permission',$pdata);
  $this->pm->insert_data('tbl_user_p_permission',$fdata);
  $this->pm->insert_data('tbl_user_f_permission',$fdata);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User role add Successfully !</h4>
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
  redirect('uRole');
}

public function get_user_role_data()
  {
  $section = $this->pm->get_user_role_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_user_role()
  {
  $info = $this->input->post();

  $where = array(
    'axid' => $info['axid']
        );

  $urole = array(
    'compid'    => $_SESSION['compid'],
    'lavelName' => $info['lavelName'],
    'status'    => $info['status'],
    'upby'      => $_SESSION['uid']
        );
  //var_dump($where,$urole); exit();
  $result = $this->pm->update_data('access_lavels',$urole,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User role update Successfully !</h4>
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
  redirect('uRole');
}

public function delete_user_role($id)
  {
  $uwhere = array(
    'userrole' => $id
        );
  $auser = $this->pm->get_data('users',$uwhere);

  if(!$auser)
    {
    $where = array(
      'axid' => $id
          );
   
    $result = $this->pm->delete_data('access_lavels',$where);
    $fdata = [
      'utype' => $id
            ];

    $this->pm->delete_data('tbl_user_m_permission',$fdata);
    $this->pm->delete_data('tbl_user_p_permission',$fdata);
    $this->pm->delete_data('tbl_user_f_permission',$fdata);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> User role delete Successfully !</h4>
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
        <h4><i class="icon fa fa-ban"></i> All ready add this user role in user !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('uRole');
}

public function user_list()
  {
  $data['title'] = 'User';
  
  $where = array(
    'userrole >' => 2
        );
  $other = array(
    'order_by' => 'uid',
    'join' => 'left'
        );
  $field = array(
    'users' => 'users.*',
    'access_lavels' => 'access_lavels.lavelName'
        );
  $join = array(
    'access_lavels' => 'access_lavels.axid = users.userrole'
        );
  $data['users'] = $this->pm->get_data('users',$where,$field,$join,$other);

  $where = array(
    'status' => 'Active'
        );
  $data['userrole'] = $this->pm->get_data('access_lavels',$where);
  $data['emp'] = $this->pm->get_employee();
  //var_dump($data['emp']); exit();
  $this->load->view('users/users',$data);
}

public function save_user()
  {
  $info = $this->input->post(); 

  $where = array(
    'empid' => $info['emp']
        );
  $emp = $this->pm->get_data('employees',$where);
  
  $mwhere = array(
    'uMobile' => $emp[0]['empMobile']
        );
    //var_dump($mwhere); exit();
  $mdata = $this->pm->get_data('users',$mwhere);
  
  if($mdata)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Your mobile number all ready Used. Change your mobile number from update Employee ! </h4></div>'
          ];

    $this->session->set_userdata($sdata);
    redirect('User');
    }
  else
    {
    $data = array(
      'compid'   => $_SESSION['compid'],
      'empid'    => $info['emp'],
      'uName'    => $emp[0]['empName'],
      'uCName'   => $_SESSION['company'],
      'uEmail'   => $emp[0]['empEmail'],
      'uMobile'  => $emp[0]['empMobile'],
      'password' => $info['password'],
      'userrole' => $info['utype'],      
      'regby'    => $_SESSION['uid']
          );
      //var_dump($data); exit();
    $result = $this->pm->insert_data('users',$data);
    
    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User add Successfully !</h4></div>'
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
    redirect('User');
    }
}

public function get_user_data()
  {
  $grup = $this->pm->get_user_data($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function update_User()
  {
  $info = $this->input->post(); 

  $sdata = array(
    'userrole' => $info['utype'],
    'password' => $info['password'],
    'status'   => $info['status'],      
    'upby'     => $_SESSION['uid']
        );

  $where = array(
    'uid' => $info['uid']
        );
      
  $result = $this->pm->update_data('users',$sdata,$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User update Successfully !</h4>
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
  redirect('User');
}

public function delete_user($id)
  {
  $where = array(
    'uid' => $id
        );
      
  $result = $this->pm->delete_data('users',$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User delete Successfully !</h4>
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
  redirect('User');
}






}