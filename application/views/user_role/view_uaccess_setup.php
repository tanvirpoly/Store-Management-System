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
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Master</th>
                          <th>Page</th>
                          <th>Function</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <ul style="list-style-type:none;">
                              <li>
                                <b>
                                  <?php if($master[0]['dashboard'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Dashboard
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['products'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Products
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['orders'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Orders
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['requisitions'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Requisitions
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['users'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Users
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['setting'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Settings
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['access_setup'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Access Setup
                              </li>
                            </ul>
                          </td>

                          <td>
                            <ul style="list-style-type:none;">
                              <li>
                                <b>
                                  <?php if($page[0]['product_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Product List
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['stock_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Stock Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['order_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Work Order List
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['new_order'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Work Order
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['order_receive'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Order Receive
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['order_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Order Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['receive_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Receive Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['requisition_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Requisition List
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['delivery_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delivery List
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['requisition_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Requisition Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['delivery_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delivery Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['customer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Customer
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['supplier'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Supplier
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['employee'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Employee
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['users'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Users
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['category'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Category
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['units'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Unit
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['user_type'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> User Type
                              </li>
                            </ul>
                          </td>

                          <td>
                            <ul style="list-style-type: none;">
                              <li>
                                <b>
                                  <?php if($function[0]['new_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Product
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Product
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Product
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_order'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Order
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_order'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Order
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['approve_order'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Approve Order
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['payment_order'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Payment Order
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_receive'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Receive
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_receive'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Receive
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_receive'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Receive
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_requisition'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Requisition
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_requisition'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                    <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Requisition
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_requisition'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Requisition
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_delivery'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Delivery
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_delivery'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Delivery
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_delivery'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Delivery
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_customer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Customer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_customer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Customer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_customer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Customer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_supplier'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Supplier
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_supplier'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Supplier
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_supplier'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Supplier
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_employee'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Employee
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_employee'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Employee
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_employee'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Employee
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_user'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New User
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_user'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit User
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_user'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete User
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_category'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Category
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_category'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Category
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_category'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Category
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_unit'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Unit
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_unit'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Unit
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_unit'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Unit
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_utype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New User Type
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_utype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit User Type
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_utype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete User Type
                              </li>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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