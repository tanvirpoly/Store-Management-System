<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Employee extends CI_Controller {

public function __construct()
  {
  parent::__construct();       
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function employee_information()
  {
  $data['title'] = 'Staff / Employee';

  $data['employee'] = $this->pm->get_data('employees',false);
  
  $this->load->view('employees/employees',$data);
}

public function save_employee()
  {       
  $info = $this->input->post();

  $query = $this->db->select('empid')
                  ->from('employees')
                  ->limit(1)
                  ->order_by('empid','DESC')
                  ->get()
                  ->row();
  if($query)
    {
    $sn = $query->empid+1;
    }
  else
    {
    $sn = 1;
    }

  $cn = strtoupper(substr($_SESSION['company'],0,3));
  $pc = sprintf("%'05d",$sn);

  $cusid = 'E-'.$cn.$pc;

  $config['upload_path'] = './upload/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
  $config['max_size'] = 80;
  $config['max_width'] = 0;
  $config['max_height'] = 0;

  $this->load->library('upload', $config);
  if($this->upload->do_upload('userfile'))
    {
    $img = $this->upload->data('file_name');
    }
  else
    {
    $img = '';
    }
  $this->upload->initialize($config);
  if($this->upload->do_upload('userfileOne'))
    {
    $imgOne = $this->upload->data('file_name');
    }
  else
    {
    $imgOne = '';
    }
    
  $employee = array(
    'empCode'    => $cusid,
    'empName'    => $info['empName'],
    'empMobile'  => $info['empMobile'],
    'empAddress' => $info['empAddress'],
    'empEmail'   => $info['empEmail'],
    'empDpt'     => $info['empDpt'],
    //'empSalary'  => $info['empSalary'],
    'joinDate'   => date('Y-m-d', strtotime($info['joinDate'])),
    'image'      => $img,
    'imageOne'      => $imgOne,
    'regby'      => $_SESSION['uid']
            );

  $result = $this->pm->insert_data('employees',$employee);
    
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Staff / Employee add Successfully !</h4></div>'
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
  redirect('Employee');
}
// public function save_employee() {
//     $info = $this->input->post();

//     // Get the latest employee ID
//     $query = $this->db->select('empid')
//                       ->from('employees')
//                       ->limit(1)
//                       ->order_by('empid', 'DESC')
//                       ->get()
//                       ->row();
//     $sn = ($query) ? $query->empid + 1 : 1;

//     // Generate the employee code
//     $cn = strtoupper(substr($this->session->userdata('company'), 0, 3)); // Ensure 'company' is set
//     $pc = sprintf("%'05d", $sn);
//     $cusid = 'E-' . $cn . $pc;

//     // File upload configuration
//     $config['upload_path'] = './upload/';
//     $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
//     $config['max_size'] = 0;
//     $config['max_width'] = 0;
//     $config['max_height'] = 0;

//     $this->load->library('upload', $config);

//     // Upload first file
//     $img = '';
//     if ($this->upload->do_upload('userfile')) {
//         $img = $this->upload->data('file_name');
//     }

//     // Reinitialize for second file upload
//     $this->upload->initialize($config);
//     $imgOne = '';
//     if ($this->upload->do_upload('userfileOne')) {
//         $imgOne = $this->upload->data('file_name');
//     }

//     // Prepare employee data
//     $employee = array(
//         'empCode'    => $cusid,
//         'empName'    => $info['empName'],
//         'empMobile'  => $info['empMobile'],
//         'empAddress' => $info['empAddress'],
//         'empEmail'   => $info['empEmail'],
//         'empDpt'     => $info['empDpt'],
//         'joinDate'   => date('Y-m-d', strtotime($info['joinDate'])),
//         'image'      => $img,
//         'imageOne'   => $imgOne,
//         'regby'      => $this->session->userdata('uid')
//     );

//     // Insert employee data into the database
//     $result = $this->pm->insert_data('employees', $employee);

//     // Prepare feedback message
//     if ($result) {
//         $sdata = [
//             'exception' => '<div class="alert alert-success alert-dismissible">
//                             <h4><i class="icon fa fa-check"></i> Staff / Employee added Successfully!</h4></div>'
//         ];
//     } else {
//         $sdata = [
//             'exception' => '<div class="alert alert-danger alert-dismissible">
//                             <h4><i class="icon fa fa-ban"></i> Failed!</h4></div>'
//         ];
//     }

//     // Set feedback message and redirect
//     $this->session->set_userdata($sdata);
//     redirect('Login'); // Redirect to login page after registration
// }


    

    // // Method to save employee data
   
public function get_emp_data()
  {
  $section = $this->pm->get_emp_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_Employee()
  {       
  $info = $this->input->post();

  $config['upload_path'] = './upload/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
  $config['max_size'] = 0;
  $config['max_width'] = 0;
  $config['max_height'] = 0;

  $this->load->library('upload', $config);
  $this->upload->initialize($config);
  if($this->upload->do_upload('userfile'))
    {
    $img = $this->upload->data('file_name');
    }
  else
    {
    $pimg = $this->db->select('image')->from('employees')->where('empid',$info['empid'])->get()->row();
    if($pimg)
      {
      $img = $pimg->image;
      }
    else
      {
      $img = '';
      }
    }

  $employee = array(
    'empName'    => $info['empName'],
    'empMobile'  => $info['empMobile'],
    'empAddress' => $info['empAddress'],
    'empEmail'   => $info['empEmail'],
    'empDpt'     => $info['empDpt'],
    //'empSalary'  => $info['empSalary'],
    'joinDate'   => date('Y-m-d', strtotime($info['joinDate'])),
    'image'      => $img,
    'status'     => $info['status'],
    'upby'       => $_SESSION['uid']
                );
    //var_dump($employee); exit();
  $where = array(
    'empid' => $info['empid']
        );

  $result = $this->pm->update_data('employees',$employee,$where);
    
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Employee / Staff update Successfully !</h4>
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
  redirect('Employee');
}

public function delete_employee($id)
  {
  $where = array(
    'empid' => $id
        );

  $result = $this->pm->delete_data('employees',$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Staff / Employee delete Successfully !</h4></div>'
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
  redirect('Employee');
}






}