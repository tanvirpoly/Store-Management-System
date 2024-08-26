<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Category extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Category';
  $data['category'] = $this->pm->get_data('categories',false);
  
  $this->load->view('category/category',$data);
}

public function save_category()
  {
  $info = $this->input->post();

  $data = array(
    'compid'  => $_SESSION['compid'],
    'catName' => $info['catName'],          
    'regby'   => $_SESSION['uid']
        );

  $result = $this->pm->insert_data('categories',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Category add Successfully !</h4>
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
  redirect('Category');
}

public function get_category_data()
  {
  $section = $this->pm->get_category_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_category()
  {
  $info = $this->input->post();

  $data = array(
    'compid'  => $_SESSION['compid'],
    'catName' => $info['catName'],
    'status'  => $info['status'],            
    'upby'    => $_SESSION['uid']
        );

  $where = array(
    'catid' => $info['catid']
        );

  $result = $this->pm->update_data('categories',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Category update Successfully !</h4>
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
  redirect('Category');
}

public function delete_category($id)
  {
  $where = array(
    'catid' => $id
        );

  $empu = $this->pm->get_data('products',$where);

  if(!$empu)
    {
    $result = $this->pm->delete_data('categories',$where);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Category delete Successfully !</h4>
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
        <h4><i class="icon fa fa-ban"></i> All ready add this Category in Product !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('Category');
}

public function product_units()
  {
  $data['title'] = 'Unit';

  $data['unit'] = $this->pm->get_data('sma_units',false);

  $this->load->view('category/product_units',$data);
}

public function save_units()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'unitName' => $info['unitName'],
    //'uQnt'     => $info['uQnt'],         
    'regby'    => $_SESSION['uid']
        );

  $result = $this->pm->insert_data('sma_units',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Units add Successfully !</h4>
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
  redirect('Unit');
}

public function get_unit_data()
  {
  $section = $this->pm->get_unit_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_units()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'unitName' => $info['unitName'],
    //'uQnt'     => $info['uQnt'], 
    'status'   => $info['status'],            
    'upby'     => $_SESSION['uid']
        );

  $where = array(
    'untid' => $info['untid']
        );

  $result = $this->pm->update_data('sma_units',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Unit update Successfully !</h4>
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
  redirect('Unit');
}

public function delete_units($id)
  {
  $where = array(
    'untid' => $id
        );
  $empu = $this->pm->get_data('products',$where);

  if(!$empu)
    {
    $result = $this->pm->delete_data('sma_units',$where);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Unit delete Successfully !</h4>
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
        <h4><i class="icon fa fa-ban"></i> All ready add this Unit in Product !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('Unit');
}


public function sub_category_list()
  {
  $data['title'] = 'Sub Category';
  
  $other = array(
    'join' => 'left',
    'order_by' => 'scatid'
        );
  $field = array(
    'sub_category' => 'sub_category.*',
    'categories' => 'categories.catName'
        );
  $join = array(
    'categories' => 'categories.catid = sub_category.catid'
        );
  
  $data['subcategory'] = $this->pm->get_data('sub_category',false,$field,$join,$other);
    
  $data['category'] = $this->pm->get_data('categories',false);
  
  $this->load->view('category/sub_category',$data);
}
public function save_sub_category()
  {
  $info = $this->input->post();

  $data = array(
    'compid'    => $_SESSION['compid'],
    'catid'    => $info['category'],
    'scatName' => $info['scatName'],
    'regby'    => $_SESSION['uid']
        );

  $result = $this->pm->insert_data('sub_category',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Sub Category added Successfully !</h4>
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
  redirect('subCategory');
}

public function get_sub_category_data()
  {
  $section = $this->pm->get_sub_category_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_sub_category()
  {
  $info = $this->input->post();

  $data = array(
    'catid'    => $info['category'],
    'scatName' => $info['scatName'],
    'status'   => $info['status'],            
    'upby'     => $_SESSION['uid']
        );

  $where = array(
    'scatid' => $info['scatid']
        );

  $result = $this->pm->update_data('sub_category',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Sub Category updated Successfully !</h4>
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
  redirect('subCategory');
}

public function delete_sub_category($id)
  {
  $where = array(
    'scatid' => $id
        );

  $result = $this->pm->delete_data('sub_category',$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Sub Category deleted Successfully !</h4>
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
  redirect('subCategory');
}


}