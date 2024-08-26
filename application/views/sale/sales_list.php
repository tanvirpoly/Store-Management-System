<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Requisition</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Requisition</li>
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
                <h3 class="card-title">Requisition List</h3>
                <?php if($_SESSION['new_requisition'] == 1){ ?>
                <a href="<?php echo site_url(); ?>newRequisit" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i> New Requisition</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Req. No.</th>
                      <th>Date</th>
                      <th>Reference</th>
                      <th>Employee</th>
                      <th>Department</th>
                      <!--<th>Mobile</th>-->
                      <!--<th>Total</th>-->
                      <th>Notes</th>
                      <th>status</th>
                      <th style="width: 12%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($sales as $value){
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['invoice']; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['saDate'])); ?></td>
                      <td><?php echo $value['reference']; ?></td>
                      <td><?php echo $value['uName']; ?></td>
                      <td><?php echo $value['empDpt']; ?></td>
                      <!--<td><?php echo $value['empMobile']; ?></td>-->
                      <!--<td><?php echo number_format($value['tAmount'], 2); ?></td>-->
                      <td><?php echo $value['note']; ?></td>
                      <td><?php echo $value['status']; ?></td>
                      <td>
                        <a class="btn btn-info btn-xs" href="<?php echo site_url().'viewReq/'.$value['said']; ?>"><i class="fa fa-eye"></i></a>
                        <?php if($value['status'] == "On Process"){ ?>
                        <?php if($_SESSION['edit_requisition'] == 1){ ?>
                        <a class="btn btn-success btn-xs" href="<?php echo site_url().'editReq/'.$value['said']; ?>"><i class="fa fa-edit"></i></a>
                        <?php } if($_SESSION['delete_requisition'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Sale/delete_sales').'/'.$value['said']; ?>" onclick="return confirm('Are you sure you want to delete this Requisition ?');"><i class="fa fa-trash"></i></a>
                        <?php } if($_SESSION['approve_requisition'] == 1){ ?>
                        <a class="btn btn-warning btn-xs" href="<?php echo site_url().'approveReq/'.$value['said']; ?>" onclick="return confirm('Are you sure you want to Approve this Requisition ?');"><i class="fa fa-check"></i></a>
                        <?php } } ?>
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