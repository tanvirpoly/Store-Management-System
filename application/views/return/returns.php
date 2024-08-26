<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Refund</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Refund</li>
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
                <h3 class="card-title">Refund List</h3>
                <?php if($_SESSION['new_refund'] == 1){ ?>
                <a href="<?php echo site_url('newReturn') ?>" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i> New Refund</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th style="width: 12%;">Date</th>
                      <th style="width: 15%;">R-Inv. No.</th>
                      <th style="width: 15%;">Requisition</th>
                      <th style="width: 18%;">Employee</th>
                      <th style="width: 10%;">Quantity</th>
                      <th style="width: 10%;">Status</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($return as $value) {
                    $i++;
                    
                    $rp = $this->db->select('sum(quantity) as total')
                                    ->from('returns_product')
                                    ->where('rt_id',$value['returnId'])
                                    ->get()
                                    ->row();
                    ?>
                    <tr class="gradeX" style="border: 1px solid #000;">
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['returnDate'])); ?></td>
                      <td><?php echo $value['rid']; ?></td>
                      <td><?php echo $value['invoice']; ?></td>
                      <td><?php echo $value['uName']; ?></td>
                      <td>
                          <?php echo $rp->total; ?>
                      </td>
                      <td>
                          <?php 
                            if($value['approval'] == 0) {
                                echo '<span style="color:red;">Not approved</span>';
                            }else{
                                echo '<span style="color:green;">Approved</span>';
                            }
                                
                          ?>
                      </td>
                      <td>
                        <a class=" btn btn-info btn-xs" href="<?php echo site_url('viewReturn').'/'.$value['returnId'] ?>"><i class="fa fa-eye"></i></a>
                        <!--<a class=" btn btn-success btn-xs" href="<?php echo site_url('editReturn').'/'.$value['returnId'] ?>"><i class="fa fa-edit"></i></a>-->
                        <?php if($value['approval'] == 0) { ?>
                        <?php if($_SESSION['delete_refund'] == 1){ ?>
                        <a href="<?php echo site_url('Returns/delete_returns').'/'.$value['returnId'] ?>" onclick="return confirm('Are you sure you want to Delete this Refund ?');" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i></a>
                        <?php } if($_SESSION['approve_refund'] == 1){ ?>
                        <a class="btn btn-warning btn-xs" href="<?php echo site_url('Returns/approve_refund').'/'.$value['returnId'] ?>" onclick="return confirm('Are you sure you want to Approve this Refund ?');"><i class="fa fa-check"></i></a>
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