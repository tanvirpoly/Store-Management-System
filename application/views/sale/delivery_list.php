<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Delivery</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Delivery</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Delivery List</h3>
                <?php if($_SESSION['new_delivery'] == 1){ ?>
                <a href="<?php echo site_url(); ?>newDelivery" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i> New Delivery</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Requisition</th>
                      <th>Date</th>
                      <th>Employee</th>
                      <th>Mobile</th>
                      <th>Notes</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($delivery as $value){
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['rInvoice']; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['dDate'])); ?></td>
                      <td><?php echo $value['uName']; ?></td>
                      <td><?php echo $value['uMobile']; ?></td>
                      <td><?php echo $value['notes']; ?></td>
                      <td>
                        <?php if($_SESSION['edit_delivery'] == 1){ ?>
                        <a class="btn btn-info btn-xs" href="<?php echo site_url().'viewDelivery/'.$value['did']; ?>"><i class="fa fa-eye"></i></a>
                        <?php } if($_SESSION['delete_delivery'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Sale/delete_delivery').'/'.$value['did']; ?>" onclick="return confirm('Are you sure you want to delete this Delivery ?');"><i class="fa fa-trash"></i></a>
                        <?php } ?>
                      </td>
                    </tr>   
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>