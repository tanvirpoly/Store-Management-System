<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Orders Receive</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Orders Receive</li>
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
                <h3 class="card-title">Work Orders Receive List</h3>
                <?php if($_SESSION['new_receive'] == 1){ ?>
                <a href="<?php echo site_url(); ?>newOReceive" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Order Receive</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Memo No.</th>
                      <th>Date</th>
                      <th>Supplier</th>
                      <th>Mobile</th>
                      <th>Total</th>
                      <th>Notes</th>
                      <th style="width: 13%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach($purchase as $value){
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['roMemo'] ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['roDate'])) ?></td>
                      <td><?php echo $value['supName'] ?></td>
                      <td><?php echo $value['supMobile'] ?></td>
                      <td><?php echo number_format($value['tAmount'], 2) ?></td>
                      <td><?php echo $value['note']; ?></td>
                      <td>
                        <?php if($_SESSION['edit_receive'] == 1){ ?>
                        <a class="btn btn-info btn-xs" href="<?php echo site_url().'viewWReceive/'.$value['roid']; ?>" title="view" ><i class="fa fa-eye"></i></a>
                        <?php } if($_SESSION['delete_receive'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Purchase/delete_receive_order').'/'.$value['roid']; ?>" onclick="return confirm('Are you sure you want to delete this Receive Order ?');" title="Delete" ><i class="fa fa-trash"></i></a>
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