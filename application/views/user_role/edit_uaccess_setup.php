<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Access Setup</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Access Setup</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Access Setup Information</h3>
              </div>

              <div class="card-body">
        		<div class="row">
        		  <div class="col-md-12 col-sm-12 col-12">
              		<table>
              		  <tbody>
                        <tr>
                          <td>User Type</td>
                          <td>: <?= $user[0]['lavelName']; ?></td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td>: <?= $user[0]['status']; ?></td>
                        </tr>
                      </tbody>
    			    </table>
                  </div>
            
            	  <div class="col-md-12 col-sm-12 col-12">
                    <div class="box-header">
                      <h3 class="box-title">List of Pages And Functions</h3>
                    </div>
                    <div class="box-body">
                      <form action="<?= base_url().'Access_setup/setup_user_access/'.$user[0]['axid']; ?>" method="post">
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <label><input type="checkbox" name="products" value="1" <?php if($master[0]['products'] == '1'){ ?>checked<?php } ?>> Products</label>
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="product_list" value="1" <?php if($page[0]['product_list'] == '1'){ ?>checked<?php } ?>> Product List</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_product" value="1" <?php if($function[0]['new_product'] == '1'){ ?>checked<?php } ?>> New Product</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_product" value="1" <?php if($function[0]['edit_product'] == '1'){ ?>checked<?php } ?>> Edit Product</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_product" value="1" <?php if($function[0]['delete_product'] == '1'){ ?>checked<?php } ?>> Delete Product</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="stock_report" value="1" <?php if($page[0]['stock_report'] == '1'){ ?>checked<?php } ?>> Stock Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <label><input type="checkbox" name="orders" value="1" <?php if($master[0]['orders'] == '1'){ ?>checked<?php } ?>> Orders</label>
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="order_list" value="1" <?php if($page[0]['order_list'] == '1'){ ?>checked<?php } ?>> Order List</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_order" value="1" <?php if($function[0]['edit_order'] == '1'){ ?>checked<?php } ?>> Edit Order</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_order" value="1" <?php if($function[0]['delete_order'] == '1'){ ?>checked<?php } ?>> Delete Order</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="approve_order" value="1" <?php if($function[0]['approve_order'] == '1'){ ?>checked<?php } ?>> Approve Order</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="payment_order" value="1" <?php if($function[0]['payment_order'] == '1'){ ?>checked<?php } ?>> Payment Order</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="new_order" value="1" <?php if($page[0]['new_order'] == '1'){ ?>checked<?php } ?>> New Order</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                         
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="order_receive" value="1" <?php if($page[0]['order_receive'] == '1'){ ?>checked<?php } ?>> Order Receive List</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_receive" value="1" <?php if($function[0]['new_receive'] == '1'){ ?>checked<?php } ?>> New Receive</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_receive" value="1" <?php if($function[0]['edit_receive'] == '1'){ ?>checked<?php } ?>> Edit Receive</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_receive" value="1" <?php if($function[0]['delete_receive'] == '1'){ ?>checked<?php } ?>> Delete Receive</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="order_report" value="1" <?php if($page[0]['order_report'] == '1'){ ?>checked<?php } ?>> Order Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                         
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="receive_report" value="1" <?php if($page[0]['receive_report'] == '1'){ ?>checked<?php } ?>> Receive Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                         
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <label><input type="checkbox" name="requisitions" value="1" <?php if($master[0]['requisitions'] == '1'){ ?>checked<?php } ?>> Requisitions</label>
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="requisition_list" value="1" <?php if($page[0]['requisition_list'] == '1'){ ?>checked<?php } ?>> Requisition List</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_requisition" value="1" <?php if($function[0]['new_requisition'] == '1'){ ?>checked<?php } ?>> New Requisition</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_requisition" value="1" <?php if($function[0]['edit_requisition'] == '1'){ ?>checked<?php } ?>> Edit Requisition</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_requisition" value="1" <?php if($function[0]['delete_requisition'] == '1'){ ?>checked<?php } ?>> Delete Requisition</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="approve_requisition" value="1" <?php if($function[0]['approve_requisition'] == '1'){ ?>checked<?php } ?>> Approve Requisition</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="delivery_list" value="1" <?php if($page[0]['delivery_list'] == '1'){ ?>checked<?php } ?>> Delivery List</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_delivery" value="1" <?php if($function[0]['new_delivery'] == '1'){ ?>checked<?php } ?>> New Delivery</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_delivery" value="1" <?php if($function[0]['edit_delivery'] == '1'){ ?>checked<?php } ?>> Edit Delivery</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_delivery" value="1" <?php if($function[0]['delete_delivery'] == '1'){ ?>checked<?php } ?>> Delete Delivery</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="refund_list" value="1" <?php if($page[0]['refund_list'] == '1'){ ?>checked<?php } ?>> Refund List</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_refund" value="1" <?php if($function[0]['new_refund'] == '1'){ ?>checked<?php } ?>> New Refund</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_refund" value="1" <?php if($function[0]['delete_refund'] == '1'){ ?>checked<?php } ?>> Delete Refund</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="approve_refund" value="1" <?php if($function[0]['approve_refund'] == '1'){ ?>checked<?php } ?>> Approve Refund</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="requisition_report" value="1" <?php if($page[0]['requisition_report'] == '1'){ ?>checked<?php } ?>> Requisition Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="delivery_report" value="1" <?php if($page[0]['delivery_report'] == '1'){ ?>checked<?php } ?>> Delivery Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <label><input type="checkbox" name="users" value="1" <?php if($master[0]['users'] == '1'){ ?>checked<?php } ?>> Users</label>
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="customer" value="1" <?php if($page[0]['customer'] == '1'){ ?>checked<?php } ?>> Customer</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_customer" value="1" <?php if($function[0]['new_customer'] == '1'){ ?>checked<?php } ?>> New Customer</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_customer" value="1" <?php if($function[0]['edit_customer'] == '1'){ ?>checked<?php } ?>> Edit Customer</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_customer" value="1" <?php if($function[0]['delete_customer'] == '1'){ ?>checked<?php } ?>> Delete Customer</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="supplier" value="1" <?php if($page[0]['supplier'] == '1'){ ?>checked<?php } ?>> Supplier</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_supplier" value="1" <?php if($function[0]['new_supplier'] == '1'){ ?>checked<?php } ?>> New Supplier</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_supplier" value="1" <?php if($function[0]['edit_supplier'] == '1'){ ?>checked<?php } ?>> Edit Supplier</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_supplier" value="1" <?php if($function[0]['delete_supplier'] == '1'){ ?>checked<?php } ?>> Delete Supplier</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="employee" value="1" <?php if($page[0]['employee'] == '1'){ ?>checked<?php } ?>> Employee</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_employee" value="1" <?php if($function[0]['new_employee'] == '1'){ ?>checked<?php } ?>> New Employee</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_employee" value="1" <?php if($function[0]['edit_employee'] == '1'){ ?>checked<?php } ?>> Edit Employee</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_employee" value="1" <?php if($function[0]['delete_employee'] == '1'){ ?>checked<?php } ?>> Delete Employee</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="users" value="1" <?php if($page[0]['users'] == '1'){ ?>checked<?php } ?>> User</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_user" value="1" <?php if($function[0]['new_user'] == '1'){ ?>checked<?php } ?>> New User</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_user" value="1" <?php if($function[0]['edit_user'] == '1'){ ?>checked<?php } ?>> Edit User</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_user" value="1" <?php if($function[0]['delete_user'] == '1'){ ?>checked<?php } ?>> Delete User</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <label><input type="checkbox" name="setting" value="1" <?php if($master[0]['setting'] == '1'){ ?>checked<?php } ?>> Settings</label>
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="category" value="1" <?php if($page[0]['category'] == '1'){ ?>checked<?php } ?>> Category</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_category" value="1" <?php if($function[0]['new_category'] == '1'){ ?>checked<?php } ?>> New Category</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_category" value="1" <?php if($function[0]['edit_category'] == '1'){ ?>checked<?php } ?>> Edit Category</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_category" value="1" <?php if($function[0]['delete_category'] == '1'){ ?>checked<?php } ?>> Delete Category</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="units" value="1" <?php if($page[0]['units'] == '1'){ ?>checked<?php } ?>> Unit</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_unit" value="1" <?php if($function[0]['new_unit'] == '1'){ ?>checked<?php } ?>> New Unit</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_unit" value="1" <?php if($function[0]['edit_unit'] == '1'){ ?>checked<?php } ?>> Edit Unit</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_unit" value="1" <?php if($function[0]['delete_unit'] == '1'){ ?>checked<?php } ?>> Delete Unit</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="user_type" value="1" <?php if($page[0]['user_type'] == '1'){ ?>checked<?php } ?>> User Type</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_utype" value="1" <?php if($function[0]['new_utype'] == '1'){ ?>checked<?php } ?>> New User Type</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_utype" value="1" <?php if($function[0]['edit_utype'] == '1'){ ?>checked<?php } ?>> Edit User Type</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_utype" value="1" <?php if($function[0]['delete_utype'] == '1'){ ?>checked<?php } ?>> Delete User Type</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <label><input type="checkbox" name="access_setup" value="1" <?php if($master[0]['access_setup'] == '1'){ ?>checked<?php } ?>> Access Setup</label>
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>

						</div>
	              		<div class="col-md-12 col-sm-12 col-12" style="text-align: center;">
                    	  <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                          <a href="<?php echo site_url('userAccess'); ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
                    	</div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer');?>